<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pemasok extends MY_Model
{
	protected $table = 'pemasok';
	protected $primary_key = 'n_pemasok';
	protected $order_by = 'n_pemasok';
	protected $order_by_type = 'DESC';

	public function getData()
	{
		$this->db->select('pemasok.*,coa.nama as n_akun');
		$this->db->where(['statusA' => '1']);
		$this->db->join('coa', 'coa.akun = pemasok.akun');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getFirstData()
	{
		$this->db->select('pemasok.*,coa.nama as n_akun');
		$this->db->where(['statusA' => '1']);
		$this->db->join('coa', 'coa.akun = pemasok.akun');
		$data = $this->db->get($this->table);

		return $data->row();
	}

	public function getDataAll()
	{
		$this->db->select('*,(SELECT nama FROM coa WHERE coa.akun = pemasok.akun) as n_akun');
		$this->db->where(['statusA' => '1']);
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getDataNaktif()
	{
		$this->db->select('*,(SELECT nama FROM coa WHERE coa.akun = pemasok.akun) as n_akun');
		$this->db->where(['statusA' => '0']);
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function insertPemasok($param)
	{
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);

		$object = [
			"n_pemasok" 	=> generateNomorPerson(PREFIX_PEMASOK, 'n_pemasok', 'pemasok'),
			"tanggal" 		=> $tanggal,
			"akun" 			=> $param['akun'],
			"nama" 			=> $param['nama'],
			"alamat" 		=> $param['alamat'],
			"telepon" 		=> $param['telepon'],
			"email" 		=> $param['email'],
			"batas" 		=> $param['batas'],
			"created_by"	=> getSession('userId')
		];

		return $this->db->insert("pemasok", $object);
	}

	public function editPemasok($param)
	{
		$data = [
			// 'tanggal'=> $param['tanggal'],
			'akun' 			=> $param['akun'],
			'nama' 			=> $param['nama'],
			'alamat' 		=> $param['alamat'],
			'telepon'		=> $param['telepon'],
			'email' 		=> $param['email'],
			'batas' 		=> $param['batas'],
			'statusA' 		=> $param['status'],
			'updated_by' 	=> getSession('userId'),
		];

		$this->db->where([$this->primary_key => $param['n_pemasok']]);
		return $this->db->update($this->table, $data);
	}

	public function getDetail($nama)
	{
		$this->db->where($this->primary_key, $nama);
		$data = $this->db->get($this->table)->row();
		if (!$data) {
			return FALSE;
		} else {
			return $data;
		}
	}

	public function ambilCoa($grup)
	{
		$this->db->select('*');
		$this->db->where("grup", $grup);
		$this->db->from('coa');
		$data = $this->db->get();

		return $data->result();
	}

	public function hapusData($n_pemasok)
	{
		$this->db->where($this->primary_key, $n_pemasok);
		return $this->db->delete($this->table);
	}

	public function aktif_pemasok($n_pemasok)
	{
		$object = [
			"statusA" => '1'
		];
		$this->db->where($this->primary_key, $n_pemasok);
		return $this->db->update($this->table, $object);
	}
}
