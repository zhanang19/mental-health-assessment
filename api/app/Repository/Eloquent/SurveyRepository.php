<?php

namespace App\Repository\Eloquent;

use App\Repository\SurveyRepositoryInterface;
use App\Models\Survey;
use Illuminate\Support\Collection;

class SurveyRepository extends BaseRepository implements SurveyRepositoryInterface
{
    /**
     * SurveyRepository constructor.
     *
     * @param Operation $model
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
        return Survey::get();
    }

    public function createNewSurveyForm()
    {

    }
}
