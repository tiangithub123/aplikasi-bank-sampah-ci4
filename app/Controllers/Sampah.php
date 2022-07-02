<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SampahModel;
use App\Models\JenisModel;
use App\Models\SatuanModel;
use Config\Services;

class Sampah extends BaseController
{
    protected $M_sampah;
    protected $M_jenis;
    protected $M_satuan;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_sampah        = new SampahModel($this->request);
        $this->M_jenis         = new JenisModel($this->request);
        $this->M_satuan        = new SatuanModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Sampah | Rewaste World";
        $data['menu']      = "data_sampah";
        $data['page']      = "sampah";
        $data['jenis']     = $this->M_jenis->findAll();
        $data['satuan']    = $this->M_satuan->findAll();
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('sampah/index', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_sampah)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_sampah . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalSampah'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('Sampah/delete/' . $id_sampah) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_sampah)
    {
        $data = $this->M_sampah->find($id_sampah);
        echo json_encode($data);
    }

    // Simpan data sampah
    public function save()
    {
        $nama_sampah = $this->request->getPost('nama_sampah');
        $id_jenis    = $this->request->getPost('id_jenis');
        $id_satuan   = $this->request->getPost('id_satuan');
        $harga       = str_replace('.', '', trim($this->request->getPost('harga')));
        $deskripsi   = $this->request->getPost('deskripsi');
        $stok        = $this->request->getPost('stok');
        $foto        = $this->request->getFile('foto');

        $data_validasi = [
            'nama_sampah' => $nama_sampah,
            'id_jenis'    => $id_jenis,
            'id_satuan'   => $id_satuan,
            'harga'       => $harga,
            'deskripsi'   => $deskripsi,
            'stok'        => $stok,
            'foto'        => $foto
        ];

        //Cek Validasi Data Sampah, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'sampah') == FALSE) {

            $validasi = [
                'error'   => true,
                'sampah_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            if ($foto == '') {
                //data sampah
                $data = [
                    'nama_sampah' => $nama_sampah,
                    'id_jenis'    => $id_jenis,
                    'id_satuan'   => $id_satuan,
                    'harga'       => $harga,
                    'deskripsi'   => $deskripsi,
                    'stok'        => $stok
                ];
                //Simpan data sampah
                $this->M_sampah->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file foto ke direktori public/sampah
                $nama_foto = $foto->getRandomName();
                $foto->move('images/sampah', $nama_foto);
                //Data Sampah
                $data = [
                    'nama_sampah' => $nama_sampah,
                    'id_jenis'    => $id_jenis,
                    'id_satuan'   => $id_satuan,
                    'harga'       => $harga,
                    'deskripsi'   => $deskripsi,
                    'stok'        => $stok,
                    'foto'        => $nama_foto
                ];
                //Simpan Data Sampah
                $this->M_sampah->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Update data sampah
    public function update()
    {
        $id          = $this->request->getPost('id_sampah');
        $nama_sampah = $this->request->getPost('nama_sampah');
        $id_jenis    = $this->request->getPost('id_jenis');
        $id_satuan   = $this->request->getPost('id_satuan');
        $harga       = str_replace('.', '', trim($this->request->getPost('harga')));
        $deskripsi   = $this->request->getPost('deskripsi');
        $stok        = $this->request->getPost('stok');
        $foto        = $this->request->getFile('foto');

        //data sampah
        $data_validasi = [
            'nama_sampah' => $nama_sampah,
            'id_jenis'    => $id_jenis,
            'id_satuan'   => $id_satuan,
            'harga'       => $harga,
            'deskripsi'   => $deskripsi,
            'stok'        => $stok,
            'foto'        => $foto
        ];

        //Cek Validasi data sampah, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'sampah') == FALSE) {

            $validasi = [
                'error'   => true,
                'sampah_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            if ($foto == '') {
                //data sampah
                $data = [
                    'nama_sampah' => $nama_sampah,
                    'id_jenis'    => $id_jenis,
                    'id_satuan'   => $id_satuan,
                    'harga'       => $harga,
                    'deskripsi'   => $deskripsi,
                    'stok'        => $stok
                ];
                //Update data sampah
                $this->M_sampah->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file foto peserta ke direktori public/sampah
                $nama_foto = $foto->getRandomName();
                $foto->move('images/sampah', $nama_foto);
                //data sampah
                $data = [
                    'nama_sampah' => $nama_sampah,
                    'id_jenis'    => $id_jenis,
                    'id_satuan'   => $id_satuan,
                    'harga'       => $harga,
                    'deskripsi'   => $deskripsi,
                    'stok'        => $stok,
                    'foto'        => $nama_foto
                ];
                // hapus foto lama
                $old_foto = $this->M_sampah->find($id);
                if ($old_foto['foto'] == true) {
                    unlink('images/sampah/' . $old_foto['foto']);
                }
                //Update data sampah
                $this->M_sampah->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data sampah
    public function delete($id_sampah)
    {
        $data = $this->M_sampah->find($id_sampah);
        // delete foto
        if ($data['foto'] == true) {
            unlink('images/sampah/' . $data['foto']);
        }
        $this->M_sampah->delete($id_sampah);
    }

    // tampilkan data sampah
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_sampah->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->foto;
                $row[] = $list->nama_sampah;
                $row[] = $list->nama_jenis;
                $row[] = $list->nama_satuan;
                $row[] = $list->harga;
                $row[] = $list->deskripsi;
                $row[] = $list->stok;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_sampah->count_all(),
                "recordsFiltered" => $this->M_sampah->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
