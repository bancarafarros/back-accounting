<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/icon-itsk.png'); ?>">
    <title>Laporan Persediaan</title>
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
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN DAFTAR BARANG</h4></center><br/></td>
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
        <th style="text-align:center;">Nama Barang</th>
        <th style="text-align:center;">Kode Barang</th>
        <th style="text-align:center;">Normal Unit</th>
        <th style="text-align:center;">Big Unit</th>
        <th style="text-align:center;">Konversi</th>
        <th style="text-align:center;">Harga Jual</th>
    </tr>
</thead>
<tbody>
<?php
$no=1;
   foreach ($data as $key => $value) {
    $harga = number_format($value->harga_jual1);
?>
    <tr>
        <td style="text-align:center;"><?=$no++?></td>
        <td style="text-align:left;"><?=$value->nama?></td>
        <td style="text-align:left;"><?=$value->n_barang?></td>
        <td style="text-align:left;"><?=$value->n_unit?></td>
        <td style="text-align:left;"><?=$value->b_unit?></td>
        <td style="text-align:left;"><?=$value->konversi_unit?></td>
        <td style="text-align:right;"><?=$harga?></td>
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