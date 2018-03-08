<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use Illuminate\Database\Eloquent\Model;

final class Technology extends Model
{
    public const ID = 'id';
    public const NAME = 'name';
    public const TYPE = 'type';
    public const PARENT_ID = 'parent_id';
}
