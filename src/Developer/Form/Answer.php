<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer\Form;

use CoenMooij\DevpoolApi\Developer\Developer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Answer extends Model
{
    public const ID = 'id';
    public const DEVELOPER_ID = 'developer_id';
    public const QUESTION_ID = 'question_id';
    public const VALUE = 'value';

    protected $hidden = [
        self::ID,
        self::DEVELOPER_ID,
        self::QUESTION_ID,
        'updated_at',
    ];

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
