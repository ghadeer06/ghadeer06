<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ReviewerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if ($role !== 'reviewer') {
            $home = $role === 'admin' ? '/admin/tickets' : '/tickets';
            return redirect()->to($home)->with('error', 'ما عندك صلاحية الدخول لهذي الصفحة');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}