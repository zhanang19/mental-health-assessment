<?php

namespace App\Repository;

use App\SurveyResponse;
use App\SurveyResponseGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface SurveyResponseRepositoryInterface extends EloquentRepositoryInterface
{
    // /**
    //  * Get all survey forms.
    //  *
    //  * @return Collection
    //  */
    // public function all(): Collection;

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
    ): Collection;

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
    ): ?SurveyResponseGroup;

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
    ): ?SurveyResponseGroup;

    /**
     * Get the T-Score of each scale.
     *
     * @param int $responseId
     * @return \App\SurveyResponse
     */
    public function interpret(int $responseId): ?SurveyResponse;
}
