<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer\Link;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public const ID = 'id';
    public const DEVELOPER_ID = 'developer_id';
    public const TYPE = 'type';
    public const URI = 'uri';
}
