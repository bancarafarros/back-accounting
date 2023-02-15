<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Laporan Buku Besar</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=base_url('assets/css/laporan.css'); ?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<?php
    $param=$this->input->post();

    $conv_date = strtotime($param['tgl']);
    $tanggal = date('d-M-Y',$conv_date);

    $b=$perusahaan->row_array();
?>
<table border="0" align="center" style="width:600px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <th style="width:600px;"><center>LAPORAN RUGI LABA TAHUNAN</center></th>
    </tr>
    <tr>
        <th style="width:600px;"><center><?php echo $b['nama'];?></center></th>
    </tr>
    <tr>
        <th style="width:600px;"><center>s/d <?php echo " ".$tanggal;?></center></th>
    </tr>                   
</table>


<table align="center" style="border:none;width:600px;">
    <tr style="border-top: 1PX solid;border-bottom: 1px solid;">
        <th></th>
        <th style="text-align:left;">GRUP</th>
        <th style="text-align:left;">PERKIRAAN</th>
        <th style="text-align:right;">SALDO</th>
    </tr>

<table border="0" align="center" style="border:none;width:600px;">
    <thead>
        <tr style="">
            <th colspan="4" style="text-align:left;width:600px;">Pendapatan</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $ttlpend = 0;
       foreach ($pendapatan as $key => $value) {
        
        $nilai =  ($value->t_kreditp) - ($value->t_debetp);
        $ttlpend += ($value->t_kreditp) - ($value->t_debetp);
    ?>
        <tr>
            <td style="width: 5%;"></td>
            <td style="text-align:left;width: 15%;"><?=$value->akun?></td>
            <td style="text-align:left;width: 60%;"><?=$value->nama?></td>
            <td style="text-align:right;width: 20%;"><?php echo number_format($nilai,2,",",".");?></td>
        </tr>
    <?php }?>
    </tbody>
    <tfoot>
        <tr style="">
            <td colspan="3" style="text-align:right;"><b>Total Pendapatan</b></td>
            <td style="text-align:right;border-top:1px solid;"><b><?php echo number_format($ttlpend,2,",",".");?></b></td>
        </tr>
    </tfoot>
</table>

<table border="0" align="center" style="border:none;width:600px;">
    <thead>
        <tr style="">
            <th colspan="4" style="text-align:left;width:600px;">HPP</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $ttlhpp = 0;
       foreach ($hpp as $key => $value) {
        
        $nilai = ($value->t_debetb) - ($value->t_kreditb);
        $ttlhpp += ($value->t_debetb) - ($value->t_kreditb);
    ?>
        <tr>
            <td style="width: 5%;"></td>
            <td style="text-align:left;width: 15%;"><?=$value->akun?></td>
            <td style="text-align:left;width: 60%;"><?=$value->nama?></td>
            <td style="text-align:right;width: 20%;"><?php echo number_format($nilai,2,",",".");?></td>
        </tr>
    <?php }?>
    </tbody>
    <tfoot>
        <tr style="">
            <td colspan="3" style="text-align:right;"><b>Total HPP</b></td>
            <td style="text-align:right;border-top:1px solid;"><b><?php echo number_format($ttlhpp,2,",",".");?></b></td>
        </tr>
    </tfoot>
</table>

<table border="0" align="center" style="border:none;width:600px;margin-top:5px;">
    <thead>
        <tr style="">
            <th colspan="4" style="text-align:left;width:600px;">Biaya</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $ttlbiaya = 0;
       foreach ($biaya as $key => $value) {
        
        $nilai = ($value->t_debetb) - ($value->t_kreditb);
        $ttlbiaya += ($value->t_debetb) - ($value->t_kreditb);
    ?>
        <tr>
            <td style="width: 5%;"></td>
            <td style="text-align:left;width: 15%;"><?=$value->akun?></td>
            <td style="text-align:left;width: 60%;"><?=$value->nama?></td>
            <td style="text-align:right;width: 20%;"><?php echo number_format($nilai,2,",",".");?></td>
        </tr>
    <?php }?>
    </tbody>
    <tfoot>
        <tr style="border-bottom: 1px solid;">
            <td colspan="3" style="text-align:right;"><b>Total Biaya</b></td>
            <td style="text-align:right;border-top:1px solid;"><b><?php echo number_format($ttlbiaya,2,",",".");?></b></td>
        </tr>
    </tfoot>
</table>

<table align="center" style="width:600px; border:none;margin-top:5px;margin-bottom:20px;">
   <tr style="border-bottom: 1px solid;">
        <td colspan="3" style="text-align:right;"><b>Total Laba</b></td>
        <td style="text-align:right;"><b><?php echo number_format(($ttlpend - $ttlhpp - $ttlbiaya),2,",",".");?></b></td>
    </tr>
</table>
    <tr style="border-bottom: 1px solid;"></tr>
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
        <td colspan="5" style="text-align:right;padding-top:20px;"><small>Dicetak Tanggal : <?php echo date('d-M-Y')?> Jam: <?php echo date('h:i:s')?></small></td>
        <td style="text-align:right; padding-top:20px;"><small>Oleh :<?php echo $this->session->userdata("user_name");?></small></td>
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