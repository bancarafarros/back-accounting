<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_grupbarang extends MY_Model
{
	protected $table = 'barang_grup';
	protected $primary_key = 'n_grup';
	protected $order_by = 'n_grup';
	protected $order_by_type = 'DESC';

	public function getDataAll()
	{
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getDataGrup()
	{
		$this->db->where('departement IS NULL');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getDataDepart()
	{
		$this->db->where('departement IS NOT NULL');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function insertGrupBarang($param)
	{
		$this->db->db_debug = false;
		$object = [
			"n_grup" => $param['n_grup'],
			"grup" => $param['grup'],
			"created_by" => getSession('userId'),
		];

		return $this->db->insert($this->table, $object);
	}

	public function editGrupBarang($n_grup, $param)
	{
		$object = [
			// "n_grup" => $param['n_grup'],
			"grup" => $param['grup'],
			"margin_grup" => $param['grup'],
			"updated_by" => getSession('userId'),
		];

		$this->db->where($this->primary_key, $n_grup);
		return $this->db->update($this->table, $object);
	}

	public function insertDepartBarang($param)
	{
		$object = [
			"n_grup" => $param['n_grup2'],
			"grup" => $param['grup2'],
			"departement" => $param['departement'],
			"akun_hpp" => $param['akun_hpp'],
			"akun_persediaan" => $param['akun_persediaan'],
			"akun_pendapatan" => $param['akun_pendapatan'],
			"margin_departement" => $param['margin_departement'],
			"kode" => $param['kode'],
			"created_by" => getSession('userId'),
		];

		return $this->db->insert($this->table, $object);
	}

	public function editDepartBarang($param)
	{
		$object = [
			"n_grup" => $param['n_grup2'],
			"departement" => $param['departement'],
			"akun_hpp" => $param['akun_hpp'],
			"akun_persediaan" => $param['akun_persediaan'],
			"akun_pendapatan" => $param['akun_pendapatan'],
			"margin_departement" => $param['margin_departement'],
			"updated_by" => getSession('userId'),
		];

		$this->db->where($this->primary_key, $param['n_grup2']);
		return $this->db->update($this->table, $object);
	}

	public function getDetail($nama)
	{
		$this->db->where($this->primary_key, $nama);
		$data = $this->db->get($this->table)->row();
		return $data;
	}

	public function hapusData($n_grup)
	{
		$this->db->where($this->primary_key, $n_grup);
		return $this->db->delete($this->table);
	}

	public function get_KodeLast($n_barang)
	{
		$hasil = $this->db->query("SELECT RIGHT(n_grup, 3) as kodeLast FROM barang_grup WHERE grup = '$n_barang' ORDER BY n_grup DESC LIMIT 1");
		if ($hasil->num_rows() > 0) {
			foreach ($hasil->result() as $value) {
				$data = array(
					'KodeLast' => $value->kodeLast,
				);
			}
			return $data;
		} else {
			$data = array('KodeLast' => "000");
			return $data;
		}
	}

	public function getDetailDepart($n_grup)
	{
		$this->db->select('*, (SELECT nama FROM coa WHERE akun = akun_hpp) as namaakun_hpp, (SELECT nama FROM coa WHERE akun = akun_persediaan) as namaakun_persediaan, (SELECT nama FROM coa WHERE akun = akun_pendapatan) as namaakun_pendapatan');
		$this->db->where("n_grup", $n_grup);
		$data = $this->db->get("barang_grup")->result();
		return $data[0];
	}
}
