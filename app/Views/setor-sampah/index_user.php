<?= $this->extend('layout/admin/user_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Setor Sampah</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
                    <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalSetorSampah" role="button">
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
                            <table id="tabel-setor-sampah" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Nama Sampah</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Total</th>
                                        <th>Tgl. Penjemputan</th>
                                        <th>Status</th>
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

    <div class="modal fade" id="modalSetorSampah" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- judul form data SetorSampah -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data SetorSampah -->
                <form id="formSetorSampah" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_setor" id="id_setor">
                        <input type="hidden" name="id_nasabah" id="id_nasabah" value="<?= $id; ?>">
                        <div class="form-group">
                            <label>Nama Sampah</label>
                            <select class="form-control chosen-select" name="id_sampah" id="id_sampah">
                                <option value="">-- Pilih --</option>
                                <?php foreach ($sampah as $row) : ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['nama_sampah']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <small id="id_sampah_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" autocomplete="off">
                            <small id="jumlah_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" class="form-control" id="total" name="total" autocomplete="off" readonly>
                            <small id="total_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Tgl. Penjemputan</label>
                            <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tgl_penjemputan" name="tgl_penjemputan" value="<?php echo date("d-m-Y"); ?>">
                            <small id="tgl_mulai_error" class="text-danger"></small>
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

        // menampilkan data sampah
        var table = $('#tabel-setor-sampah').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/SetorSampah/loadDataUser",
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
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '100px',
                },
                {
                    "targets": [3],
                    "width": '100px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        var btn = data + " " + row[4];
                        return btn;
                    }
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "visible": false,
                },
                {
                    "targets": [5],
                    "width": '100px',
                    "className": 'text-right',
                    render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
                },
                {
                    "targets": [6],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [7],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "responsivePriority": 2,
                    "targets": [8],
                    "orderable": false,
                    "width": '80px',
                    "className": 'text-center',
                },
            ],
        });

        // ============================================ Form =============================================
        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            // reset form
            $('#formSetorSampah')[0].reset();
            $('#id_sampah').val('').trigger('chosen:updated');
            // judul form
            $('#modalLabel').text('Input Data Setor Sampah');
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Setor Sampah") {
                var data = new FormData($("#formSetorSampah")[0]);
                $.ajax({
                    url: "/SetorSampah/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.setor_sampah_error['id_sampah'] != '') $('#id_sampah_error').html(data.setor_sampah_error['id_sampah']);
                            else $('#id_sampah_error').html('');
                            if (data.setor_sampah_error['jumlah'] != '') $('#jumlah_error').html(data.setor_sampah_error['jumlah']);
                            else $('#jumlah_error').html('');
                            if (data.setor_sampah_error['total'] != '') $('#total_error').html(data.setor_sampah_error['total']);
                            else $('#total_error').html('');
                            if (data.setor_sampah_error['tgl_penjemputan'] != '') $('#tgl_penjemputan_error').html(data.setor_sampah_error['tgl_penjemputan']);
                            else $('#tgl_penjemputan_error').html('');
                        }
                        //Data sampah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formSetorSampah')[0].reset();
                            $('#modalSetorSampah').modal('hide');
                            $('#id_sampah_error').html('');
                            $('#jumlah_error').html('');
                            $('#total_error').html('');
                            $('#tgl_penjemputan_error').html('');
                            $('#tabel-setor-sampah').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Transaksi Setor Sampah berhasil disimpan.'
                            })
                        }
                    }
                });
            }
        });

        // Hapus data sampah
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data sampah ini?",
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
                            $('#tabel-setor-sampah').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Transaksi Setor Sampah berhasil dihapus.'
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