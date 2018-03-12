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
    public const DISPLAY_NAME = 'display_name';
    public const FULL_NAME = 'full_name';

    public const NAME_KEY = 'name';

    public const DEFAULT_TYPE = UserType::DEVELOPER;

    protected $guarded = [
        self::ID,
    ];

    protected $hidden = [
        self::PASSWORD,
        self::SALT,
        self::TOKEN,
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array[self::TYPE] = $this->getType();
        $array[self::DISPLAY_NAME] = $this->getDisplayName();
        $array[self::FULL_NAME] = $this->getFullName();

        return $array;
    }

    public function getType(): string
    {
        return UserType::getName($this->{self::TYPE});
    }

    public function getDisplayName(): string
    {
        return $this->{self::SHOW_NICKNAME} ? $this->{self::NICKNAME} : $this->getFullName();
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    private function getFullName(): string
    {
        return $this->{self::FIRST_NAME} . ' ' . $this->{self::LAST_NAME};
    }
}
