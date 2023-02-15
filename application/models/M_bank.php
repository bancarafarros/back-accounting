<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bank extends MY_Model
{
	protected $table = 'bank';
	protected $primary_key = 'n_bank';
	protected $order_by = 'nama';
	protected $order_by_type = 'DESC';

	public function getData()
	{
		$this->db->select('bank.*, coa.nama n_akun');
		$this->db->join('coa', 'coa.akun = bank.akun');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function rules()
	{
		return [
			[
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required|max_length[50]',
			],
			[
				'field' => 'norek',
				'label' => 'norek',
				'rules' => 'required|max_length[100]',
			],
			[
				'field' => 'pemilik',
				'label' => 'Pemilik',
				'rules' => 'required|max_length[100]',
			],
			[
				'field' => 'akun',
				'label' => 'Akun',
				'rules' => 'required|max_length[100]',
			],
			[
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required|max_length[60]',
			],
			[
				'field' => 'telepon',
				'label' => 'Telepon',
				'rules' => 'required|max_length[60]',
			],

		];
	}

	public function insertBank($param)
	{
		$object = [
			"akun" 			=> $param['akun'],
			"nama" 			=> $param['nama'],
			"norek" 		=> $param['norek'],
			"pemilik" 		=> $param['pemilik'],
			"alamat" 		=> $param['alamat'],
			"telepon" 		=> $param['telepon'],
			"created_by"	=> getSession('userId'),
		];
		return $this->db->insert($this->table, $object);
	}

	public function editBank($param)
	{
		$object = [
			"n_bank" => $param['n_bank'],
			"akun" 			=> $param['akun'],
			"nama" 			=> $param['nama'],
			"norek" 		=> $param['norek'],
			"pemilik" 		=> $param['pemilik'],
			"alamat" 		=> $param['alamat'],
			"telepon" 		=> $param['telepon'],
			"updated_by"	=> getSession('userId'),
		];

		$this->db->where("n_bank", $param['n_bank']);

		return $this->db->update($this->table, $object);
	}

	public function getDetail($nama)
	{
		$this->db->where("n_bank", $nama);
		$data = $this->db->get($this->table)->row();
		return $data;
	}

	public function hapusData($n_bank)
	{
		$this->db->where("n_bank", $n_bank);
		return $this->db->delete($this->table);
	}
}
