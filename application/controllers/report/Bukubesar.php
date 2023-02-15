<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Bukubesar extends BaseController
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
        $this->load->model('M_coa');
        $this->load->model('M_pelanggan');
        $this->load->model('M_pemasok');
        $this->load->model('M_piutang');
        $this->load->model('M_hutang');
        $this->load->model('M_barang');
        $this->load->model('M_kasbank');
        array_push($this->bread, ['title' => 'Laporan', 'url' => site_url('laporan')]);
        array_push($this->bread, ['title' => 'Buku Besar', 'url' => site_url('report/bukubesar')]);
    }

    public function index()
    {
        $title = 'Buku Besar';
        $this->data['judul_title'] = $title;
        $this->render('index');
    }

    public function posisikeuangan()
    {
        $tanggal = date('Y-m-d');
        $title = 'Posisi Keuangan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/bukubesar/js/posisikeuangan.js'];
        $this->render('posisikeuangan');
    }

    public function bukubantuall()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Buku Bantu Seluruh Perkiraan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/bukubesar/js/bukubantuall.js'];
        $this->render('bukubantu');
    }

    public function pdf_bukubantuall()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getBukubantu($param)->result_array();
        $x['result'] = $result;

        $x['judul_title'] = 'Laporan Buku Bantu Seluruh Perkiraan';
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'bukubantuall-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/bukubesar/bukubantu_pdf', $filename, $x, $download);
    }

    public function bukubantuone()
    {
        $title = 'Buku Bantu Tiap Perkiraan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $this->data['perkiraan'] = $this->M_laporan->listCoa();
        $this->data['akun'] = $this->M_laporan->firstCoa();
        $this->data['scripts'] = ['report/bukubesar/js/bukubantuone.js'];
        $this->render('bukubantuone');
    }

    public function pdf_bukubantuone()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

        $param['akun_jurnal'] = $this->input->get('akun');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $result = $this->M_laporan->getBukubantuP($param)->result_array();
        $x['result'] = $result;
        $x['saldoawal'] = $this->M_laporan->getSaldoAwal($param)->result_array();

        $x['judul_title'] = 'Laporan Buku Bantu Tiap Perkiraan';
        $x['akun'] = $this->M_coa->getDetail($param['akun_jurnal']);
        $x['tgl_dari'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tgl_sampai'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'bukubantuone-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/bukubesar/bukubantuone_pdf', $filename, $x, $download);
    }

    public function bukubantuone_data()
    {
        $param = $this->input->post();
        $x['data'] = $this->M_laporan->getBukubantuP($param)->result_array();
        $x['saldoawal'] = $this->M_laporan->getSaldoAwal($param)->result_array();
        $return['akun'] = $this->M_coa->getDetail($param['akun_jurnal'])->nama;
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        $return['data'] = '<table align="center" style="width:100%;margin-bottom:5px;margin-top:1px;border: none;">';
        $saldo_awal = 0;
        foreach ($x['saldoawal'] as $s) {
            $saldo_awal =  $s['debet'] - $s['kredit'];
            $return['data'] .= '<tr style="border-top: 1px solid;" class="bg-success text-white">
                <td width="15%" align="center">Tanggal</td>
                <td width="10%" align="center">Nomor Jurnal</td>
                <td width="25%" align="center">Keterangan</td>
                <td width="10%" align="center">No. Referensi</td>
                <td width="12%" align="center">Debet</td>
                <td width="12%" align="center">Kredit</td>
                <td width="16%" align="center">Saldo</td>
            </tr>
            <tr style="border-bottom: 1px solid;">
                <td colspan="5"></td>
                <td width="10%" align="center" style="text-align:right;color:red;">Saldo Awal</td>
                <td width="12%"style="text-align:right;color:red;"><b>' . currencyIDR($saldo_awal) . '</b></td>
            </tr>';
        }

        $urut = 0;
        $nomor = 0;
        $totaldebet = 0;
        $totalkredit = 0;
        $saldo = 0;
        $group = '-';
        if (empty($x['data'])) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            foreach ($x['data'] as $d) {
                $nomor++;
                $urut++;
                $tglj = strtotime($d['tanggal_jurnal']);
                $tanggaljur = $this->tanggalindo->konversi($d['tanggal_jurnal']);
                $debet = $d['debet_jurnal'];
                $kredit = $d['kredit_jurnal'];
                $namaakun = $d['nama_akun'];
                $totaldebet += $d['debet_jurnal'];
                $totalkredit += $d['kredit_jurnal'];
                $saldo = $totaldebet - $totalkredit + $saldo_awal;

                if ($group == '-' || $group != $d['akun_jurnal']) {
                    $return['data'] .= '</table><table align="center" width="900px;" style="border:5px;">';
                }
                $group = $d['akun_jurnal'];
                $return['data'] .= '<tr style="padding: 1rem;">
                <td style="text-align:center;" width="15%">' . $tanggaljur . '</td>
                <td style="text-align:left;padding-right: 10px;" width="10%">' . $d['njurnal'] . '</td>
                <td style="text-align:left;" width="25%">' . $d['ket'] . '</td>
                <td style="text-align:center;" width="10%">' . $d['reff'] . '</td>
                <td style="text-align:right;" width="12%">' . currencyIDR($debet) . '</td>
                <td style="text-align:right;" width="12%">' . currencyIDR($kredit) . '</td>
                <td style="text-align:right;" width="16%">' . currencyIDR($saldo) . '</td>
            </tr>';
            }

            $return['data'] .= '</table><table align="center" style="width:100%;border:none;margin-top:1px;border-bottom: 1px solid;"><tr>
                <td colspan="7"></td></tr>
            <tr>
                <td colspan="4"></td>
                <td width="10%" style="text-align:right;"><b>Total:</b></td>
                <td width="10%" style="text-align:right;border-top: 1px solid;"><b>' . currencyIDR($totaldebet) . '</b>
                </td>
                <td width="10%"style="text-align:right;border-top: 1px solid;"><b>' . currencyIDR($totalkredit) . '</b>
                </td>
                <td width="12%" style="border-top: 1px solid;"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td width="10%" style="text-align:right;color:blue;">Mutasi</td>
                <td width="10%"style="text-align:right;color:blue;"><b>' . currencyIDR(($totaldebet - $totalkredit)) . '</b>
                </td>
                <td width="12%"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td width="10%" style="text-align:right;color:red;">Saldo Akhir</td>
                <td width="10%"style="text-align:right;color:red;"><b>' . currencyIDR(($totaldebet - $totalkredit + $saldo_awal)) . '</b>
                </td>
            </tr>
        </table>';
        }
        echo json_encode($return);
    }

    public function bukubantuall_data()
    {
        $x = $this->input->post();
        $param['tgl_dari'] = $x['tanggal_awal'];
        $param['tgl_sampai'] = $x['tanggal_akhir'];
        $result = $this->M_laporan->getBukubantu($param)->result_array();
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        if (empty($result)) {
            $return['data'] = '<h2 class="text-center">Tidak data transaksi pada tanggal tersebut</h2>';
        } else {
            $urut = 0;
            $nomor = 0;
            $totaldebet = 0;
            $totalkredit = 0;
            $group = '-';
            $return['data'] = null;
            foreach ($result as $d) {
                $nomor++;
                $urut++;
                $tanggaljur = $this->tanggalindo->konversi($d['tanggal_jurnal']);
                $debet = $d['debet_jurnal'];
                $kredit = $d['kredit_jurnal'];
                $noakun = $d['akun_jurnal'];
                $namaakun = $d['nama_akun'];
                $totaldebet += $d['debet_jurnal'];
                $totalkredit += $d['kredit_jurnal'];
                if ($group == '-' || $group != $d['akun_jurnal']) {
                    $return['data'] .= '<br>
                <table align="center" style="width:100%;border:none;border-top:1px solid;">
                <tr style="border-top:1px solid;">
                <td><b>Nomor Akun</b></td><td colspan="2" style="text-align:left;">' . ': ' . '<b>' . $noakun . '</b></td><td style="text-align:right;"><b>Nama Akun</b></td><td colspan="2" style="text-align:left;">' . ': ' . '<b>' . $namaakun . '</b></td></tr><tr style="border-bottom:1px solid;" class="bg-success text-light">
            <td width="15%" align="center">Tanggal</td>
            <td width="10%" align="center">Nomor Jurnal</td>
            <td width="35%" align="center">Keterangan</td>
            <td width="10%" align="center">No. Referensi</td>
            <td width="15%" align="center">Debet</td>
            <td width="15%" align="center">Kredit</td></tr>';
                }
                $group = $d['akun_jurnal'];
                $return['data'] .= '<tr>
            <td style="text-align:center;">' . $tanggaljur . '</td>
                            <td style="text-align:left;padding-right: 5px;" >' . $d['njurnal'] . '</td>
                            <td style="text-align:left;">' . $d['ket'] . '</td>
                            <td style="text-align:center;">' . $d['reff'] . '</td>
                            <td style="text-align:right;">' . currencyIDR($debet) . '</td>
                            <td style="text-align:right;">' . currencyIDR($kredit) . '</td>
                        </tr>';
            }

            $return['data'] .= '</table>';
            $return['data'] .= '<table align="center" style="width:100%; border:none;margin-top:5px;margin-bottom:20px;"><tr>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td width="10%" style="text-align:right;border-top: 1px solid;">Total</td>
                        <td width="15%" style="text-align:right;border-top: 1px solid;"><b>' . currencyIDR($totaldebet) . '</b>
                        </td>
                        <td width="15%" style="text-align:right;border-top: 1px solid;"><b>' . currencyIDR($totalkredit) . '</b>
                        </td>
                    </tr></table>';
        }
        echo json_encode($return);
    }

    public function posisikeuangandata()
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
        $hpp = $this->hpp_data($tanggal);
        $data['pasiva_hpp'] = $hpp['pasivas_h'];
        $data['ttlhpp'] = $hpp['ttlhpp'];
        $data['biaya'] = $this->biaya_data($tanggal);
        $data['coa_laba'] = $this->coa_laba_data($tanggal);
        $data['coa_laba']['nominal'] = currencyIDR($data['pendapatan'] - $hpp['ttlhpp'] - $data['biaya']);

        $data['total_kewajiban'] = currencyIDR(($data['pendapatan'] - $hpp['ttlhpp'] - $data['biaya']));
        $data['total_pasiva']  = currencyIDR(($pasiva_h['ttlpasivah'] + $data['ttlpasivam'] + ($data['pendapatan'] - $hpp['ttlhpp'] - $data['biaya'])));
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
        $return['ttlhpp'] = 0;
        $ttlhpp = 0;
        $return['pasivas_h'] = null;
        foreach ($hpp as $key => $b) {
            $nilai = ($b->t_debetb) - ($b->t_kreditb);
            $ttlhpp += ($b->t_debetb) - ($b->t_kreditb);

            $return['pasivas_h'] .= '<table style="width:100%;"><tr>
            <td style="text-align:left;width:10%;"></td>
            <td style="text-align:left;width:40%;">' . $b->nama . '</td>
            <td style="text-align:right;width:50%;">' . $nilai . '</td>
            </tr></table>';
        }
        $return['ttlhpp'] = $ttlhpp;
        return $return;
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

    public function pdfposisikeuangan($param)
    {
        $this->load->library('Dom_pdf', 'dom_pdf');

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

        $x['judul_title'] = 'Posisi Keuangan';
        $x['tanggal'] = $this->tanggalindo->konversi($param);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $filename = 'posisikeuangan-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('report/bukubesar/posisikeuangan_pdf', $filename, $x, $download);
    }

    public function aruskas_tahunan()
    {
        $tanggal = date('Y-m-d');
        $this->data['tanggal'] = $tanggal;
        $title = 'Arus Kas Tahunan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/bukubesar/js/aruskas_tahunan.js'];
        $this->render('aruskas_tahunan');
    }

    public function aruskas_bulanan()
    {
        $bulan = date('Y-m');
        $this->data['bulan'] = $bulan;
        $title = 'Arus Kas Bulanan';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['bulan_indo'] = $bulan;
        $this->data['scripts'] = ['report/bukubesar/js/aruskas_bulanan.js'];
        $this->render('aruskas_bulanan');
    }

    public function aruskastahunan_data()
    {
        $param = $this->input->post('tanggal');
        $pendapatan = $this->labarugi_pendapatan($param);
        $hpp = $this->labarugi_hpp($param);
        $biaya = $this->labarugi_biaya($param);
        $data['tanggal_indo'] = $this->tanggalindo->konversi($param);
        $data['pendapatan'] = $pendapatan['pendapatan'];
        $data['hpp'] = $hpp['hpp'];
        $data['biaya'] = $biaya['biaya'];
        $data['ttllaba'] = '<td style="text-align:right;">' . currencyIDR($pendapatan['ttlpend'] - $hpp['ttlhpp'] - $biaya['ttlbiaya']) . '</td>';
        echo json_encode($data);
    }

    public function aruskasbulanan_data()
    {
        $param = $this->input->post('bulan');
        $pendapatan = $this->labarugibulanan_pendapatan($param);
        $hpp = $this->labarugibulanan_hpp($param);
        $biaya = $this->labarugibulanan_biaya($param);
        $x['pendapatan'] = $pendapatan['pendapatan'];
        $x['hpp'] = $hpp['hpp'];
        $x['biaya'] = $biaya['biaya'];
        $x['bulan_indo'] = $this->tanggalindo->get_tahun_bulan($param);
        $x['ttllaba'] = '<td style="text-align:right;">' . currencyIDR($pendapatan['ttlpend'] - $hpp['ttlhpp'] - $biaya['ttlbiaya']) . '</td>';
        echo json_encode($x);
    }

    private function labarugi_pendapatan($tanggal)
    {
        $pendapatan = $this->M_laporan->getRulabPend($tanggal);
        $ttlpend = 0;
        $return['pendapatan'] = '<table style="width:100%;">';
        foreach ($pendapatan as $key => $value) {
            $nilai =  ($value->t_kreditp) - ($value->t_debetp);
            $ttlpend += ($value->t_kreditp) - ($value->t_debetp);
            $return['pendapatan'] .= '<tr>
            <td style="width: 5%;"></td>
            <td style="text-align:left;width: 15%;">' . $value->akun . '</td>
            <td style="text-align:left;width: 60%;">' . $value->nama . '</td>
            <td style="text-align:right;width: 20%;">' . currencyIDR($nilai) . '</td>
            </tr>';
        }
        $return['pendapatan'] .= '<tr>
            <td colspan="3" style="text-align:right;"><b>Total Pendapatan</b></td>
            <td style="text-align:right;border-top:1px solid;"><b>' . currencyIDR($ttlpend) . '</b></td>
            </tr></table>';
        $return['ttlpend'] = $ttlpend;

        return $return;
    }
    private function labarugibulanan_pendapatan($bulan)
    {
        $pendapatan = $this->M_laporan->getRulabPendB($bulan);
        $ttlpend = 0;
        $return['pendapatan'] = '<table style="width:100%;">';
        foreach ($pendapatan as $key => $value) {
            $nilai =  ($value->t_kreditp) - ($value->t_debetp);
            $ttlpend += ($value->t_kreditp) - ($value->t_debetp);
            $return['pendapatan'] .= '<tr>
            <td style="width: 5%;"></td>
            <td style="text-align:left;width: 15%;">' . $value->akun . '</td>
            <td style="text-align:left;width: 60%;">' . $value->nama . '</td>
            <td style="text-align:right;width: 20%;">' . currencyIDR($nilai) . '</td>
            </tr>';
        }
        $return['pendapatan'] .= '<tr>
            <td colspan="3" style="text-align:right;"><b>Total Pendapatan</b></td>
            <td style="text-align:right;border-top:1px solid;"><b>' . currencyIDR($ttlpend) . '</b></td>
            </tr></table>';
        $return['ttlpend'] = $ttlpend;

        return $return;
    }

    private function labarugi_hpp($tanggal)
    {
        $hpp = $this->M_laporan->getRulabHpp($tanggal);
        $ttlhpp = 0;
        $return['hpp'] = '<table style="width:100%;">';
        foreach ($hpp as $key => $value) {

            $nilai = ($value->t_debetb) - ($value->t_kreditb);
            $ttlhpp += ($value->t_debetb) - ($value->t_kreditb);
            $tampilNilai = $nilai >= 0 ? currencyIDR($nilai) : '(' . currencyIDR($nilai * -1) . ')';
            $return['hpp'] .= '<tr>
                        <td style="width: 5%;"></td>
                        <td style="text-align:left;width: 15%;">' . $value->akun . '</td>
                        <td style="text-align:left;width: 60%;">' . $value->nama . '</td>
                        <td style="text-align:right;width: 20%;">' . $tampilNilai . '</td>
                    </tr>';
        }

        $return['hpp'] .= '<tr>
        <td colspan="3" style="text-align:right;"><b>Total HPP</b></td>
        <td style="text-align:right;border-top:1px solid;"><b>' . currencyIDR($ttlhpp) . '</b></td></tr>';
        $return['ttlhpp'] = $ttlhpp;
        return $return;
    }
    private function labarugibulanan_hpp($bulan)
    {
        $hpp = $this->M_laporan->getRulabHppB($bulan);
        $ttlhpp = 0;
        $return['hpp'] = '<table style="width:100%;">';
        foreach ($hpp as $key => $value) {

            $nilai = ($value->t_debetb) - ($value->t_kreditb);
            $ttlhpp += ($value->t_debetb) - ($value->t_kreditb);

            $return['hpp'] .= '<tr>
                        <td style="width: 5%;"></td>
                        <td style="text-align:left;width: 15%;">' . $value->akun . '</td>
                        <td style="text-align:left;width: 60%;">' . $value->nama . '</td>
                        <td style="text-align:right;width: 20%;">' . currencyIDR($nilai) . '</td>
                    </tr>';
        }

        $return['hpp'] .= '<tr>
        <td colspan="3" style="text-align:right;"><b>Total HPP</b></td>
        <td style="text-align:right;border-top:1px solid;"><b>' . currencyIDR($ttlhpp) . '</b></td></tr>';
        $return['ttlhpp'] = $ttlhpp;
        return $return;
    }

    private function labarugi_biaya($tanggal)
    {
        $biaya = $this->M_laporan->getRulabBiaya($tanggal);
        $ttlbiaya = 0;
        $return['biaya'] = '<table style="width:100%;">';
        foreach ($biaya as $key => $value) {
            $nilai = ($value->t_debetb) - ($value->t_kreditb);
            $ttlbiaya += ($value->t_debetb) - ($value->t_kreditb);
            $tampilNilai = $nilai >= 0 ? currencyIDR($nilai) : '(' . currencyIDR($nilai * -1) . ')';
            $return['biaya'] .= '<td style="width: 5%;"></td>
                        <td style="text-align:left;width: 15%;">' . $value->akun . '</td>
                        <td style="text-align:left;width: 60%;">' . $value->nama . '</td>
                        <td style="text-align:right;width: 20%;">' . $tampilNilai . '</td>
                        </tr>';
        }
        $return['biaya'] .= '<tr>
            <td colspan="3" style="text-align:right;"><b>Total Biaya</b></td>
            <td style="text-align:right;border-top:1px solid;"><b>' . currencyIDR($ttlbiaya) . '</b></td>
            </tr></table>';
        $return['ttlbiaya'] = $ttlbiaya;
        return $return;
    }
    private function labarugibulanan_biaya($bulan)
    {
        $biaya = $this->M_laporan->getRulabBiayaB($bulan);
        $ttlbiaya = 0;
        $return['biaya'] = '<table style="width:100%;">';
        foreach ($biaya as $key => $value) {
            $nilai = ($value->t_debetb) - ($value->t_kreditb);
            $ttlbiaya += ($value->t_debetb) - ($value->t_kreditb);

            $return['biaya'] .= '<td style="width: 5%;"></td>
                        <td style="text-align:left;width: 15%;">' . $value->akun . '</td>
                        <td style="text-align:left;width: 60%;">' . $value->nama . '</td>
                        <td style="text-align:right;width: 20%;">' . currencyIDR($nilai) . '</td>
                        </tr>';
        }
        $return['biaya'] .= '<tr>
            <td colspan="3" style="text-align:right;"><b>Total Biaya</b></td>
            <td style="text-align:right;border-top:1px solid;"><b>' . currencyIDR($ttlbiaya) . '</b></td>
            </tr></table>';
        $return['ttlbiaya'] = $ttlbiaya;
        return $return;
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
