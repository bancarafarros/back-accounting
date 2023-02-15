<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sales extends MY_Model
{

	protected $table = 'salesman';
	protected $primary_key = 'n_sales';
	protected $order_by = 'n_sales';
	protected $order_by_type = 'DESC';

	public function getData()
	{
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function insertSales($param)
	{
		// $n_sales = generateNomorPerson(PREFIX_SALES, 'n_sales', 'salesman');
		$object = [
			// "n_sales" 	=> $n_sales,
			"n_sales" 	=> generateNomorPerson(PREFIX_SALES, 'n_sales', 'salesman'),
			"nama" 		=> $param['nama'],
			"alamat"	=> $param['alamat'],
			"telepon" 	=> $param['telepon'],
			"created_by" => getSession('userId'),
		];
		return $this->db->insert($this->table, $object);
	}

	public function editSales($param)
	{
		$object = [
			"nama"	 		=> $param['nama'],
			"alamat" 		=> $param['alamat'],
			"telepon" 		=> $param['telepon'],
			"updated_by" 	=> getSession('userId'),
		];

		$this->db->where($this->primary_key, $param['n_sales']);
		return $this->db->update($this->table, $object);
	}

	public function getDetail($nama)
	{
		$this->db->where($this->primary_key, $nama);
		$data = $this->db->get($this->table)->row();
		return $data;
	}

	public function hapusData($n_sales)
	{
		$this->db->where($this->primary_key, $n_sales);
		return $this->db->delete($this->table);
	}
}
