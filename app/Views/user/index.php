<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Managemen User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
                    <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalUser" role="button">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary card-outline">
                        <div class="card-body table-responsive">
                            <table id="tabel-user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Foto</th>
                                        <th>Nama User</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <div class="modal fade" id="modalUser" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- judul form data User -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i><span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data User -->
                <form id="formUser" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" id="id_user">
                        <div class="form-group">
                            <label>Nama User</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" autocomplete="off">
                            <small id="nama_user_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                            <small id="username_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                            <small id="password_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" id="level" name="level" autocomplete="off" required>
                                <option value="">-- Pilih --</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                            <small id="level_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <div class="custom-file">
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
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mr-2" id="btnSimpan">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
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
        // initial plugins
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        // menampilkan data user
        var table = $('#tabel-user').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/User/loadData",
                "type": "POST"
            },
            responsive: {
                details: {
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.hidden ?
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                '<td>' + col.title + ':' + '</td> ' +
                                '<td>' + col.data + '</td>' +
                                '</tr>' :
                                '';
                        }).join('');

                        return data ?
                            $('<table/>').append(data) :
                            false;
                    }
                }
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                    "width": '30px',
                    "className": 'text-center',
                },
                {
                    "targets": [1],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        if (data == '') {
                            return "<img class='img-circle' src='/images/user/no_image.gif' style='height:50px;width:50px;align:middle;'/>";
                        } else {
                            return '<img src="/images/user/' + data + '"style="height:50px;width:50px;align:middle;" class="img-circle" />';
                        }
                    }
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '100px',
                },
                {
                    "targets": [3],
                    "width": '150px',
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "responsivePriority": 2,
                    "targets": [5],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                },
            ],
        });

        // ============================================ Form =============================================
        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            // sembunyikan image preview
            $('#imagePreview').hide();
            // reset form
            $('#formUser')[0].reset();
            $('#password').attr('placeholder', '');
            // judul form
            $('#modalLabel').text('Input Data User');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            // judul form
            $('#modalLabel').text('Edit Data User');
            // tampilkan berdasarkan id_user
            const id_user = $(this).attr('value');
            $.ajax({
                url: "/User/show/" + id_user,
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
                    $('#modalUser').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data user yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data User") {
                var data = new FormData($("#formUser")[0]);
                $.ajax({
                    url: "/User/save",
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
                            if (data.user_error['password'] != '') $('#password_error').html(data.user_error['password']);
                            else $('#password_error').html('');
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
                            $('#tabel-user').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data User berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data User") {
                var data = new FormData($("#formUser")[0]);
                $.ajax({
                    url: "/User/update",
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
                            $('#level_error').html('');
                            $('#foto_error').html('');
                            $('#tabel-user').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data User berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data user
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data user ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        success: function(response) {
                            $('#tabel-user').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data User berhasil dihapus.'
                            })
                        }
                    });
                }
            });
        });
        // ===================================================================
    });
</script>
<?= $this->endSection() ?>