<?php

namespace App\Repository;

use App\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface SurveyResponseRepositoryInterface
{
    // /**
    //  * Get all survey forms.
    //  *
    //  * @return Collection
    //  */
    // public function all(): Collection;

    /**
     * Find survey by id.
     *
     * @param int $responseId
     * @param array $relations
     * @return SurveyResponse
     */
    public function findById(
        int $responseId,
        array $relations = ['survey'],
        array $appends = ['response_groups']
    ): ?SurveyResponse;

    // /**
    //  * Create new survey response.
    //  *
    //  * @return SurveyResponse
    //  */
    // public function create(): ?SurveyResponse;

    // /**
    //  * Update existing survey response.
    //  *
    //  * @param int $responseId
    //  * @param \Illuminate\Http\Request $payload
    //  * @return SurveyResponse
    //  */
    // public function update(int $responseId, Request $payload);

    // /**
    //  * Delete survey by id.
    //  *
    //  * @param int $responseId
    //  * @return bool
    //  */
    // public function deleteById(int $responseId);

    // /**
    //  * @param int $responseId
    //  * @return bool
    //  */
    // public function deletePermanentlyById(int $responseId);

    // /**
    //  * Restore survey by id.
    //  *
    //  * @param int $responseId
    //  * @return bool
    //  */
    // public function restoreById(int $responseId);
}
