<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends BaseController
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
        array_push($this->bread, ['title' => 'Pembelian', 'url' => site_url('report/pembelian')]);
    }

    public function index()
    {
        $title = 'Pembelian';
        $this->data['judul_title'] = $title;
        $this->data['perkiraan'] = $this->M_jurnal->ambilCoa();
        $this->data['bulan_rulab'] = $this->M_laporan->getBulanrulab();
        $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
        $this->data['d_pemasok'] = $this->M_pemasok->getData();
        $this->data['datatranskas'] = $this->M_kasbank->getTransKas();
        $this->data['datatransbank'] = $this->M_kasbank->getTransBank();
        $this->render('index');
    }

    // public function pembelian_harian()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getPembelianHarian($param);
    //     $this->load->view('laporan/lap_pembelian_harian', $x);
    // }

    public function pembelian_harian()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Pembelian Harian';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pembelian/js/lap_pembelian_harian.js'];
        $this->render('lap_pembelian_harian');
    }

    public function pembelian_harian_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPembelianHarian($x)->result_array();
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
                $harga = number_format($d['harganya'], 2, ",", ".");
                $hargaasli = number_format($d['hargaasli'], 2, ",", ".");
                $total = number_format($d['total_pembelian'], 2, ",", ".");
                /*$grandtotal += $d['total_penjualan'];*/
                $subtotal = $d['harganya'] * $d['jumlahnya'];
                $pemasok = $d['namapemasok'];
                $alamat = $d['alamatp'];
                $bayar = $d['cara_bayar'];
                $tgl = strtotime($d['tgl_beli']);
                $tanggal_beli = date('d-M-Y', $tgl);

                if ($group == '-' || $group != $d['n_pembelian']) {
                    $npembelian = $d['n_pembelian'];
                    if ($group != '-') {
                        $return['data'] .= '</table><br>';
                    }
                    $return['data'] .= '
                    <table align="center" width="900px;" border="1"><tr><td><b>Nota</b></td><td colspan="5" style="text-align:left;">:<b>' . $npembelian . '</b></td><td style="text-align:right;"><b>Tanggal</b></td><td style="text-align:left;">: ' . $tanggal_beli . '</td></tr><tr><td><b>Pemasok</b></td> <td colspan="5" style="text-align:left;">:' . $pemasok . '</td><td style="text-align:right;"><b>Cara Bayar</b></td><td style="text-align:left;">:' . $bayar . '</td></tr><tr><td><b>Alamat</b></td> <td colspan="5" style="text-align:left;">:' . $alamat . '</td><td style="text-align:right;"><b>Total</b></td><td style="text-align:right;"><b>Rp ' . $total . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                    <td width="11%" align="center">Kode Barang</td>
                    <td width="45%" align="center">Nama Barang</td>
                    <td width="3%" align="center">Qty</td>
                    <td width="5%" align="center">Satuan</td>
                    <td width="13%" align="center">Harga Jual</td>
                    <td width="10%" align="center">Diskon</td>
                    <td width="12%" align="center">Subtotal</td>
                    
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['n_pembelian'];
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
                <td style="text-align:center;" style="">' . $d['diskon'] . '%</td>
                <td style="text-align:right;" style="">Rp ' . number_format($subtotal, 2, ",", ".") . '</td>
                </tr>';
            }
            $return['data'] .= '</table></div>';
        }
        echo json_encode($return);
    }

    public function pembelian_harian_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPembelianHarian($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Pembelian Harian';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'pembelian-harian-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/pembelian/lap_pembelian_harian_pdf', $filename, $x, $download);
    }

    // public function pembelian_perpemasok()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getPembelianPerPemasok($param);
    //     $this->load->view('laporan/lap_pembelian_perpemasok', $x);
    // }

    public function pembelian_perpemasok()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Pembelian Per Pemasok';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pembelian/js/lap_pembelian_perpemasok.js'];
        $this->render('lap_pembelian_perpemasok');
    }

    public function pembelian_perpemasok_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPembelianPerPemasok($x);
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
                    <th style="text-align:center;">Pembelian</th>
                    <th style="text-align:center;">PPN</th>
                    <th style="text-align:center;">Biaya Kirim</th>
                    <th style="text-align:center;">Total</th>
                    <th style="text-align:center;">Bayar</th>
                    <th style="text-align:center;">Hutang</th>
                </tr>
            </thead>';
            $no = 0;
            $total = 0;
            $bayar = 0;
            $totalpembelian = 0;
            $totalppn = 0;
            $totalbiaya = 0;
            $totaltotal = 0;
            $totalbayar = 0;
            $totalhutang = 0;
            foreach ($result as $key => $value) {
                $no++;
                $total = $value->total_pembelian + $value->ppn + $value->biaya_kirim;
                $bayar = $value->total_pembelian - $value->hutang;
                $totalpembelian += $value->total_pembelian;
                $totalppn += $value->ppn;
                $totalbiaya += $value->biaya_kirim;
                $totaltotal += $total;
                $totalbayar += $bayar;
                $totalhutang += $value->hutang;
                $return['data'] .= '
                <tbody>
                <tr>
                <td style="text-align:left;">' . $no . '</td>
                <td style="text-align:left;">' . $value->npemasok . '</td>
                <td style="text-align:left;">' . $value->namapemasok . '</td>
                <td style="text-align:right;">' . number_format($value->total_pembelian) . '</td>
                <td style="text-align:right;">' . number_format($value->ppn) . '</td>
                <td style="text-align:right;">' . number_format($value->biaya_kirim) . '</td>
                <td style="text-align:right;">' . number_format($total) . '</td>
                <td style="text-align:right;">' . number_format($bayar) . '</td>
                <td style="text-align:right;">' . number_format($value->hutang) . '</td>
                </tr>
                </tbody>';
            }
            $return['data'] .= '
            <tfoot>
            <tr>
            <td colspan="3" style="text-align:right;"><b>Grand Total</b></td>
            <td style="text-align:right;"><b>' . number_format($totalpembelian) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalppn) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalbiaya) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totaltotal) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalbayar) . '</b></td>
            <td style="text-align:right;"><b>' . number_format($totalhutang) . '</b></td>
            </tr>
            </tfoot>';
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function pembelian_perpemasok_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPembelianPerPemasok($param);
        $x['result'] = $result;

        $x['judul_title'] = 'Laporan Pembelian Per Pemasok';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'pembelian-perpemasok-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/pembelian/lap_pembelian_perpemasok_pdf', $filename, $x, $download);
    }

    // public function pembelian_pemasok()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getPembelianPemasok($param);
    //     $this->load->view('laporan/lap_pembelian_pemasok', $x);
    // }

    public function pembelian_pemasok()
    {
        $this->data['n_pemasok'] = $this->M_pemasok->getFirstData();
        $this->data['d_pemasok'] = $this->M_pemasok->getData();
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Pembelian Per Pemasok Dengan Detail';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pembelian/js/lap_pembelian_pemasok.js'];
        $this->render('lap_pembelian_pemasok');
    }

    public function pembelian_pemasok_data()
    {
        $param = $this->input->post();
        $x['n_pemasok'] = $param['n_pemasok'];
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getPembelianPemasok($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['n_pemasok'] = $this->M_pemasok->getDetail($x['n_pemasok'])->nama;
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
                $total = number_format($d['total_pembelian'], 2, ",", ".");
                $subtotal = $d['harganya'] * $d['jumlahnya'];
                $pemasok = $d['namapemasok'];
                $alamat = $d['alamatp'];
                $tgl = strtotime($d['tgl_beli']);
                $tanggal_beli = date('d-M-Y', $tgl);

                if ($group == '-' || $group != $d['n_pembelian']) {
                    $npembelian = $d['n_pembelian'];
                    $return['data'] .= '
                    </table><br>
                    <table align="center" width="900px;" border="1"><tr><td colspan="8" style="text-align:center;"><b>No."' . $npembelian . '"</b></td></tr><tr><td><b>Tanggal</b></td><td colspan="5" style="text-align:left;">:' . $tanggal_beli . '</td><td style="text-align:right;"><b>Total:</b></td><td style="text-align:right;"><b>Rp ' . $total . '</b></td></tr>';
                    $return['data'] .= '<tr style="background-color:#ccc;">
                    <td width="3%" align="center">No</td>
                     <td width="10%" align="center">Kode Barang</td>
                     <td width="46%" align="center">Nama Barang</td>
                     <td width="3%" align="center">Qty</td>
                     <td width="5%" align="center">Satuan</td>
                     <td width="13%" align="center">Harga Satuan</td>
                     <td width="8%" align="center">Diskon</td>
                     <td width="12%" align="center">Subtotal</td>
                     
                     </tr>';
                    $nomor = 1;
                }
                $group = $d['n_pembelian'];
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

    public function pembelian_pemasok_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['n_pemasok'] = $this->input->get('npemasok');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getPembelianPemasok($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'Laporan Pembelian Per Pemasok Dengan Detail';
        $x['n_pemasok'] = $this->M_pemasok->getDetail($param['n_pemasok']);
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'pembelian-perpemasok(detail)-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/pembelian/lap_pembelian_pemasok_pdf', $filename, $x, $download);
    }

    // public function barangmasuk()
    // {
    //     $param = $this->input->post();
    //     $x['perusahaan'] = $this->M_laporan->getPerusahaan();
    //     $x['data'] = $this->M_laporan->getBarangmasuk($param);
    //     $this->load->view('laporan/lap_barangmasuk', $x);
    // }

    public function barangmasuk()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Laporan Barang Masuk';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pembelian/js/lap_barangmasuk.js'];
        $this->render('lap_barangmasuk');
    }

    public function barangmasuk_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getBarangmasuk($x);
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
                    <th style="text-align:center;">Jumlah Beli</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Total Nilai</th>
                </tr>
            </thead>';
            $total = 0;
            $grandtotal = 0;
            foreach ($result as $key => $value) {
                $total = $value->masuk * $value->hargakm;
                $grandtotal += $total;
                $return['data'] .= '
                <tbody>
                <tr>
                <td style="text-align:center;"><b>' . $value->frekuensi . ' X</b></td>
                <td style="text-align:left;">' . $value->n_barang . '</td>
                <td style="text-align:left;">' . $value->nama_barang . '</td>
                <td style="text-align:center;">' . $value->masuk . '</td>
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

    public function barangmasuk_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getBarangmasuk($param);
        $x['result'] = $result;

        $x['judul_title'] = 'Laporan Barang Masuk';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'barangmasuk-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/pembelian/lap_barangmasuk_pdf', $filename, $x, $download);
    }
}
