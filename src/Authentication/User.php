<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use CoenMooij\DevpoolApi\CRM\Comment;
use CoenMooij\DevpoolApi\Profile\Link;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    public const ID = 'id';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const SALT = 'salt';
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const NICKNAME = 'nickname';
    public const SHOW_NICKNAME = 'show_nickname';
    public const TYPE = 'type';
    public const TOKEN = 'token';
    public const TOKEN_EXPIRES = 'token_expires';

    public const NAME_KEY = 'name';

    public const TYPE_ADMIN = 0;
    public const TYPE_BACKOFFICE = 1;
    public const TYPE_DEVELOPER = 2;
    public const TYPE_CLIENT = 3;

    public const TYPES = [
        self::TYPE_ADMIN => 'admin',
        self::TYPE_BACKOFFICE => 'backoffice',
        self::TYPE_DEVELOPER => 'developer',
        self::TYPE_CLIENT => 'client',
    ];

    protected $fillable = [
        self::EMAIL,
        self::PASSWORD,
        self::TYPE,
        self::SALT,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::NICKNAME,
        self::SHOW_NICKNAME,
        self::TOKEN,
        self::TOKEN_EXPIRES,
    ];

    public $hidden = [
        'password',
        'salt',
    ];

    public const DEFAULT_TYPE = self::TYPE_DEVELOPER;

    public static function getType(int $userType): int
    {
        return in_array($userType, self::TYPES, true) ? $userType : self::DEFAULT_TYPE;
    }

    public function getDisplayName(): string
    {
        return $this->{self::SHOW_NICKNAME} ? $this->{self::NICKNAME} : $this->getFullName();
    }

    private function getFullName(): string
    {
        return $this->{self::FIRST_NAME} . ' ' . $this->{self::LAST_NAME};
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}
