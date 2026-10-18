<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if ($role !== 'admin') {
            $home = $role === 'reviewer' ? '/reviewer/tickets' : '/tickets';
            return redirect()->to($home)->with('error', 'ما عندك صلاحية الدخول لهذي الصفحة');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}