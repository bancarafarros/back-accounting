<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class KasBank extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_kasbank', 'api_kasbank');
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

    public function detail_get()
    {
        $params = $this->input->get();
        $get = null;

        if (!empty($params['n_kasbank'])) {
            $n_kasbank = $params['n_kasbank'];
            $get = $this->api_kasbank->dkasbanByBank($n_kasbank);
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

    public function index_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['tanggal'])) {
            $tanggal = $params['tanggal'];
            $get = $this->api_kasbank->kasbankBytanggal($tanggal);
        } else {
            $get = $this->api_kasbank->kasbankData($params);
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
        // var_dump($data);
        // die;
        $n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');
        if ($data == null) {
            $format = [
                'message' => 'Data Kosong',
                'data' => false,
            ];

            $response = $this->setFormat($this->bad_gateway, $format);
            return $this->response($response, $this->bad_gateway);
        } else if (!isset($data['akun0']) || !isset($data['n_transaksi']) || !isset($data['keterangan'])) {
            $format = [
                'message' => 'Field Tidak Kosong',
                'data' => false,
            ];

            $response = $this->setFormat($this->bad_gateway, $format);
            return $this->response($response, $this->bad_gateway);
        } else if ($data > 0) {
            if ($data['n_transaksi'] == 'KM') {
                $data['n_transaksi'] = generateNomorForAccounting('KM', 'hkasbank', 'n_kasbank');
            }
            if ($data['n_transaksi'] == 'KK') {
                $data['n_transaksi'] = generateNomorForAccounting('KK', 'hkasbank', 'n_kasbank');
            }
            if ($data['n_transaksi'] == 'BM') {
                $data['n_transaksi'] = generateNomorForAccounting('BM', 'hkasbank', 'n_kasbank');
            }
            if ($data['n_transaksi'] == 'BK') {
                $data['n_transaksi'] = generateNomorForAccounting('BK', 'hkasbank', 'n_kasbank');
            }
            if ($data['bayar'] == "KAS") {
                $data['bayar'] = getPenghubung("kas")['akun'];
                $data['no_bank'] = "KAS";
            }
            if ($data['bayar'] != "KAS") {
                $akun = explode(" | ", $data['no_bank']);
                $data['no_bank'] = $akun[0];
            }

            $this->api_kasbank->insertKasBank($data, $n_jurnal);


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
        $param = json_decode(trim(file_get_contents('php://input')), true);
        $delete = null;
        if ($param != null) {
            $delete = $this->api_kasbank->hapusData($param['n_kasbank']);
        } else {
            $format = [
                'message'   => 'Nomor Kasbank tidak ada atau salah',
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
                'message'   => 'Data Kasbank telah dihapus',
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
        } else if (!isset($data['n_kasbank']) || !isset($data['akun'])) {

            $format = [
                'message' => 'Field Wajib Diisi',
                'data' => null,
            ];

            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        } else if ($data != 0) {
            $put = $this->api_kasbank->editKasBank($data);
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
