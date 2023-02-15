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
    <div>
        <div style="text-align:center;">
            <br><br>
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PIUTANG DETAIL</h4>
            <p class="text-center">Periode: <b><?= $tanggal_awal ?></b> - <b><?= $tanggal_akhir ?></b></p>
        </div>
        <div>

            <table border="1" align="center" style="width:650px;margin-bottom:20px;">
                <?php
                    $urut=0;
                    $nomor=0;
                    $group='-';
                    foreach($data->result_array()as $d){
                        $nomor++;
                        $urut++;

                        $kdpelanggan = $d['n_pelanggan'];
                        $pelanggan = $d['nama_pelanggan'];

                        if($group=='-' || $group!=$d['n_pelanggan']){
                            $npelanggan=$d['n_pelanggan'];

                            echo "</table><br>";
                            echo "<table align='center' width='650px;' border='1'>";
                            echo "<tr>
                                        <td><b>Pelanggan</b></td>
                                        <td colspan='4' style='text-align:center;'><b>$pelanggan</b></td>
                                        <td style='text-align:center;'><b>Kode</b></td>
                                        <td style='text-align:center;'>$kdpelanggan</td>
                                    </tr>";
                            echo "<tr>
                                        <td><b></b></td>
                                        <td colspan='4' style='text-align:left;'></td>
                                        <td style='text-align:right;'><b>Sub Total</b></td>
                                        <td style='text-align:right;'><b>-</b></td>
                                    </tr>";
                            echo "<tr class='bg-success'>
                                        <td width='5%' align='center'>No</td>
                                        <td width='15%' align='center'>Nomor Reff</td>
                                        <td width='15%' align='center'>Nomor Transaksi</td>
                                        <td width='10%' align='center'>Tanggal</td>
                                        <td width='25%' align='center'>Keterangan</td>
                                        <td width='10%' align='center'>Jatuh Tempo</td>
                                        <td width='20%' align='center'>Jumlah</td>
                                    </tr>";
                            $nomor=1;
                        }
                        $group=$d['n_pelanggan'];
                        if($urut==500){
                            $nomor=0;
                            echo "<div class='pagebreak'> </div>";
                        }
                        ?>
                        <tr>
                            <td style="text-align:center;" style=""><?php echo $nomor;?></td>
                            <td style="text-align:left;" style=""><?=$d['reff']?></td>
                            <td style="text-align:left;" style=""><?=$d['n_penjualan']?></td>
                            <td style="text-align:center;" style=""><?=$d['tanggal']?></td>
                            <td style="text-align:center;" style=""><?=$d['keterangan']?></td>
                            <td style="text-align:center;" style=""><?=$d['tempo']?></td>
                            <td style="text-align:right;" style="">Rp <?php echo number_format($d['sisa']);?></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>