<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_hutang extends MY_Model
{
	protected $table = 'hutang';
	protected $primary_key = 'n_pembelian';
	protected $order_by = 'tanggal';
	protected $order_by_type = 'DESC';

	public function get_kartu_by_pemasok($n_pemasok)
	{
		$this->db->where("statusA", "b");
		$this->db->where("n_pemasok", $n_pemasok);
		$this->db->order_by($this->order_by, $this->order_by_type);
		$hasil = $this->db->get($this->table);
		return $hasil->result();
	}

	public function d_hutang($pemasok)
	{
		$this->db->select('*,(SELECT nama FROM pemasok WHERE pemasok.n_pemasok = hutang.n_pemasok) as pemasok');
		$this->db->where("n_pemasok", $pemasok);
		$this->db->where("statusA", "b");
		$data = $this->db->get($this->table);
		return $data->result();
	}

	public function insertHutang($param, $jurnal, $n_jurnal)
	{
		$return['status'] = null;
		$return['message'] = null;
		$error = null;
		$conv_date = strtotime($param['tanggal']);
		$conv_date1 = strtotime($param['tempo']);
		$tanggal = date('Y-m-d', $conv_date);
		$tempo = date('Y-m-d', $conv_date1);
		$object = [
			"n_pembelian" 	=> $param['n_pembelian'],
			"tanggal" 		=> $tanggal,
			"n_pemasok" 	=> $param['n_pemasok'],
			"keterangan" 	=> $param['keterangan'],
			"jumlah" 		=> $param['jumlah'],
			"sisa"			=> $param['jumlah'],
			"tempo" 		=> $tempo,
			"statusA" 		=> $param['status'],
			"reff" 			=> $param['c_bayar'],
			"created_by"	=> getSession('userId'),
		];
		$object1 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"reff" => $param['n_pembelian'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['jumlah'],
			"statusA" => substr($param['n_pembelian'], 0, 2),
			"created_by"	=> getSession('userId'),
		];
		$object2 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['debet'],
			"debet" => $param['jumlah'],
			"kredit" => 0,
			"status_valid" => "a",
			"created_by"	=> getSession('userId'),
		];
		$object3 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['kredit'],
			"debet" => 0,
			"kredit" => $param['jumlah'],
			"status_valid" => "a",
			"created_by"	=> getSession('userId'),
		];
		$this->db->trans_start();
		$this->db->insert($this->table, $object);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->insert("hjurnal", $object1);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->insert("djurnal", $object2);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->insert("djurnal", $object3);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Transaksi hutang berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi hutang gagal';
		}
		return $return;
	}

	public function insBayarHutang($param, $jurnal, $n_jurnal)
	{
		$return['status'] = null;
		$return['message'] = null;
		$error = null;
		$this->db->trans_start();
		$conv_date = strtotime($param['tgl_transaksi']);
		$tanggal = date('Y-m-d', $conv_date);
		$no_bank = explode(" | ", $param['no_bank']);
		//hjurnal
		$object = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"reff" => $param['n_transaksi'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['sum_bayar'],
			"statusA" => substr($param['n_transaksi'], 0, 2),
			"created_by"	=> getSession('userId'),
		];
		//djurnal debet
		$object1 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['debet'],
			"debet" => $param['sum_bayar'],
			"kredit" => 0,
			"status_valid" => "a",
			"created_by"	=> getSession('userId'),
		];

		//djurnal kredit 
		$object2 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['kredit'],
			"debet" => 0,
			"kredit" => $param['sum_bayar'],
			"status_valid" => "a",
			"created_by"	=> getSession('userId'),
		];

		for ($a = 0; $a < $param['j_hutang']; $a++) {
			$objectLop = [
				"n_hutang" => $param['n_transaksi'],
				"n_pembelian" => $param['n_pembelian' . $a],
				"tanggal" => $tanggal,
				"keterangan" => $param['keterangan'],
				"bayar" => $param['j_bayar' . $a],
				"cara_bayar" =>  $param['c_bayar'],
				"n_bayar" =>  $no_bank[0],
				"created_by"	=> getSession('userId'),
			];
			$objectLop1 = [
				"sisa" => $param['sisa' . $a],
				"updated_by" => getSession('userId'),
			];
			$objectLop2 = [
				"statusA" => "s",
				"updated_by" => getSession('userId'),
			];

			if ($param['j_bayar' . $a] <> 0) {
				$this->db->insert("dhutang", $objectLop);
				$this->db->where($this->primary_key, $param['n_pembelian' . $a]);
				$this->db->update($this->table, $objectLop1);
			}
			if ($param['j_bayar' . $a] == $param['s_hutang' . $a] || $param['s_hutang' . $a] == 0) {
				$this->db->where($this->primary_key, $param['n_pembelian' . $a]);
				$this->db->update($this->table, $objectLop2);
			}
		}
		$this->db->insert("hjurnal", $object);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->insert("djurnal", $object1);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->insert("djurnal", $object2);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Transaksi bayar hutang berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi bayar hutang gagal';
		}
		return $return;
	}

	public function getDataHutangGlobal()
	{
		$curr_date = date('Y-m-d');

		$this->db->select('hutang.*, pemasok.nama as nama_pemasok');
		$this->db->select_sum('sisa');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		$this->db->group_by('n_pemasok');
		$this->db->where('hutang.statusA = "b"');
		$this->db->where('hutang.tanggal <=', $curr_date);
		$data = $this->db->get($this->table);
		return $data->result();
	}

	public function getDataHutangDetail()
	{
		$curr_date = date('Y-m-d ');

		$this->db->select('hutang.*, pemasok.nama as nama_pemasok, hutang.tanggal as tanggalp');
		/*$this->db->select_sum('sisa');*/
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		/*$this->db->group_by('n_pemasok');*/
		$this->db->where('hutang.statusA = "b"');
		$this->db->where('hutang.tanggal <=', $curr_date);
		$data = $this->db->get($this->table);
		return $data;
	}

	public function get_cetak_notaHutang($n_transaksi)
	{
		$this->db->select('hutang.*, pemasok.nama as pemasok, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		$this->db->where('hutang.n_pembelian', $n_transaksi);

		$data = $this->db->get($this->table);

		return $data;
	}

	public function get_cetak_notaBhutang($n_transaksi)
	{
		$this->db->select('dhutang.*, pemasok.nama as pemasok, hutang.keterangan as ketrHutang, hutang.n_pembelian as n_beli, bank.nama as nbank, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('hutang', 'hutang.n_pembelian = dhutang.n_pembelian');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		$this->db->join('bank', 'bank.n_bank = dhutang.n_bayar', 'left');
		$this->db->where('dhutang.n_hutang', $n_transaksi);

		$data = $this->db->get('dhutang');

		return $data;
	}

	public function getDataHutangNlunas()
	{
		$this->db->where(['statusA' => 'b', 'tempo <= ' => date('Y-m-d')]);
		$data = $this->db->get($this->table);
		return $this->setReturn($data, true, false);
	}
}
