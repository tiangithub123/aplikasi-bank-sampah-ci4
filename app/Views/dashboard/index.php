<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-primary">
                        <i class="icon fas fa-user"></i> Selamat Datang
                        <strong><?= $nama_user; ?></strong>, Anda login sebagai <strong><?= $level; ?></strong>
                    </div>
                </div>
            </div>
            <?php
            if ($level == 'Admin') { ?>
                <div class="row">
                    <div class="col-lg-4 col-6">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <?php
                                $db      = \Config\Database::connect();
                                $builder = $db->table('penarikan a');
                                $builder->select('a.id, a.id_nasabah, b.nama_nasabah');
                                $builder->join('nasabah b', 'b.id = a.id_nasabah', 'left');
                                $builder->where(['a.status' => 'Berhasil']);
                                $berhasil = $builder->countAllResults();
                                ?>
                                <h3><?= $berhasil; ?></h3>
                                <p>Transaksi Penarikan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="transaksi-penarikan" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <?php
                                $db      = \Config\Database::connect();
                                $builder = $db->table('sampah');
                                $builder->select('*');
                                $sampah = $builder->countAllResults();
                                ?>
                                <h3><?= $sampah; ?></h3>
                                <p>Data Sampah</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="sampah" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <?php
                                $db      = \Config\Database::connect();
                                $builder = $db->table('user');
                                $builder->select('*');
                                $user = $builder->countAllResults();
                                ?>
                                <h3><?= $user; ?></h3>
                                <p>Data User</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="user" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            <?php
            } else { ?>
                <div class="row">
                    <div class="col-lg-4 col-6">

                        <div class="small-box bg-warning">
                            <div class="inner">
                                <?php
                                $db      = \Config\Database::connect();
                                $builder = $db->table('setor_sampah a');
                                $builder->select('a.id, a.id_nasabah, b.nama_nasabah');
                                $builder->join('nasabah b', 'b.id = a.id_nasabah', 'left');
                                $builder->where(['a.status' => 'Menunggu']);
                                $menunggu = $builder->countAllResults();
                                ?>
                                <h3><?= $menunggu; ?></h3>
                                <p>Menunggu</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="setor-sampah" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <?php
                                $db      = \Config\Database::connect();
                                $builder = $db->table('setor_sampah a');
                                $builder->select('a.id, a.id_nasabah, b.nama_nasabah');
                                $builder->join('nasabah b', 'b.id = a.id_nasabah', 'left');
                                $builder->where(['a.status' => 'Berhasil']);
                                $berhasil = $builder->countAllResults();
                                ?>
                                <h3><?= $berhasil; ?></h3>
                                <p>Berhasil</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="setor-sampah" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <?php
                                $db      = \Config\Database::connect();
                                $builder = $db->table('setor_sampah a');
                                $builder->select('a.id, a.id_nasabah, b.nama_nasabah');
                                $builder->join('nasabah b', 'b.id = a.id_nasabah', 'left');
                                $builder->where(['a.status' => 'Gagal']);
                                $gagal = $builder->countAllResults();
                                ?>
                                <h3><?= $gagal; ?></h3>
                                <p>Gagal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="setor-sampah" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            <?php
            }
            ?>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection() ?>