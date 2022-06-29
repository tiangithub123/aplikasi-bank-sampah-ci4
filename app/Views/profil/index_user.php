<?= $this->extend('layout/admin/user_layout') ?>
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
                            <form id="formNasabah" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="hidden" name="id_nasabah" id="id_nasabah" value="<?= $id; ?>">
                                            <div class="form-group">
                                                <label>Nama Nasabah</label>
                                                <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" autocomplete="off" readonly>
                                                <small id="nama_nasabah_error" class="text-danger"></small>
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
                                                <label>Alamat</label>
                                                <textarea class="form-control" name="alamat" id="alamat" rows="3" autocomplete="off" readonly></textarea>
                                                <small id="alamat_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Telepon</label>
                                                <input type="text" class="form-control" id="telepon" name="telepon" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off" readonly>
                                                <small id="telepon_error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nama Bank</label>
                                                <input type="text" class="form-control" id="nama_bank" name="nama_bank" autocomplete="off" readonly>
                                                <small id="nama_bank_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label>No. Rekening</label>
                                                <input type="text" class="form-control" id="no_rek" name="no_rek" autocomplete="off" readonly>
                                                <small id="no_rek_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Atas Nama</label>
                                                <input type="text" class="form-control" id="atas_nama" name="atas_nama" autocomplete="off" readonly>
                                                <small id="atas_nama_error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
            var id_nasabah = $('#id_nasabah').val();
            // tampilkan data nasabah
            $.ajax({
                url: "/Profil/show_user/" + id_nasabah,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_nasabah').val(data.id);
                    $('#nama_nasabah').val(data.nama_nasabah);
                    $('#username').val(data.username);
                    // tampilkan keterangan pada password
                    $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
                    $('#alamat').val(data.alamat);
                    $('#telepon').val(data.telepon);
                    $('#nama_bank').val(data.nama_bank);
                    $('#no_rek').val(data.no_rek);
                    $('#atas_nama').val(data.atas_nama);
                    $('#imagePreview').show();
                    if (data.foto == '') {
                        $('.foto-preview').attr('src', '/images/nasabah/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/nasabah/' + data.foto);
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
            $('#nama_nasabah').removeAttr('readonly');
            $('#username').removeAttr('readonly');
            $('#password').removeAttr('readonly');
            $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
            $('#alamat').removeAttr('readonly');
            $('#telepon').removeAttr('readonly');
            $('#nama_bank').removeAttr('readonly');
            $('#no_rek').removeAttr('readonly');
            $('#atas_nama').removeAttr('readonly');
            $('#foto_profil').removeAttr('style');
        });
        // ===============================================================================================

        // ============================================ Form =============================================
        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            var data = new FormData($("#formNasabah")[0]);
            $.ajax({
                url: "/Profil/update_user",
                method: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    //Data error 
                    if (data.error) {
                        if (data.nasabah_error['nama_nasabah'] != '') $('#nama_nasabah_error').html(data.nasabah_error['nama_nasabah']);
                        else $('#nama_nasabah_error').html('');
                        if (data.nasabah_error['username'] != '') $('#username_error').html(data.nasabah_error['username']);
                        else $('#username_error').html('');
                        if (data.nasabah_error['alamat'] != '') $('#alamat_error').html(data.nasabah_error['alamat']);
                        else $('#alamat_error').html('');
                        if (data.nasabah_error['telepon'] != '') $('#telepon_error').html(data.nasabah_error['telepon']);
                        else $('#telepon_error').html('');
                        if (data.nasabah_error['nama_bank'] != '') $('#nama_bank_error').html(data.nasabah_error['nama_bank']);
                        else $('#nama_bank_error').html('');
                        if (data.nasabah_error['no_rek'] != '') $('#no_rek_error').html(data.nasabah_error['no_rek']);
                        else $('#no_rek_error').html('');
                        if (data.nasabah_error['atas_nama'] != '') $('#atas_nama_error').html(data.nasabah_error['atas_nama']);
                        else $('#atas_nama_error').html('');
                        if (data.nasabah_error['foto'] != '') $('#foto_error').html(data.nasabah_error['foto']);
                        else $('#foto_error').html('');
                    }
                    //Data user berhasil disimpan
                    if (data.success) {
                        // reset form
                        $('#formNasabah')[0].reset();
                        $('#modalUser').modal('hide');
                        $('#nama_nasabah_error').html('');
                        $('#username_error').html('');
                        $('#password_error').html('');
                        $('#alamat_error').html('');
                        $('#telepon_error').html('');
                        $('#nama_bank_error').html('');
                        $('#no_rek_error').html('');
                        $('#atas_nama_error').html('');
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
            $('#nama_nasabah').attr('readonly', 'true');
            $('#username').attr('readonly', 'true');
            $('#password').attr('readonly', 'true');
            $('#password').val('');
            $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
            $('#alamat').attr('readonly', 'true');
            $('#telepon').attr('readonly', 'true');
            $('#nama_bank').attr('readonly', 'true');
            $('#no_rek').attr('readonly', 'true');
            $('#atas_nama').attr('readonly', 'true');
            $('#foto_profil').attr('style', 'display:none;');
        }
        // ==============================================================================================

    });
</script>
<?= $this->endSection() ?>