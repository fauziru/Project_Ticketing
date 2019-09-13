<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;


class m_req extends Model
{
    protected $table = 'request';
    protected $primaryKey = 'req_id';
    protected $fillable = [
        'pic_id', 'stat_id','kategori_id','prioritas_id','diajukan_oleh','deskripsi_masalah'
    ];
}
