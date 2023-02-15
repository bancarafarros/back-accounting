<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasok extends BaseController
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
        array_push($this->bread, ['title' => 'Pemasok', 'url' => site_url('report/pemasok')]);
    }
    
    public function index()
    {
        $title = 'laporan';
        $this->data['judul_title'] = $title;
        $this->render('index');
    }

    public function daftar_pemasok()
    {
        $tanggal = date('Y-m-d');
        $this->data['tanggal'] = $tanggal;
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $title = 'Daftar Pemasok';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pemasok/js/pemasok.js'];
        $this->render('daftar_pemasok');
    }
    
    public function daftar_pemasok_data()
    {
        $tanggal = $this->input->post('tanggal');
        $return['tanggal'] = $tanggal;
        $return['tanggalindo'] = $this->tanggalindo->konversi($tanggal);
        
        $title = 'Daftar Pemasok';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);

        $result = $this->M_laporan->getDataPemasok($tanggal)->result_array();

        if(empty($result)){
            $return['data'] = '<h2 style="text-align:center;" class="text-danger">Tidak ada pemasok di tanggal tersebut</h2>';
        }else{
            $no= 0;
            $return['data'] = null;
            $return['data'] .= '<table class="table table-bordered">';
            $return['data'] .= '<thead>
            <tr class="bg-success"><th class="text-white">No</th><th class="text-white">Kode Pemasok</th><th class="text-white">Nama Pemasok</th><th class="text-white">Tanggal Registrasi</th><th class="text-white">Alamat</th><th class="text-white">Telepon</th><th class="text-white">Email</th><th class="text-white">Batas Kredit</th>
            </tr>
            </thead>';

            foreach($result as $d){
                $no++;
                $batas_kredit = number_format($d['batas']);
                $return['data'] .= '    
                    <tbody>
                    <tr>
                    <td>' . $no . '</td>
                    <td>' . $d['n_pemasok'] . '</td>
                    <td>' . $d['nama'] . '</td>
                    <td>' . $d['tanggal'] . '</td>
                    <td>' . $d['alamat'] . '</td>
                    <td>' . $d['telepon'] . '</td>
                    <td>' . $d['email'] . '</td>
                    <td>Rp. ' . $batas_kredit . '</td>
                    </tr>
                    </tbody>
                ';
            }
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function daftar_pemasok_pdf(){
        $this->load->library('Dom_pdf', 'dom_pdf');
        $tanggal = $this->input->get('tgl');
        $x['judul_title'] = 'Daftar Pemasok';
        $x['tanggal_indo'] = $this->tanggalindo->konversi($tanggal);
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $pemasok = $this->M_laporan->getDataPemasok($tanggal);

        $x['data'] = $pemasok->result();
        
        $filename = 'Daftar Pemasok-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('laporan/lap_daftar_pemasok', $filename, $x, $download);
    }
    

    public function hutang_global()
    {
        $tanggal = date('Y-m-d');
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = 'Hutang Global';
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pemasok/js/hutang_global.js'];
        $this->render('hutang_global');
    }

    public function hutang_global_data()
    {
        $x = $this->input->post();
        $param['tgl_dari'] = $x['tanggal_awal'];
        $param['tgl_sampai'] = $x['tanggal_akhir'];
        $result = $this->M_laporan->getDataHutangGlobal($param)->result_array();
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        if(empty($result)){
            $return['data'] = '<h2 style="text-align: center;" class="text-danger">Tidak ada Hutang di periode tanggal tersebut</h2>';
        }else{
            $return['data'] = null;
            $return['data'] .= '<table class="table table-bordered">';
            $return['data'] .= '<thead>
            <tr class="bg-success">
                <th class="text-white">No</th>
                <th class="text-white">Kode Pemasok</th>
                <th class="text-white">Nama Pemasok</th>
                <th class="text-white" style="text-align:right;">Jumlah</th>
            </tr>
            </thead>';
            $no = 0;
            $total = 0;
            foreach($result as $d){
                $no++;
                $jumlah = number_format($d['sisa']);
                $total += $d['sisa'];
                $return['data'] .= '<tbody>
                        <tr>
                            <td>' . $no . '</td>
                            <td>' . $d['n_pemasok'] . '</td>
                            <td>' . $d['nama_pemasok'] . '</td>
                            <td style="text-align:right;">' . $jumlah . '</td>
                        </tr>
                        </tbody>';
            }
            $return['data'] .= '<tfoot>
            <tr>
                <td colspan="3" style="text-align:right;"><b>Total</b></td>
                <td style="text-align:right;"><b>Rp. ' . number_format($total) . '</b></td>
            </tr>
            </tfoot>';
            $return['data'] .= '</table>';
        }
        echo json_encode($return);
    }

    public function hutang_global_pdf(){
        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tgl_awal');
        $param['tgl_sampai'] = $this->input->get('tgl_akhir');
        $x['tanggal_awal'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tanggal_akhir'] = $this->tanggalindo->konversi($param['tgl_sampai']);

        $x['judul_title'] = 'Laporan Hutang Global';
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $hutang = $this->M_laporan->getDataHutangGlobal($param);
        $x['data'] = $hutang->result();

        $filename = 'Hutang Global-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('laporan/lap_hutang_global', $filename, $x, $download);
    }

    public function hutang_detail()
    {
        $this->data['tanggal'] = date('Y-m-d');
        $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
        $title = "Detail Hutang";
        $this->data['judul_title'] = $title;
        array_push($this->bread, ['title' => $title]);
        $this->data['scripts'] = ['report/pemasok/js/hutang_detail.js'];
        $this->render('hutang_detail');
    }

    public function hutang_detail_data()
    {
        $x = $this->input->post();
        $param['tgl_dari'] = $x['tanggal_awal'];
        $param['tgl_sampai'] = $x['tanggal_akhir'];
        $result = $this->M_laporan->getDataHutangDetail($param);
        $cek_data = $result->result_array();
        $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
        if(empty($cek_data)){
            $return['data'] = '<h2 class="text-danger" style="text-align: center;">Tidak ada transaksi hutang di periode tanggal tersebut</h2>';
        }else{
            $return['data'] = null;
            $no= 0;
            $urut=0;
            $group='-';
            $return['data'] = '<table border="1" align="center" style="width:900px;margin-bottom:20px;">';
            foreach($result->result_array() as $d){
                $kdpemasok = $d['n_pemasok'];
                $pemasok = $d['nama_pemasok'];
                $no++;
                if($group=='-' || $group!=$d['n_pemasok']){
                    $npemasok=$d['n_pemasok'];
                    $return['data'] .= '<table align="center" width="900px;" border="1">
                                <tr>
                                    <td><b>pemasok</b></td>
                                    <td colspan="4" style="text-align:center;"><b>' . $pemasok . '</b></td>
                                    <td style="text-align:center;"><b>Kode</b></td>
                                    <td style="text-align:center;">' . $kdpemasok . '</td>
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
                $group=$d['n_pemasok'];

                if($urut==500){
                    $no=0;
                    echo "<div class='pagebreak'> </div>";
                }

                $return['data'] .= '<tr>
                <td style="text-align:center;" style="">' . $no . '</td>
                <td style="text-align:left;" style="">' . $d['reff'] . '</td>
                <td style="text-align:left;" style="">' . $d['n_pembelian']. '</td>
                <td style="text-align:center;" style="">' . $d['tanggalp'] . '</td>
                <td style="text-align:center;" style="">' . $d['keterangan'] . '</td>
                <td style="text-align:center;" style="">' . $d['tempo'] . '</td>
                <td style="text-align:right;" style="">' . number_format($d['sisa']) . '</td>
                </tr><br>';
            }
            $return['data'] .= '</table>';
        }
        
        echo json_encode($return);
    }

    public function hutang_detail_pdf()
    {
        $this->load->library('Dom_pdf', 'dom_pdf');
        $param['tgl_dari'] = $this->input->get('tgl_awal');
        $param['tgl_sampai'] = $this->input->get('tgl_akhir');
        $x['tanggal_awal'] = $this->tanggalindo->konversi($param['tgl_dari']);
        $x['tanggal_akhir'] = $this->tanggalindo->konversi($param['tgl_sampai']);

        $x['judul_title'] = 'Laporan Detail Hutang';
        $x['waktu_cetak'] = date('Y-m-d H:i:s');

        $detail = $this->M_laporan->getDataHutangDetail($param);
        $x['data'] = $detail;

        $filename = 'Hutang Detail-' . date('Y-m-d His');
        $download = false;
        $this->dom_pdf->load_view('laporan/lap_hutang_detail', $filename, $x, $download);
    }

    // public function hutang_lunas()
    // {
    //     $this->data['tanggal'] = date('Y-m-d');
    //     $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
    //     $title = "Hutang Lunas";
    //     $this->data['judul_title'] = $title;
    //     array_push($this->bread, ['title' => $title]);
    //     $this->data['scripts'] = ['report/pemasok/js/hutang_lunas.js'];
    //     $this->render('hutang_lunas');
    // }

    // public function hutang_lunas_data()
    // {
    //     $x = $this->input->post();
    //     $param['tgl_dari'] = $x['tanggal_awal'];
    //     $param['tgl_sampai'] = $x['tanggal_akhir'];
    //     $result = $this->M_laporan->getDataHutangLunas($param);
    //     $cek_data = $result->result_array();
    //     $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
    //     $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
    //     if(empty($cek_data)){
    //         $return['data'] = '<h2 class="text-danger" style="text-align: center;">Tidak ada transaksi pembayaran di periode tersebut</h2>';
    //     }else{
    //         $return['data'] = null;
    //         $no= 0;
    //         $urut=0;
    //         $group='-';
    //         $return['data'] = '<table border="1" align="center" style="width:900px;margin-bottom:20px;">';
    //         foreach($result->result_array() as $d){
    //             $kdpemasok = $d['n_pemasok'];
    //             $pemasok = $d['nama_pemasok'];
    //             $no++;
    //             if($group=='-' || $group!=$d['n_pemasok']){
    //                 $npemasok=$d['n_pemasok'];
    //                 $return['data'] .= '<table align="center" width="900px;" border="1">
    //                             <tr>
    //                                 <td><b>pemasok</b></td>
    //                                 <td colspan="4" style="text-align:center;"><b>' . $pemasok . '</b></td>
    //                                 <td style="text-align:center;"><b>Kode</b></td>
    //                                 <td style="text-align:center;">' . $kdpemasok . '</td>
    //                             </tr>
    //                             <tr>
    //                                 <td><b></b></td> 
    //                                 <td colspan="4" style="text-align:left;"></td>
    //                                 <td style="text-align:right;"><b>Sub Total</b></td>
    //                                 <td style="text-align:right;"><b>-</b></td>
    //                             </tr>';
    //                 $return['data'] .= '
    //                             <tr class="bg-success">
    //                                 <td width="5%" align="center">No</td>
    //                                 <td width="15%" align="center">Nomor Reff</td>
    //                                 <td width="15%" align="center">Nomor Transaksi</td>
    //                                 <td width="10%" align="center">Tanggal</td>
    //                                 <td width="25%" align="center">Keterangan</td>
    //                                 <td width="10%" align="center">Jatuh Tempo</td>
    //                                 <td width="20%" align="center">Jumlah</td>
    //                             </tr>';
    //                             $no = 1;
    //             }
    //             $group=$d['n_pemasok'];

    //             if($urut==500){
    //                 $no=0;
    //                 echo "<div class='pagebreak'> </div>";
    //             }

    //             $return['data'] .= '<tr>
    //             <td style="text-align:center;" style="">' . $no . '</td>
    //             <td style="text-align:left;" style="">' . $d['reff'] . '</td>
    //             <td style="text-align:left;" style="">' . $d['n_pembelian']. '</td>
    //             <td style="text-align:center;" style="">' . $d['tanggalp'] . '</td>
    //             <td style="text-align:center;" style="">' . $d['keterangan'] . '</td>
    //             <td style="text-align:center;" style="">' . $d['tempo'] . '</td>
    //             <td style="text-align:right;" style="">' . number_format($d['jumlah']) . '</td>
    //             </tr><br>';
    //         }
    //         $return['data'] .= '</table>';
    //     }
    //     echo json_encode($return);
    // }

    // public function hutang_lunas_pdf()
    // {
    //     $this->load->library('Dom_pdf', 'dom_pdf');
    //     $param['tgl_dari'] = $this->input->get('tgl_awal');
    //     $param['tgl_sampai'] = $this->input->get('tgl_akhir');
    //     $x['tanggal_awal'] = $this->tanggalindo->konversi($param['tgl_dari']);
    //     $x['tanggal_akhir'] = $this->tanggalindo->konversi($param['tgl_sampai']);

    //     $x['judul_title'] = 'Laporan Hutang Lunas';
    //     $x['waktu_cetak'] = date('Y-m-d H:i:s');

    //     $detail = $this->M_laporan->getDataHutangLunas($param);
    //     $x['data'] = $detail;

    //     $filename = 'Hutang Lunas-' . date('Y-m-d His');
    //     $download = false;
    //     $this->dom_pdf->load_view('laporan/lap_hutang_lunas', $filename, $x, $download);
    // }

    // public function pembayaran_hutang()
    // {
    //     $this->data['tanggal'] = date('Y-m-d');
    //     $this->data['tanggal_indo'] = $this->tanggalindo->konversi(date('Y-m-d'));
    //     $title = "Hutang Lunas";
    //     $this->data['judul_title'] = $title;
    //     array_push($this->bread, ['title' => $title]);
    //     $this->data['scripts'] = ['report/pemasok/js/pembayaran_hutang.js'];
    //     $this->render('pembayaran_hutang');
    // }

    // public function pembayaran_hutang_data()
    // {
    //     $x = $this->input->post();
    //     $param['tgl_dari'] = $x['tanggal_awal'];
    //     $param['tgl_sampai'] = $x['tanggal_akhir'];
    //     $result = $this->M_laporan->getDataPembayaranHutang($param)->result_array();
    //     $return['tanggal_awal_indo'] = $this->tanggalindo->konversi($param['tgl_dari']);
    //     $return['tanggal_akhir_indo'] = $this->tanggalindo->konversi($param['tgl_sampai']);
    //     if(empty($result)){
    //         $return['data'] = '<h2 class="text-danger" style="text-align: center;">Tidak ada transaksi pembayaran di periode tersebut</h2>';
    //     }else{
    //         $return['data'] = null;
    //         $return['data'] .= '<thead class="bg-success">
    //         <tr>
    //             <th>No</th>
    //             <th>Nomor Transaksi</th>
    //             <th>Nomor Referensi</th>
    //             <th>Tanggal</th>
    //             <th>Keterangan</th>
    //             <th>Cara Bayar</th>
    //             <th>Bank</th>
    //             <th>Jumlah</th>
    //         </tr>
    //         </thead>';
    //         $no = 0;
            
    //         foreach($result as $d){
    //             $no++;
    //             $jumlah = number_format($d['bayar']);
    //             $pilihan_bank = '';
    //             if($d['cara_bayar'] == 'bank'){
    //                 $result_bank = $this->M_laporan->getBankByPembayaran($d['n_bayar']);
    //                 $pilihan_bank = $result_bank['nama_bank'];
    //             }

    //             $return['data'] .= '<tbody>
    //                 <tr>
    //                     <td>' . $no . '</td>
    //                     <td>' . $d['n_hutang'] . '</td>
    //                     <td>' . $d['n_pembelian'] . '</td>
    //                     <td>' . $d['tanggal'] . '</td>
    //                     <td>' . $d['keterangan'] . '</td>
    //                     <td>' . $d['cara_bayar'] . '</td>
    //                     <td>' . $pilihan_bank . '</td>
    //                     <td>' . $jumlah . '</td>
    //                 </tr>
    //             </tbody>';
    //         }
    //     }
    //     echo json_encode($return);
    // }

    // public function pembayaran_hutang_pdf()
    // {
    //     $this->load->library('Dom_pdf', 'dom_pdf');
    //     $param['tgl_dari'] = $this->input->get('tgl_awal');
    //     $param['tgl_sampai'] = $this->input->get('tgl_akhir');
    //     $x['tanggal_awal'] = $this->tanggalindo->konversi($param['tgl_dari']);
    //     $x['tanggal_akhir'] = $this->tanggalindo->konversi($param['tgl_sampai']);

    //     $x['judul_title'] = 'Laporan Pembayaran Hutang';
    //     $x['waktu_cetak'] = date('Y-m-d H:i:s');

    //     $detail = $this->M_laporan->getDataPembayaranHutang($param);
    //     $x['data'] = $detail;

    //     $filename = 'Pembayaran Hutang-' . date('Y-m-d His');
    //     $download = false;
    //     $this->dom_pdf->load_view('laporan/lap_pembayaran_hutang', $filename, $x, $download);
    // }
}
