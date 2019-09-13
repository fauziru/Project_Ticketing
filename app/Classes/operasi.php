<?php
namespace App\Classes;

class operasi 
{
    public function pilih_op($operasi,$a,$b)
    {
        $tes = new operasi;
        if($operasi == 'tambah'){
            return $tes->tambah($a,$b);
        }if($operasi == 'kurang'){
            return $tes->kurang($a,$b);
        }else{
            return response('operasi tsb tidak terdaftar');
        }
    }
    public function tambah($a,$b){
        
        $hasil = $a + $b;
        return response ($hasil);
    }
    public function kurang($a,$b){
        $hasil = $a - $b;
        return response ($hasil);
    }
}

