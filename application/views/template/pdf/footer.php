<div>
    <table align="center" style="width:100%;border:none;margin-top:30px;margin-bottom:20px;">
        <tr valign="top">
            <td colspan="2" class="text-default" style="text-align:center;height:90px;">Mengetahui:</td>
            <td colspan="3" class="text-default" style="text-align:center;height:90px;">Diperiksa Oleh:</td>
            <td colspan="2" class="text-default" style="text-align:center;height:90px;">Diterima Oleh:</td>
        </tr>
        <tr valign="bottom">
            <td colspan="2" class="text-default" style="text-align:center;height:50px;">( ................................. )</td>
            <td colspan="3" class="text-default" style="text-align:center;height:50px;">( ................................. )</td>
            <td colspan="2" class="text-default" style="text-align:center;height:50px;">( ................................. )</td>
        </tr>
    </table>
</div>
<div class="mt-3">
    <p>Waktu cetak: <?= $this->tanggalindo->konversi_tgl_jam(date('Y-m-d H:i:s')) ?><br>Oleh: <?= getSession('realName') ?></p>
</div>