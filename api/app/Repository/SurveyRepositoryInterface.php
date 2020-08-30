<?php

namespace App\Repository;

use App\Survey;
use App\SurveyQuestion;
use App\SurveyQuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface SurveyRepositoryInterface
{
    /**
     * Get all survey forms.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find survey by id.
     *
     * @param int $surveyId
     * @return Survey
     */
    public function findSurveyById(int $surveyId): ?Survey;

    /**
     * Get survey by slug.
     *
     * @param string $slug
     * @return Survey
     */
    public function findBySlug(string $slug): ?Survey;

    /**
     * Start the survey.
     *
     * @param string $slug
     * @return Survey
     */
    public function takeSurvey(string $slug): ?Survey;

    /**
     * Create new survey.
     *
     * @return Survey
     */
    public function createSurvey(): ?Survey;

    /**
     * Create new survey question group.
     *
     * @param int $surveyId
     * @return SurveyQuestionGroup
     */
    public function createQuestionGroup(int $surveyId): ?SurveyQuestionGroup;

    /**
     * Create new question.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return SurveyQuestion
     */
    public function createQuestion(int $surveyId, int $questionGroupId): ?SurveyQuestion;

    /**
     * Update existing survey.
     *
     * @param int $surveyId
     * @param \Illuminate\Http\Request $payload
     * @return Survey
     */
    public function updateSurvey(int $surveyId, Request $payload);

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
    ): ?SurveyQuestionGroup;

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
    ): ?SurveyQuestion;

    /**
     * Delete survey by id.
     *
     * @param int $surveyId
     * @return bool
     */
    public function deleteById(int $surveyId);

    /**
     * Delete question group by id.
     *
     * @param int $surveyId
     * @param int $questionGroupId
     * @return bool
     */
    public function deleteQuestionGroupById(int $surveyId, int $questionGroupId): bool;

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
    ): bool;

    /**
     * @param int $surveyId
     * @return bool
     */
    public function deletePermanentlyById(int $surveyId);

    /**
     * Delete survey by slug.
     *
     * @param string $slug
     * @return bool
     */
    public function deleteBySlug(string $slug);

    /**
     * Restore survey by id.
     *
     * @param int $surveyId
     * @return bool
     */
    public function restoreById(int $surveyId);
}
