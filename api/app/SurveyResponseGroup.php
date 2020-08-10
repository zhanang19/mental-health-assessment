<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponseGroup extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'created_today',
        'date_created',
        'date_updated',
        'date_deleted',
        'created_since',
        'updated_since',
        'deleted_since'
    ];

    /**
     * Dates to be treated as Carbon instances
     *
     * @var array
     */
    public $dates = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    /**
     * Checks if user is created today.
     *
     * @return bool
     */
    public function getCreatedTodayAttribute()
    {
        return formatDate( setTimeZone(now()) ) == $this->date_created;
    }

    /**
     * Get the formatted created at attribute.
     *
     * @return string
     */
    public function getDateCreatedAttribute()
    {
        return formatDate(
            setTimeZone($this->attributes['created_at'])
        );
    }

    /**
     * Get the formatted updated at attribute.
     *
     * @return string
     */
    public function getDateUpdatedAttribute()
    {
        return formatDate(
            setTimeZone($this->attributes['updated_at'])
        );
    }

    /**
     * Get the formatted deleted at attribute.
     *
     * @return string
     */
    public function getDateDeletedAttribute()
    {
        return formatDate(
            setTimeZone($this->attributes['deleted_at'])
        );
    }

    /**
     * Get the human readable format created at attribute.
     *
     * @return string
     */
    public function getCreatedSinceAttribute()
    {
        return timeSince(
            setTimeZone($this->attributes['created_at'])
        );
    }

    /**
     * Get the human readable format updated at attribute.
     *
     * @return string
     */
    public function getUpdatedSinceAttribute()
    {
        return timeSince(
            setTimeZone($this->attributes['updated_at'])
        );
    }

    /**
     * Get the human readable format deleted at attribute.
     *
     * @return string
     */
    public function getDeletedSinceAttribute()
    {
        return timeSince(
            setTimeZone($this->attributes['deleted_at'])
        );
    }
}
