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
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PIUTANG GLOBAL</h4>
            <p class="text-center">Periode: <b><?= $tanggal_awal ?></b> - <b><?= $tanggal_akhir ?></b></p>
        </div>
        <div>
            <table style="width:100%;" class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>No</th>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        $no=0;
                        $total=0;
                        foreach ($data as $value) {
                            $no++;
                            $jumlah = number_format($value->sisa);
                            $total += $value->sisa;
                        ?>
                            <tr>
                                <td style="text-align:center;"><?=$no?></td>
                                <td style="text-align:left;"><?=$value->n_pelanggan?></td>
                                <td style="text-align:left;"><?=$value->nama_pelanggan?></td>
                                <td style="text-align:right;"><?=$jumlah?></td>
                            </tr>
                    <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;"><b>Total</b></td>
                        <td style="text-align:right;"><b><?php echo number_format($total);?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>