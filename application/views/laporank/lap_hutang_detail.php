<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Laporan Pemasok</title>
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
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN HUTANG DETAIL</h4></center><br/></td>
</tr>
                       
</table>

<table border="0" align="center" style="width:900px;border:none;">
    <?php
    $date = new DateTime("now");
    $curr_date = $date->format('d-M-Y');
    ?>
        <tr>
            <th style="text-align:left">Periode :  <?php echo $curr_date;?></th>
        </tr>
</table>

<table border="1" align="center" style="width:900px;margin-bottom:20px;">
<?php
    $urut=0;
    $nomor=0;
    $group='-';
  foreach($data->result_array()as $d){
    $nomor++;
    $urut++;

    $kdpemasok = $d['n_pemasok'];
    $pemasok = $d['nama_pemasok'];

    if($group=='-' || $group!=$d['n_pemasok']){
        $npemasok=$d['n_pemasok'];

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d ');

        $this->db->select('hutang.*, SUM(sisa) as total, pemasok.nama as nama_pemasok');
        /*$this->db->select_sum('sisa');*/
        $this->db->join('pemasok','pemasok.n_pemasok = hutang.n_pemasok');
        $this->db->from('hutang');
        $this->db->group_by('n_pemasok');
        $this->db->where('hutang.statusA = "b"');
        $this->db->where('hutang.tanggal <=',$curr_date);
        $this->db->where('hutang.n_pemasok',$npemasok);
        $t = $this->db->get();
        /*return $t;

        $tots=$t['total'];  */      

     if($group!='-')

        echo "</table><br>";
        echo "<table align='center' width='900px;' border='1'>";
        echo "<tr><td><b>pemasok</b></td><td colspan='4' style='text-align:left;'>".': '."<b>$pemasok</b></td><td style='text-align:right;'><b>Kode</b></td><td style='text-align:left;'>".': '."$kdpemasok</td></tr>";
        echo "<tr><td><b></b></td> <td colspan='4' style='text-align:left;'></td><td style='text-align:right;'><b>Sub Total</b></td><td style='text-align:right;'><b>-</b></td></tr>";
echo "<tr style='background-color:#ccc;'>
    <td width='5%' align='center'>No</td>
    <td width='15%' align='center'>Nomor Reff</td>
    <td width='15%' align='center'>Nomor Transaksi</td>
    <td width='10%' align='center'>Tanggal</td>
    <td width='25%' align='center'>Keterangan</td>
    <td width='10%' align='center'>Jatuh Tempo</td>
    <td width='20%' align='center'>Jumlah</td>
    
    </tr>";
$nomor=1;
    }
    $group=$d['n_pemasok'];
        if($urut==500){
        $nomor=0;
            echo "<div class='pagebreak'> </div>";
            }
        ?>
    <tr>
        <td style="text-align:center;" style=""><?php echo $nomor;?></td>
        <td style="text-align:left;" style=""><?=$d['reff']?></td>
        <td style="text-align:left;" style=""><?=$d['n_pembelian']?></td>
        <td style="text-align:center;" style=""><?=$d['tanggalp']?></td>
        <td style="text-align:center;" style=""><?=$d['keterangan']?></td>
        <td style="text-align:center;" style=""><?=$d['tempo']?></td>
        <td style="text-align:right;" style=""><?php echo number_format($d['sisa']);?></td>
    </tr>
<?php
}
?>
</table>

</table><table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
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