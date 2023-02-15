<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_coa extends MY_Model
{

	protected $table = 'coa';
	protected $primary_key = 'akun';
	protected $order_by = 'akun';
	protected $order_by_type = 'DESC';

	public function getData()
	{
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getDataGrup()
	{
		$this->db->where('subgrup = "" AND detail = ""');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getDataSubgrup($grup)
	{
		// $this->db->where('subgrup <> "" AND detail = ""');
		// var_dump($this->db->last_query());
		// die;
		// $data = $this->db->get($this->table);
		$this->db->select('subgrup');
		$this->db->where('grup', $grup);
		$this->db->distinct();
		$data = $this->db->get($this->table);
		// var_dump($this->db->last_query());
		// die;
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// die;

		return $data->result();
	}

	public function getDataDetailgrup()
	{
		$this->db->where('subgrup <> "" AND detail <> ""');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function insertCoa($param)
	{
		if (empty($param['link'])) {
			$object = [
				"akun" => $param['kode'] . $param['akun'],
				"nama" => $param['nama'],
				"grup" => $param['grup'],
				"subgrup" => $param['subgrup'],
				"detail" => $param['detail'],
				"link" => $param['kode'] . $param['akun'],
			];

		} else {
			$object = [
				"akun" => $param['kode'] . $param['akun'],
				"nama" => $param['nama'],
				"grup" => $param['grup'],
				"subgrup" => $param['subgrup'],
				"detail" => $param['detail'],
				"link" => $param['link'],
			];
		}

		return $this->db->insert($this->table, $object);
	}

	public function editCoa($param)
	{
		if (empty($param['link'])) {
			$object = [
				// "akun" => $param['akun'],
				"nama" => $param['nama'],
				"subgrup" => $param['subgrup'],
				"detail" => $param['detail'],
				"link" => $param['akun'],
			];
		
		} else {
			$object = [
				// "akun" => $param['akun'],
				"nama" => $param['nama'],
				"subgrup" => $param['subgrup'],
				"detail" => $param['detail'],
				"link" => $param['link'],
			];
		}

		$this->db->where($this->primary_key, $param['akun']);
		return $this->db->update($this->table, $object);
	}

	public function getDetail($nama)
	{
		$this->db->where("akun", $nama);
		// var_dump($this->db->last_query());
		// die;
		$data = $this->db->get("coa")->row();
		return $data;
	}

	public function hapusData($akun)
	{
		$this->db->where($this->primary_key, $akun);
		return $this->db->delete($this->table);
	}
}
