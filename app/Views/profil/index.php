<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pengaturan Profil</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <!-- Form Pengaturan Profil -->
                            <form id="formUser" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" name="id_user" id="id_user" value="<?= $id; ?>">
                                            <div class="form-group">
                                                <label>Nama User</label>
                                                <input type="text" class="form-control" id="nama_user" name="nama_user" autocomplete="off" readonly>
                                                <small id="nama_user_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" readonly>
                                                <small id="username_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan password jika tidak diubah" autocomplete="off" readonly>
                                                <small id="password_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Level</label>
                                                <input type="text" class="form-control" id="level" name="level" autocomplete="off" readonly>
                                                <small id="level_error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Foto</label>
                                                <div id="foto_profil" class="custom-file" style="display: none;">
                                                    <input id="foto" name="foto" type="file" class="custom-file-input" onchange="previewFoto(this);">
                                                    <label class=" custom-file-label" for="foto">Choose file</label>
                                                    <small id="foto_error" class="text-danger"></small>
                                                </div>
                                                <br>
                                                <div class="mt-3" id="imagePreview">
                                                    <img class="img-circle profile-user-img foto-preview" alt="Foto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="form-group col-md-6 mt-2">
                                        <button type="button" class="btn btn-primary" id="btnUbah">Ubah</button>
                                        <button type="button" class="btn btn-primary mr-2" id="btnSimpan">Simpan</button>
                                        <button type="button" class="btn btn-danger" id="btnBatal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript">
    // Tampilkan preview foto
    function previewFoto(input) {
        var file = $("#foto").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#imagePreview').show();
                $(".foto-preview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
    $(document).ready(function() {
        // =========================================== Onload ===========================================
        // panggil fungsi tampil data profil
        tampil_data();
        // sembunyikan tombol "simpan"
        $('#btnSimpan').hide();
        // sembunyikan tombol "batal"
        $('#btnBatal').hide();
        // ==============================================================================================

        // initial plugins
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        // konvert tanggal ke indonesia
        function convertDateDBtoIndo(string) {
            tanggal = string.split("-")[2];
            bulan = string.split("-")[1];
            tahun = string.split("-")[0];

            return tanggal + "-" + bulan + "-" + tahun;
        }

        // ======================================== Tampil Data =========================================
        // tampilkan data profil aplikasi
        function tampil_data() {
            // siapkan data "id" profil
            var id_user = $('#id_user').val();
            // tampilkan data user
            $.ajax({
                url: "/Profil/show/" + id_user,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_user').val(data.id);
                    $('#nama_user').val(data.nama_user);
                    $('#username').val(data.username);
                    // tampilkan keterangan pada password
                    $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
                    $('#level').val(data.level);
                    $('#imagePreview').show();
                    if (data.foto == '') {
                        $('.foto-preview').attr('src', '/images/user/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/user/' + data.foto);
                    }
                }
            })
        }
        // ==============================================================================================

        // ====================================== Enable Form Update ====================================
        $('#btnUbah').click(function() {
            // sembunyikan tombol "ubah"
            $('#btnUbah').hide();
            // tampilkan tombol "simpan"
            $('#btnSimpan').show();
            // tampilkan tombol "batal"
            $('#btnBatal').show();
            // aktifkan form input
            $('#nama_user').removeAttr('readonly');
            $('#username').removeAttr('readonly');
            $('#password').removeAttr('readonly');
            $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
            $('#foto_profil').removeAttr('style');
        });
        // ===============================================================================================

        // ============================================ Form =============================================
        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            var data = new FormData($("#formUser")[0]);
            $.ajax({
                url: "/Profil/update",
                method: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    //Data error 
                    if (data.error) {
                        if (data.user_error['nama_user'] != '') $('#nama_user_error').html(data.user_error['nama_user']);
                        else $('#nama_user_error').html('');
                        if (data.user_error['username'] != '') $('#username_error').html(data.user_error['username']);
                        else $('#username_error').html('');
                        if (data.user_error['level'] != '') $('#level_error').html(data.user_error['level']);
                        else $('#level_error').html('');
                        if (data.user_error['foto'] != '') $('#foto_error').html(data.user_error['foto']);
                        else $('#foto_error').html('');
                    }
                    //Data user berhasil disimpan
                    if (data.success) {
                        // reset form
                        $('#formUser')[0].reset();
                        $('#modalUser').modal('hide');
                        $('#nama_user_error').html('');
                        $('#username_error').html('');
                        $('#password_error').html('');
                        $('#level_error').html('');
                        $('#foto_error').html('');
                        // tampilkan pesan sukses simpan data
                        Toast.fire({
                            icon: 'success',
                            title: 'Pengaturan Profil berhasil diupdate.'
                        })
                        // tampilkan data profil
                        tampil_data();
                        // non-aktifkan form input
                        disable_form();
                    }
                }
            });
        });
        // ===============================================================================================

        // ====================================== Disable Form Update ====================================
        $('#btnBatal').click(function() {
            // tampilkan data profil
            tampil_data();
            // non-aktifkan form input
            disable_form();
        });

        // fungsi untuk non-aktifkan form input
        function disable_form() {
            // tampilkan tombol "ubah"
            $('#btnUbah').show();
            // sembunyikan tombol "simpan"
            $('#btnSimpan').hide();
            // sembunyikan tombol "batal"
            $('#btnBatal').hide();
            // non-aktifkan form input
            $('#nama_user').attr('readonly', 'true');
            $('#username').attr('readonly', 'true');
            $('#password').attr('readonly', 'true');
            $('#password').val('');
            $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
            $('#foto_profil').attr('style', 'display:none;');
        }
        // ==============================================================================================

    });
</script>
<?= $this->endSection() ?>