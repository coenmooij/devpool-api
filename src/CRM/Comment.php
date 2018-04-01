<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\CRM;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Profile\CommentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Comment extends Model
{
    public const ID = 'id';
    public const MESSAGE = 'message';
    public const USER_ID = 'user_id';
    public const AUTHOR_ID = 'author_id';

    protected $hidden = [
        self::USER_ID,
        self::AUTHOR_ID,
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
