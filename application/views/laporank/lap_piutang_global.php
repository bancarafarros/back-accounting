<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Laporan Pelanggan</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=base_url('assets/css/laporan.css'); ?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>

<table border="0" align="center" style="width:600px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:600px;paddin-left:20px;"><center><h4>LAPORAN PIUTANG GLOBAL</h4></center><br/></td>
</tr>
                       
</table>
 
<table border="0" align="center" style="width:600px;border:none;">
    <?php
    $date = new DateTime("now");
    $curr_date = $date->format('d-M-Y');
    ?>
        <tr>
            <th style="text-align:left">Periode :  <?php echo $curr_date;?></th>
        </tr>
</table>
<table border="1" align="center" style="width:600px;margin-bottom:20px;">
<thead>
    <tr style="background-color:#ccc;">
        <th style="text-align:center;width: 10%;">No</th>
        <th style="text-align:center;width: 20%;">Kode Pelanggan</th>
        <th style="text-align:center;width: 50%;">Nama Pelanggan</th>
        <th style="text-align:center;width: 20%;">Jumlah</th>
    </tr>
</thead>
<tbody>
<?php
$no=0;
$total=0;
   foreach ($data as $key => $value) {
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
<table align="center" style="width:600px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;">Disiapkan :</td>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;">Diperiksa:</td>
        <td colspan="2" style="text-align:center;padding-bottom:60px;padding-top:30px;">Disetujui :</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;">( ................................. )</td>
        <td colspan="2" style="text-align:center;">( ................................. )</td>
        <td colspan="2" style="text-align:center;">( ................................. )</td>
    </tr>
    <tr>    
        <td colspan="5" style="text-align:right;padding-top:20px;"><small>Dicetak Tanggal : <?php echo date('d-M-Y')?> Jam: <?php echo date('h:i:s:a')?></small></td>
        <td colspan="2" style="text-align:right; padding-top:20px;"><small>Oleh :<?php echo $this->session->userdata("user_name");?></small></td>
    </tr>
</table>
<table align="center" style="width:600px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <th><br/><br/></th>
    </tr>
    <tr>
        <th align="left"></th>
    </tr>
</table>
</div>
</body>
</html>