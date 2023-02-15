<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-md-flex align-items-center">
                    <div class="text-center text-sm-left ">
                        <div class="avatar avatar-image" style="width: 150px; height:150px">
                            <img src="<?= base_url($profil->image) ?>" alt="">
                        </div>
                    </div>
                    <div class="text-center text-sm-left m-v-15 p-l-30">
                        <h2 class="m-b-5"><?= $profil->real_name ?></h2>
                        <p class="text-opacity font-size-13">@<?= $profil->username ?></p>
                        <p class="text-dark font-size-13"><?= $profil->nama_group ?></p>
                        <p class="text-dark font-size-13"><?= $profil->email ?></p>
                        <p class="text-dark font-size-13">Terakhir Login: <?= $this->tanggalindo->konversi_tgl_jam($profil->last_login_time) ?></p>
                        <a href="<?= site_url('dashboard/profiledit') ?>" role="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Ubah Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/bundle/template_scripts'); ?>