<?php

namespace App\Repository\Eloquent;

use App\Repository\SurveyResponseRepositoryInterface;
use App\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SurveyResponseRepository implements SurveyResponseRepositoryInterface
{
    /**
     * Get all survey forms.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return collect([]);
    }

    /**
     * Find survey by id.
     *
     * @param int $surveyResponseId
     * @return SurveyResponse
     */
    public function findSurveyResponseById(int $surveyResponseId): ?SurveyResponse
    {
        return null;
    }

    /**
     * Get survey by slug.
     *
     * @param string $slug
     * @return SurveyResponse
     */
    public function findBySlug(string $slug): ?SurveyResponse
    {
        return null;
    }

    /**
     * Create new survey response.
     *
     * @return SurveyResponse
     */
    public function create(): ?SurveyResponse
    {
        return null;
    }

    /**
     * Update existing survey response.
     *
     * @param int $surveyResponseId
     * @param \Illuminate\Http\Request $payload
     * @return SurveyResponse
     */
    public function update(int $surveyResponseId, Request $payload)
    {
        return null;
    }

    /**
     * Delete survey by id.
     *
     * @param int $surveyResponseId
     * @return bool
     */
    public function deleteById(int $surveyResponseId)
    {
        return false;
    }

    /**
     * @param int $surveyResponseId
     * @return bool
     */
    public function deletePermanentlyById(int $surveyResponseId)
    {
        return false;
    }

    /**
     * Delete survey by slug.
     *
     * @param string $slug
     * @return bool
     */
    public function deleteBySlug(string $slug)
    {
        return false;
    }

    /**
     * Restore survey by id.
     *
     * @param int $surveyResponseId
     * @return bool
     */
    public function restoreById(int $surveyResponseId)
    {
        return false;
    }
}
