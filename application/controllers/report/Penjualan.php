<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends BaseController
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
        array_push($this->bread, ['title' => 'Penjualan', 'url' => site_url('report/penjualan')]);
    }

    public function index()
    {
        $title = 'Penjualan';
        $this->data['judul_title'] = $title;
        $this->render('index');
    }

    public function harian()
    {
        $title = 'Laporan Penjualan Harian';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => 'Harian', 'url' => site_url('report/penjualan/harian')]);
        $tanggal = date('Y-m-d');
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/penjualan/js/penjualan_harian.js'];
        $this->render('penjualan_harian');
    }

    public function penjualanHarian_data()
    {
        $param = $this->input->post();
        $dataTable = '<div class="table-responsive"><table border="1" align="center" style="width:900px;margin-bottom:20px;">';
        $urut = 0;
        $nomor = 0;
        $grandtotal = 0;
        $group = '-';
        $result = $this->M_laporan->getPenjualanHarian($param)->result_array();
        if (empty($result)) {
            $dataTable = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harganya'], 2, ",", ".");
                $hargaasli = $d['hargaasli'];
                $total = $d['total_penjualan'];
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harganya'] * $d['jumlahnya'];
                $pelanggan = $d['namapelanggan'];
                $sales = $d['namasales'];
                $bayar = $d['cara_bayar'];
                $tanggal_jual = $this->tanggalindo->konversi($d['tgl_jual']);

                if ($group == '-' || $group != $d['n_penjualan']) {
                    $npenjualan = $d['n_penjualan'];

                    if ($group != '-') {
                        $dataTable .= '</table><br>';
                    }
                    $dataTable .= '<table align="center" width="900px;" border="1">';
                    $dataTable .= '<tr><td><b>Nomor</b></td><td colspan="5" style="text-align:left;">: ' . '<b>' . $npenjualan . '</b></td><td style="text-align:right;"><b>Tanggal</b></td><td style="text-align:left;"> : ' . $tanggal_jual . '</td></tr>';
                    $dataTable .= '<tr>
                    <td><b>Pelanggan</b></td> <td colspan="5" style="text-align:left;">: ' . $pelanggan . '</td>
                    <td style="text-align:right;"><b>Cara Bayar</b>
                    </td><td style="text-align:left;">: ' . $bayar . '</td></tr>';
                    $dataTable .= '<tr><td><b>Sales</b></td> <td colspan="5" style="text-align:left;">: ' . $sales . '</td><td style="text-align:right;"><b>Total</b></td><td style="text-align:right;"><b>' . currencyIDR($total) . '</b></td></tr>';
                    $dataTable .= '<tr class="bg-success text-light">';
                    $dataTable .= '<td width="3%" align="center">No</td>';
                    $dataTable .= '<td width="10%" align="center">Kode Barang</td>';
                    $dataTable .= '<td width="40%" align="center">Nama Barang</td>';
                    $dataTable .= '<td width="5%" align="center">Qty</td>';
                    $dataTable .= '<td width="5%" align="center">Satuan</td>';
                    $dataTable .= '<td width="12%" align="center">Harga Jual</td>';
                    $dataTable .= '<td width="10%" align="center">Diskon</td>';
                    $dataTable .= '<td width="12%" align="center">Subtotal</td>';

                    $dataTable .= '</tr>';
                    $nomor = 1;
                }
                $group = $d['n_penjualan'];
                if ($urut == 500) {
                    $nomor = 0;
                    $dataTable .= '<div class="pagebreak"></div>';
                }
                $dataTable .= '<tr><td style="text-align:center;">' . $nomor . '</td>
                        <td style="text-align:left;">' . $d['kdbarang'] . '</td>
                        <td style="text-align:left;">' . $d['nama_barang'] . '</td>
                        <td style="text-align:center;">' . $d['jumlahnya'] . '</td>
                        <td style="text-align:center;">' . $d['satuanbrg'] . '</td>
                        <td style="text-align:right;">' . currencyIDR($hargaasli) . '</td>
                        <td style="text-align:center;">' . $d['diskon'] . '%</td>
                        <td style="text-align:right;">' . currencyIDR($subtotal) . '</td>
                    </tr>';
            }
        }
        $dataTable .= '</table></div>';
        $return['data'] = $dataTable;
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        echo json_encode($return);
    }

    public function pdf_penjualanHarian()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPenjualanHarian($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Penjualan Harian';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'penjualanharian-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/penjualan/penjualan_harian_pdf', $filename, $x, $download);
    }

    public function penjualan_perpelanggan()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Penjualan Per Pelanggan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/penjualan/js/penjualan_perpelanggan.js'];
        $this->render('penjualan_perpelanggan');
    }

    public function penjualan_perpelanggan_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPenjualanPerPelanggan($x);
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">
            <thead>
                <tr style="background-color:#ccc;">
                    <th style="text-align:left;">No.</th>
                    <th style="text-align:center;">Kode</th>
                    <th style="text-align:center;">Nama</th>
                    <th style="text-align:center;">Penjualan</th>
                    <th style="text-align:center;">PPN</th>
                    <th style="text-align:center;">Biaya Kirim</th>
                    <th style="text-align:center;">Total</th>
                    <th style="text-align:center;">Bayar</th>
                    <th style="text-align:center;">Piutang</th>
                </tr>
            </thead>';
            $no = 0;
            $total = 0;
            $bayar = 0;
            $totalpenjualan = 0;
            $totalppn = 0;
            $totalbiaya = 0;
            $totaltotal = 0;
            $totalbayar = 0;
            $totalpiutang = 0;
            foreach ($result as $key => $value) {
                $no++;
                $total = $value->total_penjualan + $value->ppn + $value->biaya_kirim;
                $bayar = $value->total_penjualan - $value->piutang;
                $totalpenjualan += $value->total_penjualan;
                $totalppn += $value->ppn;
                $totalbiaya += $value->biaya_kirim;
                $totaltotal += $total;
                $totalbayar += $bayar;
                $totalpiutang += $value->piutang;
                $return['data'] .= '
                <tbody>
                <tr>
                <td style="text-align:left;">' . $no . '</td>
                <td style="text-align:left;">' . $value->npelanggan . '</td>
                <td style="text-align:left;">' . $value->namapelanggan . '</td>
                <td style="text-align:right;">' . number_format($value->total_penjualan) . '</td>
                <td style="text-align:right;">' . number_format($value->ppn) . '</td>
                <td style="text-align:right;">' . number_format($value->biaya_kirim) . '</td>
                <td style="text-align:right;">' . number_format($total) . '</td>
                <td style="text-align:right;">' . number_format($bayar) . '</td>
                <td style="text-align:right;">' . number_format($value->piutang) . '</td>
                </tr>
                </tbody>';
            }
            $return['data'] .= '
            <tfoot>
            <tr>
            <td colspan="3" style="text-align:right;"><b>Grand Total</b></td>
            <td style="text-align:right;"><b>' . number_format($totalpenjualan) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalppn) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalbiaya) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totaltotal) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalbayar) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalpiutang) . '</b></td>
            </tr>
            </tfoot>';
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function penjualan_perpelanggan_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPenjualanPerPelanggan($param);
        $x['result'] = $result;

        $x['judul_title'] = 'Laporan Penjualan Per Pelanggan';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'penjualanperpelanggan-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/penjualan/penjualan_perpelanggan_pdf', $filename, $x, $download);
    }

    public function penjualan_pelanggan()
    {
        $this->data['n_pelanggan'] = $this->M_pelanggan->getFirstData();
        $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Penjualan Per Pelanggan Dengan Detail';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/penjualan/js/penjualan_pelanggan.js'];
        $this->render('penjualan_pelanggan');
    }

    public function penjualan_pelanggan_data()
    {
        $param = $this->input->post();
        $x['n_pelanggan'] = $param['n_pelanggan'];
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPenjualanPelanggan($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['n_pelanggan'] = $this->M_pelanggan->getDetail($x['n_pelanggan'])->nama;
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $harga = number_format($d['harganya'], 2, ",", ".");
                $hargaasli = number_format($d['hargaasli'], 2, ",", ".");
                $total = number_format($d['total_penjualan'], 2, ",", ".");
                $subtotal = $d['harganya'] * $d['jumlahnya'];
                $pelanggan = $d['namapelanggan'];
                $sales = $d['namasales'];
                $tgl = strtotime($d['tgl_jual']);
                $tanggal_jual = date('d-M-Y', $tgl);

                if ($group == '-' || $group != $d['n_penjualan']) {
                    $npenjualan = $d['n_penjualan'];
                    $return['data'] .= '
                    </table><br>
                    <table align="center" width="900px;" border="1">
                    <tr><td colspan="8" style="text-align:center;"><b>No."' . $npenjualan . '"</b></td></tr>
                    <tr><td><b>Tanggal</b></td> <td colspan="5" style="text-align:left;">:' . $tanggal_jual . '</td><td style="text-align:right;"><b>Total:</b></td><td style="text-align:right;"><b>Rp ' . $total . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                     <td width="10%" align="center">Kode Barang</td>
                     <td width="46%" align="center">Nama Barang</td>
                     <td width="3%" align="center">Qty</td>
                     <td width="5%" align="center">Satuan</td>
                     <td width="13%" align="center">Harga Jual</td>
                     <td width="8%" align="center">Diskon</td>
                     <td width="12%" align="center">Subtotal</td>
                     </tr>';
                    $nomor = 1;
                }
                $group = $d['n_penjualan'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $nomor . '</td>
                <td style="text-align:left;" style="">' . $d['kdbarang'] . '</td>
                <td style="text-align:left;" style="">' . $d['nama_barang'] . '</td>
                <td style="text-align:center;" style="">' . $d['jumlahnya'] . '</td>
                <td style="text-align:center;" style="">' . $d['satuanbrg'] . '</td>
                <td style="text-align:right;" style="">Rp ' . $hargaasli . '</td>
                <td style="text-align:center;" style="">' . $d['diskon'] . ' %</td>
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
            </tr>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function penjualan_pelanggan_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['n_pelanggan'] = $this->input->get('npelanggan');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPenjualanPelanggan($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Penjualan Per Pelanggan Dengan Detail';
        $x['n_pelanggan'] = $this->M_pelanggan->getDetail($param['n_pelanggan']);
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'penjualperpelanggan(detail)-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/penjualan/penjualan_pelanggan_pdf', $filename, $x, $download);
    }

    public function bestbuy()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Best Buy';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/penjualan/js/bestbuy.js'];
        $this->render('bestbuy');
    }

    public function bestbuy_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getBestbuy($x);
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
            $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">
            <thead>
                <tr style="background-color:#ccc;">
                    <th style="text-align:center;">Frekuensi</th>
                    <th style="text-align:left;">Kode Barang</th>
                    <th style="text-align:left;">Nama Barang</th>
                    <th style="text-align:center;">Jual</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Total Nilai</th>
                </tr>
            </thead>';
            $total = 0;
            $grandtotal = 0;
            foreach ($result as $key => $value) {
                $total = $value->keluar * $value->hargakm;
                $grandtotal += $total;
                $return['data'] .= '
                <tbody>
                <tr>
                <td style="text-align:center;"><b>' . $value->frekuensi . 'X</b></td>
                <td style="text-align:left;">' . $value->n_barang . '</td>
                <td style="text-align:left;">' . $value->nama_barang . '</td>
                <td style="text-align:center;">' . $value->keluar . '</td>
                <td style="text-align:center;">' . $value->satuankm . '</td>
                <td style="text-align:right;">Rp ' . number_format($total) . '</td>
                </tr>
                </tbody>';
            }
            $return['data'] .= '
            <tfoot>
            <tr>
            <td colspan="5" style="text-align:right;"><b>Grand Total :</b></td> 
            <td style="text-align:right;"><b>Rp ' . number_format($grandtotal) . '</b></td> 
            </tr>
            </tfoot>';
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function bestbuy_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getBestbuy($param);
        $x['result'] = $result;

        $x['judul_title'] = 'Laporan Best Buy';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'bestbuy-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/penjualan/bestbuy_pdf', $filename, $x, $download);
    }
    // public function penjualan_perpelanggan()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getPenjualanPerPelanggan($param);
    //     $this->load->view('laporan/lap_penjualan_perpelanggan', $x);
    // }

    // public function penjualan_pelanggan()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getPenjualanPelanggan($param);
    //     $this->load->view('laporan/lap_penjualan_pelanggan', $x);
    // }

    // public function bestbuy()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getBestbuy($param);
    //     $this->load->view('laporan/lap_bestbuy', $x);
    // }
}
