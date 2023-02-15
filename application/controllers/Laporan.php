<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends BaseController
{

    protected $template = "app";
    protected $module = 'laporan';
    public $loginBehavior = true;

    protected $bread = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_laporan');
        $this->load->model('M_pelanggan');
        $this->load->model('M_pemasok');
        $this->load->model('M_piutang');
        $this->load->model('M_hutang');
        $this->load->model('M_barang');
        $this->load->model('M_kasbank');
        array_push($this->bread, ['title' => 'Laporan', 'url' => site_url('laporan')]);
    }

    public function index()
    {
        $this->data['menu'] = 'm8-0';
        $title = 'Laporan';
        $this->data['judul_title'] = $title;
        $this->render('index');
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

    public function labarugi()
    {
        $tanggal = date('Y-m-d');
        $this->data['tanggal'] = $tanggal;
        array_push($this->bread, ['title' => 'Buku Besar', 'url' => site_url('laporan/bukubesar')]);
        $title = 'Laba Rugi Tahunan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['pendapatan'] = $this->M_laporan->getRulabPend($tanggal);
        $this->data['hpp'] = $this->M_laporan->getRulabHpp($tanggal);
        $this->data['biaya'] = $this->M_laporan->getRulabBiaya($tanggal);
        $this->data['scripts'] = ['laporan/js/labarugi_tahunan.js'];
        $this->render('labarugi');
    }

    public function rugilaba()
    {
        $param = $this->input->post('tgl');
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
