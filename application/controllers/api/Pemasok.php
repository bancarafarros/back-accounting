<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Pemasok extends Apicontroller{

    function __construct(){
        parent::__construct();
        $this->load->model('api/Api_pemasok', 'api_pemasok');
    }

    public function index_get()
    {
        $param = $this->input->get();
        $get = null;

        if(!empty($param['n_pemasok'])) {
            $nomor = $param['n_pemasok'];
            $get = $this->api_pemasok->pemasokByNomor($nomor);
        }else if(!empty($param['akun'])) {
            $akun = $param['akun'];
            $get = $this->api_pemasok->pemasokByAkun($akun);
        }else if(!empty($param['tanggal'])){
            $tanggal = $param['tanggal'];
            $get = $this->api_pemasok->pemasokByTanggal($tanggal);
        }else{
            $get = $this->api_pemasok->pemasokData($param);
        }

        if(!empty($get)){
            $format = [
                'message'   => 'Data ditemukan',
                'data'      => $get,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        }else{
            $format = [
                'message'   => 'Data kosong',
                'data'      => null,
            ];
            $response = $this->setFormat($this->notfound, $format);
            return $this->response($response, $this->notfound);
        }
    }

    //request method not allowed

    public function index_post()
    {
        $this->methodNotAllowed();
    }

    public function index_put()
    {
        $this->methodNotAllowed();
    }

    public function index_delete()
    {
        $this->methodNotAllowed();
    }

    public function index_patch()
    {
        $this->methodNotAllowed();
    }

    // insert API pemasok 

    public function tambah_post()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        $post = null;

        if(empty($input)){
            $format = [
                'message'   => 'data inputan kosong!',
                'data'      => null,
                'error'     => 'bad request',
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }else{

            if(!empty($input['akun']) && !empty($input['nama'])){
                $post = $this->api_pemasok->insertPemasok($input);

                if($post == true){
                    $format = [
                        'message'   => 'Sukses, Data berhasil ditambahkan',
                        'data'      => $post,
                    ];
                    $response = $this->setFormat($this->ok, $format);
                    return $this->response($response, $this->ok);
                }else{
                    $format = [
                        'message'   => 'Gagal menambahkan data!',
                        'data'      => null,
                        'error'     => 'nomor akun perkiraan tidak tersedia di database',
                    ];
                    $response = $this->setFormat($this->error, $format);
                    return $this->response($response, $this->error);
                }
            }else{
                $format = [
                    'message'   => 'Permintaan kurang lengkap!',
                    'data'      => null,
                    'error'     => 'atribut akun dan nama pemasok wajib di isi!',
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return$this->response($response, $this->bad_req);
            }
        }
    }

    //request not allowed

    public function tambah_get()
    {
        $this->methodNotAllowed();
    }

    public function tambah_put()
    {
        $this->methodNotAllowed();
    }

    public function tambah_delete()
    {
        $this->methodNotAllowed();
    }

    public function tambah_patch()
    {
        $this->methodNotAllowed();
    }

    //update API pemasok

    public function edit_put()
    {
        $edit = json_decode(trim(file_get_contents('php://input')), true);

        $put = null;

        if(empty($edit)) {
            $format = [
                'message'   => 'permintaan kurang lengkap!',
                'data'      => null,
                'error'     => 'data inputan kosong!',
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }else{

            if(!empty($edit['nomor_pemasok']) && !empty($edit['akun'])){
                $put = $this->api_pemasok->updatePemasok($edit);
                
                if($put == "invalid_nomor"){
                    $format = [
                        'message'   => 'Gagal mengedit data.',
                        'data'      => null,
                        'error'     => 'atribut nomor pemasok tidak tersedia didalam database!',
                    ];
                    $response = $this->setFormat($this->error, $format);
                    return $this->response($response, $this->error);
                }else if($put == "invalid_akun"){
                    $format = [
                        'message'   => 'Gagal mengedit data.',
                        'data'      => null,
                        'error'     => 'atribut akun tidak valid, harus masukan akun yang terdaftar di akun daftar perkiraan.',
                    ];
                    $response = $this->setFormat($this->error, $format);
                    return $this->response($response, $this->error);
                }else{
                    $format = [
                        'message'   => 'Sukses, Data berhasil diedit',
                        'data'      => $put,
                    ];
                    $response = $this->setFormat($this->ok, $format);
                    return $this->response($response, $this->ok);
                }
            }else{
                $format = [
                    'message'   => 'Permintaan kurang lengkap!',
                    'data'      => null,
                    'error'     => 'atribut akun dan nama pemasok wajib di isi!',
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return$this->response($response, $this->bad_req);
            }
            
        }
    }

    //request method not allowed

    public function edit_get()
    {
        $this->methodNotAllowed();
    }

    public function edit_post()
    {
        $this->methodNotAllowed();
    }

    public function edit_delete()
    {
        $this->methodNotAllowed();
    }

    public function edit_patch()
    {
        $this->methodNotAllowed();
    }

    // delete API pemasok

    public function hapus_delete()
    {
        $hapus = $this->input->get('nomor_pemasok');

        $del = null;

        if(empty($hapus)){
            $format = [
                'message'   => 'Permintaan kurang lengkap!',
                'data'      => null,
                'error'     => 'data inputan kosong.'
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }else{
            $del = $this->api_pemasok->deletePemasok($hapus);

            if($del == true){
                $format = [
                    'message'   => 'Sukses, Data berhasil dihapus',
                    'data'      => $hapus,
                ];
                $response = $this->setFormat($this->ok, $format);
                return $this->response($response, $this->ok);
            }else{
                $format = [
                    'message'   => 'Gagal menghapus data!',
                    'data'      => null,
                    'error'     => 'Nomor pemasok tidak tersedia',
                ];
                $response = $this->setFormat($this->error, $format);
                return $this->response($response, $this->error);
            }
        }        
    }

    //method not allowed

    public function hapus_get()
    {
        $this->methodNotAllowed();
    }

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
}