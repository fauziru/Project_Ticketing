<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;


class m_pic extends Model
{
    protected $table = 'pic';
    protected $timestamp = false;
}