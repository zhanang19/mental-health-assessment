<?php

namespace App\Repository\Eloquent;

use App\Enums\ScaleTypes;
use App\Survey;
use App\SurveyQuestion;
use App\SurveyQuestionGroup;
use App\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Enums\SurveyQuestionInputTypes;
use App\Enums\SurveyResponseStatuses;
use App\Repository\SurveyRepositoryInterface;
use App\Util\ScaleTypeChoices;

class SurveyRepository extends BaseRepository implements SurveyRepositoryInterface
{
    private $scaleTypeChoices;

    /**
     * SurveyRepository constructor.
     *
     * @param Survey $model
     */
    public function __construct(Survey $model, ScaleTypeChoices $scaleTypeChoices)
    {
        parent::__construct($model);

        $this->scaleTypeChoices = $scaleTypeChoices;
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
     * Find question group by id.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return SurveyQuestionGroup
     */
    public function findQuestionGroupById(
        int $surveyId,
        int $questionGroupId,
        array $relations = ['questions']
    ): ?SurveyQuestionGroup {
        return $this->findById($surveyId)
            ->questionGroups()->with($relations)
            ->findOrFail($questionGroupId);
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
     * Start the survey.
     * It basically just be based on the survey questionnaire form.
     *
     * @param int $surveyId
     * @return SurveyResponse
     */
    public function takeSurvey(int $surveyId): ?SurveyResponse
    {
        // $surveyResponse = auth()->user()->surveyResponses()
        //     ->whereSurveyId($surveyId)->first();

        // if ($surveyResponse != null) {
        //     return $surveyResponse;
        // }

        $survey = $this->findSurveyById($surveyId);

        $surveyResponse = $survey->responses()
            ->create([
                'student_id' => auth()->id(),
                'status' => SurveyResponseStatuses::InProgress,
                'title' => $survey->title,
                'slug' => $survey->slug,
                'subtitle' => $survey->subtitle,
                'description' => $survey->description,
                'color_theme' => $survey->color_theme,
            ]);

        // create survey response groups
        foreach ($survey->questionGroups as $questionGroup) {
            $responseGroup = $surveyResponse->responseGroups()->create([
                'status' => SurveyResponseStatuses::InProgress,
                'questions_answered' => 0,
                'label' => $questionGroup->label,
                'type' => $questionGroup->type,
                'instructions' => $questionGroup->instructions,
                'description' => $questionGroup->description,
                'total_questions' => $questionGroup->count(),
            ]);

            // create the response answers based on questions
            foreach ($questionGroup->questions as $question) {
                $responseGroup->answers()->create([
                    // choices will be taken from the question model
                    'survey_question_id' => $question->id,
                    'answer_a' => $question->input_type == SurveyQuestionInputTypes::Checkboxes ? json_encode([]) : null,
                    'answer_b' => $question->input_type == SurveyQuestionInputTypes::Checkboxes ? json_encode([]) : null,
                    'identifier' => $question->identifier,
                    'input_type' => $question->input_type,
                    'question' => $question->question,
                    'hint' => $question->hint,
                    'required' => $question->required,
                    'option_group_a' => json_encode($question->option_group_a),
                    'option_group_b' => json_encode($question->option_group_b),
                ]);
            }
        }

        return $surveyResponse->fresh();
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
            "label" => "Untitled Scale",
            "type" => ScaleTypes::NONE
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
            "label" => "Untitled Scale",
            "type" => ScaleTypes::NONE,
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

        $questionGroup = $survey->questionGroups()->findOrFail($questionGroupId);

        $questionsCount = $questionGroup->questions()->count();

        $question = $survey->questionGroups()
            ->findOrFail($questionGroupId)
            ->questions()->create([
                "identifier" => (string) ($questionsCount + 1),
                "input_type" => SurveyQuestionInputTypes::ShortAnswer,
                "question" => "Question Undefined",
                "hint" => "Question's hint text",
                "required" => false,
                "option_group_a" => $this->scaleTypeChoices->getType($questionGroup->type)->option_group_a,
                "option_group_b" => $this->scaleTypeChoices->getType($questionGroup->type)->option_group_b,
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
        ]));

        $survey->update(['slug' => $survey->title]);

        $survey->fresh();

        foreach ($questionGroups as $questionGroup) {
            $_questionGroup = $survey->questionGroups()->find(
                $questionGroup["id"]
            );

            $_questionGroup->update(
                Arr::only($questionGroup, [
                    'label',
                    'description',
                    'instructions',
                    'type'
                ])
            );

            $_questionGroup->fresh();

            $questions = $questionGroup["questions"];

            foreach ($questions as $question) {
                info("Survey Question", $question);

                $_question = $_questionGroup->questions()->find(
                    $question["id"]
                );

                $_question->update(
                    Arr::only($question, [
                        'identifier',
                        'input_type',
                        'question',
                        'hint',
                        'required',
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
        $survey = $this->findById($surveyId);

        $questionGroup = $survey->questionGroups()
            ->findOrFail($questionGroupId);

        $replicated = $questionGroup->replicate()->toArray();

        $questionGroup = $survey->questionGroups()->create(
            Arr::only($replicated, [
                'label',
                'instructions',
                'type'
            ])
        );

        $questionGroup->fresh();

        foreach ($replicated['questions'] as $question) {
            info('Replicated Questions > Question', $question);

            $questionGroup->questions()->create([
                'identifier' => $question['identifier'],
                'input_type' => $question['input_type'],
                'question' => $question['question'],
                'hint' => $question['hint'],
                'required' => $question['required'],
                'option_group_a' => json_encode([
                    'label' => $question['option_group_a']->label,
                    'options' => $question['option_group_a']->options
                ]),
                'option_group_b' => json_encode([
                    'label' => $question['option_group_b']->label,
                    'options' => $question['option_group_b']->options
                ]),
            ]);
        }

        return $this->findQuestionGroupById($surveyId, $questionGroup->id);
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
        $questionGroup = $this->findById($surveyId)->questionGroups()
            ->findOrFail($questionGroupId);

        $question = $questionGroup->questions()->findOrFail($questionId);

        $replicated = $question->replicate()->toArray();

        return $questionGroup->questions()->create([
            'identifier' => $replicated['identifier'],
            'input_type' => $replicated['input_type'],
            'question' => $replicated['question'],
            'hint' => $replicated['hint'],
            'required' => $replicated['required'],
            'option_group_a' => json_encode([
                'label' => $replicated['option_group_a']->label,
                'options' => $replicated['option_group_a']->options
            ]),
            'option_group_b' => $replicated['option_group_b'] != null ? json_encode([
                'label' => $replicated['option_group_b']->label,
                'options' => $replicated['option_group_b']->options
            ]) : null,
        ]);
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
     * @return \App\SurveyQuestionGroup
     */
    public function deleteQuestionGroupById(int $surveyId, int $questionGroupId): ?SurveyQuestionGroup
    {
        $questionGroup = $this->findById($surveyId)->questionGroups()->with('questions')
            ->findOrFail($questionGroupId);

        foreach ($questionGroup->questions as $question) {
            $question->forceDelete();
        }

        $questionGroup->forceDelete();

        return $questionGroup;
    }

    /**
     * Delete question by id.
     *
     * @todo
     * Cannot delete a question that is already
     * being referenced by a survey response.
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
        $question = $this->findById($surveyId)->questionGroups()
            ->findOrFail($questionGroupId)->questions()->findOrFail($questionId);

        return $question->forceDelete();
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
