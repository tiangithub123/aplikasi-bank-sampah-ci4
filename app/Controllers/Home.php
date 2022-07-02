<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = "Rewaste World";
        return view('home/index', $data);
    }
}
