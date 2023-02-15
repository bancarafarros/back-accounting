<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/icon-itsk.png'); ?>">
    <title>Laporan Kas Bank</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?=base_url('assets/css/laporan.css'); ?>"/>
</head>
<body onload="window.print()">
<div id="laporan">
<table align="center" style="width:700px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>

<table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:700px;paddin-left:20px;"><center><h4>LAPORAN KAS KELUAR</h4></center><br/></td>
</tr>
                       
</table>
<?php
    $param=$this->input->post();

    $conv_date1 = strtotime($param['tgl_dari']);
    $conv_date2 = strtotime($param['tgl_sampai']);
    $tanggal1 = date('d-M-Y',$conv_date1);
    $tanggal2 = date('d-M-Y',$conv_date2);
?>
<table border="0" align="center" style="width:700px;border:none;">
        <tr>
            <th style="text-align:left">Dari Tanggal : <?php echo $tanggal1;?></th>
        </tr>
        <tr>
            <th style="text-align:left">Sampai Tanggal : <?php echo $tanggal2;?></th>
        </tr>
</table>

<table border="1" align="center" style="width:700px;margin-bottom:20px;">
<?php
    $urut=0;
    $nomor=0;
    $grandtotal=0;
    $group='-';
  foreach($data->result_array()as $d){
    $nomor++;
    $urut++;
    $total = $d['total_kasbank'];
    $keterangan = $d['ket'];
    $tgl = strtotime($d['tanggal_kasbank']);
    $tanggal = date('d-M-Y',$tgl);

    if($group=='-' || $group!=$d['h_nkasbank']){
        $nkasbank=$d['h_nkasbank'];
        $this->db->select('hkasbank.*, hkasbank.n_kasbank as h_nkasbank, dkasbank.n_kasbank as d_nkasbank, hkasbank.tanggal as tanggal_kasbank, coa.nama as nama_akun, hkasbank.keterangan as ket, hkasbank.jumlah as total_kasbank, dkasbank.akun as nomor_akun, dkasbank.debet as debet_kasbank');
        $this->db->select_sum('dkasbank.kredit');
        $this->db->from('hkasbank');
        $this->db->join('dkasbank','dkasbank.n_kasbank = hkasbank.n_kasbank');
        $this->db->join('coa','coa.akun = dkasbank.akun');
        $this->db->where('hkasbank.tanggal >=',$tanggal1);
        $this->db->where('hkasbank.tanggal <=',$tanggal2);
        $this->db->where('hkasbank.statusA = "K"');
        $this->db->where('hkasbank.n_bank = "KAS"');
        $this->db->where('dkasbank.debet > "0"');
        $this->db->where('hkasbank.n_kasbank',$nkasbank);
        $data = $this->db->get();

     if($group!='-')
        echo "</table><br>";
        echo "<table align='center' width='700px;' border='1'>";
        echo "<tr><td><b>No. Trans</b></td><td>".': '."<b>$nkasbank</b></td><td style='text-align:right;'>Tanggal :<b>$tanggal</b></td></tr>";
        echo "<tr>
                <td><b>Keterangan</b></td> <td style='text-align:left;'>".': '."$keterangan</td><td style='text-align:right;'>Total :<b>".number_format($total)."</b></td>
            </tr>";
echo "<tr style='background-color:#ccc;'>
    <td width='15%' align='center'>No. Perkiraan</td>
    <td width='60%' align='center'>Nama Perkiraan</td>
    <td width='25%' align='center'>Jumlah</td>
    
    </tr>";
$nomor=1;
    }
    $group=$d['h_nkasbank'];
        if($urut==500){
        $nomor=0;
            echo "<div class='pagebreak'> </div>";
            }
        ?>
    <tr>
        <td style="text-align:left;" style=""><?=$d['nomor_akun']?></td>
        <td style="text-align:left;" style=""><?=$d['nama_akun']?></td>
        <td style="text-align:right;" style=""><?php echo number_format($d['debet_kasbank']);?></td>
    </tr>
<?php
}
?>
</table>

</table>
<table align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:20px;">
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
<table align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:20px;">
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