<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penghubung extends MY_Model
{
	protected $table = 'coa_penghubung';
	protected $primary_key = 'n_penghubung';
	protected $order_by = 'n_penghugung';
	protected $order_by_type = 'DESC';

	public function getData($kode)
	{
		$this->db->select('*, coa.nama as nama');
		$this->db->join('coa', 'coa.akun = coa_penghubung.akun');
		$this->db->where($this->primary_key, $kode);
		$data = $this->db->get($this->table)->row();
		return $data;
	}

	public function setPenghubung($penghubung, $akun)
	{
		$object = [
			"akun" => $akun,
		];
		$this->db->where($this->primary_key, $penghubung);
		return $this->db->update($this->table, $object);
	}

	public function getDetail($nama)
	{
		$this->db->where($this->primary_key, $nama);
		$data = $this->db->get($this->table)->row();
		return $data;
	}
}
