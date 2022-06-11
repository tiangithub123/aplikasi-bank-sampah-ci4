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
        $data['title']     = "Dashboard | Aplikasi Bank Sampah";
        $data['menu']      = "";
        $data['page']      = "dashboard";
        $data['nama_user'] = $this->session->get('nama_user');
        $data['level']     = $this->session->get('level');
        $data['foto']      = $this->session->get('foto');
        return view('dashboard/index', $data);
    }

    // Bug 1 : belum mengarah ke login admin
    // Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin');
    }
}
