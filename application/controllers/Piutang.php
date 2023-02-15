<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends BaseController
{
	protected $template = "app";
	protected $module = 'piutang';
	public $loginBehavior = true;
	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_piutang');
		$this->load->model('M_pelanggan');
		$this->load->model('M_jurnal');
		$this->load->model('M_bank');
		$this->bread[] = ['title' => 'Piutang', 'url' => site_url('piutang')];
	}

	public function index()
	{
		$this->data['menu'] = 'm3-1';
		$title = 'Transaksi Piutang';
		$this->data['judul_title'] = $title;
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_kartupiutang'] = $this->M_piutang->getDataPiutang();
		$this->data['scripts'] = ['piutang/js/index.js'];
		$this->render('index');
	}

	public function b_piutang()
	{
		$this->data['menu'] = 'm3-2';
		$title = 'Pembayaran Piutang';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => site_url('piutang/b_piutang')]);
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['scripts'] = ['piutang/js/b_piutang.js'];
		$this->render('b_piutang');
	}

	public function do_pembayaran()
	{
		$param = $this->input->post();
		//print_r($param);
		$d_pelanggan = $this->M_pelanggan->getDetail($param['pelanggan']);

		//generate no.transaksi
		$param['n_transaksi'] = generateNomorForAccounting('RY', 'dpiutang', 'n_piutang');

		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		//generate jurnal
		$jurnal = ['debet' => $cara_bayar, 'kredit' => $d_pelanggan->akun];

		$proses = $this->M_piutang->insBayarPiutang($param, $jurnal, $n_jurnal);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_transaksi'];
			$this->session->set_flashdata('true', 'Transaksi pembayar piutang berhasil');
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("piutang/cetak_nota_bayar/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function dosave()
	{
		$param = $this->input->post();
		$d_pelanggan = $this->M_pelanggan->getDetail($param['n_pelanggan']);
		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		// Generate no. transaksi
		$param['n_penjualan'] = generateNomorForAccounting('RN', 'piutang', 'n_penjualan');
		//cara bayar
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		//generate jurnal
		$jurnal = ['debet' => $d_pelanggan->akun, 'kredit' => $cara_bayar];

		$proses = $this->M_piutang->insertPiutang($param, $jurnal, $n_jurnal);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_penjualan'];
			$this->session->set_flashdata('true', 'Transaksi piutang berhasil');
			$this->session->set_userdata(['n_transaksi' => $param['n_penjualan']]);
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("piutang/cetak_nota/" . $param['n_penjualan'] . '?download=false');
		}
	}

	public function getKartu()
	{
		$kode = $this->input->get('n_pelanggan');
		// var_dump($kode);
		// die;
		$data = $this->M_piutang->get_kartu_by_pelanggan($kode);
		// var_dump($data);
		// die;
		echo json_encode($data);
	}

	public function getDPiutang()
	{
		$kode = $this->input->get('n_pelanggan');
		$data = $this->M_piutang->get_d_piutang($kode);
		echo json_encode($data);
	}

	public function cetak_nota($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('piutang');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_piutang->get_cetak_notaPiutang($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('piutang');
		}
		$x['judul_title'] = 'Bukti Transaksi Piutang';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['data']['tempo_indo'] = $this->tanggalindo->konversi($x['data']['tempo']);
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'transaksi-piutang-' . $n_transaksi . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('piutang/nota_piutang', $filename, $x, $download);
	}

	public function cetak_nota_bayar($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('piutang/b_piutang');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_piutang->get_cetak_notaBpiutang($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('piutang/b_piutang');
		}
		$x['judul_title'] = 'Bukti Transaksi Bayar Piutang';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['datas'] = $result->result_array();
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'transaksi-bayar-piutang-' . $n_transaksi . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('piutang/nota_bpiutang', $filename, $x, $download);
	}
}
