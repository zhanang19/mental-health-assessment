<?php

namespace App\Repository;

use App\Survey;
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
    public function findById(int $surveyId): ?Survey;

    /**
     * Get survey by slug.
     *
     * @param string $slug
     * @return Survey
     */
    public function findBySlug(string $slug): ?Survey;

    /**
     * Create new survey.
     *
     * @return Survey
     */
    public function newSurvey();

    /**
     * Update existing survey.
     *
     * @param int $surveyId
     * @param array $payload
     * @return Survey
     */
    public function updateSurvey(int $surveyId, $payload);

    /**
     * Delete survey by id.
     *
     * @param int $surveyId
     * @return boolean
     */
    public function deleteById(int $surveyId);

    /**
     * Delete survey by slug.
     *
     * @param string $slug
     * @return boolean
     */
    public function deleteBySlug(string $slug);
}
