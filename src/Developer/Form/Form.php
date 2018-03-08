<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Form extends Model
{
    public const ID = 'id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}