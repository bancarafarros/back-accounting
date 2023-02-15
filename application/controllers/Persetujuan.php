<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persetujuan extends BaseController {

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
		$this->data['judul_title'] = 'Daftar Pengajuan RAB';
		$this->data['rab'] = $this->M_persetujuan->rab_pengajuan()->result();
		$this->render('index');
	}

	public function doAgree($id_rab){
		$rab = $this->M_rab->getRabSetuju($id_rab)->row_array();
		$cek_pengajuan = $this->M_persetujuan->cek_pengajuan($rab['id_user'], $rab['ta']);
		if($cek_pengajuan->num_rows() < 1){
			$pengajuan = [
				'id_user'=> $rab['id_user'],
				'ta'=> $rab['ta'],
				'total'=> $rab['total']
			];
			$this->M_persetujuan->insertPengajuan($pengajuan);
		}else{
			$jumlah = $cek_pengajuan->row_array()['total'];
			$total = $rab['total'] + $jumlah;
			$where = [
				'id_user'=>$rab['id_user'],
				'ta'=>$rab['ta']
			];
			$this->M_persetujuan->ubahTotal($where, $total);
		}
		$this->M_rab->ubahStatus($id_rab, '2');
		$this->session->set_flashdata('true','Data Berhasil disimpan.');
		redirect('persetujuan');
	}

	public function doNotAgree($id_rab){
		$rab = $this->M_rab->getRab($id_rab)->row_array();
		$cek_pengajuan = $this->M_persetujuan->cek_pengajuan($rab['id_user'], $rab['ta']);
		$where = [
			'id_user'=>$rab['id_user'],
			'ta'=>$rab['ta']
		];

		$jumlah = $cek_pengajuan->row_array()['total'];
		$total = $jumlah -  $rab['total'];
		$this->M_persetujuan->ubahTotal($where, $total);
		$this->M_rab->ubahStatus($id_rab, '0');
		$this->session->set_flashdata('true','Data Berhasil disimpan.');
		redirect('persetujuan');
	}

	public function getrabta(){
		$ta = $this->input->get('ta');
		$data =$this->M_rab->getRabTa($ta)->result();
		echo json_encode($data);
	}

	public function getRabUser(){
		$id = $this->input->get('id');
		$data = $this->M_rab->getRabUserBy($id);
		echo json_encode($data);
	}

	public function dosave(){
		$param = $this->input->post();
		if($param['act'] == 'addrab'){
			$proses = $this->M_rab->insertRab($param);
			if($proses){
				$this->session->set_flashdata('true','Data Berhasil disimpan.');
				redirect('rab');
			}
		}elseif ($param['act'] == 'editdrab') {
			$proses = $this->M_rab->editDetailRab($param);
			if($proses){
				$this->session->set_flashdata('true','Data Berhasil diubah.');
				redirect('rab');
			}
		}elseif ($param['act'] == 'editrab') {
			$proses = $this->M_rab->editRab($param);
			if($proses){
				$this->session->set_flashdata('true','Data Berhasil diubah.');
				redirect('rab');
			}
		}elseif ($param['act'] == 'adddrab') {
			$proses = $this->M_rab->insertDrab($param);
			if($proses){
				$this->session->set_flashdata('true','Data Berhasil disimpan.');
				redirect('rab');
			}
		}
	}

	public function dorevisi()
	{
		$param = $this->input->post();
		$where = [
			'id'=>$param['id_rab']
		];

		$data = [
			'catatan'=>$param['catatan']
		];

		$proses = $this->M_rab->editRab($where, $data);
		if($proses){
			$this->M_rab->ubahStatus($param['id_rab'], '1');
			$this->session->set_flashdata('true','Data Berhasil disimpan.');
			redirect('persetujuan');
		}
	}

	public function pencairan(){
		$this->data['menu'] = 'm11-2';
		$this->data['judul_title'] = 'Daftar Pengajuan Pencairan';
		$this->data['rab_pencairan'] = $this->M_pencairan->rab_pencairan()->result();
		$this->render('pencairan');

	}

	public function pencairan_doagree($id_rab){
		$where = ['id_rab'=>$id_rab];
		$proses = $this->M_persetujuan->ubahStatusWarek($where, '1');
		if($proses){
			$this->session->set_flashdata('true','Data Berhasil disimpan.');
			redirect('persetujuan/pencairan');
		}
	}

	public function pencairan_donotagree($id_rab){
		$where = ['id_rab'=>$id_rab];
		$proses = $this->M_persetujuan->ubahStatusWarek($where, '0');
		if($proses){
			$this->session->set_flashdata('true','Data Berhasil disimpan.');
			redirect('persetujuan/pencairan');
		}
	}
}
?>