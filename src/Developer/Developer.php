<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Form\Answer;
use CoenMooij\DevpoolApi\Profile\PipelineStatus;
use CoenMooij\DevpoolApi\Profile\Seniority;
use CoenMooij\DevpoolApi\Profile\Speciality;
use CoenMooij\DevpoolApi\Technology\Technology;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Developer extends User
{
    public const ID = 'id';
    public const SPECIALITY = 'speciality';
    public const SENIORITY = 'seniority';
    public const PIPELINE_STATUS = 'pipeline_status';
    public const COUNTRY = 'country';
    public const PHONE_NUMBER = 'phone';
    public const BIRTH_DATE = 'birth_date';
    public const PRIORITY = 'priority';
    public const SALARY = 'salary';

    protected $casts = [self::PRIORITY => 'boolean', self::SHOW_NICKNAME => 'boolean'];

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

    protected function getSeniorityAttribute(?int $value): ?string
    {
        return $value !== null ? Seniority::getName($value) : null;
    }

    protected function getSpecialityAttribute(?int $value): ?string
    {
        return $value !== null ? Speciality::getName($value) : null;
    }

    protected function getPipelineStatusAttribute(?int $value): ?string
    {
        return $value !== null ? PipelineStatus::getName($value) : null;
    }

    protected function setSeniorityAttribute(?string $value): void
    {
        $this->attributes[self::SENIORITY] = $value ? Seniority::get($value) : null;
    }

    protected function setSpecialityAttribute(?string $value): void
    {
        $this->attributes[self::SPECIALITY] = $value ? Speciality::get($value) : null;
    }

    protected function setPipelineStatusAttribute(string $value): void
    {
        $this->attributes[self::PIPELINE_STATUS] = PipelineStatus::get($value);
    }
}
