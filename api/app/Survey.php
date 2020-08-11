<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends BaseModel
{
    /**
     * @return HasMany
     */
    public function questionGroups(): HasMany
    {
        return $this->hasMany(SurveyQuestionGroup::class);
    }

    /**
     * @return HasMany
     */
    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
