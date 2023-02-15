<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends BaseController
{
	protected $template = "app";
	protected $module = 'sales';
	public $loginBehavior = true;

	protected $bread = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_sales');
		$this->bread[] = ['title' => 'Sales', 'url' => site_url('sales')];
	}

	public function index()
	{
		$this->data['menu'] = 'm2-3';
		$this->data['d_sales'] = $this->M_sales->getData();
		$this->data['judul_title'] = 'Daftar Sales';
		$this->data['scripts'] = ['sales/js/index.js'];
		$this->render('index');
	}

	public function dosave()
	{
		$param = $this->input->post();
		$message = null;
		if ($param['act'] == "insert") {
			$proses = $this->M_sales->insertSales($param);
			if ($proses) {
				$message = 'Data berhasil disimpan';
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal disimpan';
				$this->session->set_flashdata('false', $message);
			}
		} elseif ($param['act'] == "edit") {
			$proses = $this->M_sales->editSales($param);
			if ($proses) {
				$message = 'Data berhasil diperbaharui';
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data gagal diperbaharui';
				$this->session->set_flashdata('false', $message);
			}
		}
		if ($this->input->is_ajax_request()) {
			if ($proses) {
				return successResponseJson($message);
			}
			return internalServerErrorResponseJson($message);
		} else {
			redirect("sales");
		}
	}

	public function hapus($n_sales)
	{
		$proses = $this->M_sales->hapusData($n_sales);
		if ($proses) {
			$this->session->set_flashdata('true', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('false', 'Data gagal dihapus');
		}
		redirect("sales");
	}
}
