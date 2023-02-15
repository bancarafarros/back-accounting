<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends MY_Model
{

	public function getData()
	{
		$this->db->select('pelanggan.*,coa.nama as n_akun, salesman.nama as nama_sales');
		$this->db->from('pelanggan');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('coa', 'coa.akun = pelanggan.akun');
		$this->db->where('statusA = "a"');
		$data = $this->db->get();
		var_dump($data);
		return $data->result();
	}

	public function getDatapenj()
	{
		$this->db->select('hpenjualan.*, barang.harga_pokok as hargapokok, pelanggan.nama as nama_pelanggan, salesman.nama as nama_sales, salesman.n_sales as n_sales');
		$this->db->from('hpenjualan');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = hpenjualan.n_pelanggan');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('dpenjualan', 'dpenjualan.n_penjualan = hpenjualan.n_penjualan');
		$this->db->join('barang', 'barang.n_barang = dpenjualan.n_barang');
		$this->db->where('NOT EXISTS (SELECT hpenjualan_retur.reff FROM hpenjualan_retur WHERE hpenjualan_retur.reff = hpenjualan.n_penjualan)', '', FALSE);
		$data = $this->db->get();

		return $data->result();
	}

	public function getDatapenjNow()
	{
		$now = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('hpenjualan');
		$this->db->where('tanggal', $now);
		$data = $this->db->get();
		return $data->result();
	}

	public function get_d_penjualan($penjualan)
	{
		$this->db->select('*,(SELECT n_penjualan FROM hpenjualan WHERE hpenjualan.n_penjualan = dpenjualan.n_penjualan) as penjualan, (SELECT nama FROM barang WHERE barang.n_barang = dpenjualan.n_barang) as nama_barang, (Select harga*jumlah) as total_barang');
		$this->db->where("n_penjualan", $penjualan);
		$this->db->from('dpenjualan');
		$data = $this->db->get();
		return $data->result();
	}

	public function dataSales()
	{

		$this->db->select('*');
		$this->db->from('salesman');
		$data = $this->db->get();

		return $data->result();
	}

	public function get_cetak_nota($n_transaksi)
	{

		$this->db->select('hpenjualan.*, pelanggan.nama as namapelanggan, salesman.nama as namasales, dpenjualan.harga_asli as harganya, dpenjualan.harga as hargad, dpenjualan.jumlah as jumlahnya, barang.nama as nama_barang, dpenjualan.satuan as sat, dpenjualan.disc as diskon, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('hpenjualan');
		$this->db->from('perusahaan');
		$this->db->join('dpenjualan', 'dpenjualan.n_penjualan = hpenjualan.n_penjualan');
		$this->db->join('barang', 'barang.n_barang = dpenjualan.n_barang');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = hpenjualan.n_pelanggan');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->where('hpenjualan.n_penjualan', $n_transaksi);
		$data = $this->db->get();

		return $data;
	}

	public function get_cetak_notaR($n_transaksi)
	{

		$this->db->select('hpenjualan_retur.*, pelanggan.nama as namapelanggan, dpenjualan_retur.harga as harganya, dpenjualan_retur.harga as hargad, dpenjualan_retur.jumlah as jumlahnya, barang.nama as nama_barang, dpenjualan_retur.satuan as sat, perusahaan.nama as n_perusahaan, perusahaan.alamat as a_perusahaan, perusahaan.telepon as telp_perusahaan');
		$this->db->from('hpenjualan_retur');
		$this->db->from('perusahaan');
		$this->db->join('dpenjualan_retur', 'dpenjualan_retur.n_rpenjualan = hpenjualan_retur.n_rpenjualan');
		$this->db->join('barang', 'barang.n_barang = dpenjualan_retur.n_barang');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = hpenjualan_retur.n_pelanggan');
		$this->db->where('hpenjualan_retur.n_rpenjualan', $n_transaksi);

		$data = $this->db->get();

		return $data;
	}

	public function ambilCoa($grup)
	{
		$this->db->select('*');
		$this->db->where("grup", $grup);
		$this->db->from('coa');
		$data = $this->db->get();

		return $data->result();
	}

	public function getDetail($nama)
	{
		$this->db->where("n_pelanggan", $nama);
		$data = $this->db->get("pelanggan")->result();
		return $data[0];
	}

	public function getdPenj($kode)
	{
		$this->db->select('dpenjualan.*,barang.nama as namaBarang, barang.konversi_unit as conv_unit,barang.akun_persediaan as akunpsd,barang.akun_hpp as akunhpp, barang.akun_pendapatan as akunpdpt, barang.harga_pokok as hargapokok, hpenjualan.total_penjualan as totalPenj');
		$this->db->where("dpenjualan.n_penjualan", $kode);
		$this->db->from('dpenjualan');
		$this->db->join('barang', 'barang.n_barang = dpenjualan.n_barang');
		$this->db->join('hpenjualan', 'hpenjualan.n_penjualan = dpenjualan.n_penjualan');
		$data = $this->db->get();
		// 
		return $data->result();
	}

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

	public function returPenjualan($param, $jurnal, $djurnal1, $djurnal2, $djurnal3, $stock_barang)
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

		$this->db->trans_start();
		$conv_date = strtotime($param['tanggal']);
		$tanggal = date('Y-m-d', $conv_date);
		$n_pelanggan = explode(" | ", $param['n_pelanggan']);
		$objectHjurnal = [
			"n_jurnal" => $jurnal['nomor'],
			"tanggal" => $tanggal,
			"reff" => $param['n_transaksi'],
			"keterangan" => $param['keterangan'],
			"jumlah" => $param['total_all'],
			"statusA" => substr($param['n_transaksi'], 0, 2)
		];
		$this->db->insert("hjurnal", $objectHjurnal);

		if ($param['jml_bayar'] <> 0) {
			$objectKas = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['kredit'],
				"debet" => 0,
				"kredit" => $param['jml_bayar'],
				"status_valid" => "b"
			];
			$this->db->insert("djurnal", $objectKas);
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
				"status_valid" => "b"
			];
			$this->db->insert("djurnal", $objectPpn);
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
				"status_valid" => "b"
			];
			$this->db->insert("djurnal", $objectBiaya);
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
				"status_valid" => "b"
			];
			$this->db->insert("djurnal", $objectDiskon);
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
					"debet" => $n_kredit1[1],
					"kredit" => 0,
					"status_valid" => "b"
				];
				$this->db->insert("djurnal", $objectLop);
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
					"debet" => 0,
					"kredit" => $n_debet2[1],
					"status_valid" => "b"
				];
				$this->db->insert("djurnal", $objectLop);
				$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $n_debet2[0] . ',' . $n_debet2[1] . ',0,b|';
				$jumlahJurnal += 1;
			}
		}

		for ($dj3 = 0; $dj3 <= count($djurnal3); $dj3++) {
			if (array_key_exists($dj3, $djurnal3)) {
				$n_kredit3 = explode(",", $djurnal3[$dj3]);
				$objectLop = [
					"n_jurnal" => $jurnal['nomor'],
					"tanggal" => $tanggal,
					"akun" => $n_kredit3[0],
					"debet" => $n_kredit3[1],
					"kredit" => 0,
					"status_valid" => "b"
				];
				$this->db->insert("djurnal", $objectLop);
				$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $n_kredit3[0] . ',0,' . $n_kredit3[1] . ',b|';
				$jumlahJurnal += 1;
			}
		}

		for ($st = 0; $st < count($stock_barang); $st++) {
			if (@$param['n_barang' . $st]) {
				$stock = 0;
				$n_barang = explode(",", $stock_barang[$st]);
				$qtyJual = intval($param['qty_barang' . $st] * $param['conversiUnit' . $st]);
				$qtyStok = intval($n_barang[1]);
				$stock = $qtyStok + $qtyJual;
				$objectBarang = [
					"stock_gudang" => $stock
				];
				$this->db->where("n_barang", $n_barang[0]);
				$this->db->update("barang", $objectBarang);

				$objectKeluarMasuk = [
					"reff" => $param['n_transaksi'],
					"tanggal" => $tanggal,
					"n_pelanggan" => $n_pelanggan[0],
					"n_barang" => $param['n_barang' . $st],
					"masuk" =>  $param['qty_barang' . $st],
					"keluar" => 0,
					"sisa" => $stock,
					"harga" => $param['harga_barang' . $st],
					"satuan" => $param['satuan_barang' . $st]
				];
				$this->db->insert("keluar_masuk", $objectKeluarMasuk);
				$KeluarMasukArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $n_pelanggan[0] . ',' . $param['n_barang' . $st] . ',0,' . $param['qty_barang' . $st] . ',' . $stock . ',' . $param['harga_barang' . $st] . ',' . $param['satuan_barang' . $st] . '|';
				$barangArray .= $param['n_barang' . $st] . ',' . $param['harga_barang' . $st] . ',' . $qtyStok . '|';
				$jumlahBarang += 1;
			}
		}

		$objHjual = [
			"n_rpenjualan" => $param['n_transaksi'],
			"tanggal" => $tanggal,
			"reff" => $param['reff'],
			"n_pelanggan" => $n_pelanggan[0],
			"keterangan" => $param['keterangan'],
			"total_penjualan" => $param['totalJualbrg'],
			"biaya_kirim" => $param['biaya_kirim'],
			"ppn" => $param['biaya_ppn'],
			"cara_bayar" => $param['c_bayar']
		];
		$this->db->insert("hpenjualan_retur", $objHjual);

		for ($dbl = 0; $dbl <= $param['sum_barang']; $dbl++) {
			if (@$param['n_barang' . $dbl]) {
				$b_disc = intval(str_replace('%', "", $param['diskon' . $dbl]));
				$objDjual = [
					"n_rpenjualan" => $param['n_transaksi'],
					"n_barang" => $param['n_barang' . $dbl],
					"jumlah" => $param['qty_barang' . $dbl],
					"harga" => $param['harga_diskon' . $dbl],
					"satuan" => $param['satuan_barang' . $dbl]
				];
				$this->db->insert("dpenjualan_retur", $objDjual);
				$penjualanArray .= $param['n_transaksi'] . ',' . $tanggal . ',' . $param['reff'] . ',' . $n_pelanggan[0] . ',' . $param['keterangan'] . ',' . $param['total_all'] . ',' . $param['uang_muka'] . ',' . $param['biaya_kirim'] . ',' . $param['biaya_ppn'] . ',' . $param['sisa_bayar'] . ',' . $param['c_bayar'] . ',' . $param['n_barang' . $dbl] . ',' . $param['qty_barang' . $dbl] . ',' . $b_disc . ',' . $param['satuan_barang' . $dbl] . '|';
				$jumlahPenjualan += 1;
			}
		}
		if ($param['sisa_bayar'] <> 0) {
			/*$objPiutang = [
				"n_penjualan" => $param['n_transaksi'],
				"tanggal" => $tanggal,
				"reff" => $param['reff'],
				"n_pelanggan" => $n_pelanggan[0],
				"keterangan" => $param['keterangan'],
				"jumlah" => $param['sisa_bayar'],
				"sisa" => $param['sisa_bayar'],
				"tempo" => $tanggalTempo,
				"statusA" => "b",
				"n_sales" => $param['n_sales']
			];
			$this->db->insert("piutang",$objPiutang);
			$piutangArray .= [$param['n_transaksi'].','.$tanggal,$param['reff'].','.$n_pelanggan[0].','.$param['keterangan'].','.$param['sisa_bayar'].',0,'.$param['jatuh_tempo'].',b,'.$param['n_sales'].'|'];	
			$jumlahPiutang += 1;*/

			$objectPdjurnal = [
				"n_jurnal" => $jurnal['nomor'],
				"tanggal" => $tanggal,
				"akun" => $jurnal['a_pelanggan'],
				"debet" => $param['sisa_bayar'],
				"kredit" => 0,
				"status_valid" => "b"
			];
			$this->db->insert("djurnal", $objectPdjurnal);
			$jurnalArray .= $jurnal['nomor'] . ',' . $tanggal . ',' . $param['keterangan'] . ',' . $jurnal['a_pelanggan'] . ',' . $param['sisa_bayar'] . ',0,b|';
			$jumlahJurnal += 1;
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
		return $this->db->affected_rows();
	}
}
