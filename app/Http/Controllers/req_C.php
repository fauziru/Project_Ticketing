<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\APIBaseController as APIBaseController;
use Response;
use Validator;
use App\m_kategori;
use App\m_pic;
use App\m_prioritas;
use App\m_req;
use App\m_status;

class req_C extends APIBaseController
{
    public function fkat(){
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        $dtb = m_kategori::where('kategori_id','>=',2)->get();
        return $this->sendResponse($dtb->toArray(),'a');
    }
    public function fpic(){
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        $dtb = m_pic::where('pic_id','>=',2)->orderby('pic_divisi','ASC')->get();
        return $this->sendResponse($dtb->toArray(),'a');
    }
    public function fstat(){
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        $dtb = m_status::get();
        return $this->sendResponse($dtb->toArray(),'a');
    }
    public function fpri(){
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        $dtb = m_prioritas::where('prioritas_id','>=',2)->get();
        return $this->sendResponse($dtb->toArray(),'a');
    }
    public function ambil()
    {
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        //
        $dtb = DB::table('request')
        ->join('pic','request.pic_id','=','pic.pic_id')
        ->join('status','request.stat_id','=','status.stat_id')
        ->join('kategori','request.kategori_id','=','kategori.kategori_id')
        ->join('prioritas','request.prioritas_id','=','prioritas.prioritas_id')
        ->select('request.req_id','request.stat_id','request.kategori_id','request.pic_id','request.prioritas_id','request.diajukan_oleh','request.deskripsi_masalah','request.created_at','request.updated_at','pic.pic_nama','pic.pic_divisi','kategori.kategori_nama','prioritas.prioritas_nama','status.stat_nama')
        ->orderBy('request.created_at','DESC')
        ->get();
        return $this->sendResponse($dtb->toArray(), 'Semua request berhasil diambil.');
    }

    public function detil($id){
        /**
        * Display the specified resource.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        $tiket_req = m_req::join('pic','request.pic_id','=','pic.pic_id')
        ->join('status','request.stat_id','=','status.stat_id')
        ->join('kategori','request.kategori_id','=','kategori.kategori_id')
        ->join('prioritas','request.prioritas_id','=','prioritas.prioritas_id')
        ->select('request.req_id','request.stat_id','request.kategori_id','request.pic_id','request.prioritas_id','request.diajukan_oleh','request.deskripsi_masalah','request.created_at','request.updated_at','pic.pic_nama','pic.pic_divisi','kategori.kategori_nama','prioritas.prioritas_nama','status.stat_nama')
        ->find($id);
        if (is_null($tiket_req)) {
            return $this->sendError('tiket tidak dapat ditemukan');
        }
        return $this->sendResponse($tiket_req->toArray(), 'request terpilih berhasil diambil.');
    }

    public function tiketmasuk(Request $req)
    {
        /**
        * Store a newly created resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @return \Illuminate\Http\Response
        */
        $input = $req->all();
        $validator = Validator::make($input, [
            'n' => 'required',
            'm' => 'required',
            'kat'=> 'required'
            ]);
        $input2 = array('diajukan_oleh'=>$input['n'], 'deskripsi_masalah'=>$input['m'], 'kategori_id'=>$input['kat']);
        if($validator->fails()){
            return $this->sendError('Validasi Error.', $validator->errors());
        }
        $tiket_req = m_req::create($input2);
        return $this->sendResponse($tiket_req->toArray(), 'Tiket berhasil diinput');
    }

    public function tes(Request $req)
    {
        $input = $req->all();
        $input2 = array('diajukan_oleh'=>$input['n'], 'deskripsi_masalah'=>$input['m'], 'kat_id'=>$input['kat']);
        print_r($input);
        echo '</br>';
        print_r($input2);
    }

    public function urustiket(Request $req, $id)
    {
        /**
        * Update the specified resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        $input = $req->all();
        $validator = Validator::make($input, [
            'val_pic' => 'required',
            'val_prioritas' => 'required'
            ]);
        if($validator->fails()){
            return $this->sendError('Validasi Error.', $validator->errors());
        }
        $tiket_req = m_req::find($id);
        if (is_null($tiket_req)) {
            return $this->sendError('tiket tidak dapat ditemukan');
        }
        $tiket_req->pic_id = $input['val_pic'];
        $tiket_req->prioritas_id = $input['val_prioritas'];
        $tiket_req->stat_id = 2;
        $tiket_req->save();
        return $this->sendResponse($tiket_req->toArray(), 'Tiket telah diproses');
    }
    public function editalltiket(Request $req, $id)
    {
        /**
        * Update the specified resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        $input = $req->all();
        $validator = Validator::make($input, [
            'a' => 'required',
            'b' => 'required',
            'c' => 'required',
            'd' => 'required',
            'e' => 'required',
            'f' => 'required'
            ]);
        if($validator->fails()){
            return $this->sendError('Validasi Error.', $validator->errors());
        }
        $tiket_req = m_req::find($id);
        if (is_null($tiket_req)) {
            return $this->sendError('tiket tidak dapat ditemukan');
        }
        $tiket_req->diajukan_oleh = $input['a'];
        $tiket_req->prioritas_id = $input['b'];
        $tiket_req->pic_id = $input['c'];
        $tiket_req->kategori_id = $input['d'];
        $tiket_req->stat_id = $input['e'];
        $tiket_req->deskripsi_masalah = $input['f'];
        $tiket_req->save();
        return $this->sendResponse($tiket_req->toArray(), 'Tiket telah diperbarui');
    }
    public function editinlinetiket(Request $req, $id)
    {
        /**
        * Update the specified resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        
        $input = $req->all();
        $validator = Validator::make($input, [
            'c' => 'required',
            'i' => 'required'
            ]);
        $c = null ;
        switch(true){
            case $input['c'] = 1  :
                $c = 'pic_id';
                break;
            case $input['c'] = 2  :
                $c = 'kategori_id';
                break;
            case $input['c'] = 3  :
                $c = 'prioritas_id';
                break;
            case $input['c'] = 4  :
                $c = 'status_id';
                break;
        }
        if($validator->fails()){
            return $this->sendError('Validasi Error.', $validator->errors());
        }
        $tiket_req = m_req::find($id);
        if (is_null($tiket_req)) {
            return $this->sendError('tiket tidak dapat ditemukan');
        }
        $tiket_req->$c = $input['i'];
        $tiket_req->save();
        return $this->sendResponse($tiket_req->toArray(), 'Tiket telah diperbarui');
    }
    public function tiketselesai($id)
    {
        /**
        * Update the specified resource in storage.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        $tiket_req = m_req::find($id);
        if (is_null($tiket_req)) {
            return $this->sendError('tiket tidak dapat ditemukan');
        }
        $tiket_req->stat_id = 3;
        $tiket_req->save();
        return $this->sendResponse($tiket_req->toArray(), 'Tiket selesai diproses');
    }
    public function hapustiket($id)
    {
        /**
        * Update the specified resource in storage.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        $tiket_req = m_req::find($id);
        if (is_null($tiket_req)) {
            return $this->sendError('tiket tidak dapat ditemukan');
        }
        $tiket_req->delete();
        return $this->sendResponse($tiket_req->toArray(), 'Tiket sudah dihapus!');
    }
}