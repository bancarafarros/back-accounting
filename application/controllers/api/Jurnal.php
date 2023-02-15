<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Jurnal extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_jurnal', 'api_jurnal');
    }

    // Tambah Jurnal
    public function tambah_post()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        $params['n_jurnal'] = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');
        $post = null;
        if ($params != null) {
            for ($br = 0; $br < $params['jml_baris']; $br++) {
                if (isset($params['akun' . $br]) && isset($params['tanggal']) && isset($params['jml_baris']) && isset($params['keterangan'])) {
                    if (!empty($params['akun' . $br] && $params['tanggal'] && $params['jml_baris'] && $params['keterangan'])) {
                        $post = $this->api_jurnal->insertJurnal($params);
                        if (!empty($post)) {
                            $format = [
                                'message'   => 'Data berhasil ditambahkan',
                                'data'      => $params,
                            ];
                            $response = $this->setFormat($this->ok, $format);
                            return $this->response($response, $this->ok);
                        } else {
                            $format = [
                                'message'   => 'Data gagal ditambahkan',
                                'data'      => null,
                            ];
                            $response = $this->setFormat($this->bad_req, $format);
                            return $this->response($response, $this->bad_req);
                        }
                    } else {
                        $format = [
                            'message'   => 'Akun, tanggal, jumlah baris, dan keterangan wajib diisi',
                            'data'      => null,
                        ];
                        $response = $this->setFormat($this->bad_req, $format);
                        return $this->response($response, $this->bad_req);
                    }
                } else {
                    $format = [
                        'message'   => 'Akun, tanggal, jumlah baris, dan keterangan wajib ada',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            }
        } else {
            $format = [
                'message'   => 'Data kosong atau format penulisan salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    public function tambah_get()
    {
        $this->methodNotAllowed();
    }

    public function tambah_put()
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

    // Ubah Jurnal berdasarkan statusA di Hjurnal, hanya GL yang boleh diubah
    public function edit_put()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        $put = null;
        if ($params != null) {
            for ($br = 0; $br < $params['jml_baris']; $br++) {
                if (isset($params['n_jurnal']) && isset($params['akun' . $br]) && isset($params['tanggal']) && isset($params['jml_baris']) && isset($params['keterangan'])) {
                    if (!empty($params['n_jurnal'] && $params['akun' . $br] && $params['tanggal'] && $params['jml_baris'] && $params['keterangan'])) {
                        if ($this->api_jurnal->cekStatusA($params['n_jurnal'])) {
                            $put = $this->api_jurnal->updateJurnal($params);
                            if (!empty($put)) {
                                $format = [
                                    'message'   => 'Data berhasil diubah',
                                    'data'      => $params,
                                ];
                                $response = $this->setFormat($this->ok, $format);
                                return $this->response($response, $this->ok);
                            } else {
                                $format = [
                                    'message'   => 'Data gagal diubah',
                                    'data'      => null,
                                ];
                                $response = $this->setFormat($this->bad_req, $format);
                                return $this->response($response, $this->bad_req);
                            }
                        } else {
                            $format = [
                                'message'   => 'Hanya bisa mengubah jurnal memorial saja',
                                'data'      => null,
                            ];
                            $response = $this->setFormat($this->bad_req, $format);
                            return $this->response($response, $this->bad_req);
                        }
                    } else {
                        $format = [
                            'message'   => 'Nomor jurnal, akun, tanggal, jumlah baris, dan keterangan wajib diisi',
                            'data'      => null,
                        ];
                        $response = $this->setFormat($this->bad_req, $format);
                        return $this->response($response, $this->bad_req);
                    }
                } else {
                    $format = [
                        'message'   => 'Nomor jurnal, akun, tanggal, jumlah baris, dan keterangan wajib ada',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            }
        } else {
            $format = [
                'message'   => 'Data kosong atau format penulisan salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

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

    // Ambil Hjurnal
    public function index_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['tanggal'])) {
            $tanggal = $params['tanggal'];
            $get = $this->api_jurnal->hJurnalByTanggal($tanggal);
        } else {
            $get = $this->api_jurnal->hJurnal();
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

    // Ambil Djurnal
    public function detail_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['n_jurnal'])) {
            $n_jurnal = $params['n_jurnal'];
            $get = $this->api_jurnal->dJurnalByN_jurnal($n_jurnal);
        } else {
            $format = [
                'message'   => 'Harap masukkan nomor jurnal',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
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

    public function detail_post()
    {
        $this->methodNotAllowed();
    }

    public function detail_put()
    {
        $this->methodNotAllowed();
    }

    public function detail_patch()
    {
        $this->methodNotAllowed();
    }

    public function detail_delete()
    {
        $this->methodNotAllowed();
    }
}
