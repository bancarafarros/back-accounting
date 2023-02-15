<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Barang extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_barang', 'api_barang');
    }

    // Tambah Barang
    public function tambah_post()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        $post = null;
        if ($params != null) {
            if (isset($params['n_barang']) && isset($params['akun_hpp']) && isset($params['akun_persediaan']) && isset($params['akun_pendapatan']) && isset($params['nama']) && isset($params['stock_awal'])) {
                if (!empty($params['n_barang'] && $params['akun_hpp'] && $params['akun_persediaan']  && $params['akun_pendapatan'] && $params['nama'] && $params['stock_awal'])) {
                    $post = $this->api_barang->insertBarang($params);
                } else {
                    $format = [
                        'message'   => 'Nomor barang, akun, nama, dan stock awal wajib diisi',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            } else {
                $format = [
                    'message'   => 'Nomor barang, akun, nama, dan stock awal wajib ada',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        } else {
            $format = [
                'message'   => 'Data kosong atau format penulisan salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
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

    //  Tambah Grup Barang
    public function tambahBarangGrup_post()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        $post = null;
        if ($params != null) {
            if (isset($params['n_grup']) && isset($params['grup'])) {
                if (!empty($params['n_grup'] && $params['grup'])) {
                    $post = $this->api_barang->insertBarangGrup($params);
                } else {
                    $format = [
                        'message'   => 'Nomor grup dan nama grup wajib diisi',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            } else {
                $format = [
                    'message'   => 'Nomor grup dan nama grup wajib ada',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        } else {
            $format = [
                'message'   => 'Data kosong atau format penulisan salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
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
    }

    public function tambahBarangGrup_get()
    {
        $this->methodNotAllowed();
    }

    public function tambahBarangGrup_put()
    {
        $this->methodNotAllowed();
    }

    public function tambahBarangGrup_patch()
    {
        $this->methodNotAllowed();
    }

    public function tambahBarangGrup_delete()
    {
        $this->methodNotAllowed();
    }

    // Ubah Barang
    public function edit_put()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        $put = null;
        if ($params != null) {
            if (isset($params['n_barang']) && isset($params['akun_hpp']) && isset($params['akun_persediaan']) && isset($params['akun_pendapatan']) && isset($params['nama']) && isset($params['stock_awal'])) {
                if (!empty($params['n_barang'] && $params['akun_hpp'] && $params['akun_persediaan']  && $params['akun_pendapatan'] && $params['nama'] && $params['stock_awal'])) {
                    $put = $this->api_barang->updateBarang($params);
                } else {
                    $format = [
                        'message'   => 'Nomor barang, akun, nama, dan stock awal wajib diisi',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            } else {
                $format = [
                    'message'   => 'Nomor barang, akun, nama, dan stock awal wajib ada',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        } else {
            $format = [
                'message'   => 'Data kosong atau format penulisan salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
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

    // Ubah Grup Barang
    public function editBarangGrup_put()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        $put = null;
        if ($params != null) {
            if (isset($params['n_grup']) && isset($params['grup'])) {
                if (!empty($params['n_grup'] && $params['grup'])) {
                    $put = $this->api_barang->updateBarangGrup($params);
                } else {
                    $format = [
                        'message'   => 'Nomor grup dan nama grup wajib diisi',
                        'data'      => null,
                    ];
                    $response = $this->setFormat($this->bad_req, $format);
                    return $this->response($response, $this->bad_req);
                }
            } else {
                $format = [
                    'message'   => 'Nomor grup dan nama grup wajib ada',
                    'data'      => null,
                ];
                $response = $this->setFormat($this->bad_req, $format);
                return $this->response($response, $this->bad_req);
            }
        } else {
            $format = [
                'message'   => 'Data kosong atau format penulisan salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
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
    }

    public function editBarangGrup_get()
    {
        $this->methodNotAllowed();
    }

    public function editBarangGrup_post()
    {
        $this->methodNotAllowed();
    }

    public function editBarangGrup_patch()
    {
        $this->methodNotAllowed();
    }

    public function editBarangGrup_delete()
    {
        $this->methodNotAllowed();
    }

    // Hapus Barang
    public function hapus_delete()
    {
        $params = $this->input->get('n_barang');
        $delete = null;
        if ($params != null) {
            $delete = $this->api_barang->deleteBarang($params);
        } else {
            $format = [
                'message'   => 'Nomor barang tidak ada atau salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
        if (!empty($delete)) {
            $format = [
                'message'   => 'Data berhasil dihapus',
                'data'      => $params,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        } else {
            $format = [
                'message'   => 'Data gagal dihapus',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    public function hapus_get()
    {
        $this->methodNotAllowed();
    }

    public function hapus_post()
    {
        $this->methodNotAllowed();
    }

    public function hapus_put()
    {
        $this->methodNotAllowed();
    }

    public function hapus_patch()
    {
        $this->methodNotAllowed();
    }

    // Hapus Grup Barang
    public function hapusBarangGrup_delete()
    {
        $params = $this->input->get('n_grup');
        $delete = null;
        if ($params != null) {
            $delete = $this->api_barang->deleteBarangGrup($params);
        } else {
            $format = [
                'message'   => 'Nomor grup tidak ada atau salah',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
        if (!empty($delete)) {
            $format = [
                'message'   => 'Data berhasil dihapus',
                'data'      => $params,
            ];
            $response = $this->setFormat($this->ok, $format);
            return $this->response($response, $this->ok);
        } else {
            $format = [
                'message'   => 'Data gagal dihapus',
                'data'      => null,
            ];
            $response = $this->setFormat($this->bad_req, $format);
            return $this->response($response, $this->bad_req);
        }
    }

    public function hapusBarangGrup_get()
    {
        $this->methodNotAllowed();
    }

    public function hapusBarangGrup_post()
    {
        $this->methodNotAllowed();
    }

    public function hapusBarangGrup_put()
    {
        $this->methodNotAllowed();
    }

    public function hapusBarangGrup_patch()
    {
        $this->methodNotAllowed();
    }

    // Ambil Barang
    public function index_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['n_barang'])) {
            $n_barang = $params['n_barang'];
            $get = $this->api_barang->barangByN_Barang($n_barang);
        } else {
            $get = $this->api_barang->barangData();
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

    // Ambil Grup Barang
    public function barangGrup_get()
    {
        $params = $this->input->get();
        $get = null;
        if (!empty($params['n_grup'])) {
            $n_grup = $params['n_grup'];
            $get = $this->api_barang->barangGrupByN_Grup($n_grup);
        } else {
            $get = $this->api_barang->barangGrupData();
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

    public function barangGrup_post()
    {
        $this->methodNotAllowed();
    }

    public function barangGrup_put()
    {
        $this->methodNotAllowed();
    }

    public function barangGrup_patch()
    {
        $this->methodNotAllowed();
    }

    public function barangGrup_delete()
    {
        $this->methodNotAllowed();
    }
}
