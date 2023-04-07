<?php

namespace App\Models\Mappings;

class UserTableMap
{
    public const TABLE = 'users';

    public const COL_CREATED_AT = 'created_at';
    public const COL_EMAIL = 'email';
    public const COL_EMAIL_VERIFIED_AT = 'email_verified_at';
    public const COL_ID = 'id';
    public const COL_NAME = 'name';
    public const COL_PASSWORD = 'password';
    public const COL_REMEMBER_TOKEN = 'remember_token';
    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ALL = 'users.*';
    public const TABLE_CREATED_AT = 'users.created_at';
    public const TABLE_EMAIL = 'users.email';
    public const TABLE_EMAIL_VERIFIED_AT = 'users.email_verified_at';
    public const TABLE_ID = 'users.id';
    public const TABLE_NAME = 'users.name';
    public const TABLE_PASSWORD = 'users.password';
    public const TABLE_REMEMBER_TOKEN = 'users.remember_token';
    public const TABLE_UPDATED_AT = 'users.updated_at';

    public const RELATION_PROFILE = 'profile';
    public const RELATION_SUBSCRIPTIONS = 'subscriptions';
    public const RELATION_ROLES = 'roles';
    public const RELATION_PERMISSIONS = 'permissions';

}
