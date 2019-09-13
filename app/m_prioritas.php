<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;


class m_prioritas extends Model
{
    protected $table = 'prioritas';
    protected $timestamp = false;
}
