<div class="row">
    <div class="col col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3" align="right">

                    </div>
                </div>
                <?php if ($this->session->flashdata('true')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert_berhasil">
                        <strong>Berhasil</strong>
                        <?php echo $this->session->flashdata('true'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal</strong>
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
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
                    <table class="table table-sm table-hover table-bordered list-rab" id="list-rab" style="width:100%">
                        <thead class="thead-success">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Prodi/Unit/Bagian</th>
                                <th width="10%">Mata Anggaran</th>
                                <th width="10%">Detail</th>
                                <th width="10%">Tahun Anggaran</th>
                                <th width="10%">Total</th>
                                <th width="10%">Status</th>
                                <th width="15%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($rab)) {
                                $no = 1;
                                foreach ($rab as $r) { ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><small><?= $r->real_name ?></small></td>
                                        <td><small><?= $r->akun . " &mdash; " . $r->nama ?></small></td>
                                        <td><?= $r->detail ?></td>
                                        <td><?= $r->ta ?></td>
                                        <td><?= "Rp." . formatRupiah($r->total) ?></td>
                                        <td>
                                            <?= status_rab($r->status) ?>
                                            <?= $r->status == 1 ? "<br><small class='text-primary'>Catatan: </small>" . $r->catatan : "" ?>
                                        </td>
                                        <td>
                                            <?php if ($r->status != 2) : ?>

                                                <button type="button" onclick="agree(<?= $r->id ?>)" class="btn btn-success btn-sm agree"><i class="fa fa-check"></i> Setujui</button>
                                                <button type="button" data-user="<?= $r->id_user ?>" data-rab="<?= $r->id ?>" data-ta="<?= $r->ta ?>" class="btn btn-primary btn-sm revisi" onclick="revisi(<?= $r->id ?>);"><i class="fa fa-long-arrow-alt-left"></i> Revisi</button>
                                            <?php else : ?>
                                                <button type="button" onclick="notagree(<?= $r->id ?>)" class="btn btn-danger btn-sm notagree"><i class="fa fa-times"></i> Batalkan</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php $no++;
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- 000000000000000000000000000000000000-->
<div class="modal fade" id="modal-add-revisi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Revisi RAB</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('persetujuan') ?>/dorevisi" id="formrevisi" method="POST">
                    <input type="hidden" name="id_rab" id="e_id_rab">
                    <div class="form-group">
                        <label>Mata Anggaran</label>
                        <input type="text" name="e_mata_anggaran" id="e_mata_anggaran" class="form-control form-control-sm" readonly>
                        <!-- <textarea name="mata_anggaran" id="e_mata_anggaran" class="form-control form-control-sm" placeholder="Mata anggaran" readonly=""></textarea> -->
                    </div>
                    <div class="form-group">
                        <label>Detail</label>
                        <textarea name="detail" id="e_detail" class="form-control form-control-sm" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label>Catatan Revisi</label>
                        <textarea name="catatan" id="e_catatan" class="form-control form-control-sm" placeholder="Masukkan catatan revisi"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/autoNumeric/autoNumeric.js'); ?>"></script>
<script src="<?= base_url('assets/libs/jquery/dist/jquery-dateformat.js'); ?>"></script>
<script src="<?= base_url('assets/libs/sweetalert/sweetalert.min.js') ?>"></script>

<!-- ######################################################################################## -->
<!-- ####################################################################################### -->
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
                    json[jr].akun + " &mdash; " + json[jr].nama,
                    json[jr].detail,
                    json[jr].ta,
                    formatRupiah(json[jr].total),
                    status,
                    opsi
                ]).draw(false);
            }
        });
    });

    function agree(id) {
        var link = site_url + '/persetujuan/doagree/' + id;
        swal({
            title: 'Yakin untuk menyetujui Anggaran?',
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

    function notagree(id) {
        var link = site_url + '/persetujuan/donotagree/' + id;
        swal({
            title: 'Yakin untuk membatalkan persetujuan Anggaran?',
            text: 'Data akan disimpan',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((donotAgree) => {
            if (donotAgree) {
                window.location.href = link;
            } else {
                return false;
            }
        });
    }

    function revisi(id) {
        $.getJSON(site_url + '/persetujuan/getrabuser?id=' + id, function(json) {
            $('#e_id_rab').val(json[0].id);
            $('#e_mata_anggaran').val(json[0].akun + " __ " + json[0].nama);
            $('#e_detail').val(json[0].detail);
            if (json[0].catatan != "") {
                $('#e_catatan').val(json[0].catatan);
            }
        });
        $('#e_detail').prop('readonly', true);
        $('#modal-add-revisi').modal('show');
    }
</script>