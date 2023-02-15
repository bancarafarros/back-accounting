<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coa extends BaseController
{
	protected $template = "app";
	protected $module = 'coa';
	public $loginBehavior = true;
	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_coa');
		$this->load->model('M_jurnal');
		$this->load->model('M_penghubung');
		$this->load->model('M_daftarsaldo');
		$this->bread[] = ['title' => 'Daftar Perkiraan', 'url' => site_url('coa')];
	}

	public function getSubGrup()
	{
		// print_r($this->input->post());
		// die;
		$input = $this->input->post();
		$data = $this->M_coa->getDataSubgrup($input['grup']);
		$grup = '<select class="form-control grup" type="text" id="subgrup" name="subgrup" required>
				<option value="" disabled selected>- Pilih Sub Grup Perkiraan -</option>';
		foreach ($data as $subgrup) {
			$grup .= '<option value="' . $subgrup->subgrup . ' ">' . $subgrup->subgrup . '</option>';
		}
		$grup .= '</select>';
		// echo $this->db->last_query();
		// var_dump($data);
		// die;
		echo json_encode($grup);
	}

	public function index()
	{
		// $data = $this->M_coa->getDataSubGrup();
		// echo '<pre>';
		// print_r($data);
		// echo'</pre>';
		// die;
		$this->data['menu'] = 'm1-3';
		$title = 'Daftar Perkiraan';
		$this->data['judul_title'] = $title;
		$this->data['d_coa'] = $this->M_coa->getData();
		$this->data['d_grup'] = $this->M_coa->getDataGrup();
		// $this->data['d_subgrup'] = $this->M_coa->getDataSubgrup();
		$this->data['d_detailgrup'] = $this->M_coa->getDataDetailgrup();

		$akun = $this->uri->segment(3);
		if ($akun != '') {
			$this->data['act'] = "edit";
			$this->data['detail'] = $this->M_coa->getDetail($akun);
		} else {
			$this->data['act'] = "insert";
		}
		$this->data['scripts'] = ['coa/js/index.js'];
		$this->render('index');
	}

	public function dosave()
	{
		$param = $this->input->post();
		if ($param['act'] == "insert") {
			$this->M_coa->insertCoa($param);
			$this->session->set_flashdata('true', 'Data berhasil disimpan');
		} elseif ($param['act'] == "edit") {
			$this->M_coa->editCoa($param);
			$this->session->set_flashdata('true', 'Data berhasil diperbarui');
		}
		redirect("Coa");
	}

	public function hapus($akun)
	{
		$valid = $this->M_jurnal->getDataDelete('djurnal', ['akun' => $akun]);
		$valid1 = $this->M_jurnal->getDataDelete('pemasok', ['akun' => $akun]);
		$valid2 = $this->M_jurnal->getDataDelete('pelanggan', ['akun' => $akun]);
		$valid3 = $this->M_jurnal->getDataDelete('barang', ['akun_persediaan' => $akun]);
		$valid4 = $this->M_jurnal->getDataDelete('barang', ['akun_pendapatan' => $akun]);
		$valid5 = $this->M_jurnal->getDataDelete('barang', ['akun_hpp' => $akun]);

		if ($valid == FALSE && $valid1 == FALSE && $valid2 == FALSE && $valid3 == FALSE && $valid4 == FALSE && $valid5 == FALSE) {
			$this->M_coa->hapusData($akun);
			$this->session->set_flashdata('true', 'Data Berhasil dihapus');
		} else {
			$this->session->set_flashdata('false', 'Perkiraan tersebut sudah digunakan!');
		}
		redirect("coa");
	}

	public function penghubung()
	{
		$title = 'Perkiraan Penghubung';
		$this->data['judul_title'] = $title;
		$crud = new Grid();
		$crud->setSubject('Perkiraan Penghubung');
		$crud->setTable('coa_penghubung');
		$crud->defaultOrdering('n_penghubung', 'asc');
		$columns = ['n_penghubung', 'akun', 'deskripsi'];
		$column_displays = [
			'n_penghubung' 	=> 'Kode Penghubung',
			'akun'          => 'Akun',
			'deskripsi'		=> 'Keterangan',
		];
		$requiredFields = ['n_penghubung', 'akun'];
		$addFields = ['n_penghubung', 'akun', 'deskripsi'];
		$editFields = ['n_penghubung', 'akun', 'deskripsi'];
		$crud->setRelation('akun', 'coa', '{akun} - {nama}');
		$crud->columns($columns);
		$crud->displayAs($column_displays);
		$crud->requiredFields($requiredFields);
		$crud->uniqueFields(['n_penghubung']);
		$crud->addFields($addFields);
		$crud->editFields($editFields);
		$crud->callbackBeforeInsert([$this, '_callBeforeInsert']);
		$crud->callbackBeforeUpdate([$this, '_callBeforeUpdate']);

		// $crud->unsetAdd();
		// $crud->unsetEdit();
		// $crud->unsetDelete();
		$crud->unsetJquery();

		$output = $crud->render();
		$this->setOutput($output, 'coa_penghubung');
	}

	function _callBeforeInsert($stateParameter)
	{
		$stateParameter->data['created_by'] = getSession('userId');
		return $stateParameter;
	}

	function _callBeforeUpdate($stateParameter)
	{
		$stateParameter->data['updated_by'] = getSession('userId');
		return $stateParameter;
	}

	// public function penghubung()
	// {
	// 	$this->data['menu'] = 'm1-4';
	// 	$title = 'Perkiraan Penghubung';
	// 	$this->data['judul_title'] = $title;
	// 	array_push($this->bread, ['title' => $title]);
	// 	$this->data['hubung_kas'] = $this->M_penghubung->getData('kas');
	// 	$this->data['hubung_rl'] = $this->M_penghubung->getData('rl');
	// 	$this->data['hubung_umb'] = $this->M_penghubung->getData('umb');
	// 	$this->data['hubung_umj'] = $this->M_penghubung->getData('umj');
	// 	$this->data['hubung_bkb'] = $this->M_penghubung->getData('bkb');
	// 	$this->data['hubung_bkj'] = $this->M_penghubung->getData('bkj');
	// 	$this->data['hubung_pj'] = $this->M_penghubung->getData('pj');
	// 	$this->data['hubung_pb'] = $this->M_penghubung->getData('pb');
	// 	$this->data['hubung_dsk'] = $this->M_penghubung->getData('dsk');
	// 	$this->data['hubung_dsp'] = $this->M_penghubung->getData('dsp');

	// 	$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
	// 	$this->data['scripts'] = ['coa/js/penghubung.js'];
	// 	$this->render('penghubung');
	// }

	public function penghubung_dosave()
	{
		$param = $this->input->post();
		$this->M_penghubung->setPenghubung('kas', $param['a_kas']);
		$this->M_penghubung->setPenghubung('rl', $param['a_rl']);
		$this->M_penghubung->setPenghubung('umb', $param['a_umb']);
		$this->M_penghubung->setPenghubung('umj', $param['a_umj']);
		$this->M_penghubung->setPenghubung('bkb', $param['a_bkb']);
		$this->M_penghubung->setPenghubung('bkj', $param['a_bkj']);
		$this->M_penghubung->setPenghubung('pj', $param['a_pj']);
		$this->M_penghubung->setPenghubung('pb', $param['a_pb']);
		$this->M_penghubung->setPenghubung('dsk', $param['a_dsk']);
		$this->M_penghubung->setPenghubung('dsp', $param['a_dsp']);

		$this->session->set_flashdata('true', 'Data Berhasil disimpan');
		redirect("coa/penghubung");
	}
	public function penghubung_hapus($n_penghubung)
	{
		$this->M_penghubung->hapusData($n_penghubung);
		redirect("coa/penghubung");
	}

	public function penghubung_getData()
	{
		$data = $this->M_penghubung->getData();
		echo json_encode($data);
	}


	public function saldo()
	{
		$this->data['menu'] = 'm1-2';
		$title = 'Daftar Saldo';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title]);
		$this->data['optionBulan'] =  optionMonth();
		$this->data['optionTahun'] = optionYear();
		$this->data['d_akunDG'] = $this->M_jurnal->ambilCoaDG();
		$this->render('daftar_saldo');
	}

	public function saldo_getDataRange()
	{
		$conv_date = strtotime($this->input->get('from_date'));
		$from_date = date('Y-m-d', $conv_date);

		$conv_date1 = strtotime($this->input->get('to_date'));
		$to_date = date('Y-m-d', $conv_date1);

		$n_akun = $this->input->get('n_akun');
		$data = $this->M_daftarsaldo->getDataRange($from_date, $to_date, $n_akun);
		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getSaldobyAkun()
	{
		$n_akun = $this->input->get('n_akun');
		$conv_date = strtotime($this->input->get('from_date'));
		$from_date = date('Y-m-d', $conv_date);

		$data = $this->M_daftarsaldo->getSaldobyAkun($from_date, $n_akun);
		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getSaldo()
	{
		$to_date = $this->input->get('to_date');
		$data = $this->M_daftarsaldo->getSaldo($to_date);
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// die;
		echo json_encode($data, JSON_PRETTY_PRINT);
	}
}
