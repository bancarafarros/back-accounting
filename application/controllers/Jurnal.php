<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal extends BaseController
{
	protected $template = "app";
	protected $module = 'jurnal';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_jurnal');
	}

	public function index()
	{
		$data['menu'] = 'm1-1';
		$now = date("Y-m");

		$title = 'Jurnal';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => site_url('jurnal')]);
		$this->data['optionBulan'] = optionMonth();
		$this->data['optionTahun'] = optionYear();

		$this->data['d_hjurnal'] = $this->M_jurnal->getDataHjurnal($now);
		$this->data['bulan'] = $now;
		$this->data['tanggal'] = date('Y-m-d');
		$this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
		$this->data['d_akunDG'] = $this->M_jurnal->ambilCoaDG();
		$this->data['scripts'] = ['jurnal/js/scripts.js'];
		$this->render('daftar_jurnal', $data);
	}

	public function datatable_jurnal()
	{
		$return = array();
		$field = array(
			'sEcho',
			'sSearch',
			'iSortCol_0',
			'sSortDir_0',
			'iDisplayStart',
			'iDisplayLength',
			'tahunbulan',
		);

		foreach ($field as $v) {
			$$v = $this->input->get_post($v);
		}

		$return = array(
			"sEcho" 				=> $sEcho,
			"iTotalRecords" 		=> 0,
			"iTotalDisplayRecords" 	=> 0,
			"tahunbulan" 			=> $tahunbulan,
			"aaData" 				=> array()
		);

		$params = array(
			'sSearch' 		=> $sSearch,
			'start' 		=> $iDisplayStart,
			'limit' 		=> $iDisplayLength,
			'tahunbulan' 	=> $tahunbulan,
		);

		$data = $this->M_jurnal->dataTableJurnal($params);

		if ($data['total'] > 0) {
			$return['iTotalRecords'] = $data['total'];
			$return['iTotalDisplayRecords'] = $return['iTotalRecords'];
			foreach ($data['rows'] as $k => $row) {
				$opsi = '<a role="button" target="_blank" href="' . site_url('jurnal/cetak_nota/' . $row['n_jurnal'] . '?download=true') . '" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
				<a role="button" target="_blank" href="' . site_url('jurnal/cetak_nota/' . $row['n_jurnal']) . '" class="btn btn-xs btn-warning"><i class="fa fa-print"></i></a>
				<a role="button" href="javascript:void(0)" class="btn btn-xs btn-success detail text-light" data-kode="' . $row['n_jurnal'] . '" data-tanggal="' . $row['tanggal'] . '" data-keterangan="' . $row['keterangan'] . '" data-jenis="' . $row['statusA'] . '"><i class="fa fa-eye"></i></a>';
				$row['opsi'] 		= $opsi;
				$row['nomor'] 		= $row['n_jurnal'];
				$row['tanggal'] 	= $this->tanggalindo->konversi($row['tanggal']);
				$row['referensi'] 	= $row['reff'];
				$row['keterangan'] 	= $row['keterangan'];
				$return['aaData'][] = $row;
			}
		}
		echo json_encode($return);
	}

	// public function datatable_jurnal()
	// {
	// 	$this->load->model('datatable/Dt_jurnal', 'dt_jurnal');
	// 	$list = $this->dt_jurnal->get_datatables();
	// 	$data = array();
	// 	$no = $_POST['start'];
	// 	foreach ($list as $pel) {
	// 		$row = array();
	// 		$cetak =
	// 			'<a role="button" target="_blank" href="' . site_url('dashboard/keuangan/jurnal/cetak/' . $pel->n_jurnal . '?download=true') . '" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
	//         <a role="button" target="_blank" href="' . site_url('dashboard/keuangan/jurnal/cetak/' . $pel->n_jurnal) . '" class="btn btn-xs btn-warning"><i class="fa fa-print"></i></a>
	// 		<a role="button" href="javascript:void(0)" class="btn btn-xs btn-success detail text-light" data-kode="' . $pel->n_jurnal . '" data-tanggal="' . $pel->tanggal . '" data-keterangan="' . $pel->keterangan . '" data-jenis="' . $pel->statusA . '"><i class="fa fa-eye"></i></a>';
	// 		$row[] = $cetak;
	// 		$row[] = $pel->n_jurnal;
	// 		$row[] = $this->tanggalindo->konversi($pel->tanggal);
	// 		$row[] = $pel->reff;
	// 		$row[] = $pel->keterangan;
	// 		$data[] = $row;
	// 	}

	// 	$output = array(
	// 		"draw" => $_POST['draw'],
	// 		"recordsTotal" => $this->dt_jurnal->count_all(),
	// 		"recordsFiltered" => $this->dt_jurnal->count_filtered(),
	// 		"data" => $data,
	// 	);
	// 	//output to json format
	// 	echo json_encode($output);
	// }

	public function dosave()
	{
		$param = $this->input->post();
		//generate no_jurnal
		$param['no_jurnal'] = generateNomorForAccounting('GL', 'hjurnal', 'n_jurnal');

		$proses = $this->M_jurnal->insertJurnal($param);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['no_jurnal'];
			$this->session->set_flashdata('true', $proses['message']);
			$this->session->set_userdata(['n_transaksi' => $param['no_jurnal'], 'j_transaksi' => 'tambah']);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			$x['data'] = $this->M_jurnal->getNotaJurnal($this->session->userdata('n_transaksi'));
			redirect("jurnal/cetak_nota/" . $param['no_jurnal'] . '?download=false');
		}
	}

	public function dosaveEdit()
	{
		$param = $this->input->post();
		// print_r($param);
		$proses = $this->M_jurnal->EditJurnal($param);
		if ($proses['status']) {
			$proses['n_transaksi'] = $param['no_jurnal'];
			$this->session->set_flashdata('true', $proses['message']);
			$this->session->set_userdata(['n_transaksi' => $param['no_jurnal'], 'j_transaksi' => 'edit']);
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("jurnal/cetak_nota/" . $param['no_jurnal'] . '?download=false');
		}
	}

	public function hapusJurnal()
	{
		$n_jurnal = $this->input->post('n_jurnal');
		$proses = $this->M_jurnal->deleteJurnal($n_jurnal);
		if ($proses['status']) {
			$this->session->set_flashdata('true', $proses['message']);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($proses);
		} else {
			redirect("jurnal");
		}
	}

	public function cetak_nota($n_transaksi = null, $download = false)
	{
		$this->load->library('dom_pdf');
		if (empty($n_transaksi)) {
			$this->session->set_flashdata('false', 'Alamat url salah, data tidak ditemukan.');
			redirect('jurnal');
		}
		$simpan = $this->input->get('download');
		if (isset($simpan)) {
			if ($simpan == 'true') {
				$download = true;
			}
		}
		$result = $this->M_jurnal->getNotaJurnal($n_transaksi);
		if ($result->num_rows() == 0) {
			$this->session->set_flashdata('false', 'Data tidak ditemukan.');
			redirect('jurnal');
		}
		$x['judul_title'] = 'Bukti Transaksi Jurnal';
		$x['data'] = $result->row_array();
		$x['data']['tanggal_indo'] = $this->tanggalindo->konversi($x['data']['tanggal']);
		$x['waktu_cetak'] = date('Y-m-d H:i:s');
		$x['datas'] = $result->result_array();
		$filename = 'jurnal-' . $x['data']['n_jurnal'] . '-' . date('Y-m-d His');
		$this->dom_pdf->load_view('jurnal/nota_jurnal', $filename, $x, $download);
	}

	public function getDetail()
	{
		$kode = $this->input->get('n_jurnal');
		$data = $this->M_jurnal->get_detail($kode);
		echo json_encode($data);
	}

	public function getAkun()
	{
		$kode = $this->input->get('akun');
		$data = $this->M_jurnal->ambilCoaDG_by($kode);
		echo json_encode($data);
	}

	public function cekPerkiraan()
	{
		$perk = $this->input->get('n_akun');
		$data = $this->M_jurnal->cekAkunCoa($perk);
		echo json_encode($data);
	}
}
