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
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PENJUALAN PER PELANGGAN DENGAN DETAIL</h4>
            <h5>Pelanggan : <b><?= $n_pelanggan->nama ?></b></h5>
            <h5>Periode : <b><?= $tgl_dari ?></b> Sampai <b><?= $tgl_sampai ?></b></h5>
        </div>
        <div id="laporan">
            <table border="1" align="center" style="width:650px;margin-bottom:20px;">
                <?php
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
                        echo "</table><br>";
                        echo "<table align='center' width='650px;' border='1'>";
                        echo "<tr><td colspan='8' style='text-align:center;'><b>No." . ' ' . "$npenjualan</b></td></tr>";
                        echo "<tr><td><b>Tanggal</b></td> <td colspan='5' style='text-align:left;'>" . ': ' . "$tanggal_jual</td><td style='text-align:right;'><b>Total:</b></td><td style='text-align:right;'><b>" . 'Rp ' . $total . "</b></td></tr>";
                        echo "<tr style='background-color:#ccc;'>
                        <td width='3%' align='center'>No</td>
                        <td width='10%' align='center'>Kode Barang</td>
                        <td width='46%' align='center'>Nama Barang</td>
                        <td width='3%' align='center'>Qty</td>
                        <td width='5%' align='center'>Satuan</td>
                        <td width='13%' align='center'>Harga Jual</td>
                        <td width='8%' align='center'>Diskon</td>
                        <td width='12%' align='center'>Subtotal</td>
                        </tr>";
                        $nomor = 1;
                    }
                    $group = $d['n_penjualan'];
                    if ($urut == 500) {
                        $nomor = 0;
                        echo "<div class='pagebreak'> </div>";
                    }
                ?>
                    <tr>
                        <td style="text-align:center;" style=""><?php echo $nomor; ?></td>
                        <td style="text-align:left;" style=""><?= $d['kdbarang'] ?></td>
                        <td style="text-align:left;" style=""><?= $d['nama_barang'] ?></td>
                        <td style="text-align:center;" style=""><?= $d['jumlahnya'] ?></td>
                        <td style="text-align:center;" style=""><?= $d['satuanbrg'] ?></td>
                        <td style="text-align:right;" style=""><?php echo 'Rp ' . $hargaasli ?></td>
                        <td style="text-align:center;" style=""><?= $d['diskon'] . " %" ?></td>
                        <td style="text-align:right;" style=""><?php echo 'Rp ' . number_format($subtotal, 2, ",", "."); ?></td>
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