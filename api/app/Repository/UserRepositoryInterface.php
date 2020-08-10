<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
}
