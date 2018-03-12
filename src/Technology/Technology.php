<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use CoenMooij\DevpoolApi\Developer\Developer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Technology extends Model
{
    public const ID = 'id';
    public const NAME = 'name';
    public const TYPE = 'type';
    public const PARENT_ID = 'parent_id';

    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(Developer::class);
    }
}
