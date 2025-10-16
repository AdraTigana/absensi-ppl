<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function index()
    {
        // Kalau sudah login, langsung lempar ke dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $data['title'] = 'Login Absensi PPL';
        return view('auth/login', $data);
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar!');
        }

        if ($user['password'] !== $password) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        $this->session->set([
            'user_id' => $user['id'],
            'nama'    => $user['nama'],
            'role'    => $user['role'],
            'email'   => $user['email'],
            'isLoggedIn' => true,
        ]);

        // Arahkan ke dashboard sesuai role
        switch ($user['role']) {
            case 'mahasiswa':
                return redirect()->to('/mahasiswa/dashboard');
            case 'guru':
                return redirect()->to('/guru/dashboard');
            case 'admin':
                return redirect()->to('/admin/dashboard');
            default:
                return redirect()->to('/');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Kamu berhasil logout.');
    }
}
