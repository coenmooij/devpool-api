<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Developer\Form\Answer;
use CoenMooij\DevpoolApi\Developer\Form\Form;
use CoenMooij\DevpoolApi\Technology\Technology;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Developer extends User
{
    public const ID = 'id';
    public const SPECIALITY = 'role';
    public const SENIORITY = 'seniority';
    public const PIPELINE_STATUS = 'pipeline_status';
    public const COUNTRY = 'country';
    public const PHONE_NUMBER = 'phone';
    public const BIRTH_DATE = 'birth_date';
    public const PRIORITY = 'priority';
    private const HIDDEN = [
        'pivot',
    ];

    protected $guarded = [];

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function toArray(): array
    {
        return parent::toArray();
    }

    /**
     * @return string[]
     */
    public function getHidden(): array
    {
        return array_merge(parent::getHidden(), self::HIDDEN);
    }

    public static function boot(): void
    {
        static::addGlobalScope(
            'isDeveloper',
            function ($query) {
                return $query->join('users', 'developers.id', '=', 'users.id');
            }
        );
    }
}
