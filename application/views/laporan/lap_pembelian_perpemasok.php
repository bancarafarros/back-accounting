<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Laporan Pembelian</title>
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
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN PEMBELIAN PER PEMASOK</h4></center><br/></td>
</tr>
                       
</table>
<?php
    $param=$this->input->post();

    $conv_date1 = strtotime($param['tgl_dari']);
    $conv_date2 = strtotime($param['tgl_sampai']);
    $tanggal1 = date('d-M-Y',$conv_date1);
    $tanggal2 = date('d-M-Y',$conv_date2);
?>
<table border="0" align="center" style="width:900px;border:none;">
        <tr>
            <th style="text-align:left">Tanggal : <?php echo $tanggal1."   Sampai   ".$tanggal2;?></th>
        </tr>
</table>
<table border="1" align="center" style="width:900px;margin-bottom:20px;">
<thead>
    <tr style="background-color:#ccc;">
        <th style="text-align:left;">No.</th>
        <th style="text-align:center;">Kode</th>
        <th style="text-align:center;">Nama</th>
        <th style="text-align:center;">Pembelian</th>
        <th style="text-align:center;">PPN</th>
        <th style="text-align:center;">Biaya Kirim</th>
        <th style="text-align:center;">Total</th>
        <th style="text-align:center;">Bayar</th>
        <th style="text-align:center;">Hutang</th>
    </tr>
</thead>
<tbody>
<?php
$no=0;
$total=0;
$bayar=0;
$totalpembelian=0;
$totalppn=0;
$totalbiaya=0;
$totaltotal=0;
$totalbayar=0;
$totalhutang=0;
   foreach ($data as $key => $value) {
    $no++;
    $total = $value->total_pembelian + $value->ppn + $value->biaya_kirim;
    $bayar = $value->total_pembelian - $value->hutang;
    $totalpembelian += $value->total_pembelian;
    $totalppn += $value->ppn;
    $totalbiaya += $value->biaya_kirim;
    $totaltotal += $total;
    $totalbayar += $bayar;
    $totalhutang += $value->hutang;
?>
    <tr>
        <td style="text-align:left;"><?=$no?></td>
        <td style="text-align:left;"><?=$value->npemasok?></td>
        <td style="text-align:left;"><?=$value->namapemasok?></td>
        <td style="text-align:right;"><?=number_format($value->total_pembelian)?></td>
        <td style="text-align:right;"><?=number_format($value->ppn)?></td>
        <td style="text-align:right;"><?=number_format($value->biaya_kirim)?></td>
        <td style="text-align:right;"><?=number_format($total)?></td>
        <td style="text-align:right;"><?=number_format($bayar)?></td>
        <td style="text-align:right;"><?=number_format($value->hutang)?></td>
    </tr>
<?php }?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3" style="text-align:right;"><b>Grand Total</b></td>
        <td style="text-align:right;"><b><?php echo number_format($totalpembelian);?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($totalppn);?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($totalbiaya);?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($totaltotal);?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($totalbayar);?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($totalhutang);?></b></td>
    </tr>
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
        <td colspan="5" style="text-align:right;padding-top:20px;"><small>Dicetak Tanggal : <?php echo date('d-M-Y')?> Jam: <?php echo date('h:i:s')?></small></td>
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