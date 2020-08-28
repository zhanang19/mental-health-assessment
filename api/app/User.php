<?php

namespace App;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable,
        HasApiTokens,
        HasRoles,
        SoftDeletes,
        SoftCascadeTrait,
        InteractsWithMedia;

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
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'roles',
        'media'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
        'full_name',
        // 'formatted_time_zone',
        'role',
        'is_admin',
        'is_super',
        'is_user',
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
     * @return HasOne
     */
    public function demographicProfile(): HasOne
    {
        return $this->hasOne(DemographicProfile::class, 'student_id');
    }

    /**
     * @return HasMany
     */
    public function guardians(): HasMany
    {
        return $this->hasMany(Guardian::class, 'student_id');
    }

    /**
     * Get the avatar attribute for the user.
     *
     * @return bool
     */
    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl('avatar');
    }

    /**
     * Get the full name attribute of a child.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    /**
     * Get the role flag for the user.
     *
     * @return bool
     */
    public function getFormattedTimeZoneAttribute()
    {
        return cleanTimeZoneName($this->attributes['time_zone']);
    }

    /**
     * Get the role flag for the user.
     *
     * @return bool
     */
    public function getRoleAttribute()
    {
        return $this->getRoleNames()->shift();
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->hasRole(['super-admin', 'admin']);
    }

    /**
     * Get the super administrator flag for the user.
     *
     * @return bool
     */
    public function getIsSuperAttribute()
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Get the user flag for the user.
     *
     * @return bool
     */
    public function getIsUserAttribute()
    {
        return $this->hasRole('user');
    }

    /**
     * Checks if user is created today.
     *
     * @return bool
     */
    public function getCreatedTodayAttribute()
    {
        return formatDate(setTimeZone(now())) == $this->date_created;
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

    /**
     * Set the password attribute to be encrypted before it saves in DB.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
