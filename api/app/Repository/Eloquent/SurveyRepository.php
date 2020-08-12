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
     * @param Survey $model
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
        return Survey::all();
    }

    /**
     * @param int $surveyId
     * @return Survey
     */
    public function findById(int $surveyId): ?Survey
    {
        return $this->model->with([
            'questionGroups',
            'responses'
        ])->findOrFail($surveyId);
    }

    /**
     * @param string $slug
     * @return Survey
     */
    public function findBySlug(string $slug): ?Survey
    {
        return $this->model->with([
            'questionGroups',
            'responses'
        ])->firstWhere('slug', $slug);
    }

    /**
     * Create a new survey form.
     *
     * @return Survey
     */
    public function newSurvey(): Survey
    {
        $defaultTitle = 'Untitled Form ' . Str::random(16);

        $survey = $this->model->create([
            'title' => $defaultTitle,
            'slug' => Str::slug($defaultTitle . ' ' . now()->timestamp),
        ]);

        // add 1 question group by default
        $survey->questionGroups()->create([
            'label' => 'Unlabeled Question Group'
        ]);

        return $survey;
    }

    /**
     * @param int $surveyId
     * @param \Illuminate\Http\Request $payload
     * @return Survey
     */
    public function updateSurvey(int $surveyId, $payload): Survey
    {
        $questionGroups = $payload->get('survey_question_groups');

        $survey = $this->model->find($surveyId)
            ->update($payload->get('survey'))
            ->fresh();

        foreach ($questionGroups as $questionGroup) {
            $_questionGroup = $survey->questionGroups()->find(
                $questionGroup['id']
            );

            $_questionGroup->update($questionGroup)->fresh();

            $questions = $questionGroup['questions'];

            foreach ($questions as $question) {
                $_question = $_questionGroup->questions()->find(
                    $question['id']
                );

                $_question->update($question);
            }
        }

        return $survey;
    }

    /**
     * @param int $surveyId
     * @return boolean
     */
    public function deleteById(int $surveyId)
    {
        $survey = $this->findById($surveyId);

        foreach ($survey->questionGroups as $questionGroup) {
            foreach ($questionGroup->questions as $question) {
                $question->delete();
            }

            $questionGroup->delete();
        }

        return $survey->delete();
    }

    /**
     * @param string $slug
     * @return boolean
     */
    public function deleteBySlug(string $slug)
    {
        $survey = $this->findBySlug($slug);

        foreach ($survey->questionGroups as $questionGroup) {
            foreach ($questionGroup->questions as $question) {
                $question->delete();
            }

            $questionGroup->delete();
        }

        return $survey->delete();
    }
}
