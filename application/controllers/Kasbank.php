<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasbank extends BaseController
{
	protected $template = "app";
	protected $module = 'kasbank';
	public $loginBehavior = true;

	protected $bread = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_kasbank');
		$this->load->model('M_bank');
		$this->load->model('datatable/Dt_kasbank', 'dtkasbank');
		$this->bread[] = ['title' => 'Transaksi Kas & Bank', 'url' => site_url('kasbank')];
	}

	public function index()
	{
		$title = 'Transaksi Kas & Bank';
		$this->data['optionBulan'] = optionMonth();
		$this->data['optionTahun'] = optionYear();
		$this->data['judul_title'] = $title;

		$this->data['scripts'] = ['kasbank/js/index.js'];
		$this->render('index');
	}

	public function datatable()
	{
		$list = $this->dtkasbank->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $pel) {
			$no++;
			$row = array();
			$row[] = '
			<a role="button" href="' . site_url('kasbank/cetak_nota/' . $pel->n_kasbank . '?download=true') . '" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></a>
			<a role="button" target="_blank" href="' . site_url('kasbank/cetak_nota/' . $pel->n_kasbank . '?download=false') . '" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>';
			$row[] =
				'<div class="text-center">'
				. $no .
				'</div>';
			$row[] = $pel->n_kasbank;
			$row[] = $this->tanggalindo->konversi($pel->tanggal);
			$row[] = $pel->reff;
			$row[] = $pel->keterangan;
			$row[] = 'Berhasil';
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->dtkasbank->count_all(),
			"recordsFiltered" => $this->dtkasbank->count_filtered(),
			"data"            => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$this->data['menu'] = 'm6-1';
		$title = 'Tambah Transaksi';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => site_url('kasbank/tambah')]);
		$this->data['tanggal'] = date('Y-m-d');
		$this->data['tanggal_indo'] = $this->tanggalindo->konversi($this->data['tanggal']);
		$this->data['n_kasmasuk'] = "KM";
		$this->data['n_kaskeluar'] = "KK";
		$this->data['n_bankmasuk'] = "BM";
		$this->data['n_bankkeluar'] = "BK";
		$this->data['d_akunDG'] = $this->M_jurnal->ambilCoaDG();
		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['scripts'] = ['kasbank/js/tambah.js'];
		$this->render('tambah');
	}

	public function dosave()
	{
		$param = $this->input->post();
		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');
		//generateNoTransaksi
		if ($param['n_transaksi'] == 'KM') {
			$param['n_transaksi'] = generateNomorForAccounting('KM', 'hkasbank', 'n_kasbank');
		}
		if ($param['n_transaksi'] == 'KK') {
			$param['n_transaksi'] = generateNomorForAccounting('KK', 'hkasbank', 'n_kasbank');
		}
		if ($param['n_transaksi'] == 'BM') {
			$param['n_transaksi'] = generateNomorForAccounting('BM', 'hkasbank', 'n_kasbank');
		}
		if ($param['n_transaksi'] == 'BK') {
			$param['n_transaksi'] = generateNomorForAccounting('BK', 'hkasbank', 'n_kasbank');
		}
		if ($param['bayar'] == "KAS") {
			$param['bayar'] = getPenghubung("kas")['akun'];
			$param['no_bank'] = "KAS";
		}
		if ($param['bayar'] != "KAS") {
			$akun = explode(" | ", $param['no_bank']);
			$param['no_bank'] = $akun[0];
		}
		$proses = $this->M_kasbank->insertTransKB($param, $n_jurnal);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_transaksi'];
			$this->session->set_flashdata('true', 'Data Berhasil disimpan');
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("kasbank/cetak_nota/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function cetak_nota($n_transaksi = null, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('kasbank');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_kasbank->get_cetak_nota($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('kasbank');
		}
		$x['judul_title'] = 'Bukti Transaksi Kas & Bank';
		$x['data'] = $result->row_array();
		$x['datas'] = $result->result_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['waktu_cetak'] = date('Y-m-d H:i:s');
		$filename = 'transaksi-kasbank-' . $x['data']['n_kasbank'] . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('kasbank/nota_kasbank', $filename, $x, $download);
	}

	public function exportExcel()
	{
		$this->dtkasbank->export(
			"TABEL DATA TRANSAKSI KAS DAN BANK",
			"transaksi_kas_bank" . date('Y_m_d__H_i_s'),
			"excel"
		);
	}
}
