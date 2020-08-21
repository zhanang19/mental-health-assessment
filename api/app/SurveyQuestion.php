<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyQuestion extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function questionGroup(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestionGroup::class);
    }
}
