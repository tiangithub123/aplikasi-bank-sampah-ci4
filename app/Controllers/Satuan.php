<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SatuanModel;
use Config\Services;

class Satuan extends BaseController
{
    protected $M_satuan;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_satuan        = new SatuanModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Satuan | Rewaste World";
        $data['menu']      = "data_sampah";
        $data['page']      = "satuan";
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('satuan/index', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_satuan)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_satuan . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalSatuan'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('Satuan/delete/' . $id_satuan) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_satuan)
    {
        $data = $this->M_satuan->find($id_satuan);
        echo json_encode($data);
    }

    // Simpan data satuan
    public function save()
    {
        $nama_satuan = $this->request->getPost('nama_satuan');

        $data_validasi = [
            'nama_satuan' => $nama_satuan
        ];

        //Cek Validasi Data Satuan, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'satuan') == FALSE) {

            $validasi = [
                'error'   => true,
                'satuan_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            //data satuan
            $data = [
                'nama_satuan' => $nama_satuan
            ];
            //Simpan data satuan
            $this->M_satuan->save($data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data satuan
    public function update()
    {
        $id          = $this->request->getPost('id_satuan');
        $nama_satuan = $this->request->getPost('nama_satuan');

        //data satuan
        $data_validasi = [
            'nama_satuan' => $nama_satuan
        ];

        //Cek Validasi data satuan, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'satuan') == FALSE) {

            $validasi = [
                'error'   => true,
                'satuan_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            //data satuan
            $data = [
                'nama_satuan' => $nama_satuan
            ];
            //Update data satuan
            $this->M_satuan->update($id, $data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data satuan
    public function delete($id_satuan)
    {
        $this->M_satuan->delete($id_satuan);
    }

    // tampilkan data satuan
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_satuan->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_satuan;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_satuan->count_all(),
                "recordsFiltered" => $this->M_satuan->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
