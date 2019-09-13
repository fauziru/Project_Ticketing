<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Foundation\Http\FormRequest;


class compress_C extends Controller
{
    public function compress($n_f)
    {   
        $path = "img/".$n_f."/*";
        $i = null;
        foreach (glob($path) as $list_file){
            $i = $i + 1;
            $f_name = date('Y-m-d')."-".date('H-i-s')."-compressed".".jpeg";
            $f_save = "img/compressed/";
            $list_file2 = $f_save.$f_name;
            //compress dan resize
            $manager = new ImageManager(array('driver'=>'GD'));
            $img_rescale = $manager->make($list_file);
            $img_rescale->orientate();
            //ambil nilai width
            $w = $img_rescale->width();
            $h = $img_rescale->height();
            $r = $w/$h;
            //seleksi potrait atau landscape
            if($r > 1){
                $tmp_w = 1366;
                $tmp_h = null;
            }else{
                $tmp_w = null;
                $tmp_h = 1366;
            }
            $img_rescale->resize($tmp_w, $tmp_h, function($constraint){
                $constraint->aspectRatio();
            })->save($list_file2,30);               
        }
        return response('Semua file telah di compress');
    }
    public function delete($n_f){
        $path = "img/".$n_f."/*";
        $i = null;
        foreach (glob($path) as $list_file){
            $i = $i + 1;
            //hapus
            unlink($list_file);
        }
        return response('Semua file berhasil dihapus');
    }
}
