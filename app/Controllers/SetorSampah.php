<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\USetorSampahModel;
use App\Models\ASetorSampahModel;
use App\Models\SampahModel;
use App\Models\NasabahModel;
use Config\Services;

class SetorSampah extends BaseController
{
    protected $M_setor_sampah_user;
    protected $M_setor_sampah_admin;
    protected $M_sampah;
    protected $M_nasabah;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request              = Services::request();
        $this->M_setor_sampah_user  = new USetorSampahModel($this->request);
        $this->M_setor_sampah_admin = new ASetorSampahModel($this->request);
        $this->M_sampah             = new SampahModel($this->request);
        $this->M_nasabah            = new NasabahModel($this->request);
        $this->form_validation      = \Config\Services::validation();
        $this->session              = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Setor Sampah | Rewaste World";
        $data['menu']      = "";
        $data['page']      = "setor-sampah";
        $data['id']        = $this->session->get('id');
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('setor-sampah/index', $data);
    }

    public function index_user()
    {
        $data['title']        = "Transaksi Setor Sampah | Rewaste World";
        $data['menu']         = "";
        $data['page']         = "transaksi-setor-sampah";
        $data['sampah']       = $this->M_sampah->findAll();
        $data['id']           = $this->session->get('id');
        $data['nama_nasabah'] = $this->session->get('nama_nasabah');
        $data['alamat']       = $this->session->get('alamat');
        $data['telepon']      = $this->session->get('telepon');
        $data['saldo']        = $this->session->get('saldo');
        $data['foto']         = $this->session->get('foto');
        return view('setor-sampah/index_user', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action_user($id_setor)
    {
        $link = "
                <a href='" . base_url('SetorSampah/delete/' . $id_setor) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tombol Opsi Pada Tabel
    private function _action_admin($id_setor)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_setor . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalSetorSampah'><i class='fa fa-edit'></i></button>
	      	    </a>
                ";
        return $link;
    }

    // Tampilkan data
    public function show_sampah($id_sampah)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('sampah a');
        $builder->select('a.harga, b.nama_satuan');
        $builder->join('satuan b', 'a.id_satuan = b.id', 'left');
        $builder->where('a.id', $id_sampah);
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
    
    public function show_transaksi($id_setor)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('setor_sampah a');
        $builder->select('a.id, a.id_nasabah, a.id_sampah, b.nama_nasabah, c.nama_sampah, c.harga, d.nama_satuan, a.jumlah, a.total, a.tgl_penjemputan, a.status');
        $builder->join('nasabah b', 'a.id_nasabah = b.id', 'left');
        $builder->join('sampah c', 'a.id_sampah = c.id', 'left');
        $builder->join('satuan d', 'c.id_satuan = d.id', 'left');
        $builder->where('a.id', $id_setor);
        $data = $builder->get();
        foreach ($data->getResult() as $row) {
            echo json_encode($row);
        }
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
            $this->M_setor_sampah_user->save($data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data setor
    public function update()
    {
        $id     = $this->request->getPost('id_setor');
        $status = $this->request->getPost('status');

        $id_sampah   = $this->request->getPost('id_sampah');
        $data_sampah = $this->M_sampah->find($id_sampah);
        $jumlah      = $this->request->getPost('jumlah');
        $stok        = $data_sampah['stok'] + $jumlah;

        $id_nasabah   = $this->request->getPost('id_nasabah');
        $data_nasabah = $this->M_nasabah->find($id_nasabah);
        $total        = str_replace('.', '', trim($this->request->getPost('total')));
        $saldo        = $data_nasabah['saldo'] + $total;

        //data setor_sampah
        $data_validasi = [
            'status' => $status
        ];

        //Cek Validasi data setor_sampah, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'setor_sampah_admin') == FALSE) {

            $validasi = [
                'error'              => true,
                'setor_sampah_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            if ($status != 'Berhasil') {
                //data setor_sampah
                $data_setor_sampah = [
                    'status' => $status
                ];
                //Update data setor_sampah
                $this->M_setor_sampah_admin->update($id, $data_setor_sampah);

                $validasi = [
                    'success' => true
                ];
                echo json_encode($validasi);
            } else {
                //data setor_sampah
                $data_sampah = [
                    'stok' => $stok
                ];
                //Update data setor_sampah
                $this->M_sampah->update($id_sampah, $data_sampah);

                //data setor_nasabah
                $data_nasabah = [
                    'saldo' => $saldo
                ];
                //Update data setor_nasabah
                $this->M_nasabah->update($id_nasabah, $data_nasabah);

                //data setor_sampah
                $data_setor_sampah = [
                    'status' => $status
                ];
                //Update data setor_sampah
                $this->M_setor_sampah_admin->update($id, $data_setor_sampah);

                $validasi = [
                    'success' => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data sampah
    public function delete($id_setor)
    {
        $this->M_setor_sampah_user->delete($id_setor);
    }

    // tampilkan data sampah
    public function loadDataAdmin()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_setor_sampah_admin->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = date("d-m-Y H:i:s", strtotime($list->tanggal));
                $row[] = $list->nama_nasabah;
                $row[] = $list->telepon;
                $row[] = $list->nama_sampah;
                $row[] = $list->jumlah;
                $row[] = $list->nama_satuan;
                $row[] = $list->total;
                $row[] = $list->alamat;
                $row[] = date("d-m-Y", strtotime($list->tgl_penjemputan));
                $row[] = $list->status;
                $row[] = $this->_action_admin($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_setor_sampah_admin->count_all(),
                "recordsFiltered" => $this->M_setor_sampah_admin->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }

    // tampilkan data sampah
    public function loadDataUser()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_setor_sampah_user->get_datatables();
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
                $row[] = $this->_action_user($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_setor_sampah_user->count_all(),
                "recordsFiltered" => $this->M_setor_sampah_user->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
