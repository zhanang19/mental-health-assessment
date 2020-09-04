<?php

namespace App\Repository\Eloquent;

use App\Repository\SurveyResponseRepositoryInterface;
use App\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SurveyResponseRepository extends BaseRepository implements SurveyResponseRepositoryInterface
{
    /**
     * SurveyRepository constructor.
     *
     * @param SurveyResponse $model
     */
    public function __construct(SurveyResponse $model)
    {
        parent::__construct($model);
    }

    // /**
    //  * Get all survey forms.
    //  *
    //  * @return Collection
    //  */
    // public function all(): Collection
    // {
    //     return collect([]);
    // }

    /**
     * Find survey by id.
     *
     * @param int $surveyId
     * @param int $responseId
     * @return SurveyResponse
     */
    public function findById(
        int $responseId,
        array $relations = ['survey'],
        array $appends = ['response_groups']
    ): ?SurveyResponse {
        return $this->model->with($relations)
            ->findOrFail($responseId)->append($appends);
    }

    // /**
    //  * Create new survey response.
    //  *
    //  * @return SurveyResponse
    //  */
    // public function create(): ?SurveyResponse
    // {
    //     return null;
    // }

    // /**
    //  * Update existing survey response.
    //  *
    //  * @param int $responseId
    //  * @param \Illuminate\Http\Request $payload
    //  * @return SurveyResponse
    //  */
    // public function update(int $responseId, Request $payload)
    // {
    //     return null;
    // }

    // /**
    //  * Delete survey by id.
    //  *
    //  * @param int $responseId
    //  * @return bool
    //  */
    // public function deleteById(int $responseId)
    // {
    //     return false;
    // }

    // /**
    //  * @param int $responseId
    //  * @return bool
    //  */
    // public function deletePermanentlyById(int $responseId)
    // {
    //     return false;
    // }

    // /**
    //  * Restore survey by id.
    //  *
    //  * @param int $responseId
    //  * @return bool
    //  */
    // public function restoreById(int $responseId)
    // {
    //     return false;
    // }
}
