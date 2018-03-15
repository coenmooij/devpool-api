<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use CoenMooij\DevpoolApi\CRM\Comment;
use CoenMooij\DevpoolApi\Profile\Link;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
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

    public function toArray(): array
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

    public function isBackofficeUser(): bool
    {
        return $this->isType(UserType::BACKOFFICE);
    }

    public function isAdmin(): bool
    {
        return $this->isType(UserType::ADMIN);
    }

    public function isDeveloper(): bool
    {
        return $this->isType(UserType::DEVELOPER);
    }

    public function isClient(): bool
    {
        return $this->isType(UserType::CLIENT);
    }

    public function isType(string $type): bool
    {
        return UserType::get($type) === $this->{User::TYPE};
    }

    private function getFullName(): string
    {
        return $this->{self::FIRST_NAME} . ' ' . $this->{self::LAST_NAME};
    }

    /**
     * Add these so we can use the Auth Facade
     */

    public function getAuthIdentifierName(): string
    {
        return self::ID;
    }

    public function getAuthIdentifier(): int
    {
        return $this->{self::ID};
    }

    public function getAuthPassword(): string
    {
        return '';
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void
    {
    }

    public function getRememberTokenName()
    {
        return self::TOKEN;
    }
}
