<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class User extends BaseController
{
    protected $M_user;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->M_user          = new UserModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data User | Rewaste World";
        $data['menu']      = "";
        $data['page']      = "user";
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('user/index', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_user)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_user . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalUser'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('User/delete/' . $id_user) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_user)
    {
        $data = $this->M_user->find($id_user);
        echo json_encode($data);
    }

    // Simpan data user
    public function save()
    {
        $nama_user = ucwords($this->request->getPost('nama_user'));
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');
        $level     = $this->request->getPost('level');
        $foto      = $this->request->getFile('foto');

        $data_validasi = [
            'nama_user' => $nama_user,
            'username'  => $username,
            'password'  => $password,
            'level'     => $level,
            'foto'      => $foto
        ];

        //Cek Validasi Data User, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'user_add') == FALSE) {

            $validasi = [
                'error'   => true,
                'user_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }

        //Data Valid
        else {
            if ($foto == '') {
                //data user
                $data = [
                    'nama_user' => $nama_user,
                    'username'  => $username,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'level'     => $level
                ];
                //Simpan data user
                $this->M_user->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file foto ke direktori public/user
                $nama_foto = $foto->getRandomName();
                $foto->move('images/user', $nama_foto);
                //Data User
                $data = [
                    'nama_user' => $nama_user,
                    'username'  => $username,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'level'     => $level,
                    'foto'      => $nama_foto
                ];
                //Simpan Data User
                $this->M_user->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }            
        }
    }

    // Update data user
    public function update()
    {
        $id        = $this->request->getPost('id_user');
        $nama_user = ucwords($this->request->getPost('nama_user'));
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');
        $level     = $this->request->getPost('level');
        $foto      = $this->request->getFile('foto');

        //data user
        $data_validasi = [
            'nama_user' => $nama_user,
            'username'  => $username,
            'password'  => $password,
            'level'     => $level,
            'foto'      => $foto
        ];

        //Cek Validasi data user, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'user_edit') == FALSE) {

            $validasi = [
                'error'   => true,
                'user_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            if ($foto == '' && $password == '') {
                //data user
                $data = [
                    'nama_user' => $nama_user,
                    'username'  => $username,
                    'level'     => $level
                ];
                //Update data user
                $this->M_user->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else if ($foto != '' && $password == '') {
                //Pindahkan file foto peserta ke direktori public/user
                $nama_foto = $foto->getRandomName();
                $foto->move('images/user', $nama_foto);
                //data user
                $data = [
                    'nama_user' => $nama_user,
                    'username'  => $username,
                    'level'     => $level,
                    'foto'      => $nama_foto
                ];
                // hapus foto lama
                $old_foto = $this->M_user->find($id);
                if ($old_foto['foto'] == true) {
                    unlink('images/user/' . $old_foto['foto']);
                }
                //Update data user
                $this->M_user->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else if ($foto == '' && $password != '') {
                //data user
                $data = [
                    'nama_user' => $nama_user,
                    'username'  => $username,
                    'level'     => $level,
                    'password'  => password_hash($password, PASSWORD_DEFAULT)
                ];
                //Update data user
                $this->M_user->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file foto peserta ke direktori public/user
                $nama_foto = $foto->getRandomName();
                $foto->move('images/user', $nama_foto);
                //data user
                $data = [
                    'nama_user' => $nama_user,
                    'username'  => $username,
                    'level'     => $level,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'foto'      => $nama_foto
                ];
                // hapus foto lama
                $old_foto = $this->M_user->find($id);
                if ($old_foto['foto'] == true) {
                    unlink('images/user/' . $old_foto['foto']);
                }
                //Update data user
                $this->M_user->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data user
    public function delete($id_user)
    {
        $data = $this->M_user->find($id_user);
        // delete foto
        if ($data['foto'] == true) {
            unlink('images/user/' . $data['foto']);
        }
        $this->M_user->delete($id_user);
    }

    // tampilkan data user
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->M_user->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->foto;
                $row[] = $list->nama_user;
                $row[] = $list->username;
                $row[] = $list->level;
                $row[] = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->M_user->count_all(),
                "recordsFiltered" => $this->M_user->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
