<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class Profil extends BaseController
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
        $data['title']     = "Pengaturan Profil | Aplikasi Bank Sampah";
        $data['menu']      = "";
        $data['page']      = "profil";
        $data['id']        = $this->session->get('id');
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('profil/index', $data);
    }

    // Tampilkan data saat edit
    public function show($id_user)
    {
        $data = $this->M_user->find($id_user);
        echo json_encode($data);
    }

    // Update data user
    public function update()
    {
        $id            = $this->request->getPost('id_user');
        $nama_user     = $this->request->getPost('nama_user');
        $username      = $this->request->getPost('username');
        $password      = $this->request->getPost('password');
        $level         = $this->request->getPost('level');
        $foto          = $this->request->getFile('foto');

        //data user
        $data_validasi = [
            'nama_user' => $nama_user,
            'username'  => $username,
            'level'     => $level,
            'foto'      => $foto
        ];

        //Cek Validasi data user, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'profil') == FALSE) {

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
                    'nama_user'     => $nama_user,
                    'username'      => $username,
                    'level'         => $level
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
                    'nama_user'     => $nama_user,
                    'username'      => $username,
                    'level'         => $level,
                    'foto'          => $nama_foto
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
                    'nama_user'     => $nama_user,
                    'username'      => $username,
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'level'         => $level
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
                    'nama_user'     => $nama_user,
                    'username'      => $username,
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'level'         => $level,
                    'foto'          => $nama_foto
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
}
