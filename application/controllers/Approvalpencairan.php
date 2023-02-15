<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvalpencairan extends BaseController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_coa');
		$this->load->model('M_jurnal');
		$this->load->model('M_penghubung');
		$this->load->model('M_daftarsaldo');
		$this->load->model('M_rab');
		$this->load->model('M_persetujuan');
		$this->load->model('M_pencairan');
		//is_logged_in();
	}

	public function index()
	{
		$this->data['menu'] = 'm11-1';
		$this->data['judul_title'] = 'Daftar Pengajuan Pencairan RAB';
		$this->data['rab_pencairan'] = $this->M_pencairan->rab_pencairan()->result();
		$this->render('index');
	}

	public function doAgree($id_rab){
		$where = ['id_rab'=>$id_rab];
		$proses = $this->M_pencairan->ubahStatusRektor($where, '1');
		if($proses){
			$this->session->set_flashdata('true','Data Berhasil diproses.');
			redirect('approvalpencairan');
		}
	}

	public function doNotAgree($id_rab){
		$where = ['id_rab'=>$id_rab];
		$proses = $this->M_pencairan->ubahStatusRektor($where, '0');
		if($proses){
			$this->session->set_flashdata('true','Data Berhasil diproses.');
			redirect('approvalpencairan');
		}
	}
	
}
?>