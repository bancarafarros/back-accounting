<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Pembelian extends Apicontroller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_pembelian', 'api_pembelian');
        $this->load->model('M_jurnal');
        $this->load->model('M_pemasok');
        $this->load->model('M_barang');
        $this->load->model('M_pembelian');
    }

    // Tambah Pembelian
    public function tambah_post()
    {
        $params = json_decode(trim(file_get_contents('php://input')), true);
        // var_dump($params);
        // die;

        // Generate no.transaksi
        $params['n_transaksi'] = generateNomorForAccounting('PT', 'hpembelian', 'n_pembelian');

        // Generate no. jurnal
        $n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

        if ($params['c_bayar'] == "kas") {
            $n_penghubung = getPenghubung($params['c_bayar']);
            $cara_bayar = $n_penghubung['akun'];
        }
        if ($params['c_bayar'] == "bank") {
            $cara_bayar = $params['akun_bank'];
        }

        // Cek penghubung 
        $n_ppn = getPenghubung("pb")['akun'];
        $n_biaya = getPenghubung("bkb")['akun'];
        $n_diskon = getPenghubung("dsp")['akun'];
        $brg = 0;

        $n_pemasok = explode(" | ", $params['n_pemasok']);
        $n_pemasok = $this->M_pemasok->getDetail($n_pemasok[0]);

        $post = null;
        if ($params != null) {
            // Pengolahan data barang
            for ($sm = 0; $sm < $params['sum_barang']; $sm++) {
                if (@$params['n_barang' . $sm]) {
                    $n_barang[$sm] = $this->M_barang->getDetailBarang($params['n_barang' . $sm]);
                    $barang_a[] = [$n_barang[$sm]->akun_persediaan => $params['hargaT_asli' . $sm]];
                    $s_barang[] = $this->M_barang->getDetailBarang($params['n_barang' . $sm]);
                    if ($params['satuan_barang' . $sm] == $s_barang[$brg]->konversi_unit) {
                        $params['satuan_barang' . $sm] = $s_barang[$brg]->b_unit;
                    } else {
                        $params['satuan_barang' . $sm] = $s_barang[$brg]->n_unit;
                    }
                    $stock_barang[] = $s_barang[$brg]->n_barang . "," . $s_barang[$brg]->stock_gudang . "," . $s_barang[$brg]->harga_pokok . "," . $s_barang[$brg]->stock_etalase;
                    $brg++;
                }
            }
            foreach ($barang_a as $k => $subArray) {
                foreach ($subArray as $id => $value) {
                    @$barang_a[$id] += $value;
                }
            }
            for ($br = 0; $br <= $params['sum_barang']; $br++) {
                if (@$params['n_barang' . $br]) {
                    $hasil[] = $params['perkiraan' . $br] . "," . @$barang_a[$params['perkiraan' . $br]];
                }
            }

            $djurnal = array_unique($hasil);

            // Generate jurnal
            $jurnal = ['kredit' => $cara_bayar, 'ppn' => $n_ppn, 'biaya' => $n_biaya, 'nomor' => $n_jurnal, 'a_pemasok' => $n_pemasok->akun, 'diskon' => $n_diskon];


            $post = $this->api_pembelian->insertPembelian($params, $jurnal, $djurnal, $stock_barang);
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
}
