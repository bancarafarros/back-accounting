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
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PERSEDIAAN BARANG PER GRUP</h4>
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
                    $harga = number_format($d['harga_pokok'], 2, ",", ".");
                    /*$grandtotal += $d['total_penjualan'];*/
                    $subtotal = $d['harga_pokok'] * $d['stock_gudang'];
                    $tgl = strtotime($d['tanggal']);
                    $tanggal = date('d-M-Y', $tgl);

                    if ($group == '-' || $group != $d['n_barang']) {
                        $this->db->select('keluar_masuk.*, barang_grup.n_grup as n_grup, barang_grup.grup as grup,barang.stock_gudang as stock_gudang,barang.n_unit as n_unit, barang.harga_pokok as harga_pokok,  tanggal');
                        $this->db->select_sum('masuk');
                        $this->db->like('reff');
                        $this->db->from('keluar_masuk');
                        $this->db->order_by('COUNT(reff)', 'desc');
                        $this->db->join('barang', 'barang.n_barang = keluar_masuk.n_barang');
                        $this->db->join('barang_grup', 'barang_grup.n_grup=barang.n_grup');
                        $this->db->group_by('n_grup');
                        $this->db->where('keluar = "0"');
                        $this->db->where('keluar_masuk.tanggal >=', $tgl_dari);
                        $this->db->where('keluar_masuk.tanggal <=', $tgl_sampai);
                        $this->db->order_by('n_grup', 'asc');
                        $nbarang = $d['n_grup'];
                        if ($group != '-')
                            echo "</table><br>";
                        echo "<table align='center' width='700px;' border='1'>";
                        echo "<tr><td><b>Nota</b></td><td colspan='4' style='text-align:left;'>" . ': ' . "<b>$nbarang</b></td><td style='text-align:right;'><b>Tanggal</b></td><td style='text-align:left;'>" . ': ' . "$tanggal</td></tr>";

                        echo "<tr style='background-color:#ccc;'>
    <td width='3%' align='center'>No</td>
    <td width='11%' align='center'>Kode Barang</td>
    <td width='45%' align='center'>Nama Barang</td>

    <td width='5%' align='center'>Jumlah</td>
    <td width='13%' align='center'>Satuan</td>
    <td width='13%' align='center'>HPP</td>
    <td width='30%' align='center'>Total</td>
    
    </tr>";

                        $nomor = 1;
                    }
                    $group = $d['n_grup'];
                    if ($urut == 500) {
                        $nomor = 0;
                        echo "<div class='pagebreak'> </div>";
                    }
                ?>
                    <tr>
                        <td style="text-align:center;" style=""><?php echo $nomor; ?></td>
                        <td style="text-align:left;" style=""><?= $d['n_grup'] ?></td>
                        <td style="text-align:left;" style=""><?= $d['grup'] ?></td>
                        <td style="text-align:center;" style=""><?= $d['stock_gudang'] ?></td>
                        <td style="text-align:center;" style=""><?= $d['n_unit']  ?></td>
                        <td style="text-align:center;" style=""><?= $harga . "" ?></td>

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