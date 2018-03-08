<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer\Form;

use CoenMooij\DevpoolApi\Developer\Developer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    public const ID = 'id';
    public const DEVELOPER_ID = 'developer_id';
    public const QUESTION_ID = 'question_id';
    public const VALUE = 'value';

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
