<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/icon-itsk.png'); ?>">
    <title>Laporan Buku Besar</title>
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

<table border="0" align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:900px;paddin-left:20px;"><center><h4>LAPORAN BUKU BANTU SELURUH PERKIRAAN</h4></center><br/></td>
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
            <th style="text-align:left">Periode : <b><?php echo $tanggal1;?> - <?php echo $tanggal2;?></b></th>
        </tr>
</table>

<table border="1" align="center" style="width:900px;">
<?php
    $urut=0;
    $nomor=0;
    $totaldebet=0;
    $totalkredit=0;
    $group='-';
  foreach($data->result_array()as $d){
    $nomor++;
    $urut++;
    $tglj = strtotime($d['tanggal_jurnal']);
    $tanggaljur = date('d-M-Y',$tglj);
    $debet = $d['debet_jurnal'];
    $kredit = $d['kredit_jurnal'];
    $noakun = $d['akun_jurnal'];
    $namaakun = $d['nama_akun'];
    $totaldebet += $d['debet_jurnal'];
    $totalkredit += $d['kredit_jurnal'];

    if($group=='-' || $group!=$d['akun_jurnal']){
        echo "</table><br>";
        echo "<table align='center' width='900px;' style='border:none;border-top:1px solid;'";
        echo "<tr style='border-top:1px solid;'><td><b>Nomor Akun</b></td><td colspan='2' style='text-align:left;'>".': '."<b>$noakun</b></td><td style='text-align:right;'><b>Nama Akun</b></td><td colspan='2' style='text-align:left;'>".': '."<b>$namaakun</b></td></tr>";
        /*echo "<tr><td colspan='4' style='text-align:right;'><b>Total</b></td><td style='text-align:right;'><b>".number_format($totaldebet)."</b></td><td style='text-align:right;'><b>".number_format($totalkredit)."</b></td></tr>";*/
        echo "<tr style='border-bottom:1px solid;background-color:#ccc;'>
            <td width='10%' align='center'>Tanggal</td>
            <td width='10%' align='center'>Nomor Jurnal</td>
            <td width='40%' align='center'>Keterangan</td>
            <td width='10%' align='center'>No. Referensi</td>
            <td width='15%' align='center'>Debet</td>
            <td width='15%' align='center'>Kredit</td>
    </tr>";
    }
    $group=$d['akun_jurnal'];
        /*$totaldbt=0;
        $totalkdt=0;
        if($urut==500){
        $nomor=0;
        $totaldbt+=$d['debet_jurnal'];
        $totalkdt+=$d['kredit_jurnal'];*/
        ?>
    <tr>
        <td style="text-align:center;" style=""><?=$tanggaljur?></td>
        <td style="text-align:left;padding-right: 5px;" style=""><?=$d['njurnal']?></td>
        <td style="text-align:left;" style=""><?=$d['ket']?></td>
        <td style="text-align:center;" style=""><?=$d['reff']?></td>
        <td style="text-align:right;" style=""><?php echo number_format($debet,2,",",".");?></td>
        <td style="text-align:right;" style=""><?php echo number_format($kredit,2,",",".");?></td>
    </tr>
<?php
}
?>
</table>

</table>
<table align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:20px;">
   <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td width="10%" style="text-align:right;border-top: 1px solid;">Total</td>
        <td width="15%"style="text-align:right;border-top: 1px solid;"><b>
            <?php echo number_format($totaldebet,2,",",".");?></b>
        </td>
        <td width="15%"style="text-align:right;border-top: 1px solid;"><b>
            <?php echo number_format($totalkredit,2,",",".");?></b>
        </td>
    </tr>
    <!-- <tr>
        <td colspan="4"></td>
        <td width="10%" style="text-align:right;color:red;">Mutasi</td>
        <td width="15%"style="text-align:right;"><b>
            <?php echo number_format($totaldebet - $totalkredit);?></b>
        </td>
    </tr> -->
</table>
<table align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:5px;">
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
<table align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:20px;">
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