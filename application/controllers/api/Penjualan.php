<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Api.php';

class Penjualan extends Apicontroller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_pelanggan');
		$this->load->model('M_barang');
		$this->load->model('M_penjualan');
		$this->load->model('M_bank');
		$this->load->model('M_piutang');
		$this->load->model('api/Api_penjualan', 'api_penjualan');
	}

	public function index_get()
    {
		$this->methodNotAllowed();
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

	public function create_post()
    {
        $param = json_decode(trim(file_get_contents('php://input')), true);

		//get no transaksi
		$param['n_transaksi'] = generateNomorForAccounting('ST', 'hpenjualan', 'n_penjualan');

		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		//cara bayar
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		//cek penghubung
		$n_ppn = getPenghubung("pj")['akun'];
		$n_biaya = getPenghubung("bkj")['akun'];
		$n_diskon = getPenghubung("dsk")['akun'];
		$brg = 0;

		$n_pelanggan = explode(" | ", $param['n_pelanggan']);
		$n_pelanggan = $this->M_pelanggan->getDetail($n_pelanggan[0]);

		//pengolahan data barang
		for ($sm = 0; $sm <= $param['sum_barang']; $sm++) {
			if (@$param['n_barang' . $sm]) {
				$n_barang[$sm] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				$barang_a[] = [$n_barang[$sm]->akun_pendapatan => $param['hargaT_asli' . $sm]];
				$barang_b[] = [$n_barang[$sm]->akun_hpp => $param['total_hpp' . $sm]];
				$barang_c[] = [$n_barang[$sm]->akun_persediaan => $param['total_hpp' . $sm]];
				$s_barang[] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				if ($param['satuan_barang' . $sm] == $s_barang[$brg]->konversi_unit) {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->b_unit;
				} else {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->n_unit;
				}
				$stock_barang[] = $s_barang[$brg]->n_barang . "," . $s_barang[$brg]->stock_gudang . "," . $s_barang[$brg]->harga_jual1 . "," . $s_barang[$brg]->stock_etalase;
				$brg++;
			}
		}
		foreach ($barang_a as $k => $subArray) {
			foreach ($subArray as $id => $value) {
				@$barang_a[$id] += $value;
			}
		}
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			if (@$param['n_barang' . $br]) {
				$hasil1[] = $param['akunpendapatan' . $br] . "," . $barang_a[$param['akunpendapatan' . $br]];
			}
		}
		$djurnal1 = array_unique($hasil1);

		foreach ($barang_b as $k => $subArray) {
			foreach ($subArray as $id => $value) {
				@$barang_b[$id] += $value;
			}
		}
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			if (@$param['n_barang' . $br]) {
				$hasil2[] = $param['akunhpp' . $br] . "," . $barang_b[$param['akunhpp' . $br]];
			}
		}
		$djurnal2 = array_unique($hasil2);

		foreach ($barang_c as $k => $subArray) {
			foreach ($subArray as $id => $value) {
				@$barang_c[$id] += $value;
			}
		}
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			if (@$param['n_barang' . $br]) {
				$hasil3[] = $param['akunpersediaan' . $br] . "," . $barang_c[$param['akunpersediaan' . $br]];
			}
		}
		$djurnal3 = array_unique($hasil3);
		//generate jurnal
		$jurnal = array('debet' => $cara_bayar, 'ppn' => $n_ppn, 'biaya' => $n_biaya, 'nomor' => $n_jurnal, 'a_pelanggan' => $n_pelanggan->akun, 'diskon' => $n_diskon);

        $post = null;
        if ($param != null) {
            $post = $this->api_penjualan->insertPenjualan($param, $jurnal, $djurnal1, $djurnal2, $djurnal3, $stock_barang);

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
}