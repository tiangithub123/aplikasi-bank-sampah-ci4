<?php

namespace App\Controllers;

use Config\Services;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $request;
    protected $form_validation;
    protected $session;
    protected $M_user;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
        $this->M_user          = new UserModel($this->request);
    }

    // Halaman Login
    public function index()
    {
        $data['title']   = "Login | Aplikasi Bank Sampah";
        return view('login-admin/index', $data);
    }

    // Cek Login
    public function cek_login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        //Validasi 
        $cek_validasi = [
            'username' => $username,
            'password' => $password
        ];

        //Cek Validasi, Jika Data Tidak Valid 
        if ($this->form_validation->run($cek_validasi, 'login') == FALSE) {

            $validasi = [
                'error'   => true,
                'login_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        // Jika Data Valid
        else {

            // Cek Data user berdasarkan username
            $cekUser = $this->M_user->where('username', $username)->first();
            // Jika user ada
            if ($cekUser) {
                $password_hash = $cekUser['password'];
                //Cek password
                //Jika password benar
                if (password_verify($password, $password_hash)) {
                    $newdata = [
                        'id'        => $cekUser['id'],
                        'nama_user' => $cekUser['nama_user'],
                        'username'  => $cekUser['username'],
                        'level'     => $cekUser['level'],
                        'foto'      => $cekUser['foto'],
                        'logged_in' => TRUE
                    ];
                    $this->session->set($newdata);
                    //Admin
                    $validasi = [
                        'success'   => true,
                        'link'   => base_url('admin/dashboard')
                    ];
                    echo json_encode($validasi);
                }
                //Password salah
                else {
                    $validasi = [
                        'error'       => true,
                        'login_error' => [
                            'password' => 'Password Salah!'
                        ]
                    ];
                    echo json_encode($validasi);
                }
            }
            //Dan jika user tidak ada
            else {
                $validasi = [
                    'error'       => true,
                    'login_error' => [
                        'username' => 'Username Tidak Terdaftar!'
                    ]
                ];
                echo json_encode($validasi);
            }
        }
    }
}
