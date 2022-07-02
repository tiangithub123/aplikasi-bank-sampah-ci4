<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenarikanUserModel;
use App\Models\PenarikanAdminModel;
use App\Models\NasabahModel;
use Config\Services;

class Penarikan extends BaseController
{
    protected $M_penarikan_user;
    protected $M_penarikan_admin;
    protected $M_nasabah;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request           = Services::request();
        $this->M_penarikan_user  = new PenarikanUserModel($this->request);
        $this->M_penarikan_admin = new PenarikanAdminModel($this->request);
        $this->M_nasabah         = new NasabahModel($this->request);
        $this->form_validation   = \Config\Services::validation();
        $this->session           = \Config\Services::session();
    }

    public function index_admin()
    {
        $data['title']     = "Transaksi Penarikan | Rewaste World";
        $data['menu']      = "";
        $data['page']      = "transaksi-penarikan";
        $data['id']        = $this->session->get('id');
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('penarikan/index_admin', $data);
    }

    public function index_user()
    {
        $data['title']        = "Transaksi Penarikan | Rewaste World";
        $data['menu']         = "";
        $data['page']         = "transaksi-penarikan";
        $data['id']           = $this->session->get('id');
        $data['nama_nasabah'] = $this->session->get('nama_nasabah');
        $data['nama_bank']    = $this->session->get('nama_bank');
        $data['no_rek']       = $this->session->get('no_rek');
        $data['saldo']        = $this->session->get('saldo');
        $data['foto']         = $this->session->get('foto');
        return view('penarikan/index_user', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action_user($id_penarikan)
    {
        $link = "
                <a href='" . base_url('Penarikan/delete/' . $id_penarikan) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tombol Opsi Pada Tabel
    private function _action_admin($id_penarikan)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_penarikan . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalPenarikan'><i class='fa fa-edit'></i></button>
	      	    </a>
                ";
        return $link;
    }

    public function show_transaksi($id_penarikan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('penarikan a');
        $builder->select('a.id, a.id_nasabah, b.nama_nasabah, b.nama_bank, b.no_rek, a.jumlah, a.status');
        $builder->join('nasabah b', 'a.id_nasabah = b.id', 'left');
        $builder->where('a.id', $id_penarikan);
        $data = $builder->get();
        foreach ($data->getResult() as $row) {
            echo json_encode($row);
        }
    }

    public function show_nasabah($id_nasabah)
    {
        $data = $this->M_nasabah->find($id_nasabah);
        echo json_encode($data);
    }
    

    // Simpan data sampah
    public function save()
    {
        $id_nasabah = $this->request->getPost('id_nasabah');
        $jenis      = $this->request->getPost('jenis');
        $jumlah     = str_replace('.', '', trim($this->request->getPost('jumlah')));
        $keterangan = $this->request->getPost('keterangan');

        $data_validasi = [
            'jenis'      => $jenis,
            'jumlah'     => $jumlah,
            'keterangan' => $keterangan
        ];

        //Cek Validasi Data Sampah, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'penarikan') == FALSE) {

            $validasi = [
                'error'           => true,
                'penarikan_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            //data sampah
            $data = [
                'id_nasabah'     => $id_nasabah,
                'jenis'          => $jenis,
                'jumlah'         => $jumlah,
                'keterangan'     => $keterangan,
                'tgl_verifikasi' => '-',
            ];
            //Simpan data sampah
            $this->M_penarikan_user->save($data);

            $validasi = [
                'success' => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data setor
    public function update()
    {
        $id     = $this->request->getPost('id_penarikan');
        $status = $this->request->getPost('status');

        $id_nasabah   = $this->request->getPost('id_nasabah');
        $data_nasabah = $this->M_nasabah->find($id_nasabah);
        $jumlah       = str_replace('.', '', trim($this->request->getPost('jumlah')));
        $saldo        = $data_nasabah['saldo'] - $jumlah;

        //data penarikan
        $data_validasi = [
            'status' => $status
        ];

        //Cek Validasi data penarikan, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'penarikan_admin') == FALSE) {

            $validasi = [
                'error'           => true,
                'penarikan_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            if ($status != 'Berhasil') {
                //data penarikan
                $data_penarikan = [
                    'tgl_verifikasi' => trim(date('d-m-Y')),
                    'status'         => $status
                ];
                //Update data penarikan
                $this->M_penarikan_admin->update($id, $data_penarikan);

                $validasi = [
                    'success' => true
                ];
                echo json_encode($validasi);
            } else {
                //data setor_nasabah
                $data_nasabah = [
                    'saldo' => $saldo
                ];
                //Update data setor_nasabah
                $this->M_nasabah->update($id_nasabah, $data_nasabah);
                //data penarikan
                $data_penarikan = [
                    'tgl_verifikasi' => trim(date('d-m-Y')),
                    'status'         => $status
                ];
                //Update data penarikan
                $this->M_penarikan_admin->update($id, $data_penarikan);

                $validasi = [
                    'success' => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data sampah
    public function delete($id_penarikan)
    {
        $this->M_penarikan_user->delete($id_penarikan);
    }

    // tampilkan data sampah
    public function loadDataAdmin()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_penarikan_admin->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = date("d-m-Y H:i:s", strtotime($list->tanggal));
                $row[] = $list->nama_nasabah;
                $row[] = $list->nama_bank;
                $row[] = $list->no_rek;
                $row[] = $list->jumlah;
                $row[] = $list->tgl_verifikasi;
                $row[] = $list->status;
                $row[] = $this->_action_admin($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_penarikan_admin->count_all(),
                "recordsFiltered" => $this->M_penarikan_admin->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }

    // tampilkan data penarikan
    public function loadDataUser()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_penarikan_user->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = date("d-m-Y H:i:s", strtotime($list->tanggal));
                $row[] = $list->nama_bank;
                $row[] = $list->no_rek;
                $row[] = $list->jumlah;
                $row[] = $list->tgl_verifikasi;
                $row[] = $list->status;
                $row[] = $this->_action_user($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_penarikan_user->count_all(),
                "recordsFiltered" => $this->M_penarikan_user->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
