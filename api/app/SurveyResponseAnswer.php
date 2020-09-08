<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponseAnswer extends BaseModel
{
    /**
     * @return BelongsTo
     */
    public function responseGroup(): BelongsTo
    {
        return $this->belongsTo(SurveyResponseGroup::class);
    }

    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'required' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        // 'validations',
        'answer_a',
        'answer_b',
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

    /**
     * Get the attribute option_group_a parsed into json.
     *
     * @return string
     */
    public function getAnswerAAttribute()
    {
        return json_decode($this->attributes['answer_a']);
    }

    /**
     * Get the attribute option_group_a parsed into json.
     *
     * @return string
     */
    public function setAnswerAAttribute($value)
    {
        $this->attributes['answer_a'] = json_encode($value);
    }

    /**
     * Get the attribute option_group_a parsed into json.
     *
     * @return string
     */
    public function getAnswerBAttribute()
    {
        return json_decode($this->attributes['answer_b']);
    }

    /**
     * Get the attribute option_group_a parsed into json.
     *
     * @return string
     */
    public function setAnswerBAttribute($value)
    {
        $this->attributes['answer_b'] = json_encode($value);
    }
}
