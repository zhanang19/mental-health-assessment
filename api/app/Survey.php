<?php

namespace App;

use App\Enums\SurveyResponseStatuses;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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

    /**
     * Scope a query to only include unfinished surveys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnfinished($query)
    {
        return $query->where('status', SurveyResponseStatuses::InProgress);
    }

    /**
     * Scope a query to only include finished surveys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinished($query)
    {
        return $query->where('status', SurveyResponseStatuses::Completed);
    }

    /**
     * Mutate the attribute value before storing to DB.
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($this->attributes['title']);
    }
}
