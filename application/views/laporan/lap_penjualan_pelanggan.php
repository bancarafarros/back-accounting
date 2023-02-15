<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
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
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>LAPORAN PENJUALAN PER PELANGGAN (DETAIL)</h4></center><br/></td>
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
            <td style="text-align:left;width:8%">Pelanggan: </td><td style="text-align:left;width:92%">:<?php echo " ".$b['namapelanggan'];?></td>
        </tr>
        <tr>
            <td style="text-align:left;width:8%">Sales: </td><td style="text-align:left;width:92%">:<?php echo " ".$b['namasales'];?></td>
        </tr>
        <tr>
            <td style="text-align:left;width:8%">Tanggal: </td><td style="text-align:left;width:92%">:<?php echo " ".$tanggal1." / ".$tanggal2;?></td>
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
    $harga = number_format($d['harganya'],2,",",".");
    $hargaasli = number_format($d['hargaasli'],2,",",".");
    $total = number_format($d['total_penjualan'],2,",",".");
    $subtotal = $d['harganya']*$d['jumlahnya'];
    $pelanggan = $d['namapelanggan'];
    $sales = $d['namasales'];
    $tgl = strtotime($d['tgl_jual']);
    $tanggal_jual = date('d-M-Y',$tgl);

    if($group=='-' || $group!=$d['n_penjualan']){
        $npenjualan=$d['n_penjualan'];
        $this->db->select('hpenjualan.*, dpenjualan.disc as diskon, dpenjualan.harga as harganya,dpenjualan.harga_asli as hargaasli, dpenjualan.jumlah as jumlahnya, barang.nama as nama_barang');
        $this->db->from('hpenjualan');
        $this->db->join('dpenjualan','dpenjualan.n_penjualan = hpenjualan.n_penjualan');
        $this->db->join('barang','barang.n_barang = dpenjualan.n_barang');
        /*$this->db->where('dpenjualan.n_penjualan = hpenjualan.n_penjualan');*/
        $this->db->where('hpenjualan.n_penjualan = "$npenjualan"');
        $this->db->order_by('n_penjualan', 'desc');
        $data = $this->db->get();

     if($group!='-')
        echo "</table><br>";
        echo "<table align='center' width='900px;' border='1'>";
        echo "<tr><td colspan='8' style='text-align:center;'><b>No.".' '."$npenjualan</b></td></tr>";
        echo "<tr><td><b>Tanggal</b></td> <td colspan='5' style='text-align:left;'>".': '."$tanggal_jual</td><td style='text-align:right;'><b>Total:</b></td><td style='text-align:right;'><b>".'Rp '.$total."</b></td></tr>";
echo "<tr style='background-color:#ccc;'>
   <td width='3%' align='center'>No</td>
    <td width='10%' align='center'>Kode Barang</td>
    <td width='46%' align='center'>Nama Barang</td>
    <td width='3%' align='center'>Qty</td>
    <td width='5%' align='center'>Satuan</td>
    <td width='13%' align='center'>Harga Jual</td>
    <td width='8%' align='center'>Diskon</td>
    <td width='12%' align='center'>Subtotal</td>
    
    </tr>";
$nomor=1;
    }
    $group=$d['n_penjualan'];
        if($urut==500){
        $nomor=0;
            echo "<div class='pagebreak'> </div>";
            }
        ?>
    <tr>
        <td style="text-align:center;" style=""><?php echo $nomor;?></td>
        <td style="text-align:left;" style=""><?=$d['kdbarang']?></td>
        <td style="text-align:left;" style=""><?=$d['nama_barang']?></td>
        <td style="text-align:center;" style=""><?=$d['jumlahnya']?></td>
        <td style="text-align:center;" style=""><?=$d['satuanbrg']?></td>
        <td style="text-align:right;" style=""><?php echo 'Rp '.$hargaasli?></td>
        <td style="text-align:center;" style=""><?=$d['diskon']." %"?></td>
        <td style="text-align:right;" style=""><?php echo 'Rp '.number_format($subtotal,2,",",".");?></td>
    </tr>
<?php
        }
        ?>
</table>

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