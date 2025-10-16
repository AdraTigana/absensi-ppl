<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use CodeIgniter\Controller;

class AbsensiController extends Controller
{
    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        helper('date');
    }

    public function checkIn()
    {
        $userId = session()->get('user_id');
        $tanggal = date('Y-m-d');
        $jamSekarang = date('H:i:s');

        $absen = $this->absensiModel->where('user_id', $userId)->where('tanggal', $tanggal)->first();
        if ($absen) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kamu sudah check-in hari ini.'])->setStatusCode(400);
        }

        $status = (strtotime($jamSekarang) > strtotime('08:00:00')) ? 'terlambat' : 'hadir';
        $this->absensiModel->insert([
            'user_id' => $userId,
            'tanggal' => $tanggal,
            'jam_masuk' => $jamSekarang,
            'status' => $status
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Check-In Berhasil!']);
    }


    public function checkOut()
    {
        $absensiModel = new AbsensiModel();
        $userId = session()->get('user_id');

        $absensi = $absensiModel->where('user_id', $userId)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        if (!$absensi || !$absensi['jam_masuk']) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Belum check-in'])->setStatusCode(400);
        }

        $jamMasuk = strtotime($absensi['jam_masuk']);
        $selisihMenit = (time() - $jamMasuk) / 60;

        if ($selisihMenit < 30) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Check-Out baru bisa setelah 30 menit dari Check-In.'
            ])->setStatusCode(400);
        }

        $absensiModel->update($absensi['id'], ['jam_keluar' => date('H:i:s')]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Check-Out Berhasil!'
        ]);
    }

    public function rekap()
    {
        $session = session();
        $user_id = $session->get('user_id');

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        if (!$startDate || !$endDate) {
            // Default: 7 hari terakhir
            $endDate = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime('-7 days'));
        }

        $rekap = $this->absensiModel->getRekap($user_id, $startDate, $endDate);

        return view('absensi/rekap', [
            'rekap' => $rekap,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function getStatus()
    {
        $userId = session()->get('user_id');
        $tanggal = date('Y-m-d');
        $absen = $this->absensiModel->getByUserAndDate($userId, $tanggal);

        if (!$absen) {
            return $this->response->setJSON([
                'status' => 'Belum Check-In',
                'canCheckIn' => true,
                'canCheckOut' => false
            ]);
        }

        if ($absen['jam_keluar']) {
            return $this->response->setJSON([
                'status' => 'Sudah Check-Out',
                'canCheckIn' => false,
                'canCheckOut' => false
            ]);
        }

        return $this->response->setJSON([
            'status' => 'Sudah Check-In',
            'canCheckIn' => false,
            'canCheckOut' => true
        ]);
    }
}
