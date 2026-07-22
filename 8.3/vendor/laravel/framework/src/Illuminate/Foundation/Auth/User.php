<?php

namespace Odigos\Illuminate\Foundation\Auth;

use Odigos\Illuminate\Auth\Authenticatable;
use Odigos\Illuminate\Auth\MustVerifyEmail;
use Odigos\Illuminate\Auth\Passwords\CanResetPassword;
use Odigos\Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Odigos\Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Odigos\Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Odigos\Illuminate\Database\Eloquent\Model;
use Odigos\Illuminate\Foundation\Auth\Access\Authorizable;
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
