<form action="<?=site_url('Pemasok/dosave')?>" method="POST">
    <label for="">Nomor Pemasok :</label>
    <input type="text" name="n_pemasok" value="<?=@$detail->n_pemasok?>" id=""><br>
    <label for="">Tgl Reg :</label>
    <input type="date" name="tanggal" value="<?=@$detail->tanggal?>" id=""><br>
    <label for="">Akun :</label>
    <select name="akun">
        <?php foreach ($d_akun as $key => $value) { 
            if ($value->akun == @$detail->akun) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            ?>
            <option value="<?=$value->akun?>" <?=$selected?>><?=$value->akun?> | <?=$value->nama?></option>
        <?php } ?>
    </select><br>
    <label for="">Nama Pemasok :</label>
    <input type="text" name="nama" value="<?=@$detail->nama?>" id=""><br>
    <label for="">Alamat :</label>
    <input type="text" name="alamat" value="<?=@$detail->alamat?>" id=""><br>
    <label for="">Telp :</label>
    <input type="text" name="telepon" value="<?=@$detail->telepon?>" id=""><br>
    <label for="">email :</label>
    <input type="text" name="email" value="<?=@$detail->email?>" id=""><br>
    <label for="">batas :</label>
    <input type="text" name="batas" value="<?=@$detail->batas?>" id=""><br>
    <label for="">status :</label>
    <input type="text" name="status" value="<?=@$detail->status?>" id=""><br>
    <input type="hidden" name="act" value="<?=$act?>">
    <input type="hidden" name="id" value="<?=@$detail->n_pemasok?>">
    <input type="submit" value="Simpan">
 </form>