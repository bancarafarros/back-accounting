<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembelian extends MY_Model
{
	protected $table = 'hpembelian';
	protected $primary_key = 'n_pembelian';
	protected $order_by = 'tanggal';
	protected $order_by_type = 'DESC';


	public function insertPembelian($param, $jurnal, $djurnal, $stock_barang)
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
		$error = null;
		$return['status'] = null;
		$return['message'] = null;
		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$nowTime = date("h:i:s");
		$conv_date1 = strtotime($param['jatuh_tempo']);
		$tanggalTempo = date('Y-m-d', $conv_date1);
		$n_pemasok = explode(" | ", $param['n_pemasok']);
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

		//djurnal pembelian
		if ($param['jml_bayar'] <> 0) {
			$objectKas = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['kredit'],
				"debet" => 0,
				"kredit" => $param['jml_bayar'],
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
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['kredit'] . ',0,' . $param['jml_bayar'] . ",b|";
			$jumlahJurnal += 1;
		}
		if ($param['biaya_ppn'] <> 0) {
			$objectPpn = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['ppn'],
				"debet" => $param['biaya_ppn'],
				"kredit" => 0,
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
				"debet" => $param['biaya_kirim'],
				"kredit" => 0,
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
				"debet" => 0,
				"kredit" => $param['total_diskon'],
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
		for ($dj = 0; $dj < count($djurnal); $dj++) {
			if (array_key_exists($dj, $djurnal)) {
				$n_kredit = explode(",", $djurnal[$dj]);
				$objectLop = [
					"n_jurnal" => $jurnal['nomor'],
					"tanggal" => $tanggal,
					"akun" => $n_kredit[0],
					"debet" => $n_kredit[1],
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
				$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $n_kredit[0] . ',' . $n_kredit[1] . ',0,b|';
				$jumlahJurnal += 1;
			}
		}


		for ($st = 0; $st < count($stock_barang); $st++) {
			if (@$param['n_barang' . $st]) {
				$stock = 0;
				$n_barang = explode(",", $stock_barang[$st]);
				$qtyBeli = intval($param['qty_barang' . $st] * $param['conversiUnit' . $st]);
				$qtyStok = intval($n_barang[1]);
				$stock = $qtyStok + $qtyBeli;
				$hppBrg = ((($qtyStok + $n_barang[3]) * intval($n_barang[2])) + ($qtyBeli * $param['harga_barang' . $st])) / ($stock + $n_barang[3]);
				// print_r($qtyStok);

				$objectBarang = [
					"stock_gudang" => $stock,
					"harga_pokok" => round($hppBrg, 2),
					"harga_beli" =>	$param['harga_barang' . $st],
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
					"n_pelanggan" => $n_pemasok[0],
					"n_barang" => $param['n_barang' . $st],
					"masuk" =>  $param['qty_barang' . $st],
					"keluar" => 0,
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
				$KeluarMasukArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $n_pemasok[0] . ',' . $param['n_barang' . $st] . ',' . $param['qty_barang' . $st] . ',0,' . $stock . ',' . $param['harga_barang' . $st] . ',' . $param['satuan_barang' . $st] . '|';
				$barangArray .= $param['n_barang' . $st] . ',' . $hppBrg . ',' . $param['harga_barang' . $st] . ',' . $qtyStok . '|';
				$jumlahBarang += 1;
			}
		}

		$objectHbeli = [
			"n_pembelian" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"n_pemasok" => $n_pemasok[0],
			"keterangan" => $param['keterangan'],
			"total_pembelian" => $param['totalBelibrg'],
			"uang_muka" => $param['uang_muka'],
			"biaya_kirim" => $param['biaya_kirim'],
			"ppn" => $param['biaya_ppn'],
			"hutang" => $param['sisa_bayar'],
			"cara_bayar" => $param['c_bayar'],
			"created_by" => getSession('userId'),
		];
		$this->db->insert($this->table, $objectHbeli);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		for ($dbl = 0; $dbl <= $param['sum_barang']; $dbl++) {
			if (@$param['n_barang' . $dbl]) {
				$b_disc = intval(str_replace('%', "", $param['diskon' . $dbl]));
				$objectDbeli = [
					"n_pembelian" => $param['n_transaksi'],
					"n_barang" => $param['n_barang' . $dbl],
					"jumlah" => $param['qty_barang' . $dbl],
					"harga_asli" => $param['harga_barang' . $dbl],
					"disc" => $b_disc,
					"harga" => $param['harga_diskon' . $dbl],
					"satuan" => $param['satuan_barang' . $dbl],
					"created_by" => getSession('userId'),
				];
				$this->db->insert("dpembelian", $objectDbeli);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				$pembelianArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $param['reff'] . ',' . $n_pemasok[0] . ',' . $param['keterangan'] . ',' . $param['total_all'] . ',' . $param['uang_muka'] . ',' . $param['biaya_kirim'] . ',' . $param['biaya_ppn'] . ',' . $param['sisa_bayar'] . ',' . $param['c_bayar'] . ',' . $param['n_barang' . $dbl] . ',' . $param['qty_barang' . $dbl] . ',' . $b_disc . ',' . $param['satuan_barang' . $dbl] . '|';
				$jumlahPembelian += 1;
			}
		}
		if ($param['sisa_bayar'] <> 0) {
			$objectHutang = [
				"n_pembelian" => $param['n_transaksi'],
				"tanggal" => $tanggal,
				"reff" => $param['reff'],
				"n_pemasok" => $n_pemasok[0],
				"keterangan" => $param['keterangan'],
				"jumlah" => $param['sisa_bayar'],
				"sisa" => $param['sisa_bayar'],
				"tempo" => $tanggalTempo,
				"statusA" => "b",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("hutang", $objectHutang);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$hutangArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $param['reff'] . ',' . $n_pemasok[0] . ',' . $param['keterangan'] . ',' . $param['sisa_bayar'] . ',0,' . $tanggalTempo . ',b|';
			$jumlahHutang += 1;
			//djurnal hutang
			$objectHdjurnal = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['a_pemasok'],
				"debet" => 0,
				"kredit" => $param['sisa_bayar'],
				"status_valid" => "a",
				"created_by" => getSession('userId'),
			];
			$this->db->insert("djurnal", $objectHdjurnal);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['a_pemasok'] . ',0,' . $param['sisa_bayar'] . ',b|';
			$jumlahJurnal += 1;
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
			$return['message'] = 'Transaksi pembelian berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi pembelian gagal';
		}
		return $return;
	}

	public function insertReturPembelian($param, $jurnal, $djurnal, $stock_barang)
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
		$userId = getSession('userId');
		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$nowTime = date("h:i:s");
		$n_pemasok = explode(" | ", $param['n_pemasok']);
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

		//djurnal pembelian
		if ($param['jml_bayar'] <> 0) {
			$objectKas = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['kredit'],
				"debet" => $param['jml_bayar'],
				"kredit" => 0,
				"status_valid" => "b",
				"created_by" => $userId,
			];
			$this->db->insert("djurnal", $objectKas);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['kredit'] . ',0,' . $param['jml_bayar'] . ",b|";
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
				"created_by" => $userId,
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
				"created_by" => $userId,
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
				"created_by" => $userId,
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
					"created_by" => $userId,
				];
			};
			$this->db->insert("djurnal", $objectLop);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $n_kredit[0] . ',' . $n_kredit[1] . ',0,b|';
			$jumlahJurnal += 1;
		}

		for ($st = 0; $st < count($stock_barang); $st++) {
			if (@$param['n_barang' . $st]) {
				$stock = 0;
				$n_barang = explode(",", $stock_barang[$st]);
				$qtyBeli = intval($param['qty_barang' . $st] * $param['conversiUnit' . $st]);
				$qtyStok = intval($n_barang[1]);
				$stock = $qtyStok - $qtyBeli;

				// $hppBrg = ((($qtyStok + $n_barang[3]) * intval($n_barang[2])) + ($qtyBeli * $param['harga_barang'.$st])) / ($stock + $n_barang[3]);
				// print_r($qtyStok);

				$objectBarang = [
					"stock_gudang" => $stock,
					"updated_by"	=> $userId,
					// "harga_pokok" => round($hppBrg,2)
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
					"n_pelanggan" => $n_pemasok[0],
					"n_barang" => $param['n_barang' . $st],
					"masuk" => 0,
					"keluar" =>  $param['qty_barang' . $st],
					"sisa" => $stock,
					"harga" => $param['harga_barang' . $st],
					"satuan" => $param['satuan_barang' . $st],
					"created_by" => $userId,
				];
				$this->db->insert("keluar_masuk", $objectKeluarMasuk);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				$KeluarMasukArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $n_pemasok[0] . ',' . $param['n_barang' . $st] . ',' . $param['qty_barang' . $st] . ',0,' . $stock . ',' . $param['harga_barang' . $st] . ',' . $param['satuan_barang' . $st] . '|';
				$barangArray .= $param['n_barang' . $st] . ',' . $param['harga_barang' . $st] . ',' . $qtyStok . '|';
				$jumlahBarang += 1;
			}
		}

		$objectHbeli = [
			"n_rpembelian" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"n_pemasok" => $n_pemasok[0],
			"keterangan" => $param['keterangan'],
			"total_pembelian" =>  $param['totalBelibrg'],
			// "uang_muka" => $param['uang_muka'],
			"biaya_kirim" => $param['biaya_kirim'],
			"ppn" => $param['biaya_ppn'],
			// "hutang" => $param['sisa_bayar'],		
			"cara_bayar" => $param['c_bayar'],
			"created_by" => $userId,
		];
		$this->db->insert("hpembelian_retur", $objectHbeli);
		if ($this->db->error()["code"] != 0) {
			$error[] = [
				'error' => $this->db->error(),
				'query' => $this->db->last_query()
			];
		}

		for ($dbl = 0; $dbl <= $param['sum_barang']; $dbl++) {
			if (@$param['n_barang' . $dbl]) {
				$b_disc = intval(str_replace('%', "", $param['diskon' . $dbl]));
				$objectDbeli = [
					"n_rpembelian" => $param['n_transaksi'],
					"n_barang" => $param['n_barang' . $dbl],
					"jumlah" => $param['qty_barang' . $dbl],
					// "harga_asli" => $param['harga_barang'.$dbl],
					// "disc" => $b_disc,
					"harga" => $param['harga_diskon' . $dbl],
					"satuan" => $param['satuan_barang' . $dbl],
					"created_by" => $userId,
				];
				$this->db->insert("dpembelian_retur", $objectDbeli);
				if ($this->db->error()["code"] != 0) {
					$error[] = [
						'error' => $this->db->error(),
						'query' => $this->db->last_query()
					];
				}
				$pembelianArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $param['reff'] . ',' . $n_pemasok[0] . ',' . $param['keterangan'] . ',' . $param['total_all'] . ',' . $param['uang_muka'] . ',' . $param['biaya_kirim'] . ',' . $param['biaya_ppn'] . ',' . $param['sisa_bayar'] . ',' . $param['c_bayar'] . ',' . $param['n_barang' . $dbl] . ',' . $param['qty_barang' . $dbl] . ',' . $b_disc . ',' . $param['satuan_barang' . $dbl] . '|';
				$jumlahPembelian += 1;
			}
		}
		if ($param['sisa_bayar'] <> 0) {
			// $objectHutang = [
			// 	"n_pembelian" => $param['n_transaksi'],
			// 	"tanggal" => $tanggal,
			// 	"reff" => $param['reff'],
			// 	"n_pemasok" => $n_pemasok[0],
			// 	"keterangan" => $param['keterangan'],
			// 	"jumlah" => $param['sisa_bayar'],
			// 	"sisa" => $param['sisa_bayar'],
			// 	"tempo" => $param['jatuh_tempo'],
			// 	"statusA" => "b",
			// ];
			// $this->db->insert("hutang",$objectHutang);
			// $hutangArray .= $param['n_transaksi'].','.$tanggal.','.$param['reff'].','.$n_pemasok[0].','.$param['keterangan'].','.$param['sisa_bayar'].',0,'.$param['jatuh_tempo'].',b|';	
			// $jumlahHutang += 1;
			//djurnal hutang
			$objectHdjurnal = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['a_pemasok'],
				"debet" => $param['sisa_bayar'],
				"kredit" => 0,
				"status_valid" => "a",
				"created_by"	=> getSession('userId'),
			];
			$this->db->insert("djurnal", $objectHdjurnal);
			if ($this->db->error()["code"] != 0) {
				$error[] = [
					'error' => $this->db->error(),
					'query' => $this->db->last_query()
				];
			}
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['a_pemasok'] . ',0,' . $param['sisa_bayar'] . ',b|';
			$jumlahJurnal += 1;
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
			$return['message'] = 'Transaksi retur pembelian berhasil';
		} else {
			$this->db->trans_rollback();
			$return['status'] = false;
			$return['error'] = $error;
			$return['message'] = 'Transaksi retur pembelian gagal';
		}
		return $return;
	}

	public function insertOrpembelian($param, $jurnal, $djurnal, $stock_barang)
	{
		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$conv_date1 = strtotime($param['tanggal_kirim']);
		$tanggal = date('Y-m-d', $conv_date);
		$tanggalKirim = date('Y-m-d', $conv_date1);
		$datetime1 = new DateTime($tanggal);
		$datetime2 = new DateTime($tanggalKirim);
		$interval = $datetime1->diff($datetime2);
		$objectHjurnal = [
			"n_jurnal" => $jurnal['nomor'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['total_all'],
			"statusA" => "a"
		];
		$this->db->insert("hjurnal", $objectHjurnal);
		if ($param['jml_bayar'] > 0) {
			$objectKas = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['kredit'],
				"debet" => 0,
				"kredit" => $param['jml_bayar'],
				"status_valid" => "a"
			];
			$this->db->insert("djurnal", $objectKas);
		}
		if ($param['biaya_ppn'] > 0) {
			$objectPpn = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['ppn'],
				"debet" => $param['biaya_ppn'],
				"kredit" => 0,
				"status_valid" => "a"
			];
			$this->db->insert("djurnal", $objectPpn);
		}
		if ($param['biaya_kirim'] > 0) {
			$objectBiaya = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['biaya'],
				"debet" => $param['biaya_kirim'],
				"kredit" => 0,
				"status_valid" => "a"
			];
			$this->db->insert("djurnal", $objectBiaya);
		}
		for ($dj = 0; $dj < count($djurnal); $dj++) {
			$n_kredit = explode(",", $djurnal[$dj]);
			$objectLop = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $n_kredit[0],
				"debet" => $n_kredit[1],
				"kredit" => 0,
				"status_valid" => "a"
			];
			$this->db->insert("djurnal", $objectLop);
		}

		$objectHbeli = [
			"n_opembelian" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"n_pemasok" => $param['no_pemasok'],
			"keterangan" => $param['keterangan'],
			"total_pembelian" => $param['total_all'],
			"uang_muka" => $param['uang_muka'],
			"biaya_kirim" => $param['biaya_kirim'],
			"cara_bayar" => $param['c_bayar'],
			"tanggal_kirim" => $tanggalKirim,
			"masa" => $interval->format('%a'),
			"statusA" => "b"
		];
		$this->db->insert("hpembelian_order", $objectHbeli);

		for ($dbl = 0; $dbl <= $param['sum_barang']; $dbl++) {

			// $b_disc = intval(str_replace('%',"",$param['diskon'.$dbl]));
			$objectDbeli = [
				"n_opembelian" => $param['n_transaksi'],
				"n_barang" => $param['n_barang' . $dbl],
				"jumlahOrder" => $param['qty_barang' . $dbl],
				"jumlahTrima" => 0,
				"sisaOrder" =>  $param['qty_barang' . $dbl],
				"harga" => $param['h_diskon' . $dbl],
				"satuan" => $param['satuan_barang' . $dbl]
			];
			$this->db->insert("dpembelian_order", $objectDbeli);
		}
		if ($param['sisa_bayar'] > 0) {
			$objectHutang = [
				"n_pembelian" => $param['n_transaksi'],
				"tanggal" => $tanggal,
				"n_pemasok" => $param['no_pemasok'],
				"keterangan" => $param['keterangan'],
				"jumlah" => $param['sisa_bayar'],
				"sisa" => $param['sisa_bayar'],
				"tempo" => $param['jatuh_tempo'],
				"statusA" => "b",
				"reff" => $param['reff'],
			];
			$this->db->insert("hutang", $objectHutang);
			$objectHdjurnal = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['a_pemasok'],
				"debet" => 0,
				"kredit" => $param['sisa_bayar'],
				"status_valid" => "a"
			];
			$this->db->insert("djurnal", $objectHdjurnal);
		}

		$this->db->trans_complete();
		return $this->db->affected_rows();
	}

	public function getOrderPembelian()
	{
		$this->db->select('hpembelian_order.*,pemasok.nama as namaPemasok');
		$this->db->from('hpembelian_order');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian_order.n_pemasok');
		$data = $this->db->get();

		return $data->result();
	}

	public function getdOrder($kode)
	{
		$this->db->select('dpembelian_order.*,barang.nama as namaBarang, hpembelian_order.total_pembelian as totalOrder');
		$this->db->where("dpembelian_order.n_opembelian", $kode);
		$this->db->from('dpembelian_order');
		$this->db->join('barang', 'barang.n_barang = dpembelian_order.n_barang');
		$this->db->join('hpembelian_order', 'hpembelian_order.n_opembelian = dpembelian_order.n_opembelian');
		$data = $this->db->get();
		// 
		return $data->result();
	}

	public function getDatapemb()
	{
		$this->db->select('hpembelian.*, pemasok.nama as nama_pemasok');
		$this->db->from('hpembelian');
		$this->db->order_by('hpembelian.tanggal', 'DESC');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian.n_pemasok');
		$this->db->where('NOT EXISTS (SELECT hpembelian_retur.reff FROM hpembelian_retur WHERE hpembelian_retur.reff = hpembelian.n_pembelian)', '', FALSE);
		$data = $this->db->get();

		return $data->result();
	}

	public function getdPemb($kode)
	{
		$this->db->select('dpembelian.*,barang.nama as namaBarang, barang.konversi_unit as conv_unit,barang.akun_persediaan as akun,hpembelian.total_pembelian as totalPemb, barang.b_unit as bigUnit');
		$this->db->where("dpembelian.n_pembelian", $kode);
		$this->db->from('dpembelian');
		$this->db->join('barang', 'barang.n_barang = dpembelian.n_barang');
		$this->db->join('hpembelian', 'hpembelian.n_pembelian = dpembelian.n_pembelian');
		$data = $this->db->get();
		// 
		return $data->result();
	}

	public function get_cetak_nota($n_transaksi)
	{

		$this->db->select('hpembelian.*, pemasok.nama as namapemasok, dpembelian.harga_asli as harganya, dpembelian.harga as hargad, dpembelian.jumlah as jumlahnya, barang.nama as nama_barang, dpembelian.satuan as sat, dpembelian.disc as diskon, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('hpembelian');
		$this->db->from('perusahaan');
		$this->db->join('dpembelian', 'dpembelian.n_pembelian = hpembelian.n_pembelian');
		$this->db->join('barang', 'barang.n_barang = dpembelian.n_barang');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian.n_pemasok');
		$this->db->where('hpembelian.n_pembelian', $n_transaksi);

		$data = $this->db->get();

		return $data;
	}

	public function get_cetak_notaR($n_transaksi)
	{

		$this->db->select('hpembelian_retur.*, pemasok.nama as namapemasok, dpembelian_retur.harga as harganya, dpembelian_retur.harga as hargad, dpembelian_retur.jumlah as jumlahnya, barang.nama as nama_barang, dpembelian_retur.satuan as sat, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('hpembelian_retur');
		$this->db->from('perusahaan');
		$this->db->join('dpembelian_retur', 'dpembelian_retur.n_rpembelian = hpembelian_retur.n_rpembelian');
		$this->db->join('barang', 'barang.n_barang = dpembelian_retur.n_barang');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian_retur.n_pemasok');
		$this->db->where('hpembelian_retur.n_rpembelian', $n_transaksi);

		$data = $this->db->get();

		return $data;
	}
}
