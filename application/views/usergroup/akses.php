<div class="container-fluid mt-2 mb-4">
    <form action="<?= site_url("usergroup/setHakAkses/" . $id_group) ?>" method="post" class="mb-4">
        <div class="row">
            <?php foreach ($modul as $m) : ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="custom-control custom-checkbox">
                                <?php if (in_array($m['nama_modul'] . '.access', $groupAccess)) : ?>
                                    <input name="access[]" type="checkbox" class="custom-control-input" id="<?= $m['nama_modul'] ?>" checked value="<?= $m['nama_modul'] ?>">
                                    <label class="custom-control-label" for="<?= $m['nama_modul'] ?>"><?= $m['nama_modul'] ?></label><span class="text-muted"></span>
                                <?php else : ?>
                                    <input name="access[]" type="checkbox" class="custom-control-input" id="<?= $m['nama_modul'] ?>" value="<?= $m['nama_modul'] ?>">
                                    <label class="custom-control-label" for="<?= $m['nama_modul'] ?>"><?= $m['nama_modul'] ?></label><span class="text-muted"></span>
                                <?php
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="w-100 d-flex justify-content-sm-center justify-content-md-center justify-content-lg-end align-items-center">
            <button type="submit" class="mb-4 btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </form>
</div>

<?php $this->load->view('template/bundle/template_scripts') ?>