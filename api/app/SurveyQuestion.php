<?php

namespace App;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyQuestion extends BaseModel
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'required' => 'boolean',
        // 'option_group_a' => Json::class,
        // 'option_group_b' => Json::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        // 'validations',
        'option_group_a',
        'option_group_b',
        'created_today',
        'date_created',
        'date_updated',
        'created_since',
        'updated_since',
    ];

    /**
     * @return BelongsTo
     */
    public function questionGroup(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestionGroup::class);
    }

    /**
     * Get the attribute option_group_a parsed into json.
     *
     * @return string
     */
    public function getOptionGroupAAttribute()
    {
        return json_decode($this->attributes['option_group_a']);
    }

    // /**
    //  * Set the attribute encoded into json.
    //  *
    //  * @return void
    //  */
    // public function setOptionGroupAAttribute($value)
    // {
    //     $this->attributes['option_group_a'] = json_encode($value);
    // }

    /**
     * Get the attribute option_group_b parsed into json.
     *
     * @return string
     */
    public function getOptionGroupBAttribute()
    {
        return json_decode($this->attributes['option_group_b']);
    }

    // /**
    //  * Set the attribute encoded into json.
    //  *
    //  * @return void
    //  */
    // public function setOptionGroupBAttribute($value)
    // {
    //     $this->attributes['option_group_b'] = json_encode($value);
    // }

    // /**
    //  * Get the attribute validations parsed into json.
    //  *
    //  * @return string
    //  */
    // public function getValidationsAttribute()
    // {
    //     return json_decode($this->attributes['validations']);
    // }
}
