<?= $this->extend('layout/admin/user_layout') ?>
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
                    <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalPenarikan" role="button">
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
                            <table id="tabel-penarikan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
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
                        <input type="hidden" name="nama_bank_cek" id="nama_bank_cek">
                        <input type="hidden" name="no_rek_cek" id="no_rek_cek">
                        <input type="hidden" name="id_nasabah" id="id_nasabah" value="<?= $id; ?>">
                        <div class="form-group">
                            <label>Sisa saldo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" id="saldo" name="saldo" value="<?= number_format($saldo, 0, ".", "."); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Bank</label>
                            <input class="form-control" type="text" name="nama_bank" id="nama_bank" value="<?= $nama_bank; ?>" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>No. Rekening</label>
                            <input class="form-control" type="text" name="no_rek" id="no_rek" value="<?= $no_rek; ?>" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off">
                            </div>
                            <small id="jumlah_error" class="text-danger"></small>
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
                "url": "/Penarikan/loadDataUser",
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
                    "className": 'text-center',
                },
                {
                    "targets": [3],
                    "width": '200px',
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "className": 'text-right',
                    render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
                },
                {
                    "targets": [5],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [6],
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
                    "targets": [7],
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
            $('#formPenarikan')[0].reset();
            // judul form
            $('#modalLabel').text('Input Penarikan');
            // tampilkan berdasarkan id_nasabah
            const id_nasabah = $('#id_nasabah').val();;
            $.ajax({
                url: "/Penarikan/show_nasabah/" + id_nasabah,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#nama_bank_cek').val(data.nama_bank);
                    $('#no_rek_cek').val(data.no_rek);
                }
            })
        });

        // Tampilkan placeholder
        $('#jenis').change(function() {
            var jenis = $('#jenis').val();
            if (jenis === 'Transfer') {
                $('#keterangan').attr('placeholder', 'Isi dengan format nama bank, no. rekening, atas nama');
            } else {
                $('#keterangan').attr('placeholder', 'Isi dengan format no. rekening listrik, atas nama');
            }
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Penarikan") {
                var saldo = convertToAngka($('#saldo').val());
                var jumlah = convertToAngka($('#jumlah').val());
                var nama_bank_cek = $('#nama_bank_cek').val();
                var no_rek_cek = $('#no_rek_cek').val();

                if (eval(jumlah) > eval(saldo)) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Jumlah tidak boleh melebihi sisa saldo'
                    })
                } else if (nama_bank_cek == '' && no_rek_cek == '') {
                    // tampilkan pesan gagal hapus data
                    Toast.fire({
                        icon: 'warning',
                        title: 'Lengkapi data Anda di pengaturan profil dulu.'
                    })
                } else {
                    var data = new FormData($("#formPenarikan")[0]);
                    $.ajax({
                        url: "/Penarikan/save",
                        method: "POST",
                        data: data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            //Data error 
                            if (data.error) {
                                if (data.penarikan_error['jumlah'] != '') $('#jumlah_error').html(data.penarikan_error['jumlah']);
                                else $('#jumlah_error').html('');
                            }
                            //Data sampah berhasil disimpan
                            if (data.success) {
                                // reset form
                                $('#formPenarikan')[0].reset();
                                $('#modalPenarikan').modal('hide');
                                $('#jumlah_error').html('');
                                $('#tabel-penarikan').DataTable().ajax.reload();
                                // tampilkan pesan sukses simpan data
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaksi Penarikan berhasil disimpan.'
                                })
                            }
                        }
                    });
                }


            }
        });

        // Hapus data sampah
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            // ambil data dari datatables
            var data = table.row($(this).parents('tr')).data();
            // membuat variabel untuk menampung data
            var status = data[6];
            // jika status tid
            if (status != 'Menunggu') {
                // tampilkan pesan gagal hapus data
                Toast.fire({
                    icon: 'error',
                    title: 'Data Transaksi tidak bisa dihapus.'
                })
            } else {
                const url = $(this).attr('href');
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Anda ingin menghapus data transaksi ini?",
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
                                $('#tabel-penarikan').DataTable().ajax.reload()
                                // tutup sweet alert
                                swal.close();
                                // tampilkan pesan sukses hapus data
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaksi Penarikan berhasil dihapus.'
                                })
                            }
                        });
                    }
                });
            }
        });
        // ===================================================================
    });
</script>
<?= $this->endSection() ?>