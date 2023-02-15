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
            <h4 class="font-weight-bolder text-bold text-uppercase">LAPORAN PEMBAYARAN HUTANG</h4>
            <p class="text-center">Periode: <b><?= $tanggal_awal ?></b> - <b><?= $tanggal_akhir ?></b></p>
        </div>
        <div>
            <table style="width:100%;" class="table table-bordered">
                <thead>
                    <tr class="bg-success">
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Nomor Referensi</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Cara Bayar</th>
                        <th>Bank</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no=0;
                        foreach ($data->result_array() as $val) {
                            $no++;
                            $nama_bank = '';

                            if($val['cara_bayar'] == 'bank'){
                                $this->db->from('dhutang');
                                $this->db->select('n_bayar, bank.nama as nama_bank');
                                $this->db->join('bank', 'bank.n_bank = dhutang.n_bayar');
                                $this->db->where('dhutang.n_bayar = ', $val['n_bayar']);
                                $bank = $this->db->get()->row_array();
                                $nama_bank = $bank['nama_bank'];
                            }
                            $jumlah = number_format($val['bayar']);
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $val['n_hutang']; ?></td>
                                <td><?= $val['n_pembelian']; ?></td>
                                <td><?= $val['tanggal']; ?></td>
                                <td><?= $val['keterangan']; ?></td>
                                <td><?= $val['cara_bayar']; ?></td>
                                <td><?= $nama_bank; ?></td>
                                <td><?= $jumlah; ?></td>
                            </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <?php $this->load->view('template/pdf/footer'); ?>
    </div>
</body>

</html>