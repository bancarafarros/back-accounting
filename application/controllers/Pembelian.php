<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends BaseController
{
	protected $template = "app";
	protected $module = 'pembelian';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_pemasok');
		$this->load->model('M_barang');
		$this->load->model('M_pembelian');
		$this->load->model('M_bank');
		$this->bread[] =  ['title' => 'Pembelian', 'url' => site_url('pembelian')];
	}

	public function index()
	{
		$this->data['menu'] = 'm4-1';
		$title = 'Pembelian';
		$this->data['judul_title'] = $title;
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_barang'] = $this->M_barang->getDataBarang();
		$this->data['d_pemasok'] = $this->M_pemasok->getData();
		$this->data['d_order'] = $this->M_pembelian->getOrderPembelian();
		$this->data['scripts'] = ['pembelian/js/index.js'];
		$this->render('index');
	}

	public function or_beli()
	{
		$this->data['judul_title'] = 'Order Pembelian';
		@$n_Opembelian = getNoLast('n_opembelian', 'hpembelian_order');
		$lst_pemb = substr(@$n_Opembelian->n_opembelian, 8) + 1;
		$id_pemb = str_pad($lst_pemb, 4, "0", STR_PAD_LEFT);

		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_barang'] = $this->M_barang->getData();
		$this->data['d_pemasok'] = $this->M_pemasok->getData();
		$this->data['n_transaksi'] = "PO0000AD" . $id_pemb;

		$this->render('or_beli');
	}

	public function ret_beli()
	{
		$this->data['menu'] = 'm4-2';
		$title = 'Retur Pembelian';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => site_url('pembelian/ret_beli')]);

		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_barang'] = $this->M_barang->getDataBarang();
		$this->data['d_pemasok'] = $this->M_pemasok->getData();
		$this->data['d_order'] = $this->M_pembelian->getOrderPembelian();
		$this->data['d_pembelian'] = $this->M_pembelian->getDatapemb();
		$this->data['scripts'] = ['pembelian/js/ret_beli.js'];

		$this->render('ret_beli');
	}

	public function dt_beli()
	{
		$data['judul_title'] = 'Daftar Transaksi Pembelian';

		$this->load->view('master/header', $data);
		$this->load->view('master/l_sidebar', $data);
		$this->load->view('pembelian/top_nav');
		$this->load->view('pembelian/dt_beli');
		$this->load->view('master/footer');
	}

	// public function dor_beli()
	// {
	// 	if($this->M_admin->logged_id()) {

	// 	$data['judul_title'] = 'Daftar Order Pembelian';

	// 	$this->load->view('master/header',$data);
	// 	$this->load->view('master/l_sidebar',$data);
	// 	$this->load->view('pembelian/top_nav');
	// 	$this->load->view('pembelian/dor_beli');
	// 	$this->load->view('master/footer');
	// }

	// public function dret_beli()
	// {
	// 	$data['judul_title'] = 'Daftar Retur Pembelian';

	// 	$this->load->view('master/header',$data);
	// 	$this->load->view('master/l_sidebar',$data);
	// 	$this->load->view('pembelian/top_nav');
	// 	$this->load->view('pembelian/dret_beli');
	// 	$this->load->view('master/footer');
	// }

	// 	public function history()
	// {
	// 	$data['judul_title'] = 'Transaksi Pembelian';

	// 	$this->load->view('master/header',$data);
	// 	$this->load->view('master/l_sidebar',$data);
	// 	$this->load->view('pembelian/top_nav_history');
	// 	$this->load->view('pembelian/history');
	// 	$this->load->view('master/footer');
	// }

	public function do_pembelian()
	{
		$param = $this->input->post();
		// get no.transaksi
		$param['n_transaksi'] = generateNomorForAccounting('PT', 'hpembelian', 'n_pembelian');

		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		// echo $n_jurnal."<br>";
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		//cek penghubung 
		$n_ppn = getPenghubung("pb")['akun'];
		$n_biaya = getPenghubung("bkb")['akun'];
		$n_diskon = getPenghubung("dsp")['akun'];
		$brg = 0;

		$n_pemasok = explode(" | ", $param['n_pemasok']);
		$n_pemasok = $this->M_pemasok->getDetail($n_pemasok[0]);

		//pengolahan data barang
		for ($sm = 0; $sm < $param['sum_barang']; $sm++) {
			if (@$param['n_barang' . $sm]) {
				$n_barang[$sm] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				$barang_a[] = [$n_barang[$sm]->akun_persediaan => $param['hargaT_asli' . $sm]];
				$s_barang[] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				if ($param['satuan_barang' . $sm] == $s_barang[$brg]->konversi_unit) {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->b_unit;
				} else {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->n_unit;
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
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			if (@$param['n_barang' . $br]) {
				$hasil[] = $param['perkiraan' . $br] . "," . @$barang_a[$param['perkiraan' . $br]];
			}
		}

		$djurnal = array_unique($hasil);
		//generate jurnal
		$jurnal = ['kredit' => $cara_bayar, 'ppn' => $n_ppn, 'biaya' => $n_biaya, 'nomor' => $n_jurnal, 'a_pemasok' => $n_pemasok->akun, 'diskon' => $n_diskon];


		$proses = $this->M_pembelian->insertPembelian($param, $jurnal, $djurnal, $stock_barang);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_transaksi'];
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("pembelian/cetak_nota/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function do_Retpembelian()
	{
		$param = $this->input->post();
		$param['n_transaksi'] = generateNomorForAccounting('PR', 'hpembelian_retur', 'n_rpembelian');

		// print_r($param);
		// echo '<br>';
		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');
		// echo $n_jurnal."<br>";
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		//cek penghubung 
		$n_ppn = getPenghubung("pb")['akun'];
		$n_biaya = getPenghubung("bkb")['akun'];
		$n_diskon = getPenghubung("dsp")['akun'];
		$brg = 0;

		$n_pemasok = explode(" | ", $param['n_pemasok']);
		$n_pemasok = $this->M_pemasok->getDetail($n_pemasok[0]);

		for ($sm = 0; $sm <= $param['sum_barang']; $sm++) {
			if (@$param['n_barang' . $sm]) {
				$n_barang[$sm] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				$barang_a[] = [$n_barang[$sm]->akun_persediaan => $param['hargaT_asli' . $sm]];
				$s_barang[] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				if ($param['satuan_barang' . $sm] == $s_barang[$brg]->konversi_unit) {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->b_unit;
				} else {
					$param['satuan_barang' . $sm] = $s_barang[$brg]->n_unit;
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
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			if (@$param['n_barang' . $br]) {
				$hasil[] = $param['perkiraan' . $br] . "," . @$barang_a[$param['perkiraan' . $br]];
			}
		}

		$djurnal = array_unique($hasil);
		//generate jurnal
		$jurnal = ['kredit' => $cara_bayar, 'ppn' => $n_ppn->akun, 'biaya' => $n_biaya->akun, 'nomor' => $n_jurnal, 'a_pemasok' => $n_pemasok->akun, 'diskon' => $n_diskon->akun];
		// echo '<br>';
		// print_r($param);
		// echo '<br>';
		// print_r($jurnal);
		// echo '<br>';
		// print_r($djurnal);
		// echo '<br>';
		// print_r($stock_barang);
		// echo '<br>';
		// print_r($barang_a);

		$proses = $this->M_pembelian->insertReturPembelian($param, $jurnal, $djurnal, $stock_barang);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_transaksi'];
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("pembelian/cetak_notaR/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function do_Orpembelian()
	{
		$param = $this->input->post();
		print_r($param);
		// Generate no. jurnal
		$datenow = date("my");
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');
		// echo $n_jurnal."<br>";
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}
		$n_ppn = getPenghubung("pb");
		$n_biaya = getPenghubung("bkb");
		$n_pemasok = explode(" | ", $param['n_pemasok']);
		$n_pemasok = $this->M_pemasok->getDetail($n_pemasok[1]);

		for ($sm = 0; $sm <= $param['sum_barang']; $sm++) {
			$n_barang[$sm] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
			$barang_a[] = [$n_barang[$sm]->akun_persediaan => $param['total' . $sm]];
			$s_barang[] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
			$stock_barang[] = $s_barang[$sm]->n_barang . "," . $s_barang[$sm]->stock_gudang;
		}
		foreach ($barang_a as $k => $subArray) {
			foreach ($subArray as $id => $value) {
				@$barang_a[$id] += $value;
			}
		}
		for ($br = 0; $br <= $param['sum_barang']; $br++) {
			$hasil[] = $param['perkiraan' . $br] . "," . $barang_a[$param['perkiraan' . $br]];
		}
		$djurnal = array_unique($hasil);
		//generate jurnal
		$jurnal = ['kredit' => $cara_bayar, 'ppn' => $n_ppn['akun'], 'biaya' => $n_biaya['akun'], 'nomor' => $n_jurnal, 'a_pemasok' => $n_pemasok->akun];

		$this->M_pembelian->insertOrpembelian($param, $jurnal, $djurnal, $stock_barang);
		redirect("pembelian/or_beli");
	}

	public function getOrder()
	{
		$kode = $this->input->get('n_order');
		$data = $this->M_pembelian->getdOrder($kode);
		echo json_encode($data);
	}

	public function getPembelian()
	{
		$kode = $this->input->get('n_pembelian');
		$data = $this->M_pembelian->getdPemb($kode);
		echo json_encode($data);
	}

	public function cetak_nota($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('pembelian');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_pembelian->get_cetak_nota($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('pembelian');
		}
		$x['judul_title'] = 'Nota Pembelian';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['datas'] = $result->result_array();
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'nota-pembelian-' . $x['data']['n_pembelian'] . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('pembelian/nota_pembelian', $filename, $x, $download);
	}

	public function cetak_notaR()
	{
		$param = $this->input->post();
		$x['data'] = $this->M_pembelian->get_cetak_notaR($this->session->userdata('n_transaksi'));
		// print_r($x['data']->row_array());
		$this->load->view('pembelian/nota_pembelianR', $x);
	}
}
