<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends BaseController
{
	protected $template = "app";
	protected $module = 'hutang';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_hutang');
		$this->load->model('M_pemasok');
		$this->load->model('M_jurnal');
		$this->load->model('M_bank');
		$this->bread[] = ['title' => 'Hutang', 'url' => site_url('hutang')];
	}

	public function index()
	{
		$this->data['menu'] = 'm5-1';
		$title = 'Transaksi Hutang';
		$this->data['judul_title'] = $title;
		$tanggal = date('Y-m-d');
		$this->data['tanggal'] = $tanggal;
		$this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
		$this->data['d_pemasok'] = $this->M_pemasok->getData();
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['scripts'] = ['hutang/js/index.js'];
		$this->render('index');
	}

	public function formHutang($var = null)
	{
		$this->data['menu'] = 'm5-2';
		$title = 'Pembayaran Hutang';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => site_url('hutang/formhutang')]);
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_pemasok'] = $this->M_pemasok->getData();
		$this->data['scripts'] = ['hutang/js/b_hutang.js'];
		$this->render('b_hutang');
	}

	public function do_pembayaran()
	{
		$param = $this->input->post();
		$d_pemasok = $this->M_pemasok->getDetail($param['pemasok']);

		//generate no.transaksi
		$param['n_transaksi'] = generateNomorForAccounting('PY', 'dhutang', 'n_hutang');

		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}
		// echo $n_jurnal;

		//generate jurnal
		$jurnal = ['debet' => $d_pemasok->akun, 'kredit' => $cara_bayar];

		// print_r($jurnal);

		$proses = $this->M_hutang->insBayarHutang($param, $jurnal, $n_jurnal);
		if ($proses['status']) {
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
			$proses['n_transaksi'] = $param['n_transaksi'];
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("hutang/cetak_nota_bayar/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function dosave()
	{
		$param = $this->input->post();
		$d_pemasok = $this->M_pemasok->getDetail($param['n_pemasok']);
		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		// Generate no. transaksi
		$param['n_pembelian'] = generateNomorForAccounting('PN', 'hutang', 'n_pembelian');

		//cara bayar
		if ($param['c_bayar'] == "kas") {
			$n_penghubung = getPenghubung($param['c_bayar']);
			$cara_bayar = $n_penghubung['akun'];
		}
		if ($param['c_bayar'] == "bank") {
			$cara_bayar = $param['akun_bank'];
		}

		//generate jurnal
		$jurnal = ['debet' => $cara_bayar, 'kredit' => $d_pemasok->akun];

		$proses = $this->M_hutang->insertHutang($param, $jurnal, $n_jurnal);
		if ($proses['status']) {
			$this->session->set_flashdata('true', $proses['message']);
			$this->session->set_userdata(['n_transaksi' => $param['n_pembelian']]);
			$proses['n_transaksi'] = $param['n_pembelian'];
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("hutang/cetak_nota/" . $param['n_pembelian'] . '?download=false');
		}
	}

	public function getKartu()
	{
		$kode = $this->input->get('n_pemasok');
		$data = $this->M_hutang->get_kartu_by_pemasok($kode);
		echo json_encode($data);
	}

	public function getDtHutang()
	{
		$kode = $this->input->get('n_pemasok');
		$data = $this->M_hutang->d_hutang($kode);
		echo json_encode($data);
	}

	public function cetak_nota($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('hutang');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_hutang->get_cetak_notaHutang($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('hutang');
		}
		$x['judul_title'] = 'Bukti Transaksi Hutang';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['data']['tempo_indo'] = $this->tanggalindo->konversi($x['data']['tempo']);
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'transaksi-hutang-' . $x['data']['n_pembelian'] . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('hutang/nota_hutang', $filename, $x, $download);
	}

	public function cetak_nota_bayar($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('hutang/formhutang');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_hutang->get_cetak_notaBhutang($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('hutang/formhutang');
		}
		$x['judul_title'] = 'Bukti Transaksi Bayar Hutang';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['datas'] = $result->result_array();
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'transaksi-bayar-hutang-' . $x['data']['n_pembelian'] . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('hutang/nota_bhutang', $filename, $x, $download);
	}
}
