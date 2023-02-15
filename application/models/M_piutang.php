<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_piutang extends MY_Model
{

	protected $table = 'piutang';
	protected $primary_key = 'n_penjualan';
	protected $order_by = 'tanggal';
	protected $order_by_type = 'DESC';
	protected $primary_filtered;
	protected $type;

	public function get_kartu_by_pelanggan($n_pelanggan)
	{
		$this->db->select('*');
		// $this->db->from('piutang');
		$this->db->where('statusA', 'b');
		$this->db->where('n_pelanggan', $n_pelanggan);
		$this->db->order_by('tanggal', 'DESC');
		$this->db->last_query();

		// $data = $this->get($n_pelanggan, true, true);

		$hasil = $this->db->get($this->table);
		return $hasil->result();
		// return $data;

		// $this->db->select('*');
		// $this->db->from('piutang');
		// $this->db->where(['statusA' => 'b', 'n_pelanggan' => $n_pelanggan]);
		// $this->db->order_by('tanggal', 'DESC');
		// $this->db->last_query();

		// // $data = $this->get($n_pelanggan, true, true);

		// $hasil = $this->db->get($this->table);
		// return $hasil->result();
		// // return $data;
	}

	public function get_d_piutang($pelanggan)
	{
		$this->db->select('*,(SELECT nama FROM pelanggan WHERE pelanggan.n_pelanggan = piutang.n_pelanggan) as pelanggan');
		$this->db->where("n_pelanggan", $pelanggan);
		$this->db->where("statusA", "b");
		$data = $this->db->get($this->table);
		return $data->result();
	}

	public function getDataPiutang()
	{
		$this->db->where(["statusA" => "b", "tempo <=" => date('Y-m-d')]);
		$data = $this->db->get($this->table);

		return $this->setReturn($data, true, false);
	}

	public function getDataPiutangGlobal()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');

		$this->db->select('piutang.*, pelanggan.nama as nama_pelanggan');
		$this->db->select_sum('sisa');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = piutang.n_pelanggan');
		$this->db->from('piutang');
		$this->db->group_by('n_pelanggan');
		$this->db->where('piutang.statusA = "b"');
		$this->db->where('piutang.tanggal <=', $curr_date);
		$data = $this->db->get();
		return $data->result();
	}

	public function getDataPiutangDetail()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');

		$this->db->select('piutang.*, pelanggan.nama as nama_pelanggan, piutang.tanggal as tanggalp');
		/*$this->db->select_sum('sisa');*/
		$this->db->from('piutang');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = piutang.n_pelanggan');
		/*$this->db->group_by('n_pelanggan');*/
		$this->db->where('piutang.statusA = "b"');
		$this->db->where('piutang.tanggal <=', $curr_date);
		$data = $this->db->get();
		return $data;
	}


	public function insertPiutang($param, $jurnal, $n_jurnal)
	{
		$error = null;
		$return['status'] = null;
		$return['message'] = null;
		$conv_date = strtotime($param['tanggal']);
		$conv_date1 = strtotime($param['tempo']);
		$tanggal = date('Y-m-d', $conv_date);
		$tempo = date('Y-m-d', $conv_date1);
		$object = [
			"n_penjualan" => $param['n_penjualan'],
			"tanggal" => $tanggal,
			"n_pelanggan" => $param['n_pelanggan'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['jumlah'],
			"sisa" => $param['jumlah'],
			"tempo" => $tempo,
			"statusA" => $param['status'],
			"reff" => $param['c_bayar'],
			"n_sales" => $param['n_sales'],
			"created_by" => getSession('userId'),
		];
		$object1 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"reff" => $param['n_penjualan'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['jumlah'],
			"statusA" => substr($param['n_penjualan'], 0, 2),
			"created_by" => getSession('userId'),
		];
		$object2 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['debet'],
			"debet" => $param['jumlah'],
			"kredit" => 0,
			"status_valid" => "a",
			"created_by" => getSession('userId'),
		];
		$object3 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['kredit'],
			"debet" => 0,
			"kredit" => $param['jumlah'],
			"status_valid" => "a",
			"created_by" => getSession('userId'),
		];
		$this->db->trans_start();
		$this->db->insert("piutang", $object);
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
			$return['message'] = 'Transaksi piutang berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi piutang gagal';
		}
		return $return;
	}

	public function insBayarPiutang($param, $jurnal, $n_jurnal)
	{
		$error = null;
		$return['status'] = null;
		$return['message'] = null;
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
			"created_by" => getSession('userId'),
		];
		//djurnal debet
		$object1 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['debet'],
			"debet" => $param['sum_bayar'],
			"kredit" => 0,
			"status_valid" => "a",
			"created_by" => getSession('userId'),
		];

		//djurnal kredit 
		$object2 = [
			"n_jurnal" => $n_jurnal,
			"tanggal" => $tanggal,
			"akun" => $jurnal['kredit'],
			"debet" => 0,
			"kredit" => $param['sum_bayar'],
			"status_valid" => "a",
			"created_by" => getSession('userId'),
		];
		for ($a = 0; $a < $param['j_piutang']; $a++) {
			$objectLop = [
				"n_piutang" => $param['n_transaksi'],
				"n_penjualan" => $param['n_penjualan' . $a],
				"tanggal" => $tanggal,
				"keterangan" => $param['keterangan'],
				"bayar" => $param['j_bayar' . $a],
				"cara_bayar" =>  $param['c_bayar'],
				"n_bayar" =>  $no_bank[0],
				"created_by" => getSession('userId'),
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
				$this->db->insert("dpiutang", $objectLop);
				$this->db->where("n_penjualan", $param['n_penjualan' . $a]);
				$this->db->update("piutang", $objectLop1);
			}
			if ($param['j_bayar' . $a] == $param['s_piutang' . $a] || $param['s_piutang' . $a] == 0) {
				$this->db->where("n_penjualan", $param['n_penjualan' . $a]);
				$this->db->update("piutang", $objectLop2);
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
			$return['message'] = 'Transaksi bayar piutang berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi bayar piutang gagal';
		}
		return $return;
	}

	public function get_cetak_notaPiutang($n_transaksi)
	{
		$this->db->select('piutang.*, pelanggan.nama as pelanggan, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('piutang');
		$this->db->from('perusahaan');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = piutang.n_pelanggan');
		$this->db->where('piutang.n_penjualan', $n_transaksi);

		$data = $this->db->get();

		return $data;
	}
	public function get_cetak_notaBpiutang($n_transaksi)
	{
		$this->db->select('dpiutang.*, pelanggan.nama as pelanggan, piutang.keterangan as ketrpiutang, piutang.n_penjualan as n_jual, bank.nama as nbank, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('dpiutang');
		$this->db->from('perusahaan');
		$this->db->join('piutang', 'piutang.n_penjualan = dpiutang.n_penjualan');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = piutang.n_pelanggan');
		$this->db->join('bank', 'bank.n_bank = dpiutang.n_bayar', 'left');
		$this->db->where('dpiutang.n_piutang', $n_transaksi);

		$data = $this->db->get();

		return $data;
	}
}
