<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface SurveyRepositoryInterface
{
    public function all(): Collection;

    public function createNewSurveyForm();
}
