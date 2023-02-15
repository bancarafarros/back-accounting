<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends BaseController
{
	protected $template = "app";
	protected $module = 'penjualan';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_pelanggan');
		$this->load->model('M_barang');
		$this->load->model('M_penjualan');
		$this->load->model('M_bank');
		$this->load->model('M_piutang');
		$this->bread[] = ['title' => 'Penjualan', 'url' => site_url('penjualan')];
	}

	public function index()
	{
		$this->data['menu'] = 'm2-1';
		$title = 'Transaksi Penjualan';
		$this->data['judul_title'] = $title;
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_barang'] = $this->M_barang->getData();
		$this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_kartupiutang'] = $this->M_piutang->getDataPiutang();
		$this->data['scripts'] = ['penjualan/js/index.js'];
		$this->render('index');
	}

	public function ret_jual()
	{
		$this->data['menu'] = 'm2-2';
		$title = 'Retur Penjualan';
		$this->data['judul_title'] = $title;
		$this->bread[] = ['title' => $title];
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_barang'] = $this->M_barang->getData();
		$this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_penjualan'] = $this->M_penjualan->getDatapenj();
		$this->data['scripts'] = ['penjualan/js/ret_jual.js'];
		$this->render('ret_jual');
	}

	public function getDetailpenj()
	{
		$kode = $this->input->get('n_penjualan');
		$data = $this->M_penjualan->get_d_penjualan($kode);
		echo json_encode($data);
	}

	public function do_penjualan()
	{
		$param = $this->input->post();
		//print_r($param);

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
		$jurnal = ['debet' => $cara_bayar, 'ppn' => $n_ppn, 'biaya' => $n_biaya, 'nomor' => $n_jurnal, 'a_pelanggan' => $n_pelanggan->akun, 'diskon' => $n_diskon];
		$proses = $this->M_penjualan->insertPenjualan($param, $jurnal, $djurnal1, $djurnal2, $djurnal3, $stock_barang);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_transaksi'];
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("penjualan/cetak_nota/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function do_retpenjualan()
	{

		// get no.transaksi
		$userId = $this->session->userdata("t_userId");
		@$n_penjualan = $this->M_jurnal->getNoLastTransaksi('n_rpenjualan', 'hpenjualan_retur', $userId, "SR");
		$lst_penj = @$n_penjualan->n_last + 1;

		if ($lst_penj >= 10000) {
			$lst_penj = 1;
		}

		$id_penj = str_pad($lst_penj, 4, "0", STR_PAD_LEFT);
		$datenow = date("my");

		$param = $this->input->post();
		$param['n_transaksi'] = "SR" . $datenow . $userId . $id_penj;

		// Generate no. jurnal
		$datenow = date("my");
		$userId = $this->session->userdata("t_userId");
		@$h_jurnal = $this->M_jurnal->getNoLastTransaksi('n_jurnal', 'hjurnal', $userId, 'GL');
		@$d_jurnal = $this->M_jurnal->getNoLastTransaksi('n_jurnal', 'djurnal', $userId, 'GL');

		if ($h_jurnal->n_last == $d_jurnal->n_last) {
			$id_jurnal = $h_jurnal->n_last + 1;
		}
		if ($h_jurnal->n_last < $d_jurnal->n_last) {
			$id_jurnal = $d_jurnal->n_last + 1;
		}
		if ($h_jurnal->n_last > $d_jurnal->n_last) {
			$id_jurnal = $h_jurnal->n_last + 1;
		}

		if ($id_jurnal >= 10000) {
			$id_jurnal = 1;
		}
		$no_jurnal = str_pad($id_jurnal, 4, "0", STR_PAD_LEFT);
		$n_jurnal = "GL" . $datenow . $userId . $no_jurnal;
		// echo $n_jurnal."<br>";
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = $this->M_jurnal->getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung->akun;
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		$n_ppn = $this->M_jurnal->getPenghubung("pj");
		$n_biaya = $this->M_jurnal->getPenghubung("bkj");
		$n_diskon = $this->M_jurnal->getPenghubung("dsk");
		$brg = 0;

		$n_pelanggan = explode(" | ", $param['n_pelanggan']);
		$n_pelanggan = $this->M_pelanggan->getDetail($n_pelanggan[0]);

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
		$jurnal = ['kredit' => $cara_bayar, 'ppn' => $n_ppn->akun, 'biaya' => $n_biaya->akun, 'nomor' => $n_jurnal, 'a_pelanggan' => $n_pelanggan->akun, 'diskon' => $n_diskon->akun];
		$this->M_penjualan->returPenjualan($param, $jurnal, $djurnal1, $djurnal2, $djurnal3, $stock_barang);
		$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		redirect("Penjualan/cetak_notaR");
	}

	public function getPenjualan()
	{
		$kode = $this->input->get('n_penjualan');
		$data = $this->M_penjualan->getdPenj($kode);
		echo json_encode($data);
	}


	public function cetak_nota($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('penjualan');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_penjualan->get_cetak_nota($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('penjualan');
		}
		$x['judul_title'] = 'Nota Penjualan';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['datas'] = $result->result_array();
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'nota-penjualan-' . $x['data']['n_penjualan'] . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('penjualan/nota_penjualan', $filename, $x, $download);
	}

	public function cetak_notaR()
	{
		$param = $this->input->post();
		$x['data'] = $this->M_penjualan->get_cetak_notaR($this->session->userdata('n_transaksi'));
		// print_r($x['data']->row_array());
		$this->load->view('penjualan/nota_penjualanR', $x);
	}

	public function or_jual()
	{
		$data['judul_title'] = 'Transaksi Order Penjualan';

		$this->load->view('master/header', $data);
		$this->load->view('master/l_sidebar', $data);
		$this->load->view('penjualan/top_nav');
		$this->load->view('penjualan/or_jual');
		$this->load->view('master/footer');
	}

	public function dt_jual()
	{
		$data['judul_title'] = 'Daftar Transaksi Penjualan';

		$this->load->view('master/header', $data);
		$this->load->view('master/l_sidebar', $data);
		$this->load->view('penjualan/top_nav');
		$this->load->view('penjualan/dt_jual');
		$this->load->view('master/footer');
	}

	public function dor_jual()
	{
		$data['judul_title'] = 'Daftar Order Penjualan';

		$this->load->view('master/header', $data);
		$this->load->view('master/l_sidebar', $data);
		$this->load->view('penjualan/top_nav');
		$this->load->view('penjualan/dor_jual');
		$this->load->view('master/footer');
	}

	public function dret_jual()
	{
		$data['judul_title'] = 'Daftar Retur Penjualan';

		$this->load->view('master/header', $data);
		$this->load->view('master/l_sidebar', $data);
		$this->load->view('penjualan/top_nav');
		$this->load->view('penjualan/dret_jual');
		$this->load->view('master/footer');
	}

	public function history()
	{
		$data['judul_title'] = 'Transaksi Penjualan';

		$this->load->view('master/header', $data);
		$this->load->view('master/l_sidebar', $data);
		$this->load->view('penjualan/top_nav_history');
		$this->load->view('penjualan/history');
		$this->load->view('master/footer');
	}
}
