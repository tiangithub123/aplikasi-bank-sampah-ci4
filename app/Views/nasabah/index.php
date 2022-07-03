<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Nasabah</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
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
                            <table id="tabel-nasabah" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Foto</th>
                                        <th>Nama Nasabah</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
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

    <div class="modal fade" id="modalNasabah" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- judul form data Nasabah -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i><span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data Nasabah -->
                <form id="formNasabah" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_nasabah" id="id_nasabah">
                        <div class="form-group">
                            <label>Nama Nasabah</label>
                            <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" autocomplete="off">
                            <small id="nama_nasabah_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                            <small id="alamat_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" autocomplete="off">
                            <small id="telepon_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <div class="custom-file">
                                <input id="foto" name="foto" type="file" class="custom-file-input" onchange="previewFoto(this);">
                                <label class="custom-file-label" for="foto">Choose file</label>
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

        // menampilkan data nasabah
        var table = $('#tabel-nasabah').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Nasabah/loadData",
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
                            return "<img class='img-circle' src='/images/nasabah/no_image.gif' style='height:50px;width:50px;align:middle;'/>";
                        } else {
                            return '<img src="/images/nasabah/' + data + '"style="height:50px;width:50px;align:middle;" class="img-circle" />';
                        }
                    }
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '150px',
                },
                {
                    "targets": [3],
                    "width": '200px',
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
            $('#formNasabah')[0].reset();
            // judul form
            $('#modalLabel').text('Input Data Nasabah');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            // judul form
            $('#modalLabel').text('Edit Data Nasabah');
            // tampilkan berdasarkan id_nasabah
            const id_nasabah = $(this).attr('value');
            $.ajax({
                url: "/Nasabah/show/" + id_nasabah,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_nasabah').val(data.id);
                    $('#nama_nasabah').val(data.nama_nasabah);
                    $('#alamat').val(data.alamat);
                    $('#telepon').val(data.telepon);
                    $('#imagePreview').show();
                    if (data.foto == '') {
                        $('.foto-preview').attr('src', '/images/nasabah/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/nasabah/' + data.foto);
                    }
                    $('#modalNasabah').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            if ($('#modalLabel').text() == "Edit Data Nasabah") {
                var data = new FormData($("#formNasabah")[0]);
                $.ajax({
                    url: "/Nasabah/update",
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
                            if (data.nasabah_error['alamat'] != '') $('#alamat_error').html(data.nasabah_error['alamat']);
                            else $('#alamat_error').html('');
                            if (data.nasabah_error['telepon'] != '') $('#telepon_error').html(data.nasabah_error['telepon']);
                            else $('#telepon_error').html('');
                            if (data.nasabah_error['foto'] != '') $('#foto_error').html(data.nasabah_error['foto']);
                            else $('#foto_error').html('');
                        }
                        //Data nasabah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formNasabah')[0].reset();
                            $('#modalNasabah').modal('hide');
                            $('#nama_nasabah_error').html('');
                            $('#alamat_error').html('');
                            $('#telepon_error').html('');
                            $('#foto_error').html('');
                            $('#tabel-nasabah').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Nasabah berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data nasabah
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data nasabah ini?",
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
                            $('#tabel-nasabah').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Nasabah berhasil dihapus.'
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