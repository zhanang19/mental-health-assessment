<?php

namespace App\Repository\Eloquent;

use App\Enums\SurveyQuestionInputTypes;
use App\Repository\SurveyRepositoryInterface;
use App\Survey;
use App\SurveyQuestion;
use App\SurveyQuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
     * @param int $surveyId
     * @return Survey
     */
    public function findSurveyById(int $surveyId): ?Survey
    {
        return $this->model->with([
            "questionGroups",
            "responses"
        ])->findOrFail($surveyId);
    }

    /**
     * @param string $slug
     * @return Survey
     */
    public function findBySlug(string $slug): ?Survey
    {
        return $this->model->with([
            "questionGroups",
            "responses"
        ])->firstWhere("slug", $slug);
    }

    /**
     * Create a new survey form.
     *
     * @return Survey
     */
    public function createSurvey(): ?Survey
    {
        $defaultTitle = "Untitled Form " . Str::random(16);

        $survey = $this->model->create([
            "title" => $defaultTitle,

            // must have else mutator will not trigger
            "slug" => null,
            // "slug" => Str::slug($defaultTitle . " " . now()->timestamp),
        ]);

        // add 1 question group by default
        $survey->questionGroups()->create([
            "label" => "Unlabeled Question Group"
        ]);

        return $survey->fresh();
    }

    /**
     * Create new survey question group.
     *
     * @param int $surveyId
     * @return SurveyQuestionGroup
     */
    public function createQuestionGroup(int $surveyId): ?SurveyQuestionGroup
    {
        $survey = $this->findSurveyById($surveyId);

        $surveyQuestionGroup = $survey->questionGroups()->create([
            "label" => "Untitled Question Group"
        ]);

        return $surveyQuestionGroup->fresh();
    }

    /**
     * Create new question.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return SurveyQuestion
     */
    public function createQuestion(int $surveyId, int $questionGroupId): ?SurveyQuestion
    {
        $survey = $this->findSurveyById($surveyId);

        $questionsCount = $survey->questionGroups()->findOrFail($questionGroupId)
            ->questions()->count();

        $question = $survey->questionGroups()
            ->findOrFail($questionGroupId)
            ->questions()->create([
                "identifier" => (string) ($questionsCount + 1),
                "input_type" => SurveyQuestionInputTypes::ShortAnswer,
                "question" => "Question Undefined",
                "hint" => "Question's hint text",
                "validations" => json_encode([]),
                "option_group_a" => json_encode([]),
                "option_group_b" => json_encode([]),
            ]);

        return $question->fresh();
    }

    /**
     * @param int $surveyId
     * @param \Illuminate\Http\Request $payload
     * @return Survey
     */
    public function updateSurvey(int $surveyId, Request $payload): Survey
    {
        $questionGroups = $payload->get("question_groups");

        $survey = $this->findById($surveyId);

        $survey->update(Arr::only($payload->toArray(), [
                'title',
                'subtitle',
                'description',
                'color_theme',
            ])
        );

        $survey->fresh();

        foreach ($questionGroups as $questionGroup) {
            $_questionGroup = $survey->questionGroups()->find(
                $questionGroup["id"]
            );

            $_questionGroup->update(
                Arr::only($questionGroup, [
                    'label',
                    'instructions',
                ])
            );

            $_questionGroup->fresh();

            $questions = $questionGroup["questions"];

            foreach ($questions as $question) {
                $_question = $_questionGroup->questions()->find(
                    $question["id"]
                );

                $_question->update(
                    Arr::only($question, [
                        'identifier',
                        'input_type',
                        'question',
                        'hint',
                        'validations',
                        'option_group_a',
                        'option_group_b',
                    ])
                );
            }
        }

        return $survey;
    }

    /**
     * Duplicate a question group by id.
     * It also duplicates the questions in it.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return SurveyQuestionGroup
     */
    public function duplicateQuestionGroup(
        int $surveyId,
        int $questionGroupId
    ): ?SurveyQuestionGroup {
        return new SurveyQuestionGroup();
    }

    /**
     * Duplicate a question by id.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @param int $questionId
     * @return SurveyQuestion
     */
    public function duplicateQuestion(
        int $surveyId,
        int $questionGroupId,
        int $questionId
    ): ?SurveyQuestion {
        return new SurveyQuestion();
    }

    /**
     * @param int $surveyId
     * @return boolean
     */
    public function deleteById(int $surveyId): bool
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
     * @param int $surveyId
     * @return boolean
     */
    public function deletePermanentlyById(int $surveyId)
    {
        $survey = $this->findTrashedById($surveyId);

        foreach ($survey->questionGroups as $questionGroup) {
            foreach ($questionGroup->questions as $question) {
                $question->forceDelete();
            }

            $questionGroup->forceDelete();
        }

        return $survey->forceDelete();
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

    /**
     * Delete question group by id.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return bool
     */
    public function deleteQuestionGroupById(int $surveyId, int $questionGroupId): bool
    {
        return false;
    }

    /**
     * Delete question by id.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @param int $questionId
     * @return bool
     */
    public function deleteQuestionById(
        int $surveyId,
        int $questionGroupId,
        int $questionId
    ): bool {
        return false;
    }

    /**
     * @param int $surveyId
     * @return boolean
     */
    public function restoreById(int $surveyId): bool
    {
        $survey = $this->findTrashedById($surveyId);

        foreach ($survey->questionGroups as $questionGroup) {
            foreach ($questionGroup->questions as $question) {
                $question->restore();
            }

            $questionGroup->restore();
        }

        return $survey->restore();
    }
}
