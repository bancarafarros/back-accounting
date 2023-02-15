<!DOCTYPE html>
<html lang="in">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= FCPATH . 'public/icon-itsk.png' ?>">
    <title><?= (!empty($judul_title) ? $judul_title : 'Dokumen') ?></title>
    <link rel="stylesheet" href="<?= FCPATH . 'public/lib/bootstrap/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?= FCPATH . 'public/css/pdf.css'; ?>">
</head>

<body>
    <?php $this->load->view('template/pdf/header'); ?>
    <div class="mt-0">
        <div style="text-align:center;">
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN KAS KELUAR</h4>
            <h5>Periode : <b><?= $tgl_dari ?></b> Sampai <b><?= $tgl_sampai ?></b></h5>
        </div>
        <div id="laporan">
            <table border="1" align="center" style="width:650px;margin-bottom:20px;">
                <?php
                $urut = 0;
                $nomor = 0;
                $grandtotal = 0;
                $group = '-';
                foreach ($result as $d) {
                    $nomor++;
                    $urut++;
                    $total = $d['total_kasbank'];
                    $keterangan = $d['ket'];
                    $tgl = strtotime($d['tanggal_kasbank']);
                    $tanggal = date('d-M-Y', $tgl);

                    if ($group == '-' || $group != $d['h_nkasbank']) {
                        $nkasbank = $d['h_nkasbank'];
                        $this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.kredit as total_kredit');
                        $this->db->select_sum('dkasbank.kredit');
                        $this->db->from('hkasbank');
                        $this->db->join('dkasbank', 'dkasbank.n_kasbank = hkasbank.n_kasbank');
                        $this->db->join('coa', 'coa.akun = dkasbank.akun');
                        $this->db->where('hkasbank.tanggal >=', $tgl_dari);
                        $this->db->where('hkasbank.tanggal <=', $tgl_sampai);
                        $this->db->where('hkasbank.statusA = "M"');
                        $this->db->where('hkasbank.n_bank = "KAS"');
                        $this->db->where('dkasbank.debet >= "0"');
                        $this->db->where('hkasbank.n_kasbank', $nkasbank);
                        $data = $this->db->get();

                        $t = $data->row_array();
                        $tots = $t['total_kredit'];

                        if ($group != '-')
                            echo "</table><br>";
                        echo "<table align='center' width='700px;' border='1'>";
                        echo "<tr><td><b>No. Trans</b></td><td>" . ': ' . "<b>$nkasbank</b></td><td style='text-align:right;'>Tanggal :<b>$tanggal</b></td></tr>";
                        echo "<tr>
                <td><b>Keterangan</b></td> <td style='text-align:left;'>" . ': ' . "$keterangan</td><td style='text-align:right;'>Total :<b>" . number_format($total) . "</b></td>
            </tr>";
                        echo "<tr style='background-color:#ccc;'>
    <td width='15%' align='center'>No. Perkiraan</td>
    <td width='60%' align='center'>Nama Perkiraan</td>
    <td width='25%' align='center'>Jumlah</td>
    
    </tr>";
                        $nomor = 1;
                    }
                    $group = $d['h_nkasbank'];
                    if ($urut == 500) {
                        $nomor = 0;
                        echo "<div class='pagebreak'> </div>";
                    }
                ?>
                    <tr>
                        <td style="text-align:left;" style=""><?= $d['nomor_akun'] ?></td>
                        <td style="text-align:left;" style=""><?= $d['nama_akun'] ?></td>
                        <td style="text-align:right;" style=""><?php echo number_format($d['debet_kasbank']); ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>

            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>