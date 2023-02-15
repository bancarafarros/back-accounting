<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends BaseController
{
	protected $template = "app";
	protected $module = 'bank';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_bank');
		$this->load->model('M_jurnal');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->data['menu'] = 'm6-2';
		$title = 'Daftar Bank';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title]);

		$this->data['d_bank'] = $this->M_bank->getData();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		$this->data['scripts'] = ['bank/js/index.js'];
		$this->render('index');
	}

	public function dosave()
	{
		$param = $this->input->post();
		$response = null;
		$message = null;
		$rules = $this->M_bank->rules();
		$this->form_validation->set_rules($rules);
		if ($param['act'] == "insert") {
			if ($this->form_validation->run() == false) {
				print_r($response);
			} else {
				$proses = $this->M_bank->insertBank($param);
			}
			if ($proses) {
				$message = 'Data berhasil disimpan';
				// $response = $this->setResponse($proses, $message);
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal disimpan';
				$this->session->set_flashdata('false', $message);
			}
			$response = $this->setResponse($proses, $message);
		} elseif ($param['act'] == "edit") {
			if ($this->form_validation->run() == false) {
				print_r($response);
			} else {
				$edit = $this->M_bank->editBank($param);
			}
			if ($edit) {
				$message = 'Data berhasil diperbarui';
				// $response = $this->setResponse($edit, $message);
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal diperbarui';
				$this->session->set_flashdata('false', $message);
			}
			$response = $this->setResponse($edit, $message);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($response);
		} else {
			redirect("bank");
		}
	}

	public function hapus($n_bank)
	{
		$valid = $this->M_jurnal->getDataDelete('dhutang', ['n_bayar' => $n_bank]);
		$valid1 = $this->M_jurnal->getDataDelete('dpiutang', ['n_bayar' => $n_bank]);

		if ($valid == FALSE && $valid1 == FALSE) {
			$this->M_bank->hapusData($n_bank);
			$this->session->set_flashdata('true', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('error', 'ERROR:: Bank tersebut sudah digunakan! ');
		}
		redirect("Bank");
	}
}
