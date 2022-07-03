<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NasabahModel;
use Config\Services;

class Nasabah extends BaseController
{
    protected $M_nasabah;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_nasabah       = new NasabahModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Nasabah | Rewaste World";
        $data['menu']      = "";
        $data['page']      = "nasabah";
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('nasabah/index', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_nasabah)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_nasabah . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalNasabah'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('Nasabah/delete/' . $id_nasabah) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_nasabah)
    {
        $data = $this->M_nasabah->find($id_nasabah);
        echo json_encode($data);
    }

    // Update data nasabah
    public function update()
    {
        $id           = $this->request->getPost('id_nasabah');
        $nama_nasabah = $this->request->getPost('nama_nasabah');
        $alamat       = $this->request->getPost('alamat');
        $telepon      = $this->request->getPost('telepon');
        $foto         = $this->request->getFile('foto');

        //data nasabah
        $data_validasi = [
            'nama_nasabah' => $nama_nasabah,
            'alamat'       => $alamat,
            'telepon'      => $telepon,
            'foto'         => $foto
        ];

        //Cek Validasi data nasabah, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'nasabah_edit') == FALSE) {

            $validasi = [
                'error'   => true,
                'nasabah_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            if ($foto == '') {
                //data nasabah
                $data = [
                    'nama_nasabah' => $nama_nasabah,
                    'alamat'       => $alamat,
                    'telepon'      => $telepon
                ];
                //Update data nasabah
                $this->M_nasabah->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file foto peserta ke direktori public/nasabah
                $nama_foto = $foto->getRandomName();
                $foto->move('images/nasabah', $nama_foto);
                //data nasabah
                $data = [
                    'nama_nasabah' => $nama_nasabah,
                    'alamat'       => $alamat,
                    'telepon'      => $telepon,
                    'foto'         => $nama_foto
                ];
                // hapus foto lama
                $old_foto = $this->M_nasabah->find($id);
                if ($old_foto['foto'] == true) {
                    unlink('images/nasabah/' . $old_foto['foto']);
                }
                //Update data nasabah
                $this->M_nasabah->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data nasabah
    public function delete($id_nasabah)
    {
        $data = $this->M_nasabah->find($id_nasabah);
        // delete foto
        if ($data['foto'] == true) {
            unlink('images/nasabah/' . $data['foto']);
        }
        $this->M_nasabah->delete($id_nasabah);
    }

    // tampilkan data nasabah
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_nasabah->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->foto;
                $row[] = $list->nama_nasabah;
                $row[] = $list->alamat;
                $row[] = $list->telepon;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_nasabah->count_all(),
                "recordsFiltered" => $this->M_nasabah->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
