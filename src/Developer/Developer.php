<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Profile\Link;
use CoenMooij\DevpoolApi\Technology\Technology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Developer extends Model
{
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const ROLE = 'role';
    public const SENIORITY = 'seniority';
    public const PIPELINE_STATUS = 'pipeline_status';
    public const COUNTRY = 'country';
    public const PHONE_NUMBER = 'phone';
    public const BIRTH_DATE = 'birth_date';
    public const PRIORITY = 'priority';

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }
}
