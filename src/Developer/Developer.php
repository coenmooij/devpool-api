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
        $data = parent::toArray();

        $data[self::SENIORITY] = $this->getSeniority();
        $data[self::SPECIALITY] = $this->getSpeciality();
        $data[self::PIPELINE_STATUS] = $this->getPipelineStatus();

        return $data;
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

    private function getSeniority(): ?string
    {
        return $this->{self::SENIORITY} ? Seniority::getName($this->{self::SENIORITY}) : null;
    }

    private function getSpeciality(): ?string
    {
        return $this->{self::SPECIALITY} ? Speciality::getName($this->{self::SPECIALITY}) : null;
    }

    private function getPipelineStatus(): string
    {
        return PipelineStatus::getName($this->{self::PIPELINE_STATUS});
    }
}
