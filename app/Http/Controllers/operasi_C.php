<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Classes\operasi;
use Response;


class operasi_C extends Controller
{
    public function operasi($operasi)
    {      
        $d_array = explode(',', $operasi);
        $tes = new operasi;
        print_r($d_array);
        return response()->json($tes->pilih_op($d_array[0],$d_array[1],$d_array[2]));
    }
}
