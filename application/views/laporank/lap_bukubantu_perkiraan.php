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
    <td colspan="2" style="width:900px;paddin-left:20px;"><center><h4>LAPORAN BUKU BANTU TIAP PERKIRAAN</h4></center><br/></td>
</tr>
                       
</table>
<?php
    $b=$data->row_array();
    $param=$this->input->post();

    $conv_date1 = strtotime($param['tgl_dari']);
    $conv_date2 = strtotime($param['tgl_sampai']);
    $tanggal1 = date('d-M-Y',$conv_date1);
    $tanggal2 = date('d-M-Y',$conv_date2);
?>
<table border="0" align="center" style="width:900px;border:none;">
        <tr>
            <th style="text-align:left">Periode : <?php echo $tanggal1;?> Sampai <?php echo $tanggal2;?></th>
        </tr>
        <tr>
            <th style="text-align:left">Nomor Perkiraan : <?php echo $b['akun_jurnal'];?></th>
        </tr>
        <tr>
            <th style="text-align:left">Nama Perkiraan : <?php echo $b['nama_akun'];?></th>
        </tr>
</table>

<table align="center" style="width:900px;margin-bottom:5px;margin-top:1px;border: none;">
    <?php
    $saldo_awal = 0;
     foreach($saldoawal->result_array()as $s){
        
        $saldo_awal =  $s['debet'] - $s['kredit'];
        
    ?>
        <tr style='border-top: 1px solid;'>
            <td width="10%" align="center">Tanggal</td>
            <td width="10%" align="center">Nomor Jurnal</td>
            <td width="38%" align="center">Keterangan</td>
            <td width="10%" align="center">No. Referensi</td>
            <td width="10%" align="center">Debet</td>
            <td width="10%" align="center">Kredit</td>
            <td width="12%" align="center">Saldo</td>
        </tr>
        <tr style="border-bottom: 1px solid;">
            <td colspan="5"></td>
            <td width="10%" align="center" style="text-align:right;color:red;">Saldo Awal</td>
            <td width="12%"style="text-align:right;color:red;"><b>
                <?php echo number_format($saldo_awal,2,",",".");?></b></td>
        </tr>
    <?php
    }
    ?>
<?php
    $urut=0;
    $nomor=0;
    $totaldebet=0;
    $totalkredit=0;
    $saldo=0;
    $group='-';
  foreach($data->result_array()as $d){
    $nomor++;
    $urut++;
    $tglj = strtotime($d['tanggal_jurnal']);
    $tanggaljur = date('d-M-Y',$tglj);
    $debet = $d['debet_jurnal'];
    $kredit = $d['kredit_jurnal'];
    $namaakun = $d['nama_akun'];
    $totaldebet += $d['debet_jurnal'];
    $totalkredit += $d['kredit_jurnal'];
    $saldo = $totaldebet - $totalkredit + $saldo_awal;

    if($group=='-' || $group!=$d['akun_jurnal']){
        echo "</table>";
        echo "<table align='center' width='900px;' style='border:5px;'>";
        /*echo "<tr><td colspan='4' style='text-align:right;'><b>Total</b></td><td style='text-align:right;'><b>".number_format($totaldebet)."</b></td><td style='text-align:right;'><b>".number_format($totalkredit)."</b></td></tr>";*/
        /*echo "<tr style='background-color:#ccc;'>
                <td width='10%' align='center'>Tanggal</td>
                <td width='10%' align='center'>Nomor Jurnal</td>
                <td width='38%' align='center'>Keterangan</td>
                <td width='10%' align='center'>No. Referensi</td>
                <td width='10%' align='center'>Debet</td>
                <td width='10%' align='center'>Kredit</td>
                <td width='12%' align='center'>Saldo</td>
            </tr>";*/
    }
    $group=$d['akun_jurnal'];
        ?>
    <tr style="padding: 1rem;">
        <td style="text-align:center;" width="10%"><?=$tanggaljur?></td>
        <td style="text-align:left;padding-right: 10px;" width="10%"><?=$d['njurnal']?></td>
        <td style="text-align:left;" width="38%"><?=$d['ket']?></td>
        <td style="text-align:center;" width="10%"><?=$d['reff']?></td>
        <td style="text-align:right;" width="10%"><?php echo number_format($debet,2,",",".");?></td>
        <td style="text-align:right;" width="10%"><?php echo number_format($kredit,2,",",".");?></td>
        <td style="text-align:right;" width="12%"><?php echo number_format($saldo,2,",",".");?></td>
    </tr>
<?php
}
?>
</table>
<table  align="center" style="width:900px;border:none;margin-top:1px;border-bottom: 1px solid;">
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td width="10%" style="text-align:right;"><b>Total:</b></td>
        <td width="10%" style="text-align:right;border-top: 1px solid;"><b>
            <?php echo number_format($totaldebet,2,",",".");?></b>
        </td>
        <td width="10%"style="text-align:right;border-top: 1px solid;"><b>
            <?php echo number_format($totalkredit,2,",",".");?></b>
        </td>
        <td width="12%" style="border-top: 1px solid;"></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td width="10%" style="text-align:right;color:blue;">Mutasi</td>
        <td width="10%"style="text-align:right;color:blue;"><b>
            <?php echo number_format(($totaldebet - $totalkredit),2,",",".");?></b>
        </td>
        <td width="12%"></td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td width="10%" style="text-align:right;color:red;">Saldo Akhir</td>
        <td width="10%"style="text-align:right;color:red;"><b>
            <?php echo number_format(($totaldebet - $totalkredit + $saldo_awal),2,",",".");?></b>
        </td>
    </tr>
</table>
<table align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:20px;">
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