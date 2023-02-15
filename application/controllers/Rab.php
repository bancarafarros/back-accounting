<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rab extends BaseController
{
	protected $template = "app";
	protected $module = 'rab';
	public $loginBehavior = true;

	protected $bread = [];

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
		$this->bread[] =
			[
				'title' => 'RAB',
				'url' => site_url('rab')
			];
	}

	public function index()
	{
		$this->data['menu'] = 'm11-1';
		$title = 'RAB';
		$this->data['judul_title'] = $title;
		$ta = thn_anggaran(date('Y-m-d'));
		$this->data['rab'] =  $this->M_rab->getMataAnggaran();
		// $this->data['rab']['detail'] = $this->rabDetail($this->data['rab']->id);
		$this->data['total_setuju'] = $this->M_persetujuan->cek_pengajuan(getSession('userId'), $ta)->result();
		$this->data['optionBulan'] = optionMonth();
		$this->data['optionTahun'] = optionYear();
		// echo '<pre>';
		// print_r($this->data['rab']);
		// echo '</pre>';
		// die;
		// $this->data['rab'] = $this->M_rab->getRabUser()->result();
		$this->render('index');
	}

	private function rabDetail($rab)
	{
		$detail = [];
		foreach ($rab as $r) {
			$rab[$r]['detail'] = $this->M_rab->getDetail($r->id);
			array_push($detail, $oke['detail']);
		}

		return $detail;
	}

	public function getAkun()
	{
		$kode = $this->input->get('akun');
		$data = $this->M_jurnal->ambilCoaDG_by($kode);
		echo json_encode($data);
	}

	public function getRabUser()
	{
		$id = $this->input->get('id');
		$data = $this->M_rab->getDetailRab('rab', $id);
		echo json_encode($data);
	}

	public function dosave()
	{
		$param = $this->input->post();
		if ($param['act'] == 'addrab') {
			$proses = $this->M_rab->insertRab($param);
			echo json_encode($proses);
			exit();
		} elseif ($param['act'] == 'editrab') {
			$proses = $this->M_rab->editRab($param);
			if ($proses) {
				$this->session->set_flashdata('true', 'Data Berhasil diubah.');
				redirect('rab');
			}
		}
	}

	public function hapus_rab($id_rab)
	{
		$this->M_rab->hapus_rab($id_rab);
		$this->session->set_flashdata('true', 'Data Berhasil dihapus.');
		redirect('rab');
	}

	public function pencairan()
	{
		$this->data['menu'] = 'm11-2';
		$title = 'Pencairan RAB';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title, 'url' => site_url('rab/pencairan')]);
		$this->data['d_rabDG'] = $this->M_rab->ambilRabDG();
		$this->data['pencairan'] = $this->M_pencairan->pencairanbyuser($this->session->userdata('t_userId'), $this->session->userdata('thn_anggaran'))->result();
		$this->data['optionBulan'] = optionMonth();
		$this->data['optionTahun'] = optionYear();

		$this->render('pencairan');
	}

	public function pencairan_save()
	{
		$param = $this->input->post();
		for ($i = 0; $i < $param['jml_baris']; $i++) {
			$data = [
				'id_rab' => $param['id_rab'][$i],
				'id_user' => $this->session->userdata('t_userId'),
				'ta' => $this->session->userdata('thn_anggaran'),
				'keterangan' => $param['keterangan'],
				'total' => $param['jumlah'][$i]
			];
			$proses = $this->M_pencairan->insertPencairan($data);
		}
		$this->session->set_flashdata('true', 'Data Berhasil disimpan.');
		redirect('rab/pencairan');
	}

	public function getAnggaran()
	{
		$id = $this->input->get('id_rab');
		$data = $this->M_rab->getRab($id);
		echo json_encode($data);
	}
}
