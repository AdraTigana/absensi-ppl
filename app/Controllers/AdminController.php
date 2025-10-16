<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin/dashboard', $data);
    }

    public function create()
    {
        $userModel = new UserModel();

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'  => $this->request->getPost('role'),
        ];

        if ($userModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'User berhasil ditambahkan']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambah user']);
        }
    }

    public function update()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id');

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        if ($userModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'User berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui user']);
        }
    }

    public function delete()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id'); // ambil dari body POST

        if ($userModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus user'
            ]);
        }
    }
}
