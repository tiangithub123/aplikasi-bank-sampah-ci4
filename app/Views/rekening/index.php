<?= $this->extend('layout/admin/user_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Rekening</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
                    <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalRekening" role="button">
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
                            <table id="tabel-rekening" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Bank</th>
                                        <th>No. Rekening</th>
                                        <th>Atas Nama</th>
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

    <div class="modal fade" id="modalRekening" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- judul form data Rekening -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data Rekening -->
                <form id="formRekening" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_rekening" id="id_rekening">
                        <input type="hidden" name="id_nasabah" id="id_nasabah" value="<?= $id; ?>">
                        <div class="form-group">
                            <label>Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank" autocomplete="off">
                            <small id="nama_bank_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>No. Rekening</label>
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening" autocomplete="off">
                            <small id="no_rekening_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input type="text" class="form-control" id="atas_nama" name="atas_nama" autocomplete="off">
                            <small id="atas_nama_error" class="text-danger"></small>
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

        // menampilkan data rekening
        var table = $('#tabel-rekening').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Rekening/loadData",
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
                    "width": '100px',
                    "className": 'text-center',

                },
                {
                    "targets": [2],
                    "width": '100px',
                    "className": 'text-center',

                },
                {
                    "responsivePriority": 1,
                    "targets": [3],
                    "width": '100px',
                    "className": 'text-center',

                },
                {
                    "responsivePriority": 2,
                    "targets": [4],
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
            $('#formRekening')[0].reset();
            // judul form
            $('#modalLabel').text('Input Data Rekening');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            // judul form
            $('#modalLabel').text('Edit Data Rekening');
            // tampilkan berdasarkan id_rekening
            const id_rekening = $(this).attr('value');
            $.ajax({
                url: "/Rekening/show/" + id_rekening,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_rekening').val(data.id);
                    $('#nama_bank').val(data.nama_bank);
                    $('#no_rekening').val(data.no_rekening);
                    $('#atas_nama').val(data.atas_nama);
                    $('#modalRekening').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data rekening yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Rekening") {
                var data = new FormData($("#formRekening")[0]);
                $.ajax({
                    url: "/Rekening/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.rekening_error['nama_bank'] != '') $('#nama_bank_error').html(data.rekening_error['nama_bank']);
                            else $('#nama_bank_error').html('');
                            if (data.rekening_error['no_rekening'] != '') $('#no_rekening_error').html(data.rekening_error['no_rekening']);
                            else $('#no_rekening_error').html('');
                            if (data.rekening_error['atas_nama'] != '') $('#atas_nama_error').html(data.rekening_error['atas_nama']);
                            else $('#atas_nama_error').html('');
                        }
                        //Data rekening berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formRekening')[0].reset();
                            $('#modalRekening').modal('hide');
                            $('#nama_bank_error').html('');
                            $('#no_rekening_error').html('');
                            $('#atas_nama_error').html('');
                            $('#tabel-rekening').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Rekening berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data Rekening") {
                var data = new FormData($("#formRekening")[0]);
                $.ajax({
                    url: "/Rekening/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.rekening_error['nama_bank'] != '') $('#nama_bank_error').html(data.rekening_error['nama_bank']);
                            else $('#nama_bank_error').html('');
                            if (data.rekening_error['no_rekening'] != '') $('#no_rekening_error').html(data.rekening_error['no_rekening']);
                            else $('#no_rekening_error').html('');
                            if (data.rekening_error['atas_nama'] != '') $('#atas_nama_error').html(data.rekening_error['atas_nama']);
                            else $('#atas_nama_error').html('');
                        }
                        //Data rekening berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formRekening')[0].reset();
                            $('#modalRekening').modal('hide');
                            $('#nama_bank_error').html('');
                            $('#no_rekening_error').html('');
                            $('#atas_nama_error').html('');
                            $('#tabel-rekening').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Rekening berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data rekening
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data rekening ini?",
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
                            $('#tabel-rekening').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Rekening berhasil dihapus.'
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