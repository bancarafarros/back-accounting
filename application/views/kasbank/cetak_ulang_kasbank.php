<html lang="en" moznomarginboxes mozdisallowselectionprint>
<?php 
    $b=$data->row_array();
    //print_r($data);
    $conv_date = strtotime($b['tanggal']);
    $tanggal = date('d-M-Y',$conv_date);
    if (@$b['n_bank'] == "KAS") {
        $jenis = "KAS";
    } else {
        $jenis = "BANK";
    }

    if ($b['statusA'] == 'M') {
        $trx = "MASUK";
    }
    if ($b['statusA'] == 'K') {
        $trx = "KELUAR";
    }
?>
<head>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/icon-itsk.png'); ?>">
    <title><?php echo $b['n_kasbank'];?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=base_url('assets/css/laporan.css'); ?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table border="0" align="center" style="width:700px;border:none;">
    <tr>
        <td colspan="1" style="width:800px;paddin-left:20px;"><h1 style="margin-bottom:1px;"><?=$b['n_perusahaan'];?></h1><?=$b['a_perusahaan'];?> | <?=$b['telp_perusahaan'];?></td>
        <td colspan="1" style="width:800px;paddin-left:20px; padding-top:5px;" align="right"><h1># TRANSAKSI <?=$jenis?></h1></td>
    </tr>
    <tr>
        <td colspan="1"></td>
        <td colspan="1" style="width:800px;paddin-left:20px; padding-top:5px;" align="right"><h3>No. <?=$b['n_kasbank']?></h3></td>
    </tr>
</table>
<table border="0" align="center" style="width:700px;border:none; border-top:1px dashed;">
        <tr>
            <th width="25%" style="text-align:left;"><b>Jenis Transaksi</b></th>
            <th style="text-align:left;">: <?=$jenis.' '.$trx?></th>
            <th style="text-align:left;"><b>Tanggal</b></th>
            <td style="text-align:left;">: <?=$tanggal?></td>
        </tr>
        <tr>
            <th style="text-align:left;">Reff</th>
            <td style="text-align:left;">: <?php echo $b['reff'];?></td>
            <?php if ($jenis == "BANK") {
                echo '<th width="25%" style="text-align:left;"><b>Nama Bank</b></th>
                <td style="text-align:left;">: '.strtoupper($b['nama_bank']).'</td>';
            }
            ?>
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
        <th>Akun</th>
        <th>Nama Akun</th>
        <th>Nominal</th>
    </tr>
</thead>
<tbody>
<?php
$totDiskon = 0; 
$no=0;
   foreach($data->result_array()as $i) {
        $no++;
        if ($trx == "MASUK") {
            $nom = $i['dkredit'];
        }  
        if ($trx == "KELUAR") {
            $nom = $i['ddebet'];
        }
?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <td style="text-align:left;"><?php echo $i['noPerkiraan'];?></td>
        <td style="text-align:left;"><?php echo $i['namaPerkiraan'];?></td>
        <td style="text-align:right;"><?php echo 'Rp '.number_format($nom);?></td>
<?php }?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3" style="text-align:right;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php echo 'Rp '.number_format($b['jumlah']);?></b></td>
    </tr>
</tfoot>
</table>
<table align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;">Mengetahui :</td>
        <td colspan="3" style="text-align:center;padding-bottom:60px;padding-top:30px;">Diperiksa Oleh :</td>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;">Diterima Oleh  :</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;">( ................................. )</td>
        <td colspan="3" style="text-align:center;">( ................................. )</td>
        <td colspan="2" style="text-align:center;">( ................................. )</td>
    </tr>
    <tr>    
        <td colspan="6" style="text-align:right;padding-top:20px;"><small>Dicetak Tanggal : <?php echo date('d-M-Y')?> | Oleh :<?php echo $this->session->userdata("user_name");?></small></td>
    </tr>
</body>
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
</html>