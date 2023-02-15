<html lang="en" moznomarginboxes mozdisallowselectionprint>
<?php 
    $b=$data->row_array();
    $conv_date = strtotime($b['tanggal']);
    $tanggal = date('d-M-Y',$conv_date);
?>
<head>
    <title><?php echo $b['n_rpembelian'];?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=base_url('assets/css/laporan.css'); ?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table border="0" align="center" style="width:700px;border:none;">
    <!-- <tr>
        <td><img src="<?php echo base_url('assets/more/logo-koperasi.png'); ?>"/></td>
    </tr> -->
</table>
<table border="0" align="center" style="width:700px;border:none;">
    <tr>
        <td colspan="1" style="width:800px;paddin-left:20px;"><h2 style="margin-bottom:1px;"><?=$b['n_perusahaan'];?></h2><?=$b['a_perusahaan'];?> | <?=$b['telp_perusahaan'];?></td>
        <td colspan="1" style="width:800px;paddin-left:20px; padding-top:5px;" align="right"><h1># NOTA RETUR PEMBELIAN</h1><br/></td>
    </tr>
</table>
<table border="0" align="center" style="width:700px;border:none;">
        <tr>
            <th width="25%" style="text-align:left;"><b>Nomor Transaksi</b></th>
            <td style="text-align:left;">: <?php echo $b['n_rpembelian'];?></td>
            <th style="text-align:left;">Pemasok</th>
            <td style="text-align:left;">: <?php echo $b['namapemasok'];?></td>
        </tr>
        <tr>
            <th style="text-align:left;">Tanggal</th>
            <td style="text-align:left;">: <?php echo $tanggal;?></td>
            <th style="text-align:left;">Cara Bayar</th>
            <td style="text-align:left;">: <?php echo $b['cara_bayar'];?></td>
        </tr>
        <tr>
            <th style="text-align:left;">Keterangan</th>
            <td style="text-align:left;">: <?php echo $b['keterangan'];?></td>
        </tr>
</table>

<table border="1" align="center" style="width:700px; margin-top:10px;margin-bottom:10px;">
<thead>

    <tr style="background-color:#ccc;">
        <th style="width:50px;">No</th>
        <th>Nama Barang</th>
        <th>Satuan</th>
        <th>Harga Beli</th>
        <th>Qty</th>
        <th>SubTotal</th>
    </tr>
</thead>
<tbody>
<?php
$no=0;
   foreach($data->result_array()as $i) {
        $no++;
        $nabar=$i['nama_barang'];
        $satuan=$i['sat'];
        
        $harjul=$i['harganya'];
        $qty=$i['jumlahnya'];

        $total=$i['hargad'] * $i['jumlahnya'];
?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <td style="text-align:left;"><?php echo $nabar;?></td>
        <td style="text-align:center;"><?php echo $satuan;?></td>
        <td style="text-align:right;"><?php echo 'Rp '.number_format($harjul);?></td>
        <td style="text-align:center;"><?php echo $qty;?></td>
        <td style="text-align:right;"><?php echo 'Rp '.number_format($total);?></td>
    </tr>
<?php }?>
</tbody>
<tfoot>
    <tr>
        <td colspan="5" style="text-align:right;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php echo 'Rp '.number_format($b['total_pembelian']);?></b></td>
    </tr>
</tfoot>
</table>
<table align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td colspan="5"></td>
        <td style="padding-left:10%;"><b>Biaya Kirim</b></td>
        <td style="text-align:right; padding-right:5px;"><?php echo 'Rp. '.number_format($b['biaya_kirim']);?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td style="padding-left:10%;"><b>PPN</b></td>
        <td style="text-align:right; padding-right:5px;"><?php echo 'Rp. '.number_format($b['ppn']);?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td style="padding-left:10%;"><b>Total Seluruhnya</b></td>
        <td style="text-align:right; border-top:1px dashed; padding-right:5px;"><?php
        $totalAll = $b['biaya_kirim'] + $b['ppn'] + $b['total_pembelian'];
            echo 'Rp. '.number_format($totalAll);?>
        </td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td style="padding-left:10%;"><b>Jumlah Bayar</b></td>
        <td style="text-align:right; padding-right:5px;"><?php
        $totalByr = $totalAll - @$b['hutang']; 
            echo 'Rp. '.number_format($totalByr);?>
        </td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td style="padding-left:10%;"><b>Sisa Bayar</b></td>
        <td style="text-align:right; padding-right:5px; border-top:1px dashed;"><?php echo 'Rp. '.number_format(@$b['hutang']);?>
        </td>
    </tr>
   <tr>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;">Mengetahui :</td>
        <td colspan="3" style="text-align:right;padding-bottom:60px;padding-top:30px;padding-right:5%;">Diperiksa Oleh :</td>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;padding-left:8%;">Diterima Oleh  :</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;">( ................................. )</td>
        <td colspan="3" style="text-align:right;padding-right:2.5%;">( ................................. )</td>
        <td colspan="2" style="text-align:center;padding-left:8%;">( ................................. )</td>
    </tr>
    <tr>    
        <td colspan="6" style="text-align:right;padding-top:20px;"><small>Dicetak Tanggal : <?php echo date('d-M-Y')?></small></td>
        <td style="text-align:right; padding-top:20px;"><small>Oleh :<?php echo $this->session->userdata("user_name");?></small></td>
    </tr>
</table>
<!-- <table align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <th><br/><br/></th>
    </tr>
    <tr>
        <th align="left"></th>
    </tr>
</table> -->
</div>
</body>

</html>