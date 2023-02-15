<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="aplikasi keuangan">
    <meta name="author" content="arkatama.id">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('public/sajada-logo-teal.png') ?>">
    <title><?= APP_NAME . ' ' . INSTANSI_NAME ?> &mdash; <?= (!empty($judul_title) ? $judul_title : 'index') ?></title>

    <!-- page css -->

    <!-- DataTables -->
    <link href="<?= base_url('public/enlink') ?>/assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('public/enlink') ?>/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?= base_url('public/lib') ?>/summernote/summernote-bs4.min.css" rel="stylesheet">

    <!-- Core css -->
    <link href="<?= base_url('public/enlink') ?>/assets/css/app.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="<?= base_url('public/lib') ?>/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?= base_url('public/lib') ?>/select2-bootstrap4-theme/select2-bootstrap4.min.css" rel="stylesheet">

    <link href="<?= base_url('public/lib') ?>/parsleyjs/parsley.css" rel="stylesheet">
    <!-- loading -->
    <link href="<?= base_url("public/loading/loading_page.css") ?>" rel="stylesheet">
    <!-- For Grocery CRUD Plugins -->
    <?php
    if (isset($output->css_files)) {
        foreach ($output->css_files as $file) {
            echo '<link href="' . $file . '" type="text/css" rel="stylesheet">';
        }
    }
    ?>
</head>

<body>
    <div id="spinner-front" class="d-none">
        <img src="<?= base_url('public/loading/ajax-loader.gif') ?>" width="80"><br>
        Loading...
    </div>
    <div id="spinner-back">
    </div>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo">
                    <a href="<?= site_url('dashboard') ?>">
                        <img style="max-width: 60px; max-height: 60px;" src="<?= base_url('public') ?>/sajada-logo-white.png" alt="Logo">
                        <center><img style="max-width: 60px; max-height: 60px;" class="logo-fold" src="<?= base_url('public') ?>/sajada-logo-white.png" alt="Logo"></center>
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <!-- <li class="dropdown dropdown-animated scale-left">
                            <a href="javascript:void(0);" data-toggle="dropdown">
                                <i class="anticon anticon-bell notification-badge"></i>
                            </a>
                            <div class="dropdown-menu pop-notification">
                                <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                                    <p class="text-dark font-weight-semibold m-b-0">
                                        <i class="anticon anticon-bell"></i>
                                        <span class="m-l-10">Notification</span>
                                    </p>
                                    <a class="btn-sm btn-default btn" href="javascript:void(0);">
                                        <small>View All</small>
                                    </a>
                                </div>
                                <div class="relative">
                                    <div class="overflow-y-auto relative scrollable" style="max-height: 300px">
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-blue avatar-icon">
                                                    <i class="anticon anticon-mail"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">You received a new message</p>
                                                    <p class="m-b-0"><small>8 min ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-cyan avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">New user registered</p>
                                                    <p class="m-b-0"><small>7 hours ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                            <div class="d-flex">
                                                <div class="avatar avatar-red avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">System Alert</p>
                                                    <p class="m-b-0"><small>8 hours ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item d-block p-15 ">
                                            <div class="d-flex">
                                                <div class="avatar avatar-gold avatar-icon">
                                                    <i class="anticon anticon-user-add"></i>
                                                </div>
                                                <div class="m-l-15">
                                                    <p class="m-b-0 text-dark">You have a new update</p>
                                                    <p class="m-b-0"><small>2 days ago</small></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li> -->
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <img src="<?= base_url(getSession('image')) ?>" alt="">
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            <img src="<?= base_url(getSession('image')) ?>" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold"><?= getSession("realName"); ?></p>
                                            <p class="m-b-0 text-dark opacity-07"><?= getSession('groupDescription') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= site_url('dashboard/profil') ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                            <span class="m-l-10">Profil</span>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= site_url('dashboard/profiledit') ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-lock"></i>
                                            <span class="m-l-10">Account Setting</span>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= site_url('dashboard/logout') ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Logout</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <!-- <li>
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#quick-view">
                                <i class="anticon anticon-appstore"></i>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <!-- Header END -->

            <!-- Side Nav START -->
            <div class="side-nav">
                <div class="text-center mt-2 mb-1">
                    <div class="avatar avatar-lg avatar-image">
                        <img src="<?= base_url(getSession('image')) ?>" alt="user-image">
                    </div>
                    <div class="mt-0 d-none d-md-block">
                        <p class="m-b-0 text-white font-weight-semibold"><?= getSession("realName"); ?></p>
                    </div>
                </div>
                <div class="side-nav-inner">
                    <ul class="side-nav-menu scrollable">
                        <li class="nav-item dropdown <?= active_page('dashboard', 'open') ?>">
                            <a href="<?= site_url('dashboard') ?>">
                                <span class="icon-holder">
                                    <i style="color: #fff;" class="anticon anticon-dashboard"></i>
                                </span>
                                <span class="title text-white">Dashboard</span>
                            </a>
                        </li>
                        <?php if (in_array("rab.access", $userMenus) || in_array("persetujuan.access", $userMenus) || in_array("pencairan.access", $userMenus) || in_array("approvalpencairan.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="anticon anticon-appstore"></i>
                                    </span>
                                    <span class="title">RAB</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array("rab.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('rab') ?>">Daftar RAB</a>
                                        </li>
                                        <li>
                                            <a href="<?= site_url('rab/pencairan') ?>">Pencairan RAB</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("persetujuan.access", $userMenus)) : ?>
                                        <li><a href="<?= site_url('persetujuan') ?>">Daftar Pengajuan RAB</a></li>
                                        <li><a href="<?= site_url('persetujuan/pencairan') ?>">Daftar Pencairan RAB</a></li>
                                    <?php endif; ?>
                                    <?php if (in_array("pencairan.access", $userMenus)) : ?>
                                        <li><a href="<?= site_url('pencairan') ?>">Pencairan RAB</a></li>
                                    <?php endif; ?>
                                    <?php if (in_array("approvalpencairan.access", $userMenus)) : ?>
                                        <li><a href="<?= site_url('approvalpencairan') ?>">Daftar Pencairan RAB</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("barang.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-cubes"></i>
                                    </span>
                                    <span class="title">Persediaan</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['barang']) ?>">
                                        <a href="<?= site_url('barang') ?>">Daftar Barang</a>
                                    </li>
                                    <li class="<?= active_subpage(['barang', 'grupbarang']) ?>">
                                        <a href="<?= site_url('barang/grupbarang') ?>">Grup Barang</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("pembelian.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-dolly-flatbed"></i>
                                    </span>
                                    <span class="title">Pembelian</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['pembelian']) ?>">
                                        <a href="<?= site_url('pembelian') ?>">Transaksi Pembelian</a>
                                    </li>
                                    <li class="<?= active_subpage(['barang', 'ret_beli']) ?>">
                                        <a href="<?= site_url('pembelian/ret_beli') ?>">Retur Pembelian</a>
                                    </li>
                                    <?php if (in_array("pemasok.access", $userMenus)) : ?>
                                        <li class="<?= active_subpage(['barang', 'pemasok']) ?>">
                                            <a href="<?= site_url('pemasok') ?>">Daftar Pemasok</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("penjualan.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                    <span class="title">Penjualan</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['penjualan']) ?>">
                                        <a href="<?= site_url('penjualan') ?>">Transaksi Penjualan</a>
                                    </li>
                                    <li class="<?= active_subpage(['penjualan', 'ret_jual']) ?>">
                                        <a href="<?= site_url('penjualan/ret_jual') ?>">Return Penjualan</a>
                                    </li>
                                    <?php if (in_array("pelanggan.access", $userMenus)) : ?>
                                        <li class="<?= active_subpage(['pelanggan']) ?>">
                                            <a href="<?= site_url('pelanggan') ?>">Daftar Pelanggan</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("sales.access", $userMenus)) : ?>
                                        <li class="<?= active_subpage(['sales']) ?>">
                                            <a href="<?= site_url('sales') ?>">Daftar Sales</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("costing.access", $userMenus)) : ?>
                            <li class="nav-item dropdown class=" <?= active_page('costing', 'open') ?>"">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-cart-arrow-down"></i>
                                    </span>
                                    <span class="title">Costing</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['costing']) ?>">
                                        <a href="<?= site_url('costing') ?>">Transaksi Costing</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("hutang.access", $userMenus)) : ?>
                            <li class="nav-item dropdown class=" <?= active_page('hutang', 'open') ?>"">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </span>
                                    <span class="title">Hutang</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['hutang']) ?>">
                                        <a href="<?= site_url('hutang') ?>">Transaksi Hutang</a>
                                    </li>
                                    <li class="<?= active_subpage(['hutang', 'formhutang']) ?>">
                                        <a href="<?= site_url('hutang/formhutang') ?>">Pembayaran Hutang</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("piutang.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-credit-card"></i>
                                    </span>
                                    <span class="title">Piutang</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['piutang']) ?>">
                                        <a href="<?= site_url('piutang') ?>">Transaksi Piutang</a>
                                    </li>
                                    <li class="<?= active_subpage(['piutang', 'b_piutang']) ?>">
                                        <a href="<?= site_url('piutang/b_piutang') ?>">Pembayaran Piutang</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("kasbank.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </span>
                                    <span class="title">Kas & Bank</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['kasbank']) ?>">
                                        <a href="<?= site_url('kasbank') ?>">Transaksi Kas & Bank</a>
                                    </li>
                                    <?php if (in_array("bank.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('bank') ?>">Daftar Bank</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("jurnal.access", $userMenus) || in_array("coa.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-file-alt"></i>
                                    </span>
                                    <span class="title">Jurnal</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array("jurnal.access", $userMenus)) : ?>
                                        <li class="<?= active_subpage(['jurnal']) ?>">
                                            <a href="<?= site_url('jurnal') ?>">Jurnal</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("coa.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('coa/saldo') ?>">Saldo</a>
                                        </li>
                                        <li>
                                            <a href="<?= site_url('coa') ?>">Daftar Perkiraan</a>
                                        </li>
                                        <li>
                                            <a href="<?= site_url('coa/penghubung') ?>">Perkiraan Penghubung</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("laporan.access", $userMenus)) : ?>
                            <!-- <li class="nav-item dropdown <?= active_page('laporan', 'open') ?>">
                                <a href="<?= site_url('laporan') ?>">
                                    <span class="icon-holder">
                                        <i class="fas fa-file"></i>
                                    </span>
                                    <span class="title">Daftar Laporan</span>
                                </a>
                            </li> -->
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-file"></i>
                                    </span>
                                    <span class="title">Daftar Laporan</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?= active_subpage(['laporan']) ?>">
                                        <a href="<?= site_url('report/bukubesar') ?>">Buku Besar</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('report/kasbank') ?>">Kas dan Bank</a>
                                    </li>
                                    <!-- <li>
                                        <a href="<?= site_url('report/penjualan') ?>">Penjualan</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('report/pembelian') ?>">Pembelian</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('report/pelanggan') ?>">Pelanggan</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('report/Pemasok') ?>">Pemasok</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('report/persediaan') ?>">Persediaan</a>
                                    </li> -->
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array("user.access", $userMenus) || in_array("setting.access", $userMenus) || in_array("usergroup.access", $userMenus) || in_array("sistem.access", $userMenus) || in_array("whatsapp.access", $userMenus)) : ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="javascript:void(0);">
                                    <span class="icon-holder">
                                        <i class="fas fa-cogs"></i>
                                    </span>
                                    <span class="title">Pengaturan</span>
                                    <span class="arrow">
                                        <i class="arrow-icon"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array("user.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('user') ?>">User</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("setting.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('setting') ?>">Perusahaan</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("setting.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('setting/modul') ?>">Modul Sistem</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("usergroup.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('usergroup') ?>">Group User</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("sistem.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('sistem') ?>">Sistem Setting</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array("whatsapp.access", $userMenus)) : ?>
                                        <li>
                                            <a href="<?= site_url('whatsapp') ?>">Whatsapp</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown" style="height:120px;">
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Side Nav END -->
            <!-- Page Container START -->
            <div class="page-container">
                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title"><?= (!empty($judul_title) ? $judul_title : 'index') ?></h2>
                        <div class="header-sub-title">
                            <?php if (isset($breadcrumb)) : $akhir = count($breadcrumb) - 1; ?>
                                <nav class="breadcrumb breadcrumb-dash">
                                    <?php foreach ($breadcrumb as $i => $crumb) : ?>
                                        <?php
                                        // $url = isset($crumb['url']) ? $crumb['url'] : '#';
                                        $url = (($akhir != $i) ? (isset($crumb['url']) ? $crumb['url'] : '#') : '#');
                                        $icon = isset($crumb['icon']) ? '<i class="' . $crumb['icon'] . ' m-r-5"></i>' : null;
                                        $active = ($akhir == $i) ? 'active' : null;
                                        ?>
                                        <a href="<?= $url ?>" class="breadcrumb-item <?= $active ?>"><?= $icon ?><?= $crumb['title'] ?></a>
                                    <?php endforeach; ?>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($this->session->flashdata('true')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('true'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php elseif ($this->session->flashdata('false')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('false'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    {CONTENT}
                </div>
                <!-- Content Wrapper END -->
                <!-- Footer START -->
                <footer class="footer">
                    <div class="footer-content">
                        <p class="m-b-0">Copyright &copy; 2022 - <?= date('Y') ?> &mdash; <?= APP_NAME ?>. All rights reserved.</p>
                    </div>
                </footer>
                <!-- Footer END -->
            </div>
            <!-- Page Container END -->

            <!-- Search Start-->
            <div class="modal modal-left fade search" id="search-drawer">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between align-items-center">
                            <h5 class="modal-title">Search</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <i class="anticon anticon-close"></i>
                            </button>
                        </div>
                        <div class="modal-body scrollable">
                            <div class="input-affix">
                                <i class="prefix-icon anticon anticon-search"></i>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <div class="m-t-30">
                                <h5 class="m-b-20">Files</h5>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-cyan avatar-icon">
                                        <i class="anticon anticon-file-excel"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Quater Report.exl</a>
                                        <p class="m-b-0 text-muted font-size-13">by Finance</p>
                                    </div>
                                </div>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-blue avatar-icon">
                                        <i class="anticon anticon-file-word"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Documentaion.docx</a>
                                        <p class="m-b-0 text-muted font-size-13">by Developers</p>
                                    </div>
                                </div>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-purple avatar-icon">
                                        <i class="anticon anticon-file-text"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Recipe.txt</a>
                                        <p class="m-b-0 text-muted font-size-13">by The Chef</p>
                                    </div>
                                </div>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-red avatar-icon">
                                        <i class="anticon anticon-file-pdf"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Project Requirement.pdf</a>
                                        <p class="m-b-0 text-muted font-size-13">by Project Manager</p>
                                    </div>
                                </div>
                            </div>
                            <div class="m-t-30">
                                <h5 class="m-b-20">Members</h5>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-image">
                                        <img src="<?= base_url('public/enlink') ?>/assets/images/avatars/thumb-1.jpg" alt="">
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Erin Gonzales</a>
                                        <p class="m-b-0 text-muted font-size-13">UI/UX Designer</p>
                                    </div>
                                </div>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-image">
                                        <img src="<?= base_url('public/enlink') ?>/assets/images/avatars/thumb-2.jpg" alt="">
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Darryl Day</a>
                                        <p class="m-b-0 text-muted font-size-13">Software Engineer</p>
                                    </div>
                                </div>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-image">
                                        <img src="<?= base_url('public/enlink') ?>/assets/images/avatars/thumb-3.jpg" alt="">
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Marshall Nichols</a>
                                        <p class="m-b-0 text-muted font-size-13">Data Analyst</p>
                                    </div>
                                </div>
                            </div>
                            <div class="m-t-30">
                                <h5 class="m-b-20">News</h5>
                                <div class="d-flex m-b-30">
                                    <div class="avatar avatar-image">
                                        <img src="<?= base_url('public/enlink') ?>/assets/images/others/img-1.jpg" alt="">
                                    </div>
                                    <div class="m-l-15">
                                        <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">5 Best Handwriting Fonts</a>
                                        <p class="m-b-0 text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">25 Nov 2018</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search End-->

            <!-- Quick View START -->
            <!-- <div class="modal modal-right fade quick-view" id="quick-view">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between align-items-center">
                            <h5 class="modal-title">Theme Config</h5>
                        </div>
                        <div class="modal-body scrollable">
                            <div class="m-b-30">
                                <h5 class="m-b-0">Header Color</h5>
                                <p>Config header background color</p>
                                <div class="theme-configurator d-flex m-t-10">
                                    <div class="radio">
                                        <input id="header-default" name="header-theme" type="radio" checked value="default">
                                        <label for="header-default"></label>
                                    </div>
                                    <div class="radio">
                                        <input id="header-primary" name="header-theme" type="radio" value="primary">
                                        <label for="header-primary"></label>
                                    </div>
                                    <div class="radio">
                                        <input id="header-success" name="header-theme" type="radio" value="success">
                                        <label for="header-success"></label>
                                    </div>
                                    <div class="radio">
                                        <input id="header-secondary" name="header-theme" type="radio" value="secondary">
                                        <label for="header-secondary"></label>
                                    </div>
                                    <div class="radio">
                                        <input id="header-danger" name="header-theme" type="radio" value="danger">
                                        <label for="header-danger"></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <h5 class="m-b-0">Side Nav Dark</h5>
                                <p>Change Side Nav to dark</p>
                                <div class="switch d-inline">
                                    <input type="checkbox" name="side-nav-theme-toogle" id="side-nav-theme-toogle">
                                    <label for="side-nav-theme-toogle"></label>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <h5 class="m-b-0">Folded Menu</h5>
                                <p>Toggle Folded Menu</p>
                                <div class="switch d-inline">
                                    <input type="checkbox" name="side-nav-fold-toogle" id="side-nav-fold-toogle">
                                    <label for="side-nav-fold-toogle"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Quick View END -->
        </div>
    </div>
</body>

</html>