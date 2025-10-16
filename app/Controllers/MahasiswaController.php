<?php

namespace App\Controllers;

class MahasiswaController extends BaseController
{
    public function index()
    {
        return view('dashboard/mahasiswa', [
            'nama' => session()->get('nama'),
            'role' => session()->get('role')
        ]);
    }
}
