<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Form extends Model
{
    public const ID = 'id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';

    protected $hidden = [
        self::ID,
        'updated_at',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
