<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['user'] = $this->userModel->find(session()->get('user_id'));
        return view('profile/index', $data);
    }

    public function updatePassword()
    {
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find(session()->get('user_id'));
        $currentPassword = $this->request->getPost('current_password');

        // بدون تشفير حاليًا (نفس منطق Auth.php الحالي)
        if ($currentPassword !== $user['password']) {
            return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        $this->userModel->update(session()->get('user_id'), [
            'password' => $this->request->getPost('new_password'),
        ]);

        return redirect()->to('/profile')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
}