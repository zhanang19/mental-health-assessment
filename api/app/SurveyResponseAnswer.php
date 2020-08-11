<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponseAnswer extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class);
    }
}
