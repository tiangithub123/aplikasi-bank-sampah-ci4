<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Setor Sampah</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
                    <!-- <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalSetorSampah" role="button">
                        <i class="fas fa-plus"></i> Tambah
                    </a> -->
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
                                        <th>Nama Nasabah</th>
                                        <th>No. Telepon</th>
                                        <th>Nama Sampah</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Total</th>
                                        <th>Alamat</th>
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
                        <input type="hidden" name="id_nasabah" id="id_nasabah">
                        <input type="hidden" name="id_sampah" id="id_sampah">
                        <div class="form-group">
                            <label>Nama Nasabah</label>
                            <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Sampah</label>
                            <input type="text" class="form-control" id="nama_sampah" name="nama_sampah" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="harga" name="harga" autocomplete="off" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="nama_satuan"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>Total</label>
                            <input type="text" class="form-control" id="total" name="total" autocomplete="off" readonly>
                            <small id="total_error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Tgl. Penjemputan</label>
                            <input type="text" class="form-control" id="tgl_penjemputan" name="tgl_penjemputan" readonly>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status" name="status" autocomplete="off">
                                <option value="Menunggu">Menunggu</option>
                                <option value="Berhasil">Berhasil</option>
                                <option value="Gagal">Gagal</option>
                            </select>
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
                "url": "/SetorSampah/loadDataAdmin",
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
                    "width": '80px',
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "width": '100px',
                },
                {
                    "targets": [5],
                    "width": '50px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        var btn = data + " " + row[6];
                        return btn;
                    }
                },
                {
                    "targets": [6],
                    "width": '100px',
                    "visible": false,
                },
                {
                    "targets": [7],
                    "width": '100px',
                    "className": 'text-right',
                    render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
                },
                {
                    "targets": [8],
                    "width": '100px',
                },
                {
                    "targets": [9],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [10],
                    "width": '80px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        switch (data) {
                            case 'Menunggu':
                                return '<span class="badge bg-warning">' + data + '</span>';
                                break;
                            case 'Berhasil':
                                return '<span class="badge bg-success">' + data + '</span>';
                                break;
                            case 'Gagal':
                                return '<span class="badge bg-danger">' + data + '</span>';
                                break;
                        }
                    }
                },
                {
                    "responsivePriority": 2,
                    "targets": [11],
                    "orderable": false,
                    "width": '80px',
                    "className": 'text-center',
                },
            ],
        });

        // ============================================ Form =============================================
        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            // judul form
            $('#modalLabel').text('Edit Data Setor Sampah');
            // ambil data dari datatables
            var data = table.row($(this).parents('tr')).data();
            // membuat variabel untuk menampung data
            var tgl_penjemputan = data[7];
            // tampilkan berdasarkan id_setor
            const id_setor = $(this).attr('value');
            $.ajax({
                url: "/SetorSampah/show_transaksi/" + id_setor,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_setor').val(data.id);
                    $('#id_nasabah').val(data.id_nasabah);
                    $('#id_sampah').val(data.id_sampah);
                    $('#nama_nasabah').val(data.nama_nasabah);
                    $('#nama_sampah').val(data.nama_sampah);
                    $('#harga').val(convertToRupiah(data.harga));
                    $('#nama_satuan').text('/' + data.nama_satuan);
                    $('#jumlah').val(data.jumlah);
                    $('#total').val(convertToRupiah(data.total));
                    $('#tgl_penjemputan').val(tgl_penjemputan);
                    $('#status').val(data.status);
                    $('#modalSetorSampah').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Edit Data Setor Sampah") {
                var data = new FormData($("#formSetorSampah")[0]);
                $.ajax({
                    url: "/SetorSampah/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.setor_sampah_error['status'] != '') $('#status_error').html(data.setor_sampah_error['status']);
                            else $('#status_error').html('');
                        }
                        //Data sampah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formSetorSampah')[0].reset();
                            $('#modalSetorSampah').modal('hide');
                            $('#status_error').html('');
                            $('#tabel-setor-sampah').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Setor Sampah berhasil diupdate.'
                            })
                        }
                    }
                });
            }
        });
        // ===================================================================
    });
</script>
<?= $this->endSection() ?>