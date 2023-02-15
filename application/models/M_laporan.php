<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends MY_Model
{

	public function getPerusahaan()
	{
		$data = $this->db->get('perusahaan')->row();
		return $data;
	}

	public function listCoa()
	{
		$this->db->where('subgrup <> "" AND detail <> ""');
		$data = $this->db->get('coa')->result_array();
		return $data;
	}

	public function firstCoa()
	{
		$this->db->where('subgrup <> "" AND detail <> ""');
		$data = $this->db->get('coa')->row_array();
		return $data;
	}

	public function getNeracaA($tanggal)
	{
		// $data = $this->db->query("
		// SELECT coa.akun, coa.nama, coa.subgrup, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debeta, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kredita FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,2) = '01')");

		$this->db->select([
			"coa.akun", "coa.nama", "coa.subgrup",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debeta",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kredita"
		]);
		$this->db->where("coa.detail <>", '');
		$this->db->where("(LEFT(coa.akun,1) = '1')");
		// $data = 
		$data = $this->db->get('coa');

		return $data;
	}

	public function getNeracaP($tanggal)
	{

		// $data = $this->db->query("SELECT coa.akun, coa.nama, coa.subgrup, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetp, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditp FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,1) = '2')");

		$this->db->select([
			"coa.akun", "coa.nama", "coa.subgrup",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetp",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditp"
		]);
		$this->db->where("coa.detail <>", '');
		$this->db->where("(LEFT(coa.akun,1) = '2')");
		$data = $this->db->get('coa');
		return $data;
	}

	public function getNeracaM($tanggal)
	{
		$coa_laba = getSystemSetting('coa_laba');
		// $data = $this->db->query("SELECT coa.akun, coa.nama, coa.subgrup, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetm, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditm FROM coa WHERE coa.detail <> '' AND 
		// 	(LEFT(coa.akun,2) = '03') AND coa.akun <> '03.1103'");
		$this->db->select([
			"coa.akun",
			"coa.nama",
			"coa.subgrup",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetm",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditm"
		]);
		$this->db->where("coa.detail <>", '');
		$this->db->where("(LEFT(coa.akun,1) = '3')");
		$this->db->where("coa.akun <> '$coa_laba'");
		$data = $this->db->get('coa');
		return $data;
	}

	public function getRulabPend($tanggal)
	{
		// $data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetp, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditp FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,2) = '04')");
		$this->db->select([
			"coa.akun", "coa.nama",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetp",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditp",
		]);
		$this->db->where("coa.detail <>", '');
		$this->db->where("(LEFT(coa.akun,1) = '4')");
		$data = $this->db->get('coa');
		return $data->result();
	}

	public function getRulabHpp($tanggal)
	{
		$data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetb, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditb FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,1) = '6')");

		return $data->result();
	}

	public function getRulabBiaya($tanggal)
	{
		// $data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetb, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditb FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,2) = '06')");

		$this->db->select([
			"coa.akun", "coa.nama",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_debetb",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND djurnal.tanggal <= '$tanggal'),0) as t_kreditb"
		]);
		$this->db->where("coa.detail <>", '');
		$this->db->where("(LEFT(coa.akun, 1) = '5')");
		$data = $this->db->get('coa');
		return $data->result();
	}

	public function getCoaLaba()
	{
		$coa_laba = getSystemSetting('coa_laba');
		// $this->db->select('*');
		// $this->db->from('coa');
		$this->db->where(["akun" => $coa_laba]);
		$data = $this->db->get("coa");

		return $data;
	}

	public function getBulanrulab()
	{
		$this->db->select("DISTINCT(DATE_FORMAT(hjurnal.tanggal,'%Y-%m')) as bulan_jurnal");
		$this->db->from('hjurnal');
		$this->db->join('djurnal', 'djurnal.n_jurnal = hjurnal.n_jurnal');
		$data = $this->db->get();

		return $data->result();
	}

	public function getRulabPendB($bulan)
	{
		// $data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_debetp, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_kreditp FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,2) = '04')");

		$this->db->select([
			"coa.akun", "coa.nama",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_debetp", "IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_kreditp"
		]);
		$this->db->where("coa.detail <> ''");
		$this->db->where("(LEFT(coa.akun,1) = '4')");
		$data = $this->db->get("coa");

		return $data->result();
	}

	public function getRulabHppB($bulan)
	{
		// $data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_debetb, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_kreditb FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,2) = '05')");

		$this->db->select([
			"coa.akun", "coa.nama",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_debetb",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_kreditb"
		]);
		$this->db->where("coa.detail <> ''");
		$this->db->where("(LEFT(coa.akun, 1) = '05')");
		$data = $this->db->get('coa');
		return $data->result();
	}

	public function getRulabBiayaB($bulan)
	{
		// $data = $this->db->query("SELECT coa.akun, coa.nama, IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_debetb, IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_kreditb FROM coa WHERE coa.detail <> '' AND (LEFT(coa.akun,2) = '06')");

		$this->db->select([
			"coa.akun", "coa.nama",
			"IFNULL((SELECT sum(debet) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_debetb",
			"IFNULL((SELECT sum(kredit) FROM djurnal WHERE djurnal.akun = coa.akun AND MID(djurnal.tanggal,1,7) = '$bulan'),0) as t_kreditb"
		]);
		$this->db->where("coa.detail <> ''");
		$this->db->where("(LEFT(coa.akun, 1) = '5')");
		$data = $this->db->get('coa');

		return $data->result();
	}

	public function getBukubantu($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hjurnal.*, hjurnal.tanggal as tanggal_jurnal, coa.nama as nama_akun, djurnal.akun as akun_jurnal, djurnal.debet as debet_jurnal, djurnal.kredit as kredit_jurnal, hjurnal.keterangan as ket, djurnal.n_jurnal as njurnal');
		$this->db->from('hjurnal');
		$this->db->join('djurnal', 'djurnal.n_jurnal = hjurnal.n_jurnal');
		$this->db->join('coa', 'coa.akun = djurnal.akun');
		$this->db->where('hjurnal.tanggal >=', $tanggal1);
		$this->db->where('hjurnal.tanggal <=', $tanggal2);
		$this->db->order_by('djurnal.akun', 'asc');
		$this->db->order_by('djurnal.tanggal', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getBukubantuP($param)
	{
		$akun = $param['akun_jurnal'];
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hjurnal.*, hjurnal.tanggal as tanggal_jurnal, coa.nama as nama_akun, djurnal.akun as akun_jurnal, djurnal.debet as debet_jurnal, djurnal.kredit as kredit_jurnal, hjurnal.keterangan as ket, djurnal.n_jurnal as njurnal');
		$this->db->from('hjurnal');
		$this->db->join('djurnal', 'djurnal.n_jurnal = hjurnal.n_jurnal');
		$this->db->join('coa', 'coa.akun = djurnal.akun');
		$this->db->where('djurnal.akun', $akun);
		$this->db->where('hjurnal.tanggal >=', $tanggal1);
		$this->db->where('hjurnal.tanggal <=', $tanggal2);
		$this->db->order_by('hjurnal.id', 'asc');
		/*$this->db->group_by('djurnal.akun',$akun);*/
		$data = $this->db->get();

		return $data;
	}

	public function getSaldoAwal($param)
	{
		$akun = $param['akun_jurnal'];
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('djurnal.*, akun as nama_akun');
		$this->db->select_sum('debet');
		$this->db->select_sum('kredit');
		$this->db->from('djurnal');
		$this->db->where('djurnal.akun', $akun);
		$this->db->where('djurnal.tanggal <', $tanggal1);
		/*$this->db->group_by('djurnal.akun',$akun);*/
		$data = $this->db->get();

		return $data;
	}

	public function getPenjualanHarian($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hpenjualan.*, salesman.nama as namasales, pelanggan.nama as namapelanggan, dpenjualan.disc as diskon, dpenjualan.harga as harganya,dpenjualan.harga_asli as hargaasli, dpenjualan.jumlah as jumlahnya, barang.nama as nama_barang, hpenjualan.tanggal as tgl_jual, barang.n_barang as kdbarang, dpenjualan.satuan as satuanbrg');
		$this->db->from('hpenjualan');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = hpenjualan.n_pelanggan');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('dpenjualan', 'dpenjualan.n_penjualan = hpenjualan.n_penjualan');
		$this->db->join('barang', 'barang.n_barang = dpenjualan.n_barang');
		/*$this->db->where('dpenjualan.n_penjualan = hpenjualan.n_penjualan');*/
		$this->db->where('hpenjualan.tanggal >=', $tanggal1);
		$this->db->where('hpenjualan.tanggal <=', $tanggal2);
		$this->db->order_by('n_penjualan', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getPenjualanPelanggan($param)
	{

		$npelanggan = $param['n_pelanggan'];
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hpenjualan.*, salesman.nama as namasales, pelanggan.nama as namapelanggan, dpenjualan.disc as diskon, dpenjualan.harga as harganya,dpenjualan.harga_asli as hargaasli, dpenjualan.jumlah as jumlahnya, barang.nama as nama_barang, hpenjualan.tanggal as tgl_jual, barang.n_barang as kdbarang, dpenjualan.satuan as satuanbrg');
		$this->db->from('hpenjualan');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = hpenjualan.n_pelanggan');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('dpenjualan', 'dpenjualan.n_penjualan = hpenjualan.n_penjualan');
		$this->db->join('barang', 'barang.n_barang = dpenjualan.n_barang');
		/*$this->db->where('dpenjualan.n_penjualan = hpenjualan.n_penjualan');*/
		$this->db->where('hpenjualan.n_pelanggan', $npelanggan);
		$this->db->where('hpenjualan.tanggal >=', $tanggal1);
		$this->db->where('hpenjualan.tanggal <=', $tanggal2);
		$this->db->order_by('n_penjualan', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getPenjualanPerPelanggan($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hpenjualan.*, hpenjualan.n_pelanggan as npelanggan, salesman.nama as namasales, pelanggan.nama as namapelanggan, hpenjualan.tanggal as tgl_jual');
		$this->db->select_sum('total_penjualan');
		$this->db->select_sum('piutang');
		$this->db->select_sum('uang_muka');
		$this->db->select_sum('ppn');
		$this->db->select_sum('biaya_kirim');
		/*$this->db->count_all_results('keluar_masuk');*/
		$this->db->from('hpenjualan');
		/*$this->db->order_by('COUNT(reff)', 'desc');*/
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = hpenjualan.n_pelanggan');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->group_by('hpenjualan.n_pelanggan');
		$this->db->where('hpenjualan.tanggal >=', $tanggal1);
		$this->db->where('hpenjualan.tanggal <=', $tanggal2);
		$data = $this->db->get();

		return $data->result();
	}

	public function getBestbuy($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('keluar_masuk.*, COUNT(reff) as frekuensi, barang.nama as nama_barang, keluar_masuk.harga as hargakm, keluar_masuk.satuan as satuankm');
		$this->db->select_sum('keluar');
		/*$this->db->count_all_results('keluar_masuk');*/
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->group_by('n_barang');
		$this->db->where('masuk = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$data = $this->db->get();

		return $data->result();
	}

	public function getPembelianHarian($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hpembelian.*, pemasok.nama as namapemasok, dpembelian.disc as diskon, dpembelian.harga as harganya,dpembelian.harga_asli as hargaasli, dpembelian.jumlah as jumlahnya, barang.nama as nama_barang, hpembelian.tanggal as tgl_beli, barang.n_barang as kdbarang, dpembelian.satuan as satuanbrg, pemasok.alamat as alamatp');
		$this->db->from('hpembelian');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian.n_pemasok');
		$this->db->join('dpembelian', 'dpembelian.n_pembelian = hpembelian.n_pembelian');
		$this->db->join('barang', 'barang.n_barang = dpembelian.n_barang');
		/*$this->db->where('dpembelian.n_pembelian = hpembelian.n_pembelian');*/
		$this->db->where('hpembelian.tanggal >=', $tanggal1);
		$this->db->where('hpembelian.tanggal <=', $tanggal2);
		$this->db->order_by('n_pembelian', 'asc');
		$data = $this->db->get();

		return $data;
	}
	public function getDaftarBarang($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);
		$this->db->select('keluar_masuk.*, barang.nama as nama,barang.n_unit as n_unit,barang.b_unit as b_unit, barang.konversi_unit as konversi_unit,barang.harga_jual1 as harga_jual1,  tanggal');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->group_by('n_barang');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$this->db->order_by('n_barang', 'asc');
		$data = $this->db->get();


		return $data;
	}
	public function getPerbandinganHarga($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);
		$this->db->select('keluar_masuk.*, barang.stock_gudang as stock_gudang,barang.nama as nama,barang.harga_pokok as harga_pokok,barang.harga_beli as harga_beli,barang.harga_jual1 as harga_jual1,barang.stock_etalase as stock_etalase,tanggal');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->group_by('n_barang');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$this->db->order_by('n_barang', 'asc');
		$data = $this->db->get();


		return $data;
	}
	public function getHarianCosting($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);
		$this->db->select('keluar_masuk.*, barang.nama as nama,barang.harga_pokok as harga_pokok,barang.stock_gudang as stock_gudang,barang.n_unit as n_unit,   tanggal');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->group_by('n_barang');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$this->db->order_by('n_barang', 'asc');
		$data = $this->db->get();


		return $data;
	}
	public function getPersediaanBarang($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);
		$this->db->select('keluar_masuk.*, barang.nama as nama, barang.stock_gudang as stock_gudang,barang.n_unit as n_unit, barang.harga_pokok as harga_pokok,  tanggal');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->group_by('n_barang');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$this->db->order_by('n_barang', 'asc');
		$data = $this->db->get();


		return $data;
	}

	public function getPersediaanBarangGrup($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);
		$this->db->select('keluar_masuk.*, barang_grup.n_grup as n_grup, barang_grup.grup as grup,barang.stock_gudang as stock_gudang,barang.n_unit as n_unit, barang.harga_pokok as harga_pokok,  tanggal');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->join('barang_grup', 'barang_grup.n_grup=barang.n_grup');
		$this->db->group_by('n_grup');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$this->db->order_by('n_grup', 'asc');
		$data = $this->db->get();


		return $data;
	}
	public function getPersediaanBarangDepartement($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);
		$this->db->select('keluar_masuk.*, barang_grup.n_grup as n_grup, barang_grup.departement as departement,barang.stock_gudang as stock_gudang,barang.n_unit as n_unit, barang.harga_pokok as harga_pokok,  tanggal');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->join('barang_grup', 'barang_grup.n_grup=barang.n_grup');
		$this->db->group_by('n_grup');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$this->db->order_by('n_grup', 'asc');
		$data = $this->db->get();


		return $data;
	}
	public function getPembelianPemasok($param)
	{

		$npemasok = $param['n_pemasok'];
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hpembelian.*, pemasok.nama as namapemasok, dpembelian.disc as diskon, dpembelian.harga as harganya,dpembelian.harga_asli as hargaasli, dpembelian.jumlah as jumlahnya, barang.nama as nama_barang, hpembelian.tanggal as tgl_beli, barang.n_barang as kdbarang, dpembelian.satuan as satuanbrg, pemasok.alamat as alamatp');
		$this->db->from('hpembelian');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian.n_pemasok');
		$this->db->join('dpembelian', 'dpembelian.n_pembelian = hpembelian.n_pembelian');
		$this->db->join('barang', 'barang.n_barang = dpembelian.n_barang');
		/*$this->db->where('dpembelian.n_pembelian = hpembelian.n_pembelian');*/
		$this->db->where('hpembelian.n_pemasok', $npemasok);
		$this->db->where('hpembelian.tanggal >=', $tanggal1);
		$this->db->where('hpembelian.tanggal <=', $tanggal2);
		$this->db->order_by('n_pembelian', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getPembelianPerPemasok($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hpembelian.*, hpembelian.n_pemasok as npemasok, pemasok.nama as namapemasok, hpembelian.tanggal as tgl_beli');
		$this->db->select_sum('total_pembelian');
		$this->db->select_sum('hutang');
		$this->db->select_sum('uang_muka');
		$this->db->select_sum('ppn');
		$this->db->select_sum('biaya_kirim');
		$this->db->from('hpembelian');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hpembelian.n_pemasok');
		$this->db->group_by('hpembelian.n_pemasok');
		$this->db->where('hpembelian.tanggal >=', $tanggal1);
		$this->db->where('hpembelian.tanggal <=', $tanggal2);
		$data = $this->db->get();

		return $data->result();
	}

	public function getBarangmasuk($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('keluar_masuk.*, COUNT(reff) as frekuensi, barang.nama as nama_barang, keluar_masuk.harga as hargakm, keluar_masuk.satuan as satuankm');
		$this->db->select_sum('masuk');
		$this->db->like('reff');
		$this->db->from('keluar_masuk');
		$this->db->order_by('COUNT(reff)', 'desc');
		$this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
		$this->db->group_by('n_barang');
		$this->db->where('keluar = "0"');
		$this->db->where('keluar_masuk.tanggal >=', $tanggal1);
		$this->db->where('keluar_masuk.tanggal <=', $tanggal2);
		$data = $this->db->get();

		return $data->result();
	}

	public function getKasmasuk($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.akun as nomor_akun, dkasbank.kredit as kredit_kasbank');
		$this->db->from('hkasbank');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->where('hkasbank.tanggal >=', $tanggal1);
		$this->db->where('hkasbank.tanggal <=', $tanggal2);
		$this->db->where('hkasbank.statusA = "M"');
		$this->db->where('hkasbank.n_bank = "KAS"');
		$this->db->where('dkasbank.kredit > "0"');
		$this->db->order_by('hkasbank.n_kasbank', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getKaskeluar($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.akun as nomor_akun, dkasbank.debet as debet_kasbank');
		$this->db->from('hkasbank');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->where('hkasbank.tanggal >=', $tanggal1);
		$this->db->where('hkasbank.tanggal <=', $tanggal2);
		$this->db->where('hkasbank.statusA = "K"');
		$this->db->where('hkasbank.n_bank = "KAS"');
		$this->db->where('dkasbank.debet > "0"');
		$this->db->order_by('hkasbank.n_kasbank', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getBankmasuk($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.akun as nomor_akun, dkasbank.kredit as kredit_kasbank');
		$this->db->from('hkasbank');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->where('hkasbank.tanggal >=', $tanggal1);
		$this->db->where('hkasbank.tanggal <=', $tanggal2);
		$this->db->where('hkasbank.statusA = "M"');
		$this->db->where('hkasbank.n_bank <> "KAS"');
		$this->db->where('dkasbank.kredit > "0"');
		$this->db->order_by('hkasbank.n_kasbank', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function getBankkeluar($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.akun as nomor_akun, dkasbank.debet as debet_kasbank');
		$this->db->from('hkasbank');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->where('hkasbank.tanggal >=', $tanggal1);
		$this->db->where('hkasbank.tanggal <=', $tanggal2);
		$this->db->where('hkasbank.statusA = "K"');
		$this->db->where('hkasbank.n_bank <> "KAS"');
		$this->db->where('dkasbank.debet > "0"');
		$this->db->order_by('hkasbank.n_kasbank', 'asc');
		$data = $this->db->get();

		return $data;
	}

	public function forKasbank($nkasbank, $param)
	{
		$this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.kredit as total_kredit');
		$this->db->select_sum('dkasbank.kredit');
		$this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
		$this->db->join('coa', 'coa.akun = dkasbank.akun');
		$this->db->where('hkasbank.tanggal >=', $param['tgl_dari']);
		$this->db->where('hkasbank.tanggal <=', $param['tgl_sampai']);
		$this->db->where('hkasbank.statusA = "M"');
		$this->db->where('hkasbank.n_bank = "KAS"');
		$this->db->where('dkasbank.debet >= "0"');
		$this->db->where('hkasbank.n_kasbank', $nkasbank);
		$data = $this->db->get('hkasbank');
		return $data;
	}

	public function getDataPemasok($param)
	{
		$this->db->from('pemasok');
		$this->db->select('pemasok.*, coa.nama as n_akun');
		$this->db->where(['statusA' => '1']);
		$this->db->where('pemasok.tanggal >=', $param);
		$this->db->join('coa', 'coa.akun = pemasok.akun');
		$data = $this->db->get();

		return $data;
	}

	public function getDataHutangGlobal($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->from('hutang');
		$this->db->select('hutang.*, pemasok.nama as nama_pemasok');
		$this->db->select_sum('sisa');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		$this->db->group_by('n_pemasok');
		$this->db->where('hutang.statusA = "b"');
		$this->db->where('hutang.tanggal >=', $tanggal1);
		$this->db->where('hutang.tanggal <=', $tanggal2);
		$data = $this->db->get();
		return $data;
	}

	public function getDataHutangDetail($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->from('hutang');
		$this->db->select('hutang.*, pemasok.nama as nama_pemasok, hutang.tanggal as tanggalp');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		$this->db->where('hutang.statusA = "b"');
		$this->db->where('hutang.tanggal >=', $tanggal1);
		$this->db->where('hutang.tanggal <=', $tanggal2);
		$data = $this->db->get();
		return $data;
	}

	public function getDataPembayaranHutang($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->from('dhutang');
		$this->db->select('dhutang.*');
		// $this->db->join('bank', 'bank.n_bank = dhutang.n_bayar');
		$this->db->where('dhutang.tanggal >=', $tanggal1);
		$this->db->where('dhutang.tanggal <=', $tanggal2);
		$data = $this->db->get();
		return $data;
	}

	public function getBankByPembayaran($param)
	{
		$this->db->from('dhutang');
		$this->db->select('n_bayar, bank.nama as nama_bank');
		$this->db->join('bank', 'bank.n_bank = dhutang.n_bayar');
		$this->db->where('dhutang.n_bayar = ', $param);
		$data = $this->db->get()->row_array();
		return $data;
	}

	public function getDataHutangLunas($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->from('hutang');
		$this->db->select('hutang.*, pemasok.nama as nama_pemasok, hutang.tanggal as tanggalp');
		$this->db->join('pemasok', 'pemasok.n_pemasok = hutang.n_pemasok');
		$this->db->where('hutang.statusA = "s"');
		$this->db->where('hutang.tanggal >=', $tanggal1);
		$this->db->where('hutang.tanggal <=', $tanggal2);
		$data = $this->db->get();
		return $data;
	}

	public function getDataPelanggan($param)
	{
		$this->db->from('pelanggan');
		$this->db->select('pelanggan.*,coa.nama as n_akun, salesman.nama as nama_sales');
		$this->db->join('salesman', 'salesman.n_sales = pelanggan.n_sales');
		$this->db->join('coa', 'coa.akun = pelanggan.akun');
		$this->db->where('pelanggan.tanggal >=', $param);
		$this->db->where(['statusA' => "1"]);
		$data = $this->db->get();

		return $data;
	}

	public function getDataPiutangGlobal($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('piutang.*, pelanggan.nama as nama_pelanggan');
		$this->db->select_sum('sisa');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = piutang.n_pelanggan');
		$this->db->from('piutang');
		$this->db->group_by('n_pelanggan');
		$this->db->where('piutang.statusA = "b"');
		$this->db->where('piutang.tanggal >=', $tanggal1);
		$this->db->where('piutang.tanggal <=', $tanggal2);
		$data = $this->db->get();
		return $data;
	}

	public function getDataPiutangDetail($param)
	{
		$conv_date1 = strtotime($param['tgl_dari']);
		$conv_date2 = strtotime($param['tgl_sampai']);
		$tanggal1 = date('Y-m-d', $conv_date1);
		$tanggal2 = date('Y-m-d', $conv_date2);

		$this->db->select('piutang.*, pelanggan.nama as nama_pelanggan, piutang.tanggal as tanggalp');
		$this->db->from('piutang');
		$this->db->join('pelanggan', 'pelanggan.n_pelanggan = piutang.n_pelanggan');
		$this->db->where('piutang.statusA = "b"');
		$this->db->where('piutang.tanggal >=', $tanggal1);
		$this->db->where('piutang.tanggal <=', $tanggal2);
		$data = $this->db->get();
		return $data;
	}
}
