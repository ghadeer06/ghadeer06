<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'الرجاء تعبئة جميع الحقول');
        }

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || $password !== $user['password']) {
    return redirect()->back()->withInput()->with('error', 'الإيميل أو كلمة المرور غير صحيحة');
}

        session()->set([
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        return $this->redirectByRole()->with('success', 'مرحبًا بك ' . $user['name']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'تم تسجيل الخروج بنجاح');
    }

   private function redirectByRole()
{
    $role = session()->get('role');

    if ($role === 'admin') {
        return redirect()->to('/admin/tickets');
    }
    if ($role === 'reviewer') {
        return redirect()->to('/reviewer/tickets');
    }
    return redirect()->to('/tickets');
}
}