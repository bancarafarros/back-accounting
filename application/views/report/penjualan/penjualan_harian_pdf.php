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
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PENJUALAN HARIAN</h4>
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
                        echo "</table><br>";
                        echo '<table align="center" width="650px;" border="1">';
                        echo '<tr><td><b>Nomor</b></td><td colspan="5" style="text-align:left;">: ' . '<b>' . $npenjualan . '</b></td><td style="text-align:right;"><b>Tanggal</b></td><td style="text-align:left;"> : ' . $tanggal_jual . '</td></tr>';
                        echo '<tr>
                        <td><b>Pelanggan</b></td> <td colspan="5" style="text-align:left;">: ' . $pelanggan . '</td>
                        <td style="text-align:right;"><b>Cara Bayar</b>
                        </td><td style="text-align:left;">: ' . $bayar . '</td></tr';
                        echo '<tr><td><b>Sales</b></td> <td colspan="5" style="text-align:left;">: ' . $sales . '</td><td style="text-align:right;"><b>Total</b></td><td style="text-align:right;"><b>' . currencyIDR($total) . '</b></td></tr>';
                        echo '<tr class="bg-success text-light">
                        <td width="3%" align="center">No</td>
                        <td width="10%" align="center">Kode Barang</td>
                        <td width="40%" align="center">Nama Barang</td>
                        <td width="5%" align="center">Qty</td>
                        <td width="5%" align="center">Satuan</td>
                        <td width="12%" align="center">Harga Jual</td>
                        <td width="10%" align="center">Diskon</td>
                        <td width="12%" align="center">Subtotal</td>
                        </tr>';
                        $nomor = 1;
                    }
                    $group = $d['n_penjualan'];
                    if ($urut == 500) {
                        $nomor = 0;
                        echo "<div class='pagebreak'> </div>";
                    }
                ?>
                    <tr>
                        <td style="text-align:center;"><?= $nomor ?></td>
                        <td style="text-align:left;"><?= $d['kdbarang'] ?></td>
                        <td style="text-align:left;"><?= $d['nama_barang'] ?></td>
                        <td style="text-align:center;"><?= $d['jumlahnya'] ?></td>
                        <td style="text-align:center;"><?= $d['satuanbrg'] ?></td>
                        <td style="text-align:right;"><?= currencyIDR($hargaasli) ?></td>
                        <td style="text-align:center;"><?= $d['diskon'] ?>%</td>
                        <td style="text-align:right;"><?= currencyIDR($subtotal) ?></td>
                    </tr>
            </table>
        <?php
                }
        ?>
        </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>