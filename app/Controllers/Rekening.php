<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RekeningModel;
use Config\Services;

class Rekening extends BaseController
{
    protected $M_rekening;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_rekening      = new RekeningModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']        = "Data Rekening | Rewaste World";
        $data['menu']         = "";
        $data['page']         = "rekening";
        $data['id']           = $this->session->get('id');
        $data['nama_nasabah'] = $this->session->get('nama_nasabah');
        $data['saldo']        = $this->session->get('saldo');
        $data['foto']         = $this->session->get('foto');
        return view('rekening/index', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_rekening)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_rekening . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalRekening'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('Rekening/delete/' . $id_rekening) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_rekening)
    {
        $data = $this->M_rekening->find($id_rekening);
        echo json_encode($data);
    }

    // Simpan data rekening
    public function save()
    {
        $id_nasabah  = $this->request->getPost('id_nasabah');
        $nama_bank   = $this->request->getPost('nama_bank');
        $no_rekening = $this->request->getPost('no_rekening');
        $atas_nama   = $this->request->getPost('atas_nama');

        $data_validasi = [
            'nama_bank'   => $nama_bank,
            'no_rekening' => $no_rekening,
            'atas_nama'   => $atas_nama
        ];

        //Cek Validasi Data Rekening, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'rekening') == FALSE) {

            $validasi = [
                'error'   => true,
                'rekening_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            //data rekening
            $data = [
                'id_nasabah'  => $id_nasabah,
                'nama_bank'   => $nama_bank,
                'no_rekening' => $no_rekening,
                'atas_nama'   => $atas_nama
            ];
            //Simpan data rekening
            $this->M_rekening->save($data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data rekening
    public function update()
    {
        $id          = $this->request->getPost('id_rekening');
        $nama_bank   = $this->request->getPost('nama_bank');
        $no_rekening = $this->request->getPost('no_rekening');
        $atas_nama   = $this->request->getPost('atas_nama');

        $data_validasi = [
            'nama_bank'   => $nama_bank,
            'no_rekening' => $no_rekening,
            'atas_nama'   => $atas_nama
        ];

        //Cek Validasi data rekening, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'rekening') == FALSE) {

            $validasi = [
                'error'       => true,
                'rekening_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            //data rekening
            $data = [
                'nama_bank'   => $nama_bank,
                'no_rekening' => $no_rekening,
                'atas_nama'   => $atas_nama
            ];
            //Update data rekening
            $this->M_rekening->update($id, $data);

            $validasi = [
                'success' => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data rekening
    public function delete($id_rekening)
    {
        $this->M_rekening->delete($id_rekening);
    }

    // tampilkan data rekening
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_rekening->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_bank;
                $row[] = $list->no_rekening;
                $row[] = $list->atas_nama;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_rekening->count_all(),
                "recordsFiltered" => $this->M_rekening->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
