<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Satuan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
                    <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalSatuan" role="button">
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
                            <table id="tabel-satuan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Satuan</th>
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

    <div class="modal fade" id="modalSatuan" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- judul form data Satuan -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data Satuan -->
                <form id="formSatuan" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_satuan" id="id_satuan">
                        <div class="form-group">
                            <label>Nama Satuan</label>
                            <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" autocomplete="off">
                            <small id="nama_satuan_error" class="text-danger"></small>
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
    $(document).ready(function() {
        // initial plugins
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        // menampilkan data satuan
        var table = $('#tabel-satuan').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Satuan/loadData",
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
                    "responsivePriority": 1,
                    "targets": [1],
                    "width": '200px',
                },
                {
                    "responsivePriority": 2,
                    "targets": [2],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                },
            ],
        });

        // ============================================ Form =============================================
        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            // reset form
            $('#formSatuan')[0].reset();
            // judul form
            $('#modalLabel').text('Input Data Satuan');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            // judul form
            $('#modalLabel').text('Edit Data Satuan');
            // tampilkan berdasarkan id_satuan
            const id_satuan = $(this).attr('value');
            $.ajax({
                url: "/Satuan/show/" + id_satuan,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_satuan').val(data.id);
                    $('#nama_satuan').val(data.nama_satuan);
                    $('#modalSatuan').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data satuan yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Satuan") {
                var data = new FormData($("#formSatuan")[0]);
                $.ajax({
                    url: "/Satuan/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.satuan_error['nama_satuan'] != '') $('#nama_satuan_error').html(data.satuan_error['nama_satuan']);
                            else $('#nama_satuan_error').html('');
                        }
                        //Data satuan berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formSatuan')[0].reset();
                            $('#modalSatuan').modal('hide');
                            $('#nama_satuan_error').html('');
                            $('#tabel-satuan').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Satuan berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data Satuan") {
                var data = new FormData($("#formSatuan")[0]);
                $.ajax({
                    url: "/Satuan/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.satuan_error['nama_satuan'] != '') $('#nama_satuan_error').html(data.satuan_error['nama_satuan']);
                            else $('#nama_satuan_error').html('');
                        }
                        //Data satuan berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formSatuan')[0].reset();
                            $('#modalSatuan').modal('hide');
                            $('#nama_satuan_error').html('');
                            $('#tabel-satuan').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Satuan berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data satuan
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data satuan ini?",
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
                            $('#tabel-satuan').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Satuan berhasil dihapus.'
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