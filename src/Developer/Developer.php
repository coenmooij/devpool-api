<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Technology\Technology;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Developer extends User
{
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

    protected $table = 'users';

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
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
                return $query->join('developers', 'users.id', '=', 'developers.id');
            }
        );
    }
}
