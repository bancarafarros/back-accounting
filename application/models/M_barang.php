<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends MY_Model
{

	protected $table = 'barang';
	protected $primary_key = 'n_barang';
	protected $order_by = 'n_barang';
	protected $order_by_type = 'DESC';

	public function getData()
	{
		$this->db->select('*');
		$this->db->from('barang');
		$data = $this->db->get();
		return $data->result();
	}

	public function insertBarang($param)
	{
		$object = [
			"n_barang" 			=> $param['n_barang'],
			"barcode"			=> $param['barcode'],
			"akun_hpp" 			=> $param['akun_hpp'],
			"akun_persediaan" 	=> $param['akun_persediaan'],
			"akun_pendapatan" 	=> $param['akun_pendapatan'],
			"nama" 				=> $param['nama'],
			// "harga_pokok" 		=> $param['harga_pokok'],
			"harga_beli" 		=> $param['harga_beli'],
			"harga_jual1" 		=> $param['harga_jual1'],
			"harga_jual2" 		=> $param['harga_jual2'],
			"harga_jual3" 		=> $param['harga_jual3'],
			"stock_gudang" 		=> $param['stock_gudang'],
			"stock_etalase" 	=> $param['stock_etalase'],
			"stock_min" 		=> $param['stock_min'],
			"n_unit" 			=> $param['n_unit'],
			"b_unit" 			=> $param['b_unit'],
			"konversi_unit" 	=> $param['konversi_unit'],
			"n_grup" 			=> $param['n_grup'],
			"diskon" 			=> $param['diskon'],
			"keterangan1" 		=> $param['keterangan1'],
			"keterangan2" 		=> $param['keterangan2'],
			"keterangan3" 		=> $param['keterangan3'],
			"created_by"		=> getSession('userId'),
		];

		return $this->db->insert($this->table, $object);
	}

	public function editBarang($param)
	{
		$object = [
			// "n_barang" 			=> $param['n_barang'],
			"barcode" 			=> $param['barcode'],
			"akun_hpp" 			=> $param['akun_hpp'],
			"akun_persediaan" 	=> $param['akun_persediaan'],
			"akun_pendapatan" 	=> $param['akun_pendapatan'],
			"nama" 				=> $param['nama'],
			"harga_beli" 		=> $param['harga_beli'],
			"harga_jual1" 		=> $param['harga_jual1'],
			"harga_jual2" 		=> $param['harga_jual2'],
			"harga_jual3" 		=> $param['harga_jual3'],
			"stock_gudang" 		=> $param['stock_gudang'],
			"stock_etalase"		=> $param['stock_etalase'],
			"stock_min" 		=> $param['stock_min'],
			"n_unit" 			=> $param['n_unit'],
			"b_unit" 			=> $param['b_unit'],
			"konversi_unit" 	=> $param['konversi_unit'],
			"n_grup" 			=> $param['n_grup'],
			"diskon" 			=> $param['diskon'],
			"keterangan1" 		=> $param['keterangan1'],
			"keterangan2" 		=> $param['keterangan2'],
			"keterangan3" 		=> $param['keterangan3'],
			"updated_by"		=> getSession('userId'),
		];

		$this->db->where($this->primary_key, $param['n_barang']);
		return $this->db->update($this->table, $object);
	}

	public function getDetail($n_barang)
	{
		$this->db->select('*, (SELECT nama FROM coa WHERE akun = akun_hpp) as namaakun_hpp, (SELECT nama FROM coa WHERE akun = akun_persediaan) as namaakun_persediaan, (SELECT nama FROM coa WHERE akun = akun_pendapatan) as namaakun_pendapatan, (SELECT departement FROM barang_grup WHERE barang_grup.n_grup = barang.n_grup) as nama_grup');
		$this->db->where("n_barang", $n_barang);
		$data = $this->db->get($this->table)->row();
		return $data;
	}

	public function getDataBarang()
	{
		$this->db->select('barang.*');
		$this->db->join('coa', 'coa.akun = barang.akun_hpp');
		$this->db->join('coa coa1', 'coa1.akun = barang.akun_persediaan');
		$this->db->join('coa coa2', 'coa2.akun = barang.akun_pendapatan');
		$data = $this->db->get($this->table);
		return $data->result();
	}

	public function getDetailBarang($n_barang)
	{
		$this->db->select('barang.*');
		$this->db->where("n_barang", $n_barang);
		$this->db->or_where("barcode", $n_barang);
		$this->db->join('coa', 'coa.akun = barang.akun_hpp');
		$this->db->join('coa coa1', 'coa1.akun = barang.akun_persediaan');
		$this->db->join('coa coa2', 'coa2.akun = barang.akun_pendapatan');
		$data = $this->db->get($this->table)->row();
		if (!$data) {
			return FALSE;
		} else {
			return $data;
		}
	}

	public function hapusData($n_barang)
	{
		$this->db->where($this->primary_key, $n_barang);
		return $this->db->delete($this->table);
	}

	public function get_KodeLast($grup)
	{
		$hasil = $this->db->query("SELECT RIGHT(n_barang, 5) as kodeLast FROM barang WHERE n_grup = '$grup' ORDER BY n_barang DESC LIMIT 1");
		$hasil2 = $this->db->query("SELECT akun_persediaan, akun_pendapatan, akun_hpp, (SELECT coa.nama FROM coa WHERE coa.akun = barang_grup.akun_persediaan) as namaakun_persediaan, (SELECT coa.nama FROM coa WHERE coa.akun = barang_grup.akun_hpp) namaakun_hpp, (SELECT coa.nama FROM coa WHERE coa.akun = barang_grup.akun_pendapatan) as namaakun_pendapatan FROM barang_grup WHERE n_grup = '$grup'");

		if ($hasil->num_rows() > 0) {
			foreach ($hasil->result() as $value) {
				$data1 = array(
					'KodeLast' => $value->kodeLast,
				);
				foreach ($hasil2->result() as $value2) {
					$data2 = array(
						'akun_persediaan' => $value2->akun_persediaan,
						'akun_hpp' => $value2->akun_hpp,
						'akun_pendapatan' => $value2->akun_pendapatan,
						'namaakun_persediaan' => $value2->namaakun_persediaan,
						'namaakun_hpp' => $value2->namaakun_hpp,
						'namaakun_pendapatan' => $value2->namaakun_pendapatan,
					);
				}
			}
			$data = array_merge($data1, $data2);
			return $data;
		} else {
			$data1 = array('KodeLast' => "00000");
			foreach ($hasil2->result() as $value2) {
				$data2 = array(
					'akun_persediaan' => $value2->akun_persediaan,
					'akun_hpp' => $value2->akun_hpp,
					'akun_pendapatan' => $value2->akun_pendapatan,
					'namaakun_persediaan' => $value2->namaakun_persediaan,
					'namaakun_hpp' => $value2->namaakun_hpp,
					'namaakun_pendapatan' => $value2->namaakun_pendapatan,
				);
			}
			$data = array_merge($data1, $data2);
			return $data;
		}
	}

	public function BarangMinimum()
	{
		$this->db->where("(stock_gudang + stock_etalase) < stock_min");
		$data = $this->db->get($this->table)->result_array();
		return $data;
	}

	public function get_kartu_barang($n_barang, $from_date, $to_date)
	{
		$this->db->select('*');
		$this->db->where("n_barang", $n_barang);
		$this->db->where("tanggal >=", $from_date);
		$this->db->where("tanggal <=", $to_date);
		$this->db->order_by('tanggal asc', 'waktu asc');
		$data = $this->db->get("keluar_masuk")->result();
		return $data;
	}
}
