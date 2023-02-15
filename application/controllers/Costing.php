<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Costing extends BaseController
{
	protected $template = "app";
	protected $module = 'costing';
	public $loginBehavior = true;
	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
		$this->load->model('M_pemasok');
		$this->load->model('M_barang');
		$this->load->model('M_costing');
		$this->load->model('M_bank');
	}

	public function index()
	{
		$this->data['menu'] = 'm10-1';
		$this->data['d_barang'] = $this->M_barang->getDataBarang();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		/*$data['d_akun'] = $this->M_jurnal->ambilCoaGrup('HPP');
		$data['d_akun'] += $this->M_jurnal->ambilCoaGrup('BIAYA');*/


		$title = 'Transaksi Costing';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => null]);
		$this->data['scripts'] = ['costing/js/index.js'];

		$this->render('index');
	}

	public function do_costing()
	{
		$param = $this->input->post();
		// print_r($param);

		// get no.transaksi
		$param['n_transaksi'] = generateNomorForAccounting('CT', 'hcosting', 'n_costing');

		// Generate no. jurnal
		$n_jurnal = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		$brg = 0;

		//pengolahan data barang
		for ($sm = 0; $sm <= $param['sum_barang']; $sm++) {
			if (@$param['n_barang' . $sm]) {
				$n_barang[$sm] = $this->M_barang->getDetailBarang($param['n_barang' . $sm]);
				$barang_a[] = [$n_barang[$sm]->akun_persediaan => $param['total' . $sm]];
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
		$jurnal = ['nomor' => $n_jurnal];


		// echo '<br>';
		// print_r($param);
		// echo '<br>';
		// // print_r($barang_a);
		// echo '<br>';
		// print_r($djurnal);
		// echo '<br>';
		// print_r($stock_barang);

		$proses = $this->M_costing->insertCosting($param, $jurnal, $djurnal, $stock_barang);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['n_transaksi'];
			$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("costing/cetak_nota/" . $param['n_transaksi'] . '?download=false');
		}
	}

	public function cetak_nota($n_transaksi, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('costing');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_costing->get_cetak_nota($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('costing');
		}
		$x['judul_title'] = 'Bukti Transaksi Costing';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['datas'] = $result->result_array();
		$x['waktu_cetak'] = date('Y-m-d H:i:s');
		// echo '<pre>';
		// print_r($x);
		// echo '</pre>';
		// die;

		$filename = 'transaksi-costing-' . $n_transaksi . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('costing/nota_costing', $filename, $x, $download);
	}
}
