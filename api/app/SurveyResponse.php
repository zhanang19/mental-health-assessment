<?php

namespace App;

use App\Enums\SurveyResponseStatuses;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyResponse extends BaseModel
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        // "survey",
        // "responseGroups"
    ];

    /**
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * @return BelongsTo
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * @return HasMany
     */
    public function responseGroups(): HasMany
    {
        return $this->hasMany(SurveyResponseGroup::class);
    }

    /**
     * Scope a query to only include unfinished surveys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSurveyId($query, int $surveyId)
    {
        return $query->where('survey_id', $surveyId);
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
     * @return Collection
     */
    public function getResponseGroupsAttribute()
    {
        return $this->responseGroups()->get();
    }
}
