<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\CRM;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Comment extends Model
{
    public const ID = 'id';
    public const MESSAGE = 'message';
    public const TYPE = 'type';
    public const USER_ID = 'user_id';
    public const AUTHOR_ID = 'author_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
