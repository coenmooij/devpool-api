<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Link extends Model
{
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const TYPE = 'type';
    public const VALUE = 'value';

    protected $hidden = [
        'user_id',
    ];

    public function toArray(): array
    {
        $array = parent::toArray();
        $array[self::TYPE] = $this->getType();

        return $array;
    }

    public function getType(): string
    {
        return LinkType::getName($this->{self::TYPE});
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
