<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;


class m_status extends Model
{
    protected $table = 'status';
    protected $timestamp = false;
}
