<?php

namespace App\Repository;

use App\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface SurveyResponseRepositoryInterface
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
     * @param string $surveySlug
     * @param int $surveyResponseId
     * @return SurveyResponse
     */
    public function findSurveyResponseById(
        string $surveySlug,
        int $surveyResponseId
    ): ?SurveyResponse;

    /**
     * Create new survey response.
     *
     * @return SurveyResponse
     */
    public function create(): ?SurveyResponse;

    /**
     * Update existing survey response.
     *
     * @param int $surveyResponseId
     * @param \Illuminate\Http\Request $payload
     * @return SurveyResponse
     */
    public function update(int $surveyResponseId, Request $payload);

    /**
     * Delete survey by id.
     *
     * @param int $surveyResponseId
     * @return bool
     */
    public function deleteById(int $surveyResponseId);

    /**
     * @param int $surveyResponseId
     * @return bool
     */
    public function deletePermanentlyById(int $surveyResponseId);

    /**
     * Restore survey by id.
     *
     * @param int $surveyResponseId
     * @return bool
     */
    public function restoreById(int $surveyResponseId);
}
