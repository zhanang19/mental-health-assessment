<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyResponseGroup extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function response(): BelongsTo
    {
        return $this->belongsTo(SurveyResponse::class);
    }

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(SurveyResponseAnswer::class);
    }
}
