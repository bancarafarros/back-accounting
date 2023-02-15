<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends BaseController
{
	public $loginBehavior = true;

	protected $template = "app";
	protected $module = 'barang';
	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_barang');
		$this->load->model('M_jurnal');
		$this->load->model('M_grupbarang');
		$this->bread[] = ['title' => 'Daftar Barang', 'url' => site_url('barang')];
	}

	public function index()
	{
		$this->data['menu'] = 'm7-1';
		$title = 'Daftar Barang';
		$this->data['judul_title'] = $title;
		$this->data['d_barang'] = $this->M_barang->getData();
		$this->data['d_grupbarang'] = $this->M_grupbarang->getDataDepart();

		$n_barang = $this->uri->segment(3);
		if ($n_barang != '') {
			$this->data['act'] = "edit";
			$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
			$this->data['d_akunAktiva'] = $this->M_jurnal->ambilCoaGrup('AKTIVA');
			$this->data['d_akunPend'] = $this->M_jurnal->ambilCoaGrup('PENDAPATAN');
			$this->data['d_akunHpp'] = $this->M_jurnal->ambilCoaGrup('HPP');
			$this->data['detail'] = $this->M_barang->getDetail($n_barang);
		} else {
			$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
			$this->data['d_akunAktiva'] = $this->M_jurnal->ambilCoaGrup('AKTIVA');
			$this->data['d_akunPend'] = $this->M_jurnal->ambilCoaGrup('PENDAPATAN');
			$this->data['d_akunHpp'] = $this->M_jurnal->ambilCoaGrup('HPP');
			$this->data['act'] = "insert";
		}
		$this->data['scripts'] = ['barang/js/index.js'];
		$this->render('index');
	}

	public function dosave()
	{
		$param = $this->input->post();
		// var_dump($param);
		// die;
		$return['status'] = null;
		$return['message'] = null;
		if ($param['act'] == "insert") {
			$proses = $this->M_barang->insertBarang($param);
			if ($proses) {
				$return['status']  = true;
				$return['message'] = 'Barang berhasil disimpan';
				$this->session->set_flashdata('true', 'Barang berhasil disimpan');
			} else {
				$return['status']  = false;
				$return['message'] = 'Barang gagal disimpan';
				$this->session->set_flashdata('false', 'Barang gagal disimpan');
			}
		} elseif ($param['act'] == "edit") {
			$simpan = $this->M_barang->editBarang($param);
			if ($simpan) {
				$return['status']  = true;
				$return['message'] = 'Barang berhasil diubah';
				$this->session->set_flashdata('true', 'Barang berhasil diubah');
			} else {
				$return['status']  = false;
				$return['message'] = 'Barang gagal diubah';
				$this->session->set_flashdata('true', 'Barang gagal diubah');
			}
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($return);
		} else {
			redirect("barang");
		}
	}

	public function hapus()
	{
		$param = $this->input->post();
		$n_barang = $param['n_barang'];
		$return['status'] = null;
		$return['message'] = null;
		$valid = $this->M_jurnal->getDataDelete('keluar_masuk', ['n_barang' => $n_barang]);
		if ($valid == FALSE) {
			$proses = $this->M_barang->hapusData($n_barang);
			if ($proses) {
				$return['status']  = true;
				$return['message'] = 'Hapus data barang berhasil';
				$this->session->set_flashdata('true', 'Hapus data barang berhasil');
			} else {
				$return['status']  = false;
				$return['message'] = 'Hapus data barang gagal';
				$this->session->set_flashdata('true', 'Hapus data barang gagal');
			}
		} else {
			$return['status']  = false;
			$return['message'] = 'ERROR:: Data barang tersebut sudah digunakan!';
			$this->session->set_flashdata('error', 'ERROR:: Data barang tersebut sudah digunakan!');
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode($return);
		} else {
			redirect("barang");
		}
	}

	public function KodeLast()
	{
		$kode = $this->input->get('grup');
		$data = $this->M_barang->get_KodeLast($kode);
		echo json_encode($data);
	}

	public function getDetail()
	{
		$kode = $this->input->get('n_barang');
		$data = $this->M_barang->getDetail($kode);
		echo json_encode($data);
	}

	public function getDetailMulti()
	{
		$kode = $this->input->get('n_barang');
		$data = $this->M_barang->getDetailBarang($kode);
		echo json_encode($data);
	}

	public function getKartuBarang()
	{
		$conv_date = strtotime($this->input->get('from_date'));
		$from_date = date('Y-m-d', $conv_date);

		$conv_date1 = strtotime($this->input->get('to_date'));
		$to_date = date('Y-m-d', $conv_date1);

		$kode = $this->input->get('n_barang');
		$data = $this->M_barang->get_kartu_barang($kode, $from_date, $to_date);
		echo json_encode($data);
	}

	public function grupbarang()
	{
		$this->data['menu'] = 'm7-1';
		$title = 'Grup & Departemen Barang';
		$this->data['judul_title'] = $title;
		$this->bread[] = ['title' => $title];
		$this->data['d_grupbarang'] = $this->M_grupbarang->getDataGrup();
		$this->data['d_departemenbarang'] = $this->M_grupbarang->getDataDepart();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		$this->data['d_akunAktiva'] = $this->M_jurnal->ambilCoaGrup('AKTIVA');
		$this->data['d_akunPend'] = $this->M_jurnal->ambilCoaGrup('PENDAPATAN');
		$this->data['d_akunHpp'] = $this->M_jurnal->ambilCoaGrup('HPP');

		$n_grup = $this->uri->segment(3);
		if ($n_grup != '') {
			$this->data['act'] = "edit";
			$this->data['detail'] = $this->M_grupbarang->getDetail($n_grup);
			$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		} else {
			$this->data['act'] = "insert";
		}
		$this->data['scripts'] = ['barang/js/grup_barang.js'];
		$this->render('grup_barang');
	}

	public function grupbarang_dosave()
	{
		$param = $this->input->post();
		$return['status'] = null;
		$return['message'] = null;
		if ($param['act'] == "insert") {
			$proses = $this->M_grupbarang->insertGrupBarang($param);
			if ($proses) {
				$message = 'Data berhasil disimpan';
				$return['status'] = true;
				$return['message'] = $message;
				$this->session->set_flashdata('true', $message);
			} else {
				$message = 'Data No Grup Sudah Terdaftar';
				$return['status'] = true;
				$return['message'] = $message;
				$this->session->set_flashdata('false', $message);
			}
		} elseif ($param['act'] == "edit") {
			$this->M_grupbarang->editGrupBarang($param['n_grup'], $param);
			$this->session->set_flashdata('true', 'Data Berhasil diperbarui');
		}
		redirect("barang/grupbarang");
	}

	public function grupbarang_dosaveDepart()
	{
		$param = $this->input->post();
		if ($param['act'] == "insert") {
			$this->db->select('kode');
			$this->db->where('kode', $param['kode']);
			$query = $this->db->get('barang_grup');
			$num = $query->num_rows();
			if ($num > 0) {
				$this->session->set_flashdata('false', 'Data Kode Barang Telah Terdaftar');
			} else {

				$proses  = $this->M_grupbarang->insertDepartBarang($param);
				if ($proses) {
					$this->session->set_flashdata('true', 'Data berhasil disimpan');
				}
			}
		} elseif ($param['act'] == "edit") {
			$proses = $this->M_grupbarang->editDepartBarang($param);
			if ($proses) {
				$this->session->set_flashdata('true', 'Data berhasil diperbarui');
			} else {
				$this->session->set_falshdata('false', 'Data gagal diperbarui');
			}
		}
		redirect("barang/grupbarang");
	}

	public function grupbarang_hapus($n_grup)
	{
		$valid = $this->M_jurnal->getDataDelete('barang', ['n_grup' => $n_grup]);
		if ($valid == FALSE) {
			$proses = $this->M_grupbarang->hapusData($n_grup);
			if ($proses) {
				$this->session->set_flashdata('true', 'Data berhasil dihapus');
			} else {
				$this->session->set_flashdata('false', 'Data gagal dihapus');
			}
		} else {
			$this->session->set_flashdata('false', 'ERROR:: Grup tersebut sudah digunakan!');
		}
		redirect("barang/grupbarang");
	}

	public function grupbarang_KodeLast()
	{
		$kode = $this->input->get('grup');
		$data = $this->M_grupbarang->get_KodeLast($kode);
		echo json_encode($data);
	}

	public function getDetailDepart()
	{
		$kode = $this->input->get('n_grup');
		$data = $this->M_grupbarang->getDetailDepart($kode);
		echo json_encode($data);
	}
}
