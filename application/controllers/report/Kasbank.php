<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasbank extends BaseController
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
        array_push($this->bread, ['title' => 'Kas & Bank', 'url' => site_url('report/kasbank')]);
    }

    public function index()
    {
        $title = 'Kas & Bank';
        $this->data['judul_title'] = $title;

        $this->data['perkiraan'] = $this->M_jurnal->ambilCoa();
        $this->data['bulan_rulab'] = $this->M_laporan->getBulanrulab();
        $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
        $this->data['d_pemasok'] = $this->M_pemasok->getData();
        $this->data['datatranskas'] = $this->M_kasbank->getTransKas();
        $this->data['datatransbank'] = $this->M_kasbank->getTransBank();

        $this->render('index');
    }
    public function pdf_kasmasuk()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getKasmasuk($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'laporan kasMasuk';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'kasmasuk-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/kasbank/kasMasuk_pdf', $filename, $x, $download);
    }
    public function pdf_kaskeluar()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getKaskeluar($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'laporan kasKeluar';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'kaskeluar-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/kasbank/kasKeluar_pdf', $filename, $x, $download);
    }
    public function pdf_bankmasuk()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getBankmasuk($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'laporan bankMasuk';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'kaskeluar-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/kasbank/bankmasuk_pdf', $filename, $x, $download);
    }
    public function pdf_bankkeluar()
    {

        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getBankkeluar($param);
        $x['result'] = $result->result_array();

        $x['judul_title'] = 'laporan bankMasuk';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'kaskeluar-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/kasbank/bankkeluar_pdf', $filename, $x, $download);
    }
    public function kasmasuk()
    {
        $tanggal = date('Y-m-d');
        $title = 'Kas Masuk';
        $this->data['judul_title'] = $title;
        //array_push($this->bread, ['title' => $title, 'url' => site_url('report/kasbank/kasmasuk')]);
        //$this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/kasbank/js/kasmasuk.js'];
        $this->render('kasmasuk');
    }

    public function kaskeluar()
    {
        $tanggal = date('Y-m-d');
        $title = 'Kas Keluar';
        array_push($this->bread, ['title' => $title, 'url' => site_url('report/kasbank/kaskeluar')]);
        $this->data['judul_title'] = $title;
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/kasbank/js/kaskeluar.js'];
        $this->render('kaskeluar');
    }

    public function bankmasuk()
    {
        $title = 'Bank Masuk';
        array_push($this->bread, ['title' => $title, 'url' => site_url('report/kasbank/bankmasuk')]);
        $tanggal = date('Y-m-d');
        $this->data['judul_title'] = $title;
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/kasbank/js/bankmasuk.js'];
        $this->render('bankmasuk');
    }

    public function bankkeluar()
    {
        $title = 'Bank Keluar';
        array_push($this->bread, ['title' => $title, 'url' => site_url('report/kasbank/bankkeluar')]);
        $tanggal = date('Y-m-d');
        $this->data['judul_title'] = $title;
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/kasbank/js/bankkeluar.js'];
        $this->render('bankkeluar');
    }


    public function bankkeluar_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($x['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($x['tgl_sampai']);
        $result = $this->M_laporan->getBankkeluar($x)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['data'] = '<table border="1" align="center" style="width:700px;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $total = $d['total_kasbank'];
                $keterangan = $d['ket'];
                $tanggal = $this->tanggalindo->konversi($d['tanggal_kasbank']);

                if ($group == '-' || $group != $d['h_nkasbank']) {
                    $nkasbank = $d['h_nkasbank'];

                    $return['data'] .= '</table><table align="center" width="100%" border="1"><tr><td><b>No. Trans</b></td><td>:<b>' . $nkasbank . '</b></td><td style="text-align:right;">Tanggal: <b>' . $tanggal . '</b></td></tr><tr>
                    <td><b>Keterangan</b></td> <td style="text-align:left;">:' . $keterangan . '</td><td style="text-align:right;">Total:<b>' . currencyIDR($total) . '</b></td></tr><tr class="text-light bg-success">
                    <td width="15%" align="center">No. Perkiraan</td>
                    <td width="60%" align="center">Nama Perkiraan</td>
                    <td width="25%" align="center">Jumlah</td></tr>';
                    $nomor = 1;
                }
                $group = $d['h_nkasbank'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                    <td style="text-align:left;">' . $d['nomor_akun'] . '</td>
                    <td style="text-align:left;">' . $d['nama_akun'] . '</td>
                    <td style="text-align:right;">' . currencyIDR($d['debet_kasbank']) . '</td></tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function kasmasuk_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getKasmasuk($x)->result_array();
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
                $total = $d['total_kasbank'];
                $keterangan = $d['ket'];
                $tanggal = $this->tanggalindo->konversi($d['tanggal_kasbank']);

                if ($group == '-' || $group != $d['h_nkasbank']) {
                    $nkasbank = $d['h_nkasbank'];
                    $return['data'] .= '
                    <table align="center" width="100%;" border="1"><tr><td><b>No. Trans</b></td><td>:<b>' . $nkasbank . '</b></td><td style="text-align:right;">Tanggal :<b>' . $tanggal . '</b></td></tr><tr>
                <td><b>Keterangan</b></td> <td style="text-align:left;">:' . $keterangan . '</td><td style="text-align:right;">Total :<b>' . currencyIDR($total) . '</b></td></tr>';
                    $return['data'] .= '<tr class="text-light bg-success">
                    <td width="15%" align="center">No. Perkiraan</td>
                    <td width="60%" align="center">Nama Perkiraan</td>
                    <td width="25%" align="center">Jumlah</td>
                    </tr>';
                    $nomor = 1;
                }
                $group = $d['h_nkasbank'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
            <td style="text-align:left;">' . $d['nomor_akun'] . '</td>
            <td style="text-align:left;">' . $d['nama_akun'] . '</td>
            <td style="text-align:right;">' . currencyIDR($d['kredit_kasbank']) . '</td></tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function kaskeluar_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $data = $this->M_laporan->getKaskeluar($param)->result_array();
        if (empty($data)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['data'] = '<table border="1" align="center" style="width:700px;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($data as $d) {
                $nomor++;
                $urut++;
                $total = $d['total_kasbank'];
                $keterangan = $d['ket'];
                $tanggal = $this->tanggalindo->konversi($d['tanggal_kasbank']);

                if ($group == '-' || $group != $d['h_nkasbank']) {
                    $nkasbank = $d['h_nkasbank'];
                    $return['data'] .= '</table><table align="center" width="100%" border="1"><tr><td><b>No. Trans</b></td><td>:<b>' . $nkasbank . '</b></td><td style="text-align:right;">Tanggal: <b>' . $tanggal . '</b></td></tr><tr>
                <td><b>Keterangan</b></td> <td style="text-align:left;">:' . $keterangan . '</td><td style="text-align:right;">Total :<b>' . currencyIDR($total) . '</b></td></tr>';
                    $return['data'] .= '<tr class="text-light bg-success">
                <td width="15%" align="center">No. Perkiraan</td>
                <td width="60%" align="center">Nama Perkiraan</td>
                <td width="25%" align="center">Jumlah</td></tr>';
                    $nomor = 1;
                }
                $group = $d['h_nkasbank'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:left;">' . $d['nomor_akun'] . '</td>
                <td style="text-align:left;">' . $d['nama_akun'] . '</td>
                <td style="text-align:right;">' . currencyIDR($d['debet_kasbank']) . '</td>
            </tr><br>';
            }

            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function bankmasuk_data()
    {
        $param = $this->input->post();
        $x['tgl_dari'] = $param['tgl_dari'];
        $x['tgl_sampai'] = $param['tgl_sampai'];
        $result = $this->M_laporan->getBankmasuk($param)->result_array();
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $return['data'] = '<table border="1" align="center" style="width:100%;margin-bottom:20px;">';
            $urut = 0;
            $nomor = 0;
            $grandtotal = 0;
            $group = '-';
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $total = $d['total_kasbank'];
                $keterangan = $d['ket'];
                $tanggal = $this->tanggalindo->konversi($d['tanggal_kasbank']);

                if ($group == '-' || $group != $d['h_nkasbank']) {
                    $nkasbank = $d['h_nkasbank'];
                    $return['data'] .= '</table><table align="center" width="100%" border="1"><tr><td><b>No. Trans</b></td><td>: <b>' . $nkasbank . '</b></td><td style="text-align:right;">Tanggal: <b>' . $tanggal . '</b></td></tr><tr>
                <td><b>Keterangan</b></td> <td style="text-align:left;">:' . $keterangan . '</td><td style="text-align:right;">Total: <b>' . currencyIDR($total) . '</b></td></tr>';
                    $return['data'] .= '<tr class="text-light bg-success">
                <td width="15%" align="center">No. Perkiraan</td>
                <td width="60%" align="center">Nama Perkiraan</td>
                <td width="25%" align="center">Jumlah</td>';
                    $nomor = 1;
                }
                $group = $d['h_nkasbank'];
                if ($urut == 500) {
                    $nomor = 0;
                    $return['data'] .= '<div class="pagebreak"></div>';
                }
                $return['data'] .= '<tr>
                <td style="text-align:left;">' . $d['nomor_akun'] . '</td>
                <td style="text-align:left;">' . $d['nama_akun'] . '</td>
                <td style="text-align:right;">' . currencyIDR($d['kredit_kasbank']) . '</td></tr><br>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }
}
