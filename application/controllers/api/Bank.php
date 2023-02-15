<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Bank extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_bank', 'api_bank');
    }

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


    public function index_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['akun'])) {
            $akun = $params['akun'];
            $get = $this->api_bank->bankByAkun($akun);
        } else if (!empty($params['n_bank'])) {
            $n_bank = $params['n_bank'];
            $get = $this->api_bank->banByBank($n_bank);
        } else {
            $get = $this->api_bank->bankData($params);
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
            $response = $this->setFormat($this->notfound, $format);
            return $this->response($response, $this->notfound);
        }
    }

    public function insert_post()
    {

        $data = json_decode(trim(file_get_contents('php://input')), true);
        if ($data == null) {
            $format = [
                'message' => 'Data Kosong',
                'data' => false,
            ];

            $response = $this->setFormat($this->bad_gateway, $format);
            return $this->response($response, $this->bad_gateway);
        } else if (!isset($data['akun']) || !isset($data['nama'])) {
            $format = [
                'message' => 'Field Tidak Kosong',
                'data' => false,
            ];

            $response = $this->setFormat($this->bad_gateway, $format);
            return $this->response($response, $this->bad_gateway);
        } else if ($data > 0) {
            $this->api_bank->insertBank($data);


            $format = [
                'message' => 'Data Berhasil Ditambahkan',
                'data' => $data,
            ];

            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        }
    }
    public function delete_delete()
    {
        $param = $this->input->get('n_bank');
        $delete = null;
        if ($param != null) {
            $delete = $this->api_bank->hapusData($param);
        } else {
            $format = [
                'message'   => 'Nomor bank tidak ada atau salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
        if (!empty($delete)) {
            $format = [
                'message'   => 'Data berhasil dihapus',
                'data'      => $param,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        } else {
            $format = [
                'message'   => 'Data bank telah dihapus',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }
    public function update_put()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        if (empty($data)) {
            $format = [
                'message' => 'Data Tidak Ada',
                'data' => null,
            ];

            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        } else if (!isset($data['n_bank']) || !isset($data['akun']) || !isset($data['nama'])) {

            $format = [
                'message' => 'Field Wajib Diisi',
                'data' => null,
            ];

            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        } else if ($data != 0) {
            $put = $this->api_bank->editBank($data);
        }


        if (!empty($put)) {
            $format = [
                'message' => 'Data Berhasil Diubah',
                'data' => $data,
            ];

            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        } else {
            $format = [
                'message' => 'Data Tidak Ada',
                'data' => null,
            ];
            $response = $this->setFormat($this->error, $format);
            return $this->response($response, $this->error);
        }
    }
}
