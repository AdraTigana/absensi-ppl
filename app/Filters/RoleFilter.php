<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->has('user_id')) {
            return redirect()->to('/login');
        }

        $role = $session->get('role');
        if ($arguments && !in_array($role, $arguments)) {
            return redirect()->to('/unauthorized')->with('error', 'Kamu tidak punya akses ke halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // kosong aja
    }
}
