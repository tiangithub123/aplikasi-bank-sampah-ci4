<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Penarikan</h1>
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
                            <table id="tabel-penarikan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Nama Nasabah</th>
                                        <th>Nama Bank</th>
                                        <th>No. Rekening</th>
                                        <th>Jumlah</th>
                                        <th>Tgl. Verikasi</th>
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

    <div class="modal fade" id="modalPenarikan" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- judul form data Penarikan -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data Penarikan -->
                <form id="formPenarikan" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_penarikan" id="id_penarikan">
                        <input type="hidden" name="id_nasabah" id="id_nasabah">
                        <div class="form-group">
                            <label>Nama Nasabah</label>
                            <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>no. Rekening</label>
                            <textarea class="form-control" name="no_rek" id="no_rek" rows="3" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off" readonly>
                            </div>
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

        // format rupiah
        var jumlah = document.getElementById('jumlah');
        jumlah.addEventListener('keyup', function(e) {
            jumlah.value = formatRupiah(this.value);
        });

        // menampilkan data sampah
        var table = $('#tabel-penarikan').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Penarikan/loadDataAdmin",
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
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "className": 'text-center',
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
                    "targets": [8],
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
            $('#modalLabel').text('Edit Penarikan');
            // tampilkan berdasarkan id_penarikan
            const id_penarikan = $(this).attr('value');
            $.ajax({
                url: "/Penarikan/show_transaksi/" + id_penarikan,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_penarikan').val(data.id);
                    $('#id_nasabah').val(data.id_nasabah);
                    $('#nama_nasabah').val(data.nama_nasabah);
                    $('#nama_bank').val(data.nama_bank);
                    $('#no_rek').val(data.no_rek);
                    $('#jumlah').val(convertToRupiah(data.jumlah));
                    $('#status').val(data.status);
                    $('#modalPenarikan').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Edit Penarikan") {
                var data = new FormData($("#formPenarikan")[0]);
                $.ajax({
                    url: "/Penarikan/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.penarikan_error['status'] != '') $('#status_error').html(data.penarikan_error['status']);
                            else $('#status_error').html('');
                        }
                        //Data sampah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formPenarikan')[0].reset();
                            $('#modalPenarikan').modal('hide');
                            $('#status_error').html('');
                            $('#tabel-penarikan').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Transaksi Penarikan berhasil diupdate.'
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