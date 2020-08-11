<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestionGroup extends BaseModel
{
    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestionGroup::class);
    }

    /**
     * @return BelongsTo
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
