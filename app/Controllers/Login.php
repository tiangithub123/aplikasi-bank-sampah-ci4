<?php

namespace App\Controllers;

use Config\Services;
use App\Models\UserModel;
use App\Models\NasabahModel;

class Login extends BaseController
{
    protected $request;
    protected $form_validation;
    protected $session;
    protected $M_user;
    protected $M_nasabah;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
        $this->M_user          = new UserModel($this->request);
        $this->M_nasabah       = new NasabahModel($this->request);
    }

    // Halaman Login admin
    public function index()
    {
        $data['title']   = "Login | Rewaste World";
        return view('login-admin/index', $data);
    }

    // Halaman login user
    public function login_user()
    {
        $data['title']   = "Login | Rewaste World";
        return view('login-user/index', $data);
    }

    // Halaman register user
    public function register_user()
    {
        $data['title']   = "Register | Rewaste World";
        return view('login-user/register', $data);
    }

    // register cek
    public function cek_register()
    {
        $nama_nasabah    = $this->request->getPost('nama_nasabah');
        $username        = $this->request->getPost('username');
        $password        = $this->request->getPost('password');
        $ulangi_password = $this->request->getPost('ulangi_password');

        $data_validasi = [
            'nama_nasabah'    => $nama_nasabah,
            'username'        => $username,
            'password'        => $password,
            'ulangi_password' => $ulangi_password
        ];

        //Cek Validasi Data User, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'register') == FALSE) {

            $validasi = [
                'error'   => true,
                'register_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        }
        //Data Valid
        else {
            //data nasabah
            $data = [
                'nama_nasabah' => $nama_nasabah,
                'username'     => $username,
                'password'     => password_hash($ulangi_password, PASSWORD_DEFAULT)
            ];
            //Simpan data nasabah
            $this->M_nasabah->save($data);

            $validasi = [
                'success' => true,
                'link'    => base_url('/user')
            ];
            echo json_encode($validasi);
        }
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

    // Cek Login
    public function cek_login_user()
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

            // Cek Data nasabah berdasarkan username
            $cekUser = $this->M_nasabah->where('username', $username)->first();
            // Jika user ada
            if ($cekUser) {
                $password_hash = $cekUser['password'];
                //Cek password
                //Jika password benar
                if (password_verify($password, $password_hash)) {
                    $newdata = [
                        'id'           => $cekUser['id'],
                        'nama_nasabah' => $cekUser['nama_nasabah'],
                        'username'     => $cekUser['username'],
                        'alamat'       => $cekUser['alamat'],
                        'telepon'      => $cekUser['telepon'],
                        'nama_bank'    => $cekUser['nama_bank'],
                        'no_rek'       => $cekUser['no_rek'],
                        'atas_nama'    => $cekUser['atas_nama'],
                        'saldo'        => $cekUser['saldo'],
                        'foto'         => $cekUser['foto'],
                        'logged_in'    => TRUE
                    ];
                    $this->session->set($newdata);
                    //Admin
                    $validasi = [
                        'success'   => true,
                        'link'   => base_url('user/dashboard')
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
