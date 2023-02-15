<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_costing extends CI_Model
{
	protected $table = 'hcosting';
	protected $primary_key = 'n_costing';
	protected $order_by = 'tanggal';
	protected $order_by_type = 'DESC';

	public function insertCosting($param, $jurnal, $djurnal, $stock_barang)
	{
		$jurnalArray = "";
		$jumlahJurnal = 0;
		$barangArray = "";
		$KeluarMasukArray = "";
		$jumlahBarang = 0;
		$pembelianArray = "";
		$jumlahPembelian = 0;
		$hutangArray = "";
		$jumlahHutang = 0;
		//HJurnal
		$return['status'] = null;
		$return['message'] = null;
		$error = null;
		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$nowTime = date("h:i:s");

		$objectHjurnal = [
			"n_jurnal" => $jurnal['nomor'],
			"tanggal" => $tanggal,
			"reff" => $param['n_transaksi'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['totalCosting'],
			"statusA" => substr($param['n_transaksi'], 0, 2),
			"created_by" => getSession('userId'),
		];
		$this->db->insert("hjurnal", $objectHjurnal);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		$objectBiaya = [
			"n_jurnal" => $jurnal['nomor'],
			"tanggal" => $tanggal,
			"akun" => $param['akun'],
			"debet" => $param['totalCosting'],
			"kredit" => 0,
			"status_valid" => "b",
			"created_by" => getSession('userId'),
		];
		$this->db->insert("djurnal", $objectBiaya);
		// $jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$param['keterangan'].','.$jurnal['biaya'].','.$param['biaya_kirim'].',0,b|';
		// $jumlahJurnal += 1;
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		for ($dj = 0; $dj < count($djurnal); $dj++) {
			if (array_key_exists($dj, $djurnal)) {
				$n_kredit = explode(",", $djurnal[$dj]);
				$objectLop = [
					"n_jurnal" => $jurnal['nomor'],
					"tanggal" => $tanggal,
					"akun" => $n_kredit[0],
					"debet" => 0,
					"kredit" => $n_kredit[1],
					"status_valid" => "b",
					"created_by" => getSession('userId'),
				];
				$this->db->insert("djurnal", $objectLop);
				// $jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$param['keterangan'].','.$n_kredit[0].','.$n_kredit[1].',0,b|';
				// $jumlahJurnal += 1;
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
			}
		}

		for ($st = 0; $st < count($stock_barang); $st++) {
			if (@$param['n_barang' . $st]) {
				$stock = 0;
				$n_barang = explode(",", $stock_barang[$st]);
				$qtyCosting = intval($param['qty_barang' . $st] * $param['conversiUnit' . $st]);
				$qtyStok = intval($n_barang[1]);
				$stock = $qtyStok - $qtyCosting;

				$objectBarang = [
					"stock_gudang" => $stock,
					"updated_by" => getSession('userId')
				];
				$this->db->where("n_barang", $n_barang[0]);
				$this->db->update("barang", $objectBarang);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}

				$objectKeluarMasuk = [
					"reff" => $param['n_transaksi'],
					"tanggal" => $tanggal,
					"waktu" => $nowTime,
					"n_pelanggan" => $param['namaakun'],
					"n_barang" => $param['n_barang' . $st],
					"masuk" => 0,
					"keluar" => $param['qty_barang' . $st],
					"sisa" => $stock,
					"harga" => $param['harga_barang' . $st],
					"satuan" => $param['satuan_barang' . $st],
					"created_by" => getSession('userId'),
				];
				$this->db->insert("keluar_masuk", $objectKeluarMasuk);
				// $KeluarMasukArray .= $param['n_transaksi'].','.$tanggal.','.$n_pemasok[0].','.$param['n_barang'.$st].','.$param['qty_barang'.$st].',0,'.$stock.','.$param['harga_barang'.$st].','.$param['satuan_barang'.$st].'|';
				// $barangArray .= $param['n_barang'.$st].','.$hppBrg.','.$param['harga_barang'.$st].','.$qtyStok.'|';
				// $jumlahBarang += 1;
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
			}
		}

		$objectHcosting = [
			"n_costing" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"keterangan" => $param['keterangan'],
			"reff" => $param['reff'],
			"akun" => $param['akun'],
			"total" => $param['totalCosting'],
			"created_by" => getSession('userId'),
		];
		$this->db->insert($this->table, $objectHcosting);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		for ($dbl = 0; $dbl <= $param['sum_barang']; $dbl++) {
			if (@$param['n_barang' . $dbl]) {
				$objectDbeli = [
					"n_costing" => $param['n_transaksi'],
					"n_barang" => $param['n_barang' . $dbl],
					"jumlah" => $param['qty_barang' . $dbl],
					"harga" => $param['harga_barang' . $dbl],
					"satuan" => $param['satuan_barang' . $dbl],
					"created_by" => getSession('userId'),
				];
				$this->db->insert("dcosting", $objectDbeli);
				// $pembelianArray .= $param['n_transaksi'].','.$tanggal.','.$param['reff'].','.$n_pemasok[0].','.$param['keterangan'].','.$param['total_all'].','.$param['uang_muka'].','.$param['biaya_kirim'].','.$param['biaya_ppn'].','.$param['sisa_bayar'].','.$param['c_bayar'].','.$param['n_barang'.$dbl].','.$param['qty_barang'.$dbl].','.$b_disc.','.$param['satuan_barang'.$dbl].'|';
				// $jumlahPembelian += 1;
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
			}
		}
		// echo "array jurnal = ";
		// echo $jurnalArray;
		// echo "<br>";
		// echo "jumlah jurnal = ";
		// echo $jumlahJurnal;
		// echo "<br>";
		// echo "<br>";
		// echo "array keluar masuk = ";
		// echo $KeluarMasukArray;
		// echo "<br>";
		// echo "array barang = ";
		// echo $barangArray;
		// echo "<br>";
		// echo "jumlah barang = ";
		// echo $jumlahBarang;
		// echo "<br>";
		// echo "<br>";
		// echo "array pembelian = ";
		// print_r($pembelianArray);
		// echo "<br>";
		// echo "jumlah pembelian = ";
		// print_r($jumlahPembelian);
		// echo "<br>";
		// echo "<br>";
		// echo "array hutang = ";
		// print_r($hutangArray);
		// echo "<br>";
		// echo "jumlah hutang = ";
		// print_r($jumlahHutang);
		// echo "<br>";

		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Transaksi costing berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi costing gagal';
		}
		return $return;
	}

	public function get_cetak_nota($n_transaksi)
	{
		$this->db->select('hcosting.*, coa.nama as namaAkun, dcosting.harga as harganya, dcosting.jumlah as jumlahnya, barang.nama as nama_barang, dcosting.satuan as sat, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('perusahaan');
		$this->db->join('dcosting', 'dcosting.n_costing = hcosting.n_costing');
		$this->db->join('barang', 'barang.n_barang = dcosting.n_barang');
		$this->db->join('coa', 'coa.akun = hcosting.akun');
		$this->db->where('hcosting.n_costing', $n_transaksi);

		$data = $this->db->get($this->table);

		return $data;
	}
}
