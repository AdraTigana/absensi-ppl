<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'tanggal', 'jam_masuk', 'jam_keluar', 'status'];

    public function getByUserAndDate($user_id, $tanggal)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();
    }

    public function getRekap($user_id, $startDate, $endDate)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }
}
