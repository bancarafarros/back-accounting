<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends BaseController
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
        $this->load->model('M_pelanggan');
		$this->load->model('M_jurnal');
		$this->load->model('M_sales');
        array_push($this->bread, ['title' => 'Laporan', 'url' => site_url('laporan')]);
        array_push($this->bread, ['title' => 'Pelanggan', 'url' => site_url('report/pelanggan')]);
    }

    public function index()
    {
        $title = 'Pelanggan';
        $this->data['judul_title'] = $title;
        // $this->data['perkiraan'] = $this->M_jurnal->ambilCoa();
        // $this->data['bulan_rulab'] = $this->M_laporan->getBulanrulab();
        // $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
        // $this->data['d_pemasok'] = $this->M_pemasok->getData();
        // $this->data['datatranskas'] = $this->M_kasbank->getTransKas();
        // $this->data['datatransbank'] = $this->M_kasbank->getTransBank();
        $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		$this->data['d_sales'] = $this->M_sales->getData();
        $this->render('index');
    }

    public function daftar_pelanggan()
    {
        $tanggal = date('Y-m-d');
        $title = 'Daftar Pelanggan';
        array_push($this->bread, ['title' => $title]);
        $this->data['judul_title'] = $title;
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['d_pelanggan'] = $this->M_pelanggan->getData();
		$this->data['d_akun'] = $this->M_jurnal->ambilCoa();
		$this->data['d_sales'] = $this->M_sales->getData();
        $this->data['scripts'] = ['report/pelanggan/js/daftar_pelanggan.js'];
        $this->render('daftar_pelanggan');
    }

    public function daftar_pelanggan_data()
    {
        $tanggal = $this->input->post('tanggal');
        $return['tanggal'] = $tanggal;
        $return['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);

        $result = $this->M_laporan->getDataPelanggan($tanggal)->result_array();

        if(empty($result)){
            $return['data'] = '<h2 class="text-center">Tidak ada data pelanggan pada tanggal tersebut</h2>';
        }else{
            $no= 0;
            $return['data'] = null;
            $return['data'] .= '<table align="center" style="width:100%">
                                    <tr class="bg-success">
                                        <th class="text-white" style="text-align:center">NO</th>
                                        <th class="text-white" style="text-align:center">Kode Pelanggan</th>
                                        <th class="text-white" style="text-align:center">Nama Pelanggan</th>
                                        <th class="text-white" style="text-align:center">Tanggal Registrasi</th>
                                        <th class="text-white" style="text-align:center">Alamat</th>
                                        <th class="text-white" style="text-align:center">Telepon</th>
                                        <th class="text-white" style="text-align:center">Batas Kredit</th>
                                        <th class="text-white" style="text-align:center">Sales</th>
                                    </tr>';

            foreach($result as $d){
                $no++;
                $batas_kredit = number_format($d['batas']);
                $return['data'] .= '<tr>
                                        <td style="text-align:center;">' . $no . '</td>
                                        <td style="text-align:center;">' . $d['n_pelanggan'] . '</td>
                                        <td style="text-align:center;">' . $d['nama'] . '</td>
                                        <td style="text-align:center;">' . $d['tanggal'] . '</td>
                                        <td style="text-align:center;">' . $d['alamat'] . '</td>
                                        <td style="text-align:center;">' . $d['telepon'] . '</td>
                                        <td style="text-align:center;">Rp ' . $batas_kredit . '</td>
                                        <td style="text-align:center;">' . $d['nama_sales'] . '</td>
                                    </tr>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function pdf_daftar_pelanggan($param)
    {
        $this->load->library('Dom_pdf', 'dom_pdf');
        $x['judul_title'] = 'Laporan Daftar Pelanggan';
        $x['tanggal'] = $this->tanggalindo->konversi($param);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $pelanggan = $this->M_laporan->getDataPelanggan($param);
        $x['data'] = $pelanggan->result();
        
        $filename = 'pelanggan-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('laporan/lap_daftar_pelanggan', $filename, $x, $download);
    }

    public function piutang_global()
    {
        $title = 'Piutang Global';
        $tanggal = date('Y-m-d');
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/pelanggan/js/piutang_global.js'];
        $this->render('piutang_global');
    }

    public function piutang_global_data()
    {
        $x = $this->input->post();
        $tanggal['tgl_dari'] = $x['tanggal_awal'];
        $tanggal['tgl_sampai'] = $x['tanggal_akhir'];
        $result = $this->M_laporan->getDataPiutangGlobal($tanggal)->result_array();
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($tanggal['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($tanggal['tgl_sampai']);

        if(empty($result)){
            $return['data'] = '<h2 class="text-center">Tidak ada data piutang pada tanggal tersebut</h2>';
        }else{
            $no= 0;
            $total = 0;
            $return['data'] = null;
            $return['data'] .= '<table align="center" style="width:100%">
                                    <tr class="bg-success">
                                        <th class="text-white" style="text-align:center">NO</th>
                                        <th class="text-white" style="text-align:center">Kode Pelanggan</th>
                                        <th class="text-white" style="text-align:center">Nama Pelanggan</th>
                                        <th class="text-white" style="text-align:center">Jumlah</th>
                                    </tr>';

            foreach($result as $d){
                $no++;
                $jumlah = number_format($d['sisa']);
                $total += $d['sisa'];
                $return['data'] .= '<tr>
                                        <td style="text-align:center;">' . $no . '</td>
                                        <td style="text-align:center;">' . $d['n_pelanggan'] . '</td>
                                        <td style="text-align:center;">' . $d['nama_pelanggan'] . '</td>
                                        <td style="text-align:center;">Rp ' . $jumlah . '</td>
                                    </tr>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function pdf_piutang_global()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $x['tanggal_awal'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tanggal_akhir'] = $this->tanggalindo->konversi($param['tgl_sampai']);

        $x['judul_title'] = 'Laporan Piutang Global';
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $piutang = $this->M_laporan->getDataPiutangGlobal($param);
        $x['data'] = $piutang->result();
        // var_dump($param);
        // die;
        
        $filename = 'piutang-global-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('laporan/lap_piutang_global', $filename, $x, $download);
        // $this->load->view('laporan/lap_piutang_global', $filename, $x, $download);
    }

    public function piutang_detail()
    {
        $title = 'Piutang Detail';
        $tanggal = date('Y-m-d');
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $this->data['scripts'] = ['report/pelanggan/js/piutang_detail.js'];
        $this->render('piutang_detail');
    }

    public function piutang_detail_data()
    {
        $x = $this->input->post();
        $tanggal['tgl_dari'] = $x['tanggal_awal'];
        $tanggal['tgl_sampai'] = $x['tanggal_akhir'];
        $result = $this->M_laporan->getDataPiutangDetail($tanggal);
        $data = $result->result_array();
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($tanggal['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($tanggal['tgl_sampai']);

        if(empty($data)){
            $return['data'] = '<h2 class="text-center">Tidak ada data piutang pada tanggal tersebut</h2>';
        }else{
            $return['data'] = '<table border="1" align="center" style="width:900px;margin-bottom:20px;">';
            $no= 0;
            $urut = 0;
            $group = '-';
            $return['data'] = null;

            foreach($result->result_array() as $d){
                $no++;
                $kdpelanggan = $d['n_pelanggan'];
                $pelanggan = $d['nama_pelanggan'];
                
                if($group=='-' || $group!=$d['n_pelanggan']){
                    $npelanggan=$d['n_pelanggan'];
                    $return['data'] .= '</table><br>
                                        <table align="center" width="900px;" border="1">
                                        <tr>
                                            <td><b>Pelanggan</b></td>
                                            <td colspan="4" style="text-align:center;"><b>' . $pelanggan . '</b></td>
                                            <td style="text-align:center;"><b>Kode</b></td>
                                            <td style="text-align:center;">' . $kdpelanggan . '</td>
                                        </tr>
                                        <tr>
                                            <td><b></b></td> 
                                            <td colspan="4" style="text-align:left;"></td>
                                            <td style="text-align:right;"><b>Sub Total</b></td>
                                            <td style="text-align:right;"><b>-</b></td>
                                        </tr>';
                    $return['data'] .= '
                                <tr class="bg-success">
                                    <td width="5%" align="center">No</td>
                                    <td width="15%" align="center">Nomor Reff</td>
                                    <td width="15%" align="center">Nomor Transaksi</td>
                                    <td width="10%" align="center">Tanggal</td>
                                    <td width="25%" align="center">Keterangan</td>
                                    <td width="10%" align="center">Jatuh Tempo</td>
                                    <td width="20%" align="center">Jumlah</td>
                                </tr>';
                                $no = 1;
                }
                $group=$d['n_pelanggan'];

                if($urut==500){
                    $no=0;
                    echo "<div class='pagebreak'> </div>";
                }

                $return['data'] .= '<tr>
                                        <td style="text-align:center;" style="">' . $no . '</td>
                                        <td style="text-align:left;" style="">' . $d['reff'] . '</td>
                                        <td style="text-align:left;" style="">' . $d['n_penjualan']. '</td>
                                        <td style="text-align:center;" style="">' . $d['tanggal'] . '</td>
                                        <td style="text-align:center;" style="">' . $d['keterangan'] . '</td>
                                        <td style="text-align:center;" style="">' . $d['tempo'] . '</td>
                                        <td style="text-align:right;" style="">Rp ' . number_format($d['sisa']) . '</td>
                                    </tr>';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function pdf_piutang_detail()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tglawal');
        $param['tgl_sampai'] = $this->input->get('tglakhir');
        $x['tanggal_awal'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tanggal_akhir'] = $this->tanggalindo->konversi($param['tgl_sampai']);

        $x['judul_title'] = 'Laporan Piutang Detail';
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $piutang = $this->M_laporan->getDataPiutangDetail($param);
        $x['data'] = $piutang;

        $filename = 'piutang-detail-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('laporan/lap_piutang_detail', $filename, $x, $download);
    }
}