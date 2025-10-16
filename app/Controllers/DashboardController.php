<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class DashboardController extends BaseController
{
    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $user_id = session()->get('user_id'); // sesuaikan dengan session yang digunakan
        $tanggal = date('Y-m-d');

        $absen = $this->absensiModel->getByUserAndDate($user_id, $tanggal);

        $statusHariIni = 'Belum Check-In';
        $bisaCheckIn = true;
        $bisaCheckOut = false;

        if ($absen) {
            if ($absen['jam_keluar']) {
                $statusHariIni = 'Sudah Check-Out';
                $bisaCheckIn = false;
            } else {
                $statusHariIni = 'Sudah Check-In';
                $bisaCheckIn = false;
                $bisaCheckOut = true;
            }
        }

        $data = [
            'title' => 'Dashboard Absensi',
            'nama' => session()->get('nama'),
            'role' => session()->get('role'),
            'absen' => $absen,
            'statusHariIni' => $statusHariIni,
            'bisaCheckIn' => $bisaCheckIn,
            'bisaCheckOut' => $bisaCheckOut
        ];

        return view('dashboard/index', $data);
    }
}
