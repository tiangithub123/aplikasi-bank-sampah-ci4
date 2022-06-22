<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\USetorSampahModel;
use App\Models\SampahModel;
use Config\Services;

class SetorSampah extends BaseController
{
    protected $M_setor_sampah;
    protected $M_sampah;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_setor_sampah  = new USetorSampahModel($this->request);
        $this->M_sampah        = new SampahModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index_user()
    {
        $data['title']        = "Transaksi Setor Sampah | Aplikasi Bank Sampah";
        $data['menu']         = "";
        $data['page']         = "transaksi-setor-sampah";
        $data['sampah']       = $this->M_sampah->findAll();
        $data['id']           = $this->session->get('id');
        $data['nama_nasabah'] = $this->session->get('nama_nasabah');
        $data['level']        = $this->session->get('level');
        $data['foto']         = $this->session->get('foto');
        return view('setor-sampah/index_user', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_setor)
    {
        $link = "
                <a href='" . base_url('SetorSampah/delete/' . $id_setor) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Simpan data sampah
    public function save()
    {
        $id_nasabah      = $this->request->getPost('id_nasabah');
        $id_sampah       = $this->request->getPost('id_sampah');
        $jumlah          = $this->request->getPost('jumlah');
        $total           = str_replace('.', '', trim($this->request->getPost('total')));
        $tgl_penjemputan = trim(date('Y-m-d', strtotime($this->request->getPost('tgl_penjemputan'))));

        $data_validasi = [
            'id_sampah'       => $id_sampah,
            'jumlah'          => $jumlah,
            'total'           => $total,
            'tgl_penjemputan' => $tgl_penjemputan
        ];

        //Cek Validasi Data Sampah, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'setor_sampah_user') == FALSE) {

            $validasi = [
                'error'   => true,
                'setor_sampah_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            //data sampah
            $data = [
                'id_nasabah'      => $id_nasabah,
                'id_sampah'       => $id_sampah,
                'jumlah'          => $jumlah,
                'total'           => $total,
                'tgl_penjemputan' => $tgl_penjemputan,
            ];
            //Simpan data sampah
            $this->M_setor_sampah->save($data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data sampah
    public function delete($id_setor)
    {
        $this->M_setor_sampah->delete($id_setor);
    }

    // tampilkan data sampah
    public function loadDataUser()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_setor_sampah->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = date("d-m-Y H:i:s", strtotime($list->tanggal));
                $row[] = $list->nama_sampah;
                $row[] = $list->jumlah;
                $row[] = $list->nama_satuan;
                $row[] = $list->total;
                $row[] = date("d-m-Y", strtotime($list->tgl_penjemputan));
                $row[] = $list->status;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_setor_sampah->count_all(),
                "recordsFiltered" => $this->M_setor_sampah->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
