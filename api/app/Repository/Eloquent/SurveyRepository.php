<?php

namespace App\Repository\Eloquent;

use App\Repository\SurveyRepositoryInterface;
use App\Survey;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SurveyRepository extends BaseRepository implements SurveyRepositoryInterface
{
    /**
     * SurveyRepository constructor.
     *
     * @param Operation $model
     */
    public function __construct(Survey $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return Survey::get();
    }

    /**
     * Create a new survey form.
     *
     * @return array
     */
    public function newSurvey(): array
    {
        $defaultTitle = 'Untitled Form ' . Str::random(16);

        $survey = $this->model->create([
            'title' => $defaultTitle,
            'slug' => Str::slug($defaultTitle . ' ' . now()->timestamp),
        ]);

        $groups = $survey->questionGroups()->create([
            'label' => 'Unlabeled Question Group'
        ]);

        return [
            'survey' => $survey,
            'groups' => $groups,
        ];
    }

    /**
     * @param int $surveyId
     * @param array $payload
     * @return array
     */
    public function updateSurvey(int $surveyId, $payload)
    {
        $questionGroups = $payload['survey_question_groups'];

        $survey = $this->model->find($surveyId)
            ->update($payload['survey'])
            ->fresh();

        foreach ($questionGroups as $questionGroup) {
            $_questionGroup = $survey->questionGroups()->find(
                $questionGroup['id']
            );

            $_questionGroup->update($questionGroup);

            $_questionGroup->fresh();

            $questions = $questionGroup['questions'];

            foreach ($questions as $question) {
                $_question = $_questionGroup->questions()->find(
                    $question['id']
                );

                $_question->update($question);
            }
        }
    }
}
