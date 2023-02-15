<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persediaan extends BaseController
{

    protected $template = "app";
    protected $module = 'laporan';
    protected $sub = 'report';
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
        array_push($this->bread, ['title' => 'Laporan', 'url' => site_url('laporan')]);
        array_push($this->bread, ['title' => 'Persediaan', 'url' => site_url('report/persediaan')]);
    }

    public function index()
    {
        $title = 'Persediaan';
        $this->data['judul_title'] = $title;
        $this->data['perkiraan'] = $this->M_jurnal->ambilCoa();
        $this->data['bulan_rulab'] = $this->M_laporan->getBulanrulab();
        $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
        $this->data['d_pemasok'] = $this->M_pemasok->getData();
        $this->data['datatranskas'] = $this->M_kasbank->getTransKas();
        $this->data['datatransbank'] = $this->M_kasbank->getTransBank();
        $this->render('index');
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

    public function daftarbarang()
    {
        $x['perusahaan'] = $this->M_laporan->getPerusahaan();
        $x['data'] = $this->M_barang->getData();
        $this->load->view('laporan/lap_daftar_barang', $x);
    }
    public function daftar_barang()
    {

        $tanggal = date('Y-m-d');
        $title = 'Daftar Barang';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $this->data['scripts'] = ['report/persediaan/js/daftarbarang.js'];
        $this->render('daftarbarang');
    }
    function daftar_barang_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getDaftarBarang($x)->result_array();

        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['konversi_unit'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harga_jual1'];
                $tgl = strtotime($d['tanggal']);
                $tanggal = date('d-M-Y', $tgl);

                if ($group == '-' || $group != $d['n_barang']) {
                    $nbarang = $d['n_barang'];
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="4" style="text-align:left;">:<b>' . $nbarang  . '</td><td style="text-align:right;"><b>Tanggal</b></td><td style="text-align:left;">:<b> ' . $tanggal . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="45%" align="center">Nama Barang</td>
                    <td width="3%" align="center">Normal Unit</td>
                    <td width="5%" align="center">Big Unit</td>
                    <td width="13%" align="center">Konversi Unit</td>
                    <td width="12%" align="center">Harga Jual</td>
                    
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_barang'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['n_barang'] . '</td>
                <td style="text-align:left;" style="">' . $d['nama'] . '</td>
                <td style="text-align:center;" style="">' . $d['n_unit'] . '</td>
                <td style="text-align:center;" style="">' . $d['b_unit'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $harga . '</td>
                
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
    public function pdf_daftarbarang()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getDaftarBarang($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'laporan Daftar Barang';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'daftarbarang-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/persediaan/daftarbarang_pdf', $filename, $x, $download);
    }

    public function persediaan_barang()
    {
        // $x['perusahaan'] = $this->M_laporan->getPerusahaan();
        // $x['data'] = $this->M_barang->getData();
        // $this->load->view('laporan/lap_persediaan_barang', $x);
        $tanggal = date('Y-m-d');
        $title = 'Persediaan Barang';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $this->data['scripts'] = ['report/persediaan/js/persediaanbarang.js'];
        $this->render('persediaanbarang');
    }

    public function persediaan_barang_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPersediaanBarang($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harga_pokok'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harga_pokok'] * $d['stock_gudang'];
                $tgl = strtotime($d['tanggal']);
                $tanggal = date('d-M-Y', $tgl);

                if ($group == '-' || $group != $d['n_barang']) {
                    $nbarang = $d['n_barang'];
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="4" style="text-align:left;">:<b>' . $nbarang  . '</td><td style="text-align:right;"><b>Tanggal</b></td><td style="text-align:left;">:<b> ' . $tanggal . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="45%" align="center">Nama Barang</td>
                    <td width="3%" align="center">Jumlah</td>
                    <td width="5%" align="center">Satuan</td>
                    <td width="13%" align="center">Harga Pokok</td>
                    <td width="12%" align="center">Total</td>
                    
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_barang'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['n_barang'] . '</td>
                <td style="text-align:left;" style="">' . $d['nama'] . '</td>
                <td style="text-align:center;" style="">' . $d['stock_gudang'] . '</td>
                <td style="text-align:center;" style="">' . $d['n_unit'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $harga . '</td>
                
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
    public function pdf_persediaanbarang()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPersediaanBarang($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'laporan Persediaan Barang';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'persediaanbarang-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/persediaan/persediaanbarang_pdf', $filename, $x, $download);
    }

    public function perbandingan_harga()
    {
        $tanggal = date('Y-m-d');
        $title = 'Perbandingan Harga';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $this->data['scripts'] = ['report/persediaan/js/perbandinganharga.js'];
        $this->render('perbandinganharga');
    }
    public function perbandingan_harga_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPerbandinganHarga($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harga_pokok'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['stock_gudang'] + $d['stock_etalase'];
                $margin = ($d['harga_jual1'] - $d['harga_pokok']) / ($d['harga_pokok']) * 100;
                $jumlah = ($d['stock_gudang'] + $d['stock_etalase']);
                $tgl = strtotime($d['tanggal']);
                $tanggal = date('d-M-Y', $tgl);
                if ($group == '-' || $group != $d['n_barang']) {
                    $nbarang = $d['n_barang'];
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="4" style="text-align:left;">:<b>' . $nbarang  . '</td><td td colspan="1"style="text-align:right;"><b>Tanggal</b></td><td td colspan="2"style="text-align:left;">:<b> ' . $tanggal . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="38%" align="center">Nama Barang</td>
                    <td width="12%" align="center">Harga Pokok</td>
                    <td width="12%" align="center">Harga Beli</td>
                    <td width="12%" align="center">Harga Jual</td>
                    <td width="11%" align="center">Margin</td>
                    <td width="13%" align="center">Qty</td>
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_barang'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['n_barang'] . '</td>
                <td style="text-align:left;" style="">' . $d['nama'] . '</td>
                <td style="text-align:center;" style="">Rp' . $harga . '</td>
                <td style="text-align:center;" style="">Rp' . $d['harga_beli'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $d['harga_jual1'] . '</td>
                
                <td style="text-align:right;" style="">' . number_format((float)$margin, 0, '.', '') . "%" . '</td>
                <td style="text-align:left;" style="">' . $jumlah . '</td>
                
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
    public function persediaan_barang_grup()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Persediaan Barang Per Grup';
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/persediaan/js/persediaanbaranggrup.js'];
        $this->render('persediaanbaranggrup');
    }
    public function persediaan_barang_grup_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPersediaanBarangGrup($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harga_pokok'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harga_pokok'] * $d['stock_gudang'];


                if ($group == '-' || $group != $d['n_grup']) {
                    $nbarang = $d['n_grup'];
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="4" style="text-align:left;">:<b>' . $nbarang  . '</td><td style="text-align:right;"><b>Total</b></td><td style="text-align:right;"><b>Rp ' . $subtotal . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="45%" align="center">Nama Barang</td>
                    <td width="3%" align="center">Jumlah</td>
                    <td width="5%" align="center">Satuan</td>
                    <td width="13%" align="center">HPP</td>
                    <td width="12%" align="center">Total</td>
                    
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_grup'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['n_grup'] . '</td>
                <td style="text-align:left;" style="">' . $d['grup'] . '</td>
                <td style="text-align:center;" style="">' . $d['stock_gudang'] . '</td>
                <td style="text-align:center;" style="">' . $d['n_unit'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $harga . '</td>
                
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
    public function pdf_perbandinganharga()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPerbandinganHarga($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Perbandingan Harga';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'perbandinganharga-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/persediaan/perbandinganharga_pdf', $filename, $x, $download);
    }
    public function pdf_persediaanbaranggrup()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPersediaanBarangGrup($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Persediaan Barang Per Grup';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'persediaanbaranggrup-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/persediaan/persediaanbaranggrup_pdf', $filename, $x, $download);
    }
    public function persediaan_barang_departement()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Persediaan Barang Per Departement';
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/persediaan/js/persediaanbarangdepartement.js'];
        $this->render('persediaanbarangdepartement');
    }
    public function persediaan_barang_departement_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPersediaanBarangDepartement($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harga_pokok'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harga_pokok'] * $d['stock_gudang'];


                if ($group == '-' || $group != $d['n_grup']) {
                    $nbarang = $d['n_grup'];
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="4" style="text-align:left;">:<b>' . $nbarang  . '</td><td style="text-align:right;"><b>Total</b></td><td style="text-align:right;"><b>Rp ' . $subtotal . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="45%" align="center">Nama Barang</td>
                    <td width="3%" align="center">Jumlah</td>
                    <td width="5%" align="center">Satuan</td>
                    <td width="13%" align="center">HPP</td>
                    <td width="12%" align="center">Total</td>
                    
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_grup'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['n_grup'] . '</td>
                <td style="text-align:left;" style="">' . $d['departement'] . '</td>
                <td style="text-align:center;" style="">' . $d['stock_gudang'] . '</td>
                <td style="text-align:center;" style="">' . $d['n_unit'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $harga . '</td>
                
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
    public function pdf_persediaanbarangdepartement()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPersediaanBarangDepartement($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Persediaan Barang Per Departement';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'persediaanbarangdepartement-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/persediaan/persediaanbarangdepartement_pdf', $filename, $x, $download);
    }
    public function harian_costing()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Harian Costing';
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/persediaan/js/hariancosting.js'];
        $this->render('hariancosting');
    }
    public function harian_costing_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getHarianCosting($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harga_pokok'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harga_pokok'] * $d['stock_gudang'];


                if ($group == '-' || $group != $d['n_barang']) {
                    $nbarang = $d['n_barang'];
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="4" style="text-align:left;">:<b>' . $nbarang  . '</td><td style="text-align:right;"><b>Total</b></td><td style="text-align:right;"><b>Rp ' . $subtotal . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="45%" align="center">Nama Barang</td>
                    <td width="3%" align="center">QTY</td>
                    <td width="5%" align="center">Satuan</td>
                    <td width="13%" align="center">Harga</td>
                    <td width="12%" align="center">Total</td>
                    
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_barang'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['n_barang'] . '</td>
                <td style="text-align:left;" style="">' . $d['nama'] . '</td>
                <td style="text-align:center;" style="">' . $d['stock_gudang'] . '</td>
                <td style="text-align:center;" style="">' . $d['n_unit'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $harga . '</td>
                
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
    public function pdf_hariancosting()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getHarianCosting($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Harian Costing';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'hariancosting-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/persediaan/hariancosting_pdf', $filename, $x, $download);
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
