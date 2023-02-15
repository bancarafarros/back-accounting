<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/icon-itsk.png'); ?>">
    <title>Laporan Penjualan</title>
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
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN PENJUALAN BEST BUY</h4></center><br/></td>
</tr>
                       
</table>
<?php
    $param=$this->input->post();

    $conv_date1 = strtotime($param['tgl_dari']);
    $conv_date2 = strtotime($param['tgl_sampai']);
    $tanggal1 = date('d-M-Y',$conv_date1);
    $tanggal2 = date('d-M-Y',$conv_date2);
?>
<table border="0" align="center" style="width:900px;border:none;margin-bottom:5px;">
        <tr>
            <th style="text-align:left">Periode : <?php echo $tanggal1." Sampai ".$tanggal2;?></th>
        </tr>
</table>
<table border="1" align="center" style="width:900px;margin-bottom:5px;">
<thead>
    <tr style="background-color:#ccc;">
        <!-- <th style="text-align:left;">No.</th> -->
        <th style="text-align:center;">Frekuensi</th>
        <th style="text-align:left;">Kode Barang</th>
        <th style="text-align:left;">Nama Barang</th>
        <th style="text-align:center;">Jual</th>
        <th style="text-align:center;">Satuan</th>
        <th style="text-align:center;">Total Nilai</th>
    </tr>
</thead>
<tbody>
<?php
/*$no=0;*/
$total=0;
$grandtotal=0;
   foreach ($data as $key => $value) {
    /*$no++;*/
    $total = $value->keluar * $value->hargakm;
    $grandtotal += $total;
?>
    <tr>
        <!-- <td style="text-align:left;"><?=$no?></td> -->
        <td style="text-align:center;"><b><?=$value->frekuensi." X"?></b></td>
        <td style="text-align:left;"><?=$value->n_barang?></td>
        <td style="text-align:left;"><?=$value->nama_barang?></td>
        <td style="text-align:center;"><?=$value->keluar?></td>
        <td style="text-align:center;"><?=$value->satuankm?></td>
        <td style="text-align:right;"><?='Rp '.number_format($total)?></td>
    </tr>
<?php }?>
</tbody>
<tr>
       <td colspan="5" style="text-align:right;"><b>Grand Total :</b></td> 
       <td style="text-align:right;"><b><?='Rp '.number_format($grandtotal)?></b></td> 
    </tr>
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