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
            <h4 class="font-weight-bolder text-bold text-uppercase">DAFTAR PEMASOK</h4>
            <h5>Per : <b><?= $tanggal_indo ?></b></h5>
        </div>
        <div>
            <table style="width:100%;" class="table table-bordered">
                <tr class="bg-success">
                    <th>No</th>
                    <th>Kode Pemasok</th>
                    <th>Nama Pemasok</th>
                    <th>Tanggal Registrasi</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Batas Kredit</th>
                </tr>
                <?php
                    $no=0;
                    foreach ($data as $value) {
                        $no++;
                        $bataskredit = number_format($value->batas);
                    ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$value->n_pemasok?></td>
                            <td><?=$value->nama?></td>
                            <td><?=$value->tanggal?></td>
                            <td><?=$value->alamat?></td>
                            <td><?=$value->telepon?></td>
                            <td><?=$value->email?></td>
                            <td>Rp.<?=$bataskredit;?></td>
                        </tr>
                <?php }?>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>