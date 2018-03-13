<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Question extends Model
{
    public const ID = 'id';
    public const FORM_ID = 'form_id';
    public const ORDER = 'order';
    public const VALUE = 'value';

    protected $hidden = [
        self::ID,
        self::FORM_ID,
        'updated_at',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
