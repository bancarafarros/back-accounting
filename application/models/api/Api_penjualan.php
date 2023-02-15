<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_penjualan extends CI_Model
{
	public function insertPenjualan($param, $jurnal, $djurnal1, $djurnal2, $djurnal3, $stock_barang)
	{
		$jurnalArray = "";
		$jumlahJurnal = 0;
		$barangArray = "";
		$KeluarMasukArray = "";
		$jumlahBarang = 0;
		$penjualanArray = "";
		$jumlahPenjualan = 0;
		$piutangArray = "";
		$jumlahPiutang = 0;
		$error = null;
		$return['status'] = null;
		$return['message'] = null;

		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$nowTime = date("h:i:s");
		$conv_date1 = strtotime($param['jatuh_tempo']);
		$tanggalTempo = date('Y-m-d', $conv_date1);
		$n_pelanggan = explode(" | ", $param['n_pelanggan']);
		$objectHjurnal = [
			"n_jurnal" => $jurnal['nomor'],
			"tanggal" => $tanggal,
			"reff" => $param['n_transaksi'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['total_all'],
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

		if ($param['jml_bayar'] <> 0) {
			$objectKas = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['debet'],
				"debet" => $param['jml_bayar'],
				"kredit" => 0,
				"status_valid" => "b",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("djurnal", $objectKas);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['debet'] . ',0,' . $param['jml_bayar'] . ",b|";
			$jumlahJurnal += 1;
		}
		if ($param['biaya_ppn'] <> 0) {
			$objectPpn = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['ppn'],
				"debet" => 0,
				"kredit" => $param['biaya_ppn'],
				"status_valid" => "b",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("djurnal", $objectPpn);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['ppn'] . ',' . $param['jml_bayar'] . ',0,b|';
			$jumlahJurnal += 1;
		}
		if ($param['biaya_kirim'] <> 0) {
			$objectBiaya = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['biaya'],
				"debet" => 0,
				"kredit" => $param['biaya_kirim'],
				"status_valid" => "b",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("djurnal", $objectBiaya);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['biaya'] . ',' . $param['biaya_kirim'] . ',0,b|';
			$jumlahJurnal += 1;
		}
		if ($param['total_diskon'] <> 0) {
			$objectDiskon = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['diskon'],
				"debet" => $param['total_diskon'],
				"kredit" => 0,
				"status_valid" => "b",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("djurnal", $objectDiskon);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			// $jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$param['keterangan'].','.$jurnal['biaya'].','.$param['biaya_kirim'].',0,b|';
			// $jumlahJurnal += 1;
		}
		for ($dj1 = 0; $dj1 <= count($djurnal1); $dj1++) {
			if (array_key_exists($dj1, $djurnal1)) {
				$n_kredit1 = explode(",", $djurnal1[$dj1]);
				$objectLop = [
					"n_jurnal" => $jurnal['nomor'],
					"tanggal" => $tanggal,
					"akun" => $n_kredit1[0],
					"debet" => 0,
					"kredit" => $n_kredit1[1],
					"status_valid" => "b",
					"created_by" => getSession('userId'),
				];
				$this->db->insert("djurnal", $objectLop);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $n_kredit1[0] . ',0,' . $n_kredit1[1] . ',b|';
				$jumlahJurnal += 1;
			}
		}

		for ($dj2 = 0; $dj2 <= count($djurnal2); $dj2++) {
			if (array_key_exists($dj2, $djurnal2)) {
				$n_debet2 = explode(",", $djurnal2[$dj2]);
				$objectLop = [
					"n_jurnal" => $jurnal['nomor'],
					"tanggal" => $tanggal,
					"akun" => $n_debet2[0],
					"debet" => $n_debet2[1],
					"kredit" => 0,
					"status_valid" => "b",
					"created_by" => getSession('userId'),
				];
				$this->db->insert("djurnal", $objectLop);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				/*$jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$param['keterangan'].','.$n_debet2[0].','.$n_debet2[1].',0,b|';
				$jumlahJurnal += 1;*/
			}
		}

		for ($dj3 = 0; $dj3 <= count($djurnal3); $dj3++) {
			if (array_key_exists($dj3, $djurnal3)) {
				$n_kredit3 = explode(",", $djurnal3[$dj3]);
				$objectLop = [
					"n_jurnal" => $jurnal['nomor'],
					"tanggal" => $tanggal,
					"akun" => $n_kredit3[0],
					"debet" => 0,
					"kredit" => $n_kredit3[1],
					"status_valid" => "b",
					"created_by" => getSession('userId'),
				];
				$this->db->insert("djurnal", $objectLop);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				/*$jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$param['keterangan'].','.$n_kredit3[0].',0,'.$n_kredit3[1].',b|';
				$jumlahJurnal += 1;*/
			}
		}

		for ($st = 0; $st < count($stock_barang); $st++) {
			if (@$param['n_barang' . $st]) {
				$stock = 0;
				$n_barang = explode(",", $stock_barang[$st]);
				$qtyJual = intval($param['qty_barang' . $st] * $param['conversiUnit' . $st]);
				$qtyStok = intval($n_barang[1]);
				$stock = $qtyStok - $qtyJual;
				$objectBarang = [
					"stock_gudang" => $stock,
					"updated_by" => getSession('userId'),
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
					"n_pelanggan" => $n_pelanggan[0],
					"n_barang" => $param['n_barang' . $st],
					"masuk" => 0,
					"keluar" => $param['qty_barang' . $st],
					"sisa" => $stock,
					"harga" => $param['harga_barang' . $st],
					"satuan" => $param['satuan_barang' . $st],
					"created_by" => getSession('userId'),
				];
				$this->db->insert("keluar_masuk", $objectKeluarMasuk);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				$KeluarMasukArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $n_pelanggan[0] . ',' . $param['n_barang' . $st] . ',0,' . $param['qty_barang' . $st] . ',' . $stock . ',' . $param['harga_barang' . $st] . ',' . $param['satuan_barang' . $st] . '|';
				$barangArray .= $param['n_barang' . $st] . ',' . $param['harga_barang' . $st] . ',' . $qtyStok . '|';
				$jumlahBarang += 1;
			}
		}

		$objHjual = [
			"n_penjualan" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"n_pelanggan" => $n_pelanggan[0],
			"keterangan" => $param['keterangan'],
			"total_penjualan" => $param['totalJualbrg'],
			"uang_muka" => $param['uang_muka'],
			"biaya_kirim" => $param['biaya_kirim'],
			"ppn" => $param['biaya_ppn'],
			"piutang" => $param['sisa_bayar'],
			"cara_bayar" => $param['c_bayar'],
			"n_sales" => $param['n_sales'],
			"created_by" => getSession('userId'),
		];
		$this->db->insert("hpenjualan", $objHjual);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		for ($dbl = 0; $dbl <= $param['sum_barang']; $dbl++) {
			if (@$param['n_barang' . $dbl]) {
				$b_disc = intval(str_replace('%', "", $param['diskon' . $dbl]));
				$objDjual = [
					"n_penjualan" => $param['n_transaksi'],
					"n_barang" => $param['n_barang' . $dbl],
					"jumlah" => $param['qty_barang' . $dbl],
					"harga_asli" => $param['harga_barang' . $dbl],
					"disc" => $b_disc,
					"harga" => $param['harga_diskon' . $dbl],
					"satuan" => $param['satuan_barang' . $dbl],
					"created_by" => getSession('userId'),
				];
				$this->db->insert("dpenjualan", $objDjual);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				/*$penjualanArray .= $param['n_transaksi'].','.$tanggal.','.$param['reff'].','.$n_pelanggan[0].','.$param['keterangan'].','.$param['total_all'].','.$param['uang_muka'].','.$param['biaya_kirim'].','.$param['biaya_ppn'].','.$param['sisa_bayar'].','.$param['c_bayar'].','.$param['n_barang'.$dbl].','.$param['qty_barang'.$dbl].','.$b_disc.','.$param['satuan_barang'.$dbl].'|';
			$jumlahPenjualan += 1;*/
			}
		}
		if ($param['sisa_bayar'] <> 0) {
			$objPiutang = [
				"n_penjualan" => $param['n_transaksi'],
				"tanggal" => $tanggal,
				"reff" => $param['reff'],
				"n_pelanggan" => $n_pelanggan[0],
				"keterangan" => $param['keterangan'],
				"jumlah" => $param['sisa_bayar'],
				"sisa" => $param['sisa_bayar'],
				"tempo" => $tanggalTempo,
				"statusA" => "b",
				"n_sales" => $param['n_sales'],
				"created_by" => getSession('userId'),
			];
			$this->db->insert("piutang", $objPiutang);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			/*$piutangArray .= [$param['n_transaksi'].','.$tanggal,$param['reff'].','.$n_pelanggan[0].','.$param['keterangan'].','.$param['sisa_bayar'].',0,'.$param['jatuh_tempo'].',b,'.$param['n_sales'].'|'];	
			$jumlahPiutang += 1;*/

			$objectPdjurnal = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['a_pelanggan'],
				"debet" => $param['sisa_bayar'],
				"kredit" => 0,
				"status_valid" => "b",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("djurnal", $objectPdjurnal);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			/*$jurnalArray .= $jurnal['nomor'].','.$tanggal.','.$param['keterangan'].','.$jurnal['a_pelanggan'].','.$param['sisa_bayar'].',0,b|';
			$jumlahJurnal += 1;*/
		}

		/*echo "array jurnal = ";
		echo $jurnalArray;
		echo "<br>";
		echo "jumlah jurnal = ";
		echo $jumlahJurnal;
		echo "<br>";
		echo "<br>";
		echo "array keluar masuk = ";
		echo $KeluarMasukArray;
		echo "<br>";
		echo "array barang = ";
		echo $barangArray;
		echo "<br>";
		echo "jumlah barang = ";
		echo $jumlahBarang;
		echo "<br>";
		echo "<br>";
		echo "array pembelian = ";
		print_r($penjualanArray);
		echo "<br>";
		echo "jumlah pembelian = ";
		print_r($jumlahPenjualan);
		echo "<br>";
		echo "<br>";
		echo "array hutang = ";
		print_r($piutangArray);
		echo "<br>";
		echo "jumlah hutang = ";
		print_r($jumlahPiutang);
		echo "<br>";*/

		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return['status'] = true;
			$return['message'] = 'Transaksi penjualan berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi penjualan gagal';
		}
		return $return;
	}
}