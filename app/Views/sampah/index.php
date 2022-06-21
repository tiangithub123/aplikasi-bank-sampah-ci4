<?= $this->extend('layout/admin/admin_layout') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Sampah</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- tombol tambah data -->
                    <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalSampah" role="button">
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
                            <table id="tabel-sampah" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Foto</th>
                                        <th>Nama Sampah</th>
                                        <th>Jenis</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Stok</th>
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

    <div class="modal fade" id="modalSampah" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- judul form data Sampah -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- isi form data Sampah -->
                <form id="formSampah" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id_sampah" id="id_sampah">
                                <div class="form-group">
                                    <label>Nama Sampah</label>
                                    <input type="text" class="form-control" id="nama_sampah" name="nama_sampah" autocomplete="off">
                                    <small id="nama_sampah_error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Sampah</label>
                                    <select class="form-control chosen-select" name="id_jenis" id="id_jenis">
                                        <option value="">-- Pilih --</option>
                                        <?php foreach ($jenis as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['nama_jenis']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <small id="id_jenis_error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control chosen-select" name="id_satuan" id="id_satuan">
                                        <option value="">-- Pilih --</option>
                                        <?php foreach ($satuan as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['nama_satuan']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <small id="id_satuan_error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                                    <small id="deskripsi_error" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" id="harga" name="harga" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off">
                                    <small id="harga_error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" autocomplete="off">
                                    <small id="stok_error" class="text-danger"></small>
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

        // Format Rupiah
        var harga = document.getElementById('harga');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value);
        });

        // menampilkan data sampah
        var table = $('#tabel-sampah').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Sampah/loadData",
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
                            return "<img class='img-circle' src='/images/sampah/no_image.gif' style='height:50px;width:50px;align:middle;'/>";
                        } else {
                            return '<img src="/images/sampah/' + data + '"style="height:50px;width:50px;align:middle;" class="img-circle" />';
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
                    "width": '200px',
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
            // sembunyikan image preview
            $('#imagePreview').hide();
            // reset form
            $('#formSampah')[0].reset();
            $('#id_jenis').val('').trigger('chosen:updated');
            $('#id_satuan').val('').trigger('chosen:updated');
            // judul form
            $('#modalLabel').text('Input Data Sampah');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            // judul form
            $('#modalLabel').text('Edit Data Sampah');
            // ambil data dari datatables
            var data = table.row($(this).parents('tr')).data();
            // tampilkan berdasarkan id_sampah
            const id_sampah = $(this).attr('value');
            $.ajax({
                url: "/Sampah/show/" + id_sampah,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_sampah').val(data.id);
                    $('#nama_sampah').val(data.nama_sampah);
                    $('#id_jenis').val(data.id_jenis).trigger('chosen:updated');
                    $('#id_satuan').val(data.id_satuan).trigger('chosen:updated');
                    $('#deskripsi').val(data.deskripsi);
                    $('#stok').val(data.stok);
                    $('#harga').val(convertToRupiah(data.harga));
                    $('#imagePreview').show();
                    if (data.foto == '') {
                        $('.foto-preview').attr('src', '/images/sampah/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/sampah/' + data.foto);
                    }
                    $('#modalSampah').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Sampah") {
                var data = new FormData($("#formSampah")[0]);
                $.ajax({
                    url: "/Sampah/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.sampah_error['nama_sampah'] != '') $('#nama_sampah_error').html(data.sampah_error['nama_sampah']);
                            else $('#nama_sampah_error').html('');
                            if (data.sampah_error['id_jenis'] != '') $('#id_jenis_error').html(data.sampah_error['id_jenis']);
                            else $('#id_jenis_error').html('');
                            if (data.sampah_error['id_satuan'] != '') $('#id_satuan_error').html(data.sampah_error['id_satuan']);
                            else $('#id_satuan_error').html('');
                            if (data.sampah_error['deskripsi'] != '') $('#deskripsi_error').html(data.sampah_error['deskripsi']);
                            else $('#deskripsi_error').html('');
                            if (data.sampah_error['harga'] != '') $('#harga_error').html(data.sampah_error['harga']);
                            else $('#harga_error').html('');
                            if (data.sampah_error['stok'] != '') $('#stok_error').html(data.sampah_error['stok']);
                            else $('#stok_error').html('');
                            if (data.sampah_error['foto'] != '') $('#foto_error').html(data.sampah_error['foto']);
                            else $('#foto_error').html('');
                        }
                        //Data sampah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formSampah')[0].reset();
                            $('#modalSampah').modal('hide');
                            $('#nama_sampah_error').html('');
                            $('#id_jenis_error').html('');
                            $('#id_satuan_error').html('');
                            $('#deskripsi_error').html('');
                            $('#harga_error').html('');
                            $('#stok_error').html('');
                            $('#foto_error').html('');
                            $('#tabel-sampah').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Sampah berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data Sampah") {
                var data = new FormData($("#formSampah")[0]);
                $.ajax({
                    url: "/Sampah/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.sampah_error['nama_sampah'] != '') $('#nama_sampah_error').html(data.sampah_error['nama_sampah']);
                            else $('#nama_sampah_error').html('');
                            if (data.sampah_error['id_jenis'] != '') $('#id_jenis_error').html(data.sampah_error['id_jenis']);
                            else $('#id_jenis_error').html('');
                            if (data.sampah_error['id_satuan'] != '') $('#id_satuan_error').html(data.sampah_error['id_satuan']);
                            else $('#id_satuan_error').html('');
                            if (data.sampah_error['deskripsi'] != '') $('#deskripsi_error').html(data.sampah_error['deskripsi']);
                            else $('#deskripsi_error').html('');
                            if (data.sampah_error['harga'] != '') $('#harga_error').html(data.sampah_error['harga']);
                            else $('#harga_error').html('');
                            if (data.sampah_error['stok'] != '') $('#stok_error').html(data.sampah_error['stok']);
                            else $('#stok_error').html('');
                            if (data.sampah_error['foto'] != '') $('#foto_error').html(data.sampah_error['foto']);
                            else $('#foto_error').html('');
                        }
                        //Data sampah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formSampah')[0].reset();
                            $('#modalSampah').modal('hide');
                            $('#nama_sampah_error').html('');
                            $('#id_jenis_error').html('');
                            $('#id_satuan_error').html('');
                            $('#deskripsi_error').html('');
                            $('#harga_error').html('');
                            $('#stok_error').html('');
                            $('#foto_error').html('');
                            $('#tabel-sampah').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Sampah berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
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
                            $('#tabel-sampah').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Sampah berhasil dihapus.'
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