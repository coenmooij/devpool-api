<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const TYPE = 'type';
    public const URI = 'uri';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
