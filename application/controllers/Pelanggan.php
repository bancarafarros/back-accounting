<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends BaseController
{
	protected $template = "app";
	protected $module = 'pelanggan';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_pelanggan');
		$this->load->model('M_jurnal');
		$this->load->model('M_sales');
		$this->bread[] = ['title' => 'Pelanggan', 'url' => site_url('pelanggan')];
	}

	public function index()
	{
		$this->data['menu'] = 'm2-3';
		$title = 'Daftar Pelanggan';
		$this->data['judul_title'] = $title;
		$this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		$this->data['d_sales'] = $this->M_sales->getData();
		$this->data['scripts'] = ['pelanggan/js/index.js'];
		$this->render('index');
	}

	public function form()
	{
		$n_pelanggan = $this->uri->segment(3);
		if ($n_pelanggan != '') {
			$data['act'] = "edit";
			$data['detail'] = $this->M_pelanggan->getDetail($n_pelanggan);
			$data['d_akun'] = $this->M_pelanggan->ambilCoa('PIUTANG');
		} else {
			$data['act'] = "insert";
			$data['d_akun'] = $this->M_pelanggan->ambilCoa('PIUTANG');
		}
		$data['sales'] = $this->M_pelanggan->dataSales();
		$this->load->view("pelanggan/form", $data);
	}

	public function dosave()
	{
		$param = $this->input->post();
		if (empty($param)) {
			return methodNotAllowedResponseJson();
		}
		$message = null;
		if ($param['act'] == "insert") {
			$proses = $this->M_pelanggan->insertPelanggan($param);
			if ($proses) {
				$message = 'Data berhasil disimpan';
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal disimpan';
				$this->session->set_flashdata('false', $message);
			}
		} elseif ($param['act'] == "edit") {
			$proses = $this->M_pelanggan->editPelanggan($param);
			if ($proses) {
				$message = 'Data berhasil diedit';
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal diedit';
				$this->session->set_flashdata('false', $message);
			}
		}
		if ($this->input->is_ajax_request()) {
			if ($proses) {
				return successResponseJson($message);
			}
			return internalServerErrorResponseJson($message);
		} else {
			redirect("pelanggan");
		}
	}
	public function hapus($n_pelanggan)
	{
		$valid = $this->M_jurnal->getDataDelete('hpenjualan', ['n_pelanggan' => $n_pelanggan]);
		$valid1 = $this->M_jurnal->getDataDelete('piutang', ['n_pelanggan' => $n_pelanggan]);
		$valid2 = $this->M_jurnal->getDataDelete('keluar_masuk', ['n_pelanggan' => $n_pelanggan]);

		if ($valid == FALSE && $valid1 == FALSE && $valid2 == FALSE) {
			$this->M_pelanggan->hapusData($n_pelanggan);
			$this->session->set_flashdata('true', 'Data Berhasil dihapus');
		} else {
			$this->session->set_flashdata('false', 'ERROR:: Pelanggan tersebut sudah digunakan! ');
		}
		redirect("pelanggan");
	}

	public function getPelanggan()
	{
		$kode = $this->input->get('n_pelanggan');
		$data = $this->M_pelanggan->getDetail($kode);
		echo json_encode($data);
	}
	public function getPelangganNaktif()
	{
		$data = $this->M_pelanggan->getDataNaktif();
		echo json_encode($data);
	}
	public function aktifPelanggan($n_pelanggan)
	{
		$this->M_pelanggan->aktif_pelanggan($n_pelanggan);
		$this->session->set_flashdata('true', 'Pelanggan ' . $n_pelanggan . ' berhasil diaktifkan');
		redirect("Pelanggan");
	}
}
