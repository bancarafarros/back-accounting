<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencairan extends BaseController
{
	public $loginBehavior = true;
	public $template = "app";
	protected $module = "pencairan";
	protected $bread = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_coa');
		$this->load->model('M_jurnal');
		$this->load->model('M_rab');
		$this->load->model('M_persetujuan');
		$this->load->model('M_pencairan');
	}

	public function index()
	{
		$this->data['menu'] = 'm11-1';
		$this->data['judul_title'] = 'Pencairan RAB';
		$this->data['pencairan'] = $this->M_pencairan->rab_pencairan()->result();
		$this->render('pencairan');
	}

	public function dosave($id_rab)
	{
		// Generate no. jurnal
		$userId = $this->session->userdata("t_userId");
		$datenow = date("my");
		$dataRAB = $this->M_pencairan->getRabPencairan($id_rab);
		// echo "<pre>";
		// print_r($dataRAB);
		// exit();
		@$h_jurnal = $this->M_jurnal->getNoLastTransaksi('n_jurnal', 'hjurnal', $userId, "GL");
		@$d_jurnal = $this->M_jurnal->getNoLastTransaksi('n_jurnal', 'djurnal', $userId, "GL");

		if ($h_jurnal->n_last == $d_jurnal->n_last) {
			$id_jurnal = $h_jurnal->n_last + 1;
		}
		if ($h_jurnal->n_last < $d_jurnal->n_last) {
			$id_jurnal = $d_jurnal->n_last + 1;
		} else {
			$id_jurnal = $h_jurnal->n_last + 1;
		}
		if ($id_jurnal >= 10000) {
			$id_jurnal = 1;
		}

		$no_jurnal = str_pad($id_jurnal, 4, "0", STR_PAD_LEFT);
		$n_jurnal = "GL" . $datenow . $userId . $no_jurnal;

		// echo "<pre>";
		// print_r($n_jurnal);
		// exit();

		//generateNoTransaksi
		@$n_noPencairan = $this->M_jurnal->getNoLastTransaksi('n_pencairan', 'pencairan_header', $userId, "PA");
		// @$n_noKasKeluar = $this->M_jurnal->getNoLastTransaksi('n_kasbank','hkasbank',$userId,"KK");
		// @$n_noBankMasuk = $this->M_jurnal->getNoLastTransaksi('n_kasbank','hkasbank',$userId,"BM");
		// @$n_noBankKeluar = $this->M_jurnal->getNoLastTransaksi('n_kasbank','hkasbank',$userId,"BK");

		// echo "<pre>";
		// print_r($n_noPencairan);
		// exit();
		$lst_Pencairan = @$n_noPencairan->n_last + 1;
		// $lst_KasKeluar = @$n_noKasKeluar->n_last + 1;
		// $lst_BankMasuk = @$n_noBankMasuk->n_last + 1;
		// $lst_BankKeluar = @$n_noBankKeluar->n_last + 1;

		if ($lst_Pencairan >= 10000) {
			$lst_Pencairan = 1;
		}
		// if ($lst_KasKeluar >= 10000) {
		// 	$lst_KasKeluar = 1;
		// } 
		// if ($lst_BankMasuk >= 10000) {
		// 	$lst_BankMasuk = 1;
		// } 
		// if ($lst_BankKeluar >= 10000) {
		// 	$lst_BankKeluar = 1;
		// }

		$id_pencairan = str_pad($lst_Pencairan, 4, "0", STR_PAD_LEFT);
		// $id_KasKeluar = str_pad($lst_KasKeluar,4,"0",STR_PAD_LEFT);
		// $id_BankMasuk = str_pad($lst_BankMasuk,4,"0",STR_PAD_LEFT);
		// $id_BankKeluar = str_pad($lst_BankKeluar,4,"0",STR_PAD_LEFT);

		// if ($param['n_transaksi'] == 'KM') {
		// 	$param['n_transaksi'] = 'KM'.$datenow.$userId.$id_KasMasuk;
		// } if ($param['n_transaksi'] == 'KK') {
		// 	$param['n_transaksi'] = 'KK'.$datenow.$userId.$id_KasKeluar;
		// } if ($param['n_transaksi'] == 'BM') {
		// 	$param['n_transaksi'] = 'BM'.$datenow.$userId.$id_BankMasuk;
		// } if ($param['n_transaksi'] == 'BK') {
		// 	$param['n_transaksi'] = 'BK'.$datenow.$userId.$id_BankKeluar;
		// } 
		$rab = $dataRAB[0];
		// echo "<pre>";
		// print_r($rab);
		// exit();
		$param['n_transaksi'] = 'PA' . $datenow . $userId . $id_pencairan;
		$param['jenis'] = 'PA';
		$param['rab'] = $rab['id_rab'];
		$param['rab_pencairan'] = $rab['id'];
		$param['mata_anggaran'] = $rab['mata_anggaran'];
		$param['jumlah'] = $rab['total'];
		$param['detail'] = $rab['detail'];
		$param['keterangan'] = $rab['keterangan'];

		// if ($param['bayar'] == "KAS") {
		// 	$param['bayar'] = $this->M_jurnal->getPenghubung("kas")->akun;
		// 	$param['no_bank'] = "KAS";
		// }
		// if ($param['bayar'] != "KAS") {
		// 	$akun = explode(" | ",$param['no_bank']);
		// 	$param['no_bank'] = $akun[0];
		// }

		// print_r($this->session->userdata("t_userId"));
		// print_r($param['n_transaksi']);
		// print_r($param);
		// echo "<pre>";
		// print_r($param);
		// exit();
		$this->M_pencairan->insertTransPencairan($param, $n_jurnal);
		$this->session->set_flashdata('true', 'Data Berhasil disimpan');
		$this->session->set_userdata(['n_transaksi' => $param['n_transaksi']]);
		redirect("pencairan");
	}

	public function cetak_nota()
	{
		$param = $this->input->post();
		$this->x['data'] = $this->M_kasbank->get_cetak_nota($this->session->userdata('n_transaksi'));
		// print_r($x['data']->row_array());
		//$this->load->view('kasbank/nota_kasbank',$x);
		$this->render('nota_kasbank');
	}

	public function cetak_ulangkas()
	{
		$param = $this->input->post();
		$this->x['data'] = $this->M_kasbank->get_cetak_ulangkas($param);
		//$this->load->view('kasbank/cetak_ulang_kasbank',$x);
		$this->render('cetak_ulang_kasbank');
	}

	public function cetak_ulangbank()
	{
		$param = $this->input->post();
		$this->x['data'] = $this->M_kasbank->get_cetak_ulangbank($param);
		//$this->load->view('kasbank/cetak_ulang_kasbank',$x);
		$this->render('cetak_ulang_kasbank');
	}
}
