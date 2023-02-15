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

<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN DAFTAR PELANGGAN</h4></center><br/></td>
</tr>
                       
</table>
 
<table border="0" align="center" style="width:900px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>
<table border="1" align="center" style="width:900px;margin-bottom:20px;">
<thead>
    <tr style="background-color:#ccc;">
        <th style="text-align:center;">No</th>
        <th style="text-align:center;">Kode Pelanggan</th>
        <th style="text-align:center;">Nama Pelanggan</th>
        <th style="text-align:center;">Tanggal Registrasi</th>
        <th style="text-align:center;">Alamat</th>
        <th style="text-align:center;">Telepon</th>
        <th style="text-align:center;">Batas Kredit</th>
        <th style="text-align:center;">Sales</th>
    </tr>
</thead>
<tbody>
<?php
$no=0;
   foreach ($data as $key => $value) {
   	$no++;
    $bataskredit = number_format($value->batas);
    $conv_date = strtotime($value->tanggal);
    $tanggal = date('d-M-Y',$conv_date);
?>
    <tr>
        <td style="text-align:center;"><?=$no?></td>
        <td style="text-align:left;"><?=$value->n_pelanggan?></td>
        <td style="text-align:left;"><?=$value->nama?></td>
        <td style="text-align:left;"><?=$tanggal?></td>
        <td style="text-align:left;"><?=$value->alamat?></td>
        <td style="text-align:left;"><?=$value->telepon?></td>
        <td style="text-align:right;"><?php echo "Rp ".$bataskredit;?></td>
        <td style="text-align:left;"><?=$value->nama_sales?></td>
    </tr>
<?php }?>
</tbody>
<tfoot>

    <!-- <tr>
        <td colspan="2" style="text-align:right;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php echo number_format($ttldebet);?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($ttlkredit);?></b></td>
    </tr> -->
</tfoot>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td></td>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <!-- <td align="right">Padang, <?php echo date('d-M-Y')?></td> -->
    </tr>
    <tr>
        <td align="right"></td>
    </tr>
   
    <tr>
    <td><br/><br/><br/><br/></td>
    </tr>    
    <tr>
        <!-- <td align="right">( <?php echo $this->session->userdata('nama');?> )</td> -->
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
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