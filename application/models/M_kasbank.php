<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kasbank extends MY_Model
{
	protected $table = 'hkasbank';
	protected $primary_key = 'n_kasbank';
	protected $order_by = 'tanggal';
	protected $order_by_type = 'DESC';

	public function insertTransKB($param, $n_jurnal)
	{
		$return['status'] = null;
		$return['message'] = null;
		$this->db->trans_start();
		$conv_date = strtotime($param['tgl_transaksi']);
		$tanggal = date('Y-m-d', $conv_date);
		//hjurnal
		$objectHjurn = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['sum_bayar'],
			"statusA" => substr($param['n_transaksi'], 0, 2),
			"created_by"	=> getSession('userId'),
		];
		$this->db->insert("hjurnal", $objectHjurn);
		//hkasbank
		$object1 = [
			"n_kasbank" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['sum_bayar'],
			"statusA" => $param['jenis'],
			"n_bank" => $param['no_bank'],
			"n_jurnal" => $n_jurnal,
			"created_by"	=> getSession('userId'),
		];
		$this->db->insert($this->table, $object1);

		//djurnal kasBank
		if ($param['jenis'] == "M") {
			$objectDjurnKB = [
				"n_jurnal" => $n_jurnal,
				"tanggal" => $tanggal,
				"akun" => $param['bayar'],
				"debet" => $param['sum_bayar'],
				"kredit" => 0,
				"status_valid" => "a",
				"created_by"	=> getSession('userId'),
			];
		}
		if ($param['jenis'] == "K") {
			$objectDjurnKB = [
				"n_jurnal" => $n_jurnal,
				"tanggal" => $tanggal,
				"akun" => $param['bayar'],
				"debet" => 0,
				"kredit" => $param['sum_bayar'],
				"status_valid" => "a",
				"created_by"	=> getSession('userId'),
			];
		}
		$this->db->insert("djurnal", $objectDjurnKB);


		//djurnal secondary
		for ($br = 0; $br < $param['jml_baris']; $br++) {
			if ($param['akun' . $br]) {
				if ($param['jenis'] == "M") {
					$objectDjurnSec = [
						"n_jurnal" => $n_jurnal,
						"tanggal" => $tanggal,
						"akun" => $param['akun' . $br],
						"debet" => 0,
						"kredit" => $param['jumlah' . $br],
						"status_valid" => "a",
						"created_by"	=> getSession('userId'),
					];
				}
				if ($param['jenis'] == "K") {
					$objectDjurnSec = [
						"n_jurnal" => $n_jurnal,
						"tanggal" => $tanggal,
						"akun" => $param['akun' . $br],
						"debet" => $param['jumlah' . $br],
						"kredit" => 0,
						"status_valid" => "a",
						"created_by"	=> getSession('userId'),
					];
				}
				$this->db->insert("djurnal", $objectDjurnSec);
			}
		}

		//dkasbank secondary
		for ($dk = 0; $dk < $param['jml_baris']; $dk++) {
			if (@$param['akun' . $dk]) {
				if ($param['jenis'] == "M") {
					$objectDkasBank = [
						"n_kasbank" => $param['n_transaksi'],
						"akun" => $param['akun' . $dk],
						"debet" => 0,
						"kredit" => $param['jumlah' . $dk],
						"created_by"	=> getSession('userId'),
					];
				}
				if ($param['jenis'] == "K") {
					$objectDkasBank = [
						"n_kasbank" => $param['n_transaksi'],
						"akun" => $param['akun' . $dk],
						"debet" => $param['jumlah' . $dk],
						"kredit" => 0,
						"created_by"	=> getSession('userId'),
					];
				}
				$this->db->insert("dkasbank", $objectDkasBank);
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Transaksi kas & bank berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['message'] = 'Transaksi kas & bank gagal';
		}
		return $return;
	}

	public function get_cetak_nota($n_transaksi)
	{
		$this->db->select('hkasbank.*, dkasbank.akun as noPerkiraan, coa.nama as namaPerkiraan, dkasbank.debet as ddebet, dkasbank.kredit as dkredit, bank.nama as nama_bank, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->join('bank', 'bank.n_bank = hkasbank.n_bank', 'left');
		$this->db->where('hkasbank.n_kasbank', $n_transaksi);

		$data = $this->db->get($this->table);

		return $data;
	}

	public function getTransKas()
	{
		$this->db->where('n_bank = "KAS"');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function getTransBank()
	{
		$this->db->where('n_bank != "KAS"');
		$data = $this->db->get($this->table);

		return $data->result();
	}

	public function get_cetak_ulangkas($param)
	{

		$transkas = $param['transkas'];

		$this->db->select('hkasbank.*, dkasbank.akun as noPerkiraan, coa.nama as namaPerkiraan, dkasbank.debet as ddebet, dkasbank.kredit as dkredit, bank.nama as nama_bank, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->join('bank', 'bank.n_bank = hkasbank.n_bank', 'left');
		$this->db->where('hkasbank.n_kasbank', $transkas);

		$data = $this->db->get($this->table);

		return $data;
	}

	public function get_cetak_ulangbank($param)
	{

		$transbank = $param['transbank'];

		$this->db->select('hkasbank.*, dkasbank.akun as noPerkiraan, coa.nama as namaPerkiraan, dkasbank.debet as ddebet, dkasbank.kredit as dkredit, bank.nama as nama_bank, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->join('bank', 'bank.n_bank = hkasbank.n_bank', 'left');
		$this->db->where('hkasbank.n_kasbank', $transbank);

		$data = $this->db->get($this->table);

		return $data;
	}
}
