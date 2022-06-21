<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Aplikasi Bank Sampah";
        return view('home/index', $data);
    }
}
