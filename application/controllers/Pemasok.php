<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasok extends BaseController
{
	protected $template = "app";
	protected $module = 'pemasok';
	public $loginBehavior = true;
	protected $bread = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_pemasok');
		$this->load->model('M_jurnal');
	}

	public function index()
	{
		$this->data['menu'] = 'm4-3';
		$title = 'Daftar Pemasok';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title]);
		// $this->data['pemasokLast'] = getNoLast('n_pemasok', 'pemasok');
		$this->data['d_pemasok'] = $this->M_pemasok->getDataAll();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		$this->data['scripts'] = ['pemasok/js/index.js'];
		$this->render('index');
	}

	public function ajaxSave()
	{
		$param = $this->input->post();
		if (empty($param)) {
			return methodNotAllowedResponseJson();
		}
		$message = null;
		if ($param['act'] == "insert") {
			$proses = $this->M_pemasok->insertPemasok($param);
			if ($proses) {
				$message = 'Data berhasil disimpan';
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal disimpan';
				$this->session->set_flashdata('false', $message);
			}
		} elseif ($param['act'] == "edit") {
			$proses = $this->M_pemasok->editPemasok($param);
			if ($proses) {
				$message = 'Data berhasil diperbarui';
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal diperbarui';
				$this->session->set_flashdata('false', $message);
			}
		}

		if ($this->input->is_ajax_request()) {
			if ($proses) {
				return successResponseJson($message);
			}
			return internalServerErrorResponseJson($message);
		} else {
			redirect("pemasok");
		}
	}
	// public function dosave()
	// {
	// 	$param = $this->input->post();
	// 	if ($param['act'] == "insert") {
	// 		$proses = $this->M_pemasok->insertPemasok($param);
	// 		if ($proses) {
	// 			$this->session->set_flashdata('true', 'Data berhasil disimpan');
	// 		} else {
	// 			$this->session->set_flashdata('false', 'Data gagal disimpan');
	// 		}
	// 	} elseif ($param['act'] == "edit") {
	// 		$proses = $this->M_pemasok->editPemasok($param);
	// 		if ($proses) {
	// 			$this->session->set_flashdata('true', 'Data berhasil diperbarui');
	// 		} else {
	// 			$this->session->set_flashdata('false', 'Data gagal diperbarui');
	// 		}
	// 	}
	// 	redirect("pemasok");
	// }

	public function hapus($n_pemasok)
	{
		$valid = $this->M_jurnal->getDataDelete('hpembelian', ['n_pemasok' => $n_pemasok]);
		$valid1 = $this->M_jurnal->getDataDelete('hutang', ['n_pemasok' => $n_pemasok]);
		$valid2 = $this->M_jurnal->getDataDelete('keluar_masuk', ['n_pelanggan' => $n_pemasok]);

		if ($valid == FALSE && $valid1 == FALSE && $valid2 == FALSE) {
			$this->M_pemasok->hapusData($n_pemasok);
			$this->session->set_flashdata('true', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('false', 'ERROR:: Data pemasok tersebut sudah digunakan! ');
		}
		redirect("pemasok");
	}

	public function getPemasok()
	{
		$kode = $this->input->get('n_pemasok');
		$data = $this->M_pemasok->getDetail($kode);
		echo json_encode($data);
	}

	public function getPemasokNaktif()
	{
		$data = $this->M_pemasok->getDataNaktif();
		echo json_encode($data);
	}

	public function aktifPemasok($n_pemasok = null)
	{
		if (empty($n_pemasok)) {
			$this->session->set_flashdata('false', 'Url salah');
			redirect('pemasok');
		}
		$proses = $this->M_pemasok->aktif_pemasok($n_pemasok);
		if ($proses) {
			$this->session->set_flashdata('true', 'Pemasok ' . $n_pemasok . ' berhasil diaktifkan');
		} else {
			$this->session->set_flashdata('false', 'Pemasok ' . $n_pemasok . ' gagal diaktfikan');
		}
		redirect("pemasok");
	}
}
