<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Pelanggan extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_pelanggan', 'api_pelanggan');
    }

    public function create_post()
    {
        $param = json_decode(trim(file_get_contents('php://input')), true);
        $post = null;

        if ($param != null) {

            if (array_key_exists('barcode', $param) && isset($param['tanggal']) && isset($param['akun']) && isset($param['nama']) && isset($param['alamat']) && isset($param['telepon']) && isset($param['email']) && isset($param['batas']) && isset($param['n_sales'])) {
                
                if (!empty($param['tanggal'] && $param['akun']  && $param['nama'] && $param['alamat'] && $param['telepon'] && $param['email'] && $param['batas'] && $param['n_sales'])) {
                    $post = $this->api_pelanggan->insertPelanggan($param);    
                
                } else {
                    $format = [
                        'message'   => 'Barcode, tanggal, akun, nama, alamat, telpon, email, batas, n_sales wajib diisi',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            
            } else {
                $format = [
                    'message'   => 'Barcode, tanggal, akun, nama, alamat, telpon, email, batas, n_sales wajib ada',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        
        } else {
            $format = [
                'message'   => 'Data tidak berhasil ditambahkan',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }

        if (!empty($post)) {
            $format = [
                'message'   => 'Data berhasil ditambahkan',
                'data'      => $param,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        } else {
            $format = [
                'message'   => 'Data tidak berhasil ditambahkan',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    public function create_get()
    {
        $this->methodNotAllowed();
    }

    public function create_put()
    {
        $this->methodNotAllowed();
    }

    public function create_patch()
    {
        $this->methodNotAllowed();
    }

    public function create_delete()
    {
        $this->methodNotAllowed();
    }

    public function index_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['n_pelanggan'])) {
            $n_pelanggan = $params['n_pelanggan'];
            $get = $this->api_pelanggan->pelangganByN_Pelanggan($n_pelanggan);
        } else if (!empty($params['tanggal'])) {
            $tanggal = $params['tanggal'];
            $get = $this->api_pelanggan->pelangganByTanggal($tanggal);
        } else if (!empty($params['akun'])) {
            $akun = $params['akun'];
            $get = $this->api_pelanggan->pelangganByAkun($akun);
        } else if (!empty($params['statusA'])) {
            $statusA = $params['statusA'];
            $get = $this->api_pelanggan->pelangganByStatusA($statusA);
        } else if (!empty($params['n_sales'])) {
            $n_sales = $params['n_sales'];
            $get = $this->api_pelanggan->pelangganByN_Sales($n_sales);
        } else {
            $get = $this->api_pelanggan->pelangganData($params);
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

    public function index_post()
    {
        $this->methodNotAllowed();
    }

    public function index_put()
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

    public function update_put()
    {
        $param = json_decode(trim(file_get_contents('php://input')), true);
        $put = null;
        if ($param != null) {
            
            if (isset($param['n_pelanggan']) && array_key_exists('barcode', $param) && isset($param['tanggal']) && isset($param['akun']) && isset($param['nama']) && isset($param['alamat']) && isset($param['telepon']) && isset($param['email']) && isset($param['batas']) && isset($param['status']) && isset($param['n_sales'])) {
                
                if (!empty($param['n_pelanggan'] && $param['tanggal'] && $param['akun']  && $param['nama'] && $param['alamat'] && $param['telepon'] && $param['email'] && $param['batas'] && $param['status'] && $param['n_sales'])) {
                    $put = $this->api_pelanggan->editPelanggan($param);    
                
                } else {
                    $format = [
                        'message'   => 'n_pelanggan, barcode, tanggal, akun, nama, alamat, telpon, email, batas, status, dan n_sales wajib diisi',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            
            } else {
                $format = [
                    'message'   => 'n_pelanggan, barcode, tanggal, akun, nama, alamat, telpon, email, batas, status, dan n_sales wajib ada',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        
        } else {
            $format = [
                'message'   => 'Data tidak berhasil diubah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }

        if (!empty($put)) {
            $format = [
                'message'   => 'Data berhasil diubah',
                'data'      => $param,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        
        } else {
            $format = [
                'message'   => 'Data tidak berhasil diubah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    public function update_get()
    {
        $this->methodNotAllowed();
    }

    public function update_post()
    {
        $this->methodNotAllowed();
    }

    public function update_patch()
    {
        $this->methodNotAllowed();
    }

    public function update_delete()
    {
        $this->methodNotAllowed();
    }

    public function delete_delete()
    {
        $param = $this->input->get('n_pelanggan');
        $delete = null;

        if ($param != null) {
            $delete = $this->api_pelanggan->hapusData($param);

        } else {
            $format = [
                'message'   => 'Data tidak berhasil dihapus',
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
                'message'   => 'Data tidak berhasil dihapus',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    public function delete_get()
    {
        $this->methodNotAllowed();
    }

    public function delete_post()
    {
        $this->methodNotAllowed();
    }

    public function delete_put()
    {
        $this->methodNotAllowed();
    }

    public function delete_patch()
    {
        $this->methodNotAllowed();
    }
}