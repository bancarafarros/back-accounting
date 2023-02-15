<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporank extends BaseController
{

	protected $template = "app";
	protected $module = 'laporan';
	public $loginBehavior = true;

	protected $bread = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_laporan');
		$this->load->model('M_jurnal');
		$this->load->model('M_pelanggan');
		$this->load->model('M_pemasok');
		$this->load->model('M_piutang');
		$this->load->model('M_hutang');
		$this->load->model('M_barang');
		$this->load->model('M_kasbank');
		array_push($this->bread, ['title' => 'Laporan']);
	}

	public function index()
	{
		$this->data['menu'] = 'm8-0';
		$title = 'Laporan';
		$this->data['judul_title'] = $title;

		$this->data['perkiraan'] = $this->M_jurnal->ambilCoa();
		$this->data['bulan_rulab'] = $this->M_laporan->getBulanrulab();
		$this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_pemasok'] = $this->M_pemasok->getData();
		$this->data['datatranskas'] = $this->M_kasbank->getTransKas();
		$this->data['datatransbank'] = $this->M_kasbank->getTransBank();

		$this->render('indexs');
	}

	public function neraca()
	{
		$tanggal = date('Y-m-d');
		$title = 'Neraca';
		$this->data['judul_title'] = $title;
		array_push($this->bread, ['title' => $title]);
		$this->data['tanggal'] = $tanggal;
		$this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
		$this->data['scripts'] = ['laporan/js/neraca.js'];

		$this->render('neraca');
	}

	public function neracadata()
	{
		$tanggal = $this->input->post('tanggal');
		$data['tanggal'] = $tanggal;
		$data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);

		$aktiva = $this->aktiva_data($tanggal);
		$data['aktiva'] = $aktiva['aktiva'];
		$data['aktivas'] = $aktiva['aktivas'];
		$data['ttlaktiva'] = currencyIDR($aktiva['ttlaktiva']);

		$pasiva_h = $this->pasivah_data($tanggal);
		$data['pasiva_h'] = $pasiva_h['pasiva_h'];
		$data['pasivas_h'] = $pasiva_h['pasivas_h'];
		$data['ttlpasivah'] = number_format($pasiva_h['ttlpasivah'], 2, ",", ".");


		$pasiva_m = $this->pasivam_data($tanggal);
		$data['pasiva_m'] = $pasiva_m['pasiva_m'];
		$data['pasivas_m'] = $pasiva_m['pasivas_m'];
		$data['ttlpasivam'] = $pasiva_m['ttlpasivam'];

		$data['pendapatan'] = $this->pendapatan_data($tanggal);
		$data['hpp'] = $this->hpp_data($tanggal);
		$data['biaya'] = $this->biaya_data($tanggal);
		$data['coa_laba'] = $this->coa_laba_data($tanggal);
		$data['coa_laba']['nominal'] = currencyIDR($data['pendapatan'] - $data['hpp'] - $data['biaya']);
		// <?= currencyIDR(($ttlpend - $ttlhpp - $ttlbiaya)); 

		$data['total_kewajiban'] = currencyIDR(($data['pendapatan'] - $data['hpp'] - $data['biaya']));
		$data['total_pasiva']  = currencyIDR(($pasiva_h['ttlpasivah'] + $data['ttlpasivam'] + ($data['pendapatan'] - $data['hpp'] - $data['biaya'])));
		echo json_encode($data);
	}

	private function aktiva_data($tanggal)
	{
		$data = $this->M_laporan->getNeracaA($tanggal);
		$return['aktiva'] = $data->row_array();
		$aktivas = $data->result_array();
		$return['aktivas'] = null;
		$ttlaktiva = 0;
		foreach ($aktivas as $value) {
			$debet = number_format($value['t_debeta']);
			$kredit = number_format($value['t_kredita']);
			$total = $value['t_debeta'] - $value['t_kredita'];

			$nilai = ($total >= 0 ? currencyIDR($total) : '(' . currencyIDR($total * -1) . ')');
			$ttlaktiva += $value['t_debeta'] - $value['t_kredita'];

			$return['aktivas'] .= '
			<table style="width:100%;"><tr>
            <td style="text-align:left;width:10%;"></td>
            <td style="text-align:left;width:40%;">' . $value['nama'] . '</td>
            <td style="text-align:right;width:50%;">' . $nilai . '</td>
            </tr></table>';
		}
		$return['ttlaktiva'] = $ttlaktiva;
		return $return;
	}

	private function pasivah_data($tanggal)
	{
		$data = $this->M_laporan->getNeracaP($tanggal);
		$return['pasiva_h'] = $data->row_array();
		$pasivas_h = $data->result_array();
		$return['pasivas_h'] = null;
		$ttlpasivah = 0;
		foreach ($pasivas_h as $value) {
			$debet = number_format($value['t_debetp']);
			$kredit = number_format($value['t_kreditp']);

			$total = $value['t_kreditp'] - $value['t_debetp'];

			$nilai = ($total >= 0 ? currencyIDR($total) : '(' . currencyIDR($total * -1) . ')');
			$ttlpasivah += ($value['t_kreditp']) - ($value['t_debetp']);
			$return['pasivas_h'] .= '<table style="width:100%;"><tr>
            <td style="text-align:left;width:10%;"></td>
            <td style="text-align:left;width:40%;">' . $value['nama'] . '</td>
            <td style="text-align:right;width:50%;">' . $nilai . '</td>
            </tr></table>';
		}
		$return['ttlpasivah'] = $ttlpasivah;
		return $return;
	}

	private function pasivam_data($tanggal)
	{

		$data = $this->M_laporan->getNeracaM($tanggal);
		$return['pasiva_m'] = $data->row_array();
		$pasivas_m = $data->result_array();
		$return['pasivas_m'] = null;
		$ttlpasivam = 0;
		foreach ($pasivas_m as $value) {
			$debet = number_format($value['t_debetm']);
			$kredit = number_format($value['t_kreditm']);

			$total = $value['t_kreditm'] - $value['t_debetm'];

			$nilai = ($total >= 0 ? currencyIDR($total) : '(' . currencyIDR($total * -1) . ')');
			$ttlpasivam += ($value['t_kreditm']) - ($value['t_debetm']);

			$return['pasivas_m'] .= '<table style="width:100%;"><tr>
            <td style="text-align:left;width:10%;"></td>
            <td style="text-align:left;width:40%;">' . $value['nama'] . '</td>
            <td style="text-align:right;width:50%;">' . $nilai . '</td>
            </tr></table>';
		}
		$return['ttlpasivam'] = $ttlpasivam;
		return $return;
	}

	private function pendapatan_data($tanggal)
	{

		$data = $this->M_laporan->getRulabPend($tanggal);
		$ttlpend = 0;
		foreach ($data as $key => $p) {
			$nilai =  ($p->t_kreditp) - ($p->t_debetp);
			$ttlpend += ($p->t_kreditp) - ($p->t_debetp);
		}
		return $ttlpend;
	}

	private function hpp_data($tanggal)
	{

		$hpp = $this->M_laporan->getRulabHpp($tanggal);
		$ttlhpp = 0;
		foreach ($hpp as $key => $b) {
			$nilai = ($b->t_debetb) - ($b->t_kreditb);
			$ttlhpp += ($b->t_debetb) - ($b->t_kreditb);
		}
		return $ttlhpp;
	}

	private function biaya_data($tanggal)
	{

		$biaya = $this->M_laporan->getRulabBiaya($tanggal);
		$ttlbiaya = 0;
		foreach ($biaya as $key => $b) {

			$nilai = ($b->t_debetb) - ($b->t_kreditb);
			$ttlbiaya += ($b->t_debetb) - ($b->t_kreditb);
		}
		return $ttlbiaya;
	}

	private function coa_laba_data($tanggal)
	{
		$coa_laba = $this->M_laporan->getCoaLaba($tanggal)->row_array();
		return $coa_laba;
	}

	public function pdfneraca()
	{
		$param = $this->input->post();
		$this->load->library('dom_pdf');
		$perusahaan = $this->M_laporan->getPerusahaan();

		$x['data']['n_perusahaan'] = $perusahaan->nama;
		$x['data']['a_perusahaan'] = $perusahaan->alamat;
		$x['data']['telp_perusahaan'] = $perusahaan->telepon;

		$aktiva = $this->M_laporan->getNeracaA($param);
		$x['aktiva'] = $aktiva->row_array();
		$x['aktivas'] = $aktiva->result_array();

		$pasiva_h = $this->M_laporan->getNeracaP($param);
		$x['pasiva_h'] = $pasiva_h->row_array();
		$x['pasiva_hs'] = $pasiva_h->result_array();

		$pasiva_m = $this->M_laporan->getNeracaM($param);
		$x['pasiva_m'] = $pasiva_m->row_array();
		$x['pasiva_ms'] = $pasiva_m->result_array();

		$x['pendapatan'] = $this->M_laporan->getRulabPend($param);
		$x['hpp'] = $this->M_laporan->getRulabHpp($param);
		$x['biaya'] = $this->M_laporan->getRulabBiaya($param);

		$coa_laba = $this->M_laporan->getCoaLaba($param);
		$x['coa_laba'] = $coa_laba->row_array();
		$x['coa_labas'] = $coa_laba->result_array();

		$x['judul_title'] = 'Neraca';
		$x['waktu_cetak'] = date('Y-m-d H:i:s');

		$filename = 'neraca-' . date('Y-m-d His');
		$download = false;
		$this->dom_pdf->load_view('laporan/lap_neraca', $filename, $x, $download);
	}

	public function rugilaba()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['pendapatan'] = $this->M_laporan->getRulabPend($param);
		$x['hpp'] = $this->M_laporan->getRulabHpp($param);
		$x['biaya'] = $this->M_laporan->getRulabBiaya($param);
		$this->load->view('laporan/lap_rugilaba', $x);
	}

	public function rugilaba_bulanan()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['pendapatan'] = $this->M_laporan->getRulabPendB($param);
		$x['hpp'] = $this->M_laporan->getRulabHppB($param);
		$x['biaya'] = $this->M_laporan->getRulabBiayaB($param);
		$this->load->view('laporan/lap_rugilaba_bulanan', $x);
	}

	public function bukubantu()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getBukubantu($param);
		$this->load->view('laporan/lap_bukubantu', $x);
	}

	public function bukubantuP()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getBukubantuP($param);
		$x['saldoawal'] = $this->M_laporan->getSaldoAwal($param);
		$this->load->view('laporan/lap_bukubantu_perkiraan', $x);
	}

	public function penjualan_harian()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getPenjualanHarian($param);
		$this->load->view('laporan/lap_penjualan_harian', $x);
	}

	public function penjualan_perpelanggan()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getPenjualanPerPelanggan($param);
		$this->load->view('laporan/lap_penjualan_perpelanggan', $x);
	}

	public function penjualan_pelanggan()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getPenjualanPelanggan($param);
		$this->load->view('laporan/lap_penjualan_pelanggan', $x);
	}

	public function bestbuy()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getBestbuy($param);
		$this->load->view('laporan/lap_bestbuy', $x);
	}

	public function pembelian_harian()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getPembelianHarian($param);
		$this->load->view('laporan/lap_pembelian_harian', $x);
	}

	public function pembelian_pemasok()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getPembelianPemasok($param);
		$this->load->view('laporan/lap_pembelian_pemasok', $x);
	}

	public function pembelian_perpemasok()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getPembelianPerPemasok($param);
		$this->load->view('laporan/lap_pembelian_perpemasok', $x);
	}

	public function barangmasuk()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getBarangmasuk($param);
		$this->load->view('laporan/lap_barangmasuk', $x);
	}

	public function daftar_pelanggan()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_pelanggan->getData();
		$this->load->view('laporan/lap_daftar_pelanggan', $x);
	}

	public function piutang_global()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_piutang->getDataPiutangGlobal();
		$this->load->view('laporan/lap_piutang_global', $x);
	}

	public function piutang_detail()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_piutang->getDataPiutangDetail();
		$this->load->view('laporan/lap_piutang_detail', $x);
	}


	public function daftar_pemasok()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_pemasok->getData();
		$this->load->view('laporan/lap_daftar_pemasok', $x);
	}

	public function hutang_global()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_hutang->getDataHutangGlobal();
		$this->load->view('laporan/lap_hutang_global', $x);
	}

	public function hutang_detail()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_hutang->getDataHutangDetail();
		$this->load->view('laporan/lap_hutang_detail', $x);
	}

	public function daftar_barang()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_barang->getData();
		$this->load->view('laporan/lap_daftar_barang', $x);
	}

	public function persediaan_barang()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_barang->getData();
		$this->load->view('laporan/lap_persediaan_barang', $x);
	}

	public function perbandingan_harga()
	{
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_barang->getData();
		$this->load->view('laporan/lap_perbandingan_harga', $x);
	}

	public function kasmasuk()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getKasmasuk($param);
		$this->load->view('laporan/lap_kasmasuk', $x);
	}
	public function kaskeluar()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getKaskeluar($param);
		$this->load->view('laporan/lap_kaskeluar', $x);
	}
	public function bankmasuk()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getBankmasuk($param);
		$this->load->view('laporan/lap_bankmasuk', $x);
	}
	public function bankkeluar()
	{
		$param = $this->input->post();
		$x['perusahaan'] = $this->M_laporan->getPerusahaan();
		$x['data'] = $this->M_laporan->getBankkeluar($param);
		$this->load->view('laporan/lap_bankkeluar', $x);
	}
}
