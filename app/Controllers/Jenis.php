<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisModel;
use Config\Services;

class Jenis extends BaseController
{
    protected $M_jenis;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_jenis         = new JenisModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Jenis | Rewaste World";
        $data['menu']      = "data_sampah";
        $data['page']      = "jenis";
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('jenis/index', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_jenis)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_jenis . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalJenis'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('Jenis/delete/' . $id_jenis) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_jenis)
    {
        $data = $this->M_jenis->find($id_jenis);
        echo json_encode($data);
    }

    // Simpan data jenis
    public function save()
    {
        $nama_jenis = $this->request->getPost('nama_jenis');

        $data_validasi = [
            'nama_jenis' => $nama_jenis
        ];

        //Cek Validasi Data Jenis, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'jenis') == FALSE) {

            $validasi = [
                'error'   => true,
                'jenis_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            //data jenis
            $data = [
                'nama_jenis' => $nama_jenis
            ];
            //Simpan data jenis
            $this->M_jenis->save($data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data jenis
    public function update()
    {
        $id         = $this->request->getPost('id_jenis');
        $nama_jenis = $this->request->getPost('nama_jenis');

        //data jenis
        $data_validasi = [
            'nama_jenis' => $nama_jenis
        ];

        //Cek Validasi data jenis, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'jenis') == FALSE) {

            $validasi = [
                'error'       => true,
                'jenis_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            //data jenis
            $data = [
                'nama_jenis' => $nama_jenis
            ];
            //Update data jenis
            $this->M_jenis->update($id, $data);

            $validasi = [
                'success' => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data jenis
    public function delete($id_jenis)
    {
        $this->M_jenis->delete($id_jenis);
    }

    // tampilkan data jenis
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_jenis->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_jenis;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_jenis->count_all(),
                "recordsFiltered" => $this->M_jenis->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
