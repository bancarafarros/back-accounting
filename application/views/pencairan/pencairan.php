<div class="row">
    <div class="col col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3" align="right">
                    </div>
                </div>
                <div class="row">
                    <label class="col-2 col-sm-2 col-md-2 text-right pl-0 control-label col-form-label">Tahun :</label>
                    <div class="col-2 col-sm-2 col-md-2">
                        <select class="custom-select range" id="tahunJ">
                            <?php $datesek = date('Y');
                            for ($th = 0; $th < 15; $th++) {
                                if ($th == 12) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo '<option value=' . intval($datesek + $th - 12) . '-' . intval($datesek + $th - 11) . ' ' . $selected . '>' . intval($datesek + $th - 12) . '-' . intval($datesek + $th - 11) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover list-rab" id="list-rab" style="width:100%">
                        <thead class="thead-success">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Prodi/Unit/Bagian</th>
                                <th width="10%">Mata Anggaran</th>
                                <th width="10%">RAB</th>
                                <th width="5%">Tahun Anggaran</th>
                                <th width="15%">Keterangan</th>
                                <th width="10%">Total</th>
                                <th width="10%">Status</th>
                                <th width="15%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($pencairan)) {
                                $no = 1;
                                foreach ($pencairan as $r) {
                                    if ($r->warek != 0 && $r->rektor != 0 && $r->status != 1) :
                            ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $r->real_name ?></td>
                                            <td><?= $r->mata_anggaran ?></td>
                                            <td><?= $r->detail ?></td>
                                            <td><?= $r->ta ?></td>
                                            <td><?= $r->keterangan ?></td>
                                            <td><?= currencyIDR($r->total) ?></td>
                                            <td><?= ($r->rektor == 1 && $r->warek == 1) ? "<span class='text-success'>Disetujui</span>" : "<span class='text-danger'>Belum/Tidak Disetujui</span>"; ?></td>
                                            <td>
                                                <?php if ($r->warek == 1 && $r->rektor == 1) : ?>
                                                    <button type="button" data-url="<?= site_url('approvalpencairan/doagree') ?>/<?= $r->id_rab ?>" onclick="transaksi(<?= $r->id ?>)" class="btn btn-primary btn-sm prosestransaksi"><i class="fa fa-check"></i> Transaksikan</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                            <?php $no++;
                                    endif;
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ######################################################################################## -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Isi Data Mata Anggaran Belanja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('rab/dosave') ?>" id="formAddrab" method="POST">
                    <div class="form-group">
                        <label>Mata Anggaran</label>
                        <!-- <input type="text" name="mata_anggaran" class="form-control form-control-sm" placeholder="Mata anggaran" id="mata_anggaran"> -->
                        <textarea name="mata_anggaran" class="form-control form-control-sm" placeholder="Mata anggaran"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Ex: Tiap bulan / Per tahun" id="keterangan">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="act" value="addrab">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ####################################################################################### -->
<?php $this->load->view('template/bundle/template_scripts'); ?>
<script type="text/javascript">
    var site_url = "<?= site_url() ?>";
    $(document).ready(function() {
        var table = $('.list-rab').DataTable({
            "paging": false,
            "retrieve": true
        });
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^-.\d]/g, '').toString(),
            split = number_string.split('.'),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/[-\d]{3}/gi);
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }
        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }

    $('.range').on('change', function() {
        var table = $('#list-rab').DataTable({
            "paging": false,
            "retrieve": true
        });
        table.clear().draw()
        var range = $("#tahunJ").val();
        $.getJSON(site_url + '/persetujuan/getrabta?ta=' + range, function(json) {
            console.log(json);
            var html = "";
            var status = '';
            var opsi = '';
            for (let jr = 0; jr < json.length; jr++) {
                if (json[jr].status == 0) {
                    status = "<span class='text-danger'>Belum/Tidak Disetujui</span>";
                    opsi =
                        "<button type='button' data-url=" + site_url + "/persetujuan/doagree/" + json[jr].id + "?id_user=" + json[jr].id_user + "&ta=" + json[jr].ta + " class=" + "'btn btn-primary btn-sm agree'" + "><i class='fa fa-check'></i> Setujui</button>";
                } else {
                    status = "<span class='text-success'>Disetujui</span>";
                    opsi =
                        "<button type='button' data-url=" + site_url + "/persetujuan/donotagree/" + json[jr].id + "?id_user=" + json[jr].id_user + "&ta=" + json[jr].ta + " class=" + "'btn btn-danger btn-sm notagree'" + "><i class='fa fa-times'></i> Batalkan</button>";
                }
                table.row.add([
                    jr + 1,
                    json[jr].real_name,
                    json[jr].mata_anggaran,
                    json[jr].ta,
                    formatRupiah(json[jr].total),
                    status,
                    opsi
                ]).draw(false);
            }
        });
    });

    function transaksi(id) {
        var link = site_url + '/pencairan/dosave/' + id;
        swal({
            title: 'Yakin melakukan transaksi?',
            text: 'Data akan disimpan',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((doAgree) => {
            if (doAgree) {
                window.location.href = link;
            } else {
                return false;
            }
        });
    }
</script>