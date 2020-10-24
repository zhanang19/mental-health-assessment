<?php

namespace App\Repository\Eloquent;

use App\Enums\SurveyQuestionInputTypes;
use App\Repository\SurveyResponseRepositoryInterface;
use App\SurveyResponse;
use App\SurveyResponseGroup;
use App\Util\ScaleInterpretation;
use App\Util\ScaleTypeChoices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Util\CalculationHelper;

class SurveyResponseRepository extends BaseRepository implements SurveyResponseRepositoryInterface
{
    private $calculationHelper;

    /**
     * SurveyRepository constructor.
     *
     * @param SurveyResponse $model
     */
    public function __construct(SurveyResponse $model, CalculationHelper $calculationHelper)
    {
        parent::__construct($model);

        $this->calculationHelper = $calculationHelper;
    }

    /**
     * Get all survey responses by survey ID.
     *
     * @param int $surveyId
     * @return Collection
     */
    public function getSurveyResponsesById(
        int $surveyId,
        array $relations = ['survey'],
        array $appends = ['response_groups']
    ): Collection {
        return $this->model->surveyId($surveyId)
            ->with($relations)->get()->append($appends);
    }

    /**
     * Find survey response by id.
     *
     * @param int $responseId
     * @return SurveyResponse
     */
    public function findById(
        int $responseId,
        array $relations = ['survey'],
        array $appends = ['response_groups']
    ): ?SurveyResponse {
        return $this->model->with($relations)
            ->findOrFail($responseId)->append($appends);
    }

    /**
     * Find survey response group by id.
     *
     * @param int $responseId
     * @param int $responseGroupId
     * @return SurveyResponseGroup
     */
    public function findResponseGroupById(
        int $responseId,
        int $responseGroupId,
        array $relations = ['answers']
    ): ?SurveyResponseGroup {
        return $this->findById($responseId)
            ->responseGroups()->with($relations)
            ->findOrFail($responseGroupId);
    }

    /**
     * Update a response group by id.
     *
     * This will update all of the answers that belongs to
     * the survey response group. No need to update every single
     * question.
     *
     * @param int $responseId
     * @param int $responseGroupId
     * @param Request $payload
     * @return SurveyResponseGroup
     */
    public function updateResponseGroupById(
        int $responseId,
        int $responseGroupId,
        array $payload
    ): ?SurveyResponseGroup {
        $responseGroup = $this->findResponseGroupById($responseId, $responseGroupId);
        $answers = $payload['answers'];

        $responseGroup->update([
            'is_completed' => true
        ]);

        $responseGroup->fresh();

        foreach ($answers as $answer) {
            $responseGroupAnswer = $responseGroup->answers()->findOrFail($answer['id']);

            $responseGroupAnswer->update(
                Arr::only($answer, [
                    'answer_a',
                    'answer_b',
                ])
            );
        }

        return $responseGroup;
    }

    /**
     * Calculate for the T-Score.
     *
     * @param int $responseId
     * @return \App\SurveyResponse
     */
    public function interpret(int $responseId): ?SurveyResponse
    {
        $response = $this->findById($responseId);

        $scaleInterpretation = new ScaleInterpretation();
        $scaleTypeChoice = new ScaleTypeChoices();

        foreach ($response->responseGroups as $responseGroup) {
            $answers = $responseGroup->answers;

            // an array of all numbers associated
            // to the particular scale and get mean value
            $numbersX = collect([]);
            $numbersY = collect([]);

            // loop through all answer and check
            // if they are of type multiple choice
            // else, do not push to array otherwise
            // the item pushed is not necessary
            foreach ($answers as $answer) {
                if (SurveyQuestionInputTypes::MultipleChoice) {

                    /**
                     * @todo gets illegal offset on 'text'
                     * from `getValueFromType()`
                     */
                    $numbersX->push(
                        $scaleTypeChoice->getValueFromType(
                            $responseGroup->type,
                            'option_group_a',
                            $answer->answer_a
                        )
                    );

                    $numbersY->push(
                        $scaleTypeChoice->getValueFromType(
                            $responseGroup->type,
                            'option_group_b',
                            $answer->answer_b
                        )
                    );
                }
            }

            // calculate for the `raw score`
            $rawScoreX = $numbersX->sum();
            $rawScoreY = $numbersY->sum();

            // calculate for the `mean`
            // ref [https://www.mathsisfun.com/mean.html#:~:text=How%20to%20Find%20the%20Mean,sum%20divided%20by%20the%20count.]
            $meanX = $this->calculationHelper->findMean($numbersX->toArray());
            $meanY = $this->calculationHelper->findMean($numbersY->toArray());

            // calculating for the `standard deviation`
            // ref [https://www.mathsisfun.com/data/standard-deviation-formulas.html]
            $standardDeviationX = $this->calculationHelper->findStandardDeviation($numbersX->toArray());
            $standardDeviationY = $this->calculationHelper->findStandardDeviation($numbersY->toArray());

            if ($standardDeviationX != 0) {
                $dividendX = ( ($rawScoreX - $meanX) / $standardDeviationX);
            } else {
                $dividendX = 0;
            }

            if ($standardDeviationY != 0) {
                $dividendY = ( ($rawScoreY - $meanY) / $standardDeviationY);
            } else {
                $dividendY = 0;
            }

            // calculating for the `t-score`
            $tScoreX = ($dividendX * 10) + 50;
            $tScoreY = ($dividendY * 10) + 50;

            info('ALGORITHM', [
                'numbersX' => $numbersX,
                'numbersY' => $numbersY,
                'meanX' => $meanX,
                'meanY' => $meanY,
                'standardDeviationX' => $standardDeviationX,
                'standardDeviationY' => $standardDeviationY,
                'tScoreX' => $tScoreX,
                'tScoreY' => $tScoreY,
            ]);

            // update the values in DB based on results
            // from the calculations above
            $responseGroup->update([
                // frequency
                'interpretation_x' => $scaleInterpretation->getInterpretation($tScoreX),
                't_score_x' => $tScoreX,
                'raw_score_x' => $rawScoreX,
                'mean_x' => $meanX,
                'standard_deviation_x' => $standardDeviationX,

                // degree of being bothered
                'interpretation_y' => $scaleInterpretation->getInterpretation($tScoreY),
                't_score_y' => $tScoreY,
                'raw_score_y' => $rawScoreY,
                'mean_y' => $meanY,
                'standard_deviation_y' => $standardDeviationY,
            ]);
        }

        return $response;
    }
}
