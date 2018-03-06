<?php

namespace CoenMooij\DevpoolApi\Authentication;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public const ID = 'id';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const SALT = 'salt';
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const TOKEN = 'token';
    public const TOKEN_EXPIRES = 'token_expires';
}
