<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pelanggan extends MY_Model
{
	protected $table = 'pelanggan';
	protected $primary_key = 'n_pelanggan';
	protected $order_by = 'n_pelanggan';
	protected $order_by_type = 'DESC';

	public function getData()
	{
		$this->db->select('pelanggan.*,coa.nama as n_akun, salesman.nama as nama_sales');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('coa', 'coa.akun = pelanggan.akun');
		$this->db->where(['statusA' => "1"]);
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getFirstData()
	{
		$this->db->select('pelanggan.*,coa.nama as n_akun, salesman.nama as nama_sales');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('coa', 'coa.akun = pelanggan.akun');
		$this->db->where(['statusA' => "1"]);
		$data = $this->db->get($this->table);

		return $data->row();
	}

	public function dataSales()
	{
		$this->db->select('*');
		$data = $this->db->get('salesman');

		return $data->result();
	}

	public function getDataNaktif()
	{
		$this->db->select('*,(SELECT nama FROM coa WHERE coa.akun = pelanggan.akun) as n_akun');
		$this->db->from('pelanggan');
		$this->db->where(['statusA' => "0"]);
		$data = $this->db->get();

		return $data->result();
	}

	public function insertPelanggan($param)
	{
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);

		if (empty($param['batas'])) {
			$object = [
				"n_pelanggan" 	=> generateNomorPerson(PREFIX_PELANGGAN, 'n_pelanggan', 'pelanggan'),
				"barcode" 		=> $param['barcode'],
				"tanggal" 		=> $tanggal,
				"akun" 			=> $param['akun'],
				"nama" 			=> $param['nama'],
				"alamat" 		=> $param['alamat'],
				"telepon" 		=> $param['telepon'],
				"email" 		=> $param['email'],
				"batas" 		=> 0,
				"n_sales" 		=> $param['n_sales'],
				'created_by'	=> getSession('userId'),
			];
		} else {
			$object = [
				"n_pelanggan" 	=> generateNomorPerson(PREFIX_PELANGGAN, 'n_pelanggan', 'pelanggan'),
				"barcode" 		=> $param['barcode'],
				"tanggal" 		=> $tanggal,
				"akun" 			=> $param['akun'],
				"nama" 			=> $param['nama'],
				"alamat" 		=> $param['alamat'],
				"telepon" 		=> $param['telepon'],
				"email" 		=> $param['email'],
				"batas" 		=> $param['batas'],
				"n_sales" 		=> $param['n_sales'],
				'created_by'	=> getSession('userId'),
			];
		}

		return $this->db->insert($this->table, $object);
	}

	public function editPelanggan($param)
	{
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);

		$object = [
			"n_pelanggan" => $param['n_pelanggan'],
			"barcode" => $param['barcode'],
			// "pass" => $param['pass'],
			"tanggal" => $tanggal,
			"akun" => $param['akun'],
			"nama" => $param['nama'],
			"alamat" => $param['alamat'],
			"telepon" => $param['telepon'],
			"email" => $param['email'],
			"batas" => $param['batas'],
			"statusA" => $param['status'],
			"n_sales" => $param['n_sales']
		];

		$this->db->where($this->primary_key, $param['n_pelanggan']);
		return $this->db->update($this->table, $object);
	}

	public function ambilCoa($grup)
	{
		$this->db->where(["grup" => $grup]);
		$data = $this->db->get('coa');

		return $data->result();
	}

	public function getDetail($nama)
	{
		$this->db->select('pelanggan.*, salesman.nama as nama_sales');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->where($this->primary_key, $nama);
		$data = $this->db->get($this->table)->result();
		if (!$data) {
			return FALSE;
		} else {
			return $data[0];
		}
	}

	public function hapusData($n_pelanggan)
	{
		$this->db->where($this->primary_key, $n_pelanggan);
		return $this->db->delete($this->table);
	}

	public function aktif_pelanggan($n_pelanggan)
	{
		$object = [
			"statusA" => '1'
		];

		$this->db->where($this->primary_key, $n_pelanggan);
		return $this->db->update($this->table, $object);
	}
}
