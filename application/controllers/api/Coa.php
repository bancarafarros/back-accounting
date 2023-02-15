<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Coa extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_coa', 'api_coa');
        $this->load->model('M_jurnal');
    }

    //method get api coa

    public function index_get()
    {
        $param = $this->input->get();
        $get = null;

        if (!empty($param['akun'])) {
            $akun = $param['akun'];
            $get = $this->api_coa->coaByAkun($akun);
        } else if(!empty($param['grup'])){
            $grup = strtoupper($param['grup']);
            $get = $this->api_coa->coaByGrup($grup);
        }else{
            $get = $this->api_coa->coaData($param);
        }

        if (!empty($get)) {
            $format = [
                'message'   => 'Data ditemukan',
                'data'      => $get,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        } else {
            $format = [
                'message'   => 'Data kosong',
                'data'      => null,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        }
    }

    // request method not allowed
    
    public function index_put()
    {
        $this->methodNotAllowed();
    }
    
    public function index_post()
    {
        $this->methodNotAllowed();
    }
    
    public function index_patch()
    {
        $this->methodNotAllowed();
    }
    
    public function index_delete()
    {
        $this->methodNotAllowed();
    }

    //method insert api

    public function tambah_post()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        $post = null;

        if(empty($input)){
            $format = [
                'message'   => 'Permintaan kurang lengkap!',
                'data'      => null,
                'error'     => 'data inputan kosong.',
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }else{

            if(!empty($input['akun']) && !empty($input['nama'])){
                $post = $this->api_coa->insertCoa($input);

                if(empty($post)){
                    $format = [
                        'message'   => 'Gagal menambahkan data!',
                        'data'      => null,
                        'error'     => 'duplikat akun coa',
                    ];
                    $response = $this->setFormat($this->error, $format);
                    return $this->response($response, $this->error);
                }else{
                    $format = [
                        'message'   => 'Sukses, Data berhasil ditambahkan',
                        'data'      => $post,
                    ];
                    $response = $this->setFormat($this->ok, $format);
                    return $this->response($response, $this->ok);
                }
            }else{
                $format = [
                    'message'   => 'Permintaan kurang lengkap!',
                    'data'      => null,
                    'error'     => 'atribut akun dan nama coa wajib di isi!',
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return$this->response($response, $this->bad_req);
            }
        }
    }

    // request method not allowed
    
    public function tambah_put()
    {
        $this->methodNotAllowed();
    }
    
    public function tambah_get()
    {
        $this->methodNotAllowed();
    }
    
    public function tambah_patch()
    {
        $this->methodNotAllowed();
    }
    
    public function tambah_delete()
    {
        $this->methodNotAllowed();
    }

    // method update api

    public function edit_put()
    {
        $edit = json_decode(trim(file_get_contents('php://input')), true);

        $put = null;

        if(empty($edit)){
            $format = [
                'message'   => 'Permintaan kurang lengkap!',
                'data'      => null,
                'error'     => 'data inputan kosong.',
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }else{

            if(!empty($edit['akun'])){
                $put = $this->api_coa->updateCoa($edit);

                if(empty($put)){
                    $format = [
                        'message'   => 'Gagal mengedit data!',
                        'data'      => null,
                        'error'     => 'akun coa tidak tersedia.',
                    ];
                    $response = $this->setFormat($this->error, $format);
                    return $this->response($response, $this->error);
                }else{
                    $format = [
                        'message'   => 'Sukses, Data berhasil di edit',
                        'data'      => $put,
                    ];
                    $response = $this->setFormat($this->ok, $format);
                    return $this->response($response, $this->ok);
                }
            }else{
                $format = [
                    'message'   => 'Permintaan kurang lengkap!',
                    'data'      => null,
                    'error'     => 'atribut akun coa wajib diisi.',
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        }
    }

    // request method not allowed
    
    public function edit_get()
    {
        $this->methodNotAllowed();
    }
    
    public function edit_post()
    {
        $this->methodNotAllowed();
    }
    
    public function edit_patch()
    {
        $this->methodNotAllowed();
    }
    
    public function edit_delete()
    {
        $this->methodNotAllowed();
    }

    // method delete api

    public function hapus_delete()
    {
        $hapus = $this->input->get('akun');

        $del = null;

        if(!empty($hapus)){

            $cek_data = $this->api_coa->cekData($hapus);

            if($cek_data){
                $valid = $this->M_jurnal->getDataDelete('djurnal', ['akun' => $hapus]);
                $valid1 = $this->M_jurnal->getDataDelete('pemasok', ['akun' => $hapus]);
                $valid2 = $this->M_jurnal->getDataDelete('pelanggan', ['akun' => $hapus]);
                $valid3 = $this->M_jurnal->getDataDelete('barang', ['akun_persediaan' => $hapus]);
                $valid4 = $this->M_jurnal->getDataDelete('barang', ['akun_pendapatan' => $hapus]);
                $valid5 = $this->M_jurnal->getDataDelete('barang', ['akun_hpp' => $hapus]);
                
                if($valid == FALSE && $valid1 == FALSE && $valid2 == FALSE && $valid3 == FALSE && $valid4 == FALSE && $valid5 == FALSE){
                    $del = $this->api_coa->deleteCoa($hapus);
                    
                    $format = [
                        'message'   => 'Sukses, data berhasil dihapus',
                        'data'      => $hapus,
                    ];
                    $response = $this->setFormat($this->ok, $format);
                    return $this->response($response, $this->ok);
                }else{  
                    $format = [
                        'message'   => 'Gagal menghapus data!',
                        'data'      => null,
                        'error'     => 'akun coa tersebut telah digunakan.',
                    ];
                    $response = $this->setFormat($this->error, $format);
                    return $this->response($response, $this->error);
                }
            }else{
                $format = [
                    'message'   => 'akun coa tidak tersedia',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        }else{
            $format = [
                'message'   => 'Permintaan kurang lengkap!',
                'data'      => null,
                'error'     => 'data inputan kosong.',
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    // request method not allowed
    
    public function hapus_put()
    {
        $this->methodNotAllowed();
    }
    
    public function hapus_post()
    {
        $this->methodNotAllowed();
    }
    
    public function hapus_patch()
    {
        $this->methodNotAllowed();
    }
    
    public function hapus_get()
    {
        $this->methodNotAllowed();
    }
}
