<?php

namespace App\Controllers;

use Config\Services;

class Dashboard extends BaseController
{
    protected $session;
    protected $request;

    public function __construct()
    {
        $this->request = Services::request();
        $this->session = \Config\Services::session();
    }

    // Halaman Dashboard
    public function index()
    {
        $data['title']     = "Dashboard | Rewaste World";
        $data['menu']      = "";
        $data['page']      = "dashboard";
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('dashboard/index', $data);
    }

    // Halaman Dashboard user
    public function index_user()
    {
        $data['title']        = "Dashboard | Rewaste World";
        $data['menu']         = "";
        $data['page']         = "dashboard";
        $data['id']           = $this->session->get('id');
        $data['nama_nasabah'] = $this->session->get('nama_nasabah');
        $data['saldo']        = $this->session->get('saldo');
        $data['foto']         = $this->session->get('foto');
        return view('dashboard/index_user', $data);
    }

    // Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin');
    }

    // Logout user
    public function logout_user()
    {
        $this->session->destroy();
        return redirect()->to('/user');
    }
}
