<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class GuruController extends BaseController
{
    public function index()
    {
        $model = new AbsensiModel();
        $data['rekap'] = $model
            ->select('users.nama, absensi.tanggal, absensi.jam_masuk, absensi.jam_keluar, absensi.status')
            ->join('users', 'users.id = absensi.user_id')
            ->orderBy('absensi.tanggal', 'DESC')
            ->findAll();

        return view('guru/dashboard', $data);
    }
}
