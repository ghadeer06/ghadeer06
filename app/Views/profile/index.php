<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حسابي | نظام البلاغات التقنية</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        :root {
            --cream: #F6F4F0;
            --beige: #ECE6DE;
            --green-soft: #9FD297;
            --tan: #C5B298;
            --brown-gold: #AA926D;
            --teal: #309C99;
            --teal-dark: #02807A;

            --dark-green: #02807A;
            --gold: #AA926D;
            --gold-light: #C5B298;
            --bg-light: #F6F4F0;
        }

        /* ===== الفوتر الثابت ===== */
        html, body { height: 100%; }

        body {
            background: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content { flex: 1 0 auto; padding-bottom: 2rem; }

        .site-footer {
            flex-shrink: 0;
            background: var(--dark-green);
            color: #fff;
            font-size: 0.85rem;
            text-align: center;
            padding: 1rem 0;
        }

        /* ===== النافبار ===== */
        .navbar {
            background: var(--dark-green) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand { color: var(--gold) !important; font-weight: 700; }
        .navbar span, .navbar strong { color: #ffffff !important; }

        .navbar .btn-outline-danger {
            color: #02807A;
            background: #F6F4F0;
            border: 1.5px solid #F6F4F0;
            font-weight: 600;
        }
        .navbar .btn-outline-danger:hover {
            background: #ECE6DE;
            border-color: #ECE6DE;
            color: #02807A;
        }

        /* ===== البطاقات والعناوين ===== */
        .card-box {
            border-radius: 12px;
            border: none;
            border-top: 4px solid var(--gold);
            box-shadow: 0 2px 12px rgba(26,60,52,0.1);
            background: #fff;
            max-width: 500px;
            margin: 0 auto;
        }

        h4, h5 { color: var(--dark-green); font-weight: 700; }
        .form-label { color: var(--dark-green); font-weight: 600; }

        .form-control {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 10px 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:hover { border-color: var(--gold); }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }

        /* ===== زر الرجوع ===== */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #02807A;
            background: transparent;
            border: 1.5px solid #02807A;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
        }
        .btn-back:hover {
            background: #02807A;
            color: #fff;
            transform: translateX(2px);
        }

        /* ===== زر الحفظ ===== */
        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            background: #02807A;
            border: 1.5px solid #02807A;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
        }
        .btn-save:hover {
            background: #026B66;
            border-color: #026B66;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2,128,122,0.25);
        }
        .btn-save:active { transform: translateY(0); box-shadow: none; }
    </style>
</head>
<body>

    <?php
        // الرجوع يختلف حسب دور المستخدم
        $role = session()->get('role');

        if ($role === 'admin') {
            $home  = 'admin/tickets';
            $brand = 'لوحة التقني';
        } elseif ($role === 'reviewer') {
            $home  = 'reviewer/tickets';
            $brand = 'لوحة المدقق';
        } else {
            $home  = 'tickets';
            $brand = 'نظام البلاغات التقنية';
        }
    ?>

    <nav class="navbar navbar-expand-lg px-4 mb-4">
        <span class="navbar-brand fw-bold"><?= $brand ?></span>
        <div class="d-flex align-items-center gap-3">
            <span>مرحبًا، <strong><?= esc(session()->get('name')) ?></strong></span>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">تسجيل الخروج</a>
        </div>
    </nav>

    <div class="container page-content">

        <div class="d-flex justify-content-between align-items-center mb-4" style="max-width:500px; margin:0 auto;">
            <h4 class="m-0">حسابي</h4>
            <a href="<?= site_url($home) ?>" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                رجوع
            </a>
        </div>

        <div class="card card-box mb-3">
            <div class="card-body p-4">
                <p class="mb-1"><strong>الاسم:</strong> <?= esc($user['name']) ?></p>
                <p class="mb-0"><strong>البريد الإلكتروني:</strong> <?= esc($user['email']) ?></p>
            </div>
        </div>

        <div class="card card-box">
            <div class="card-body p-4">
                <h5 class="mb-3">تغيير كلمة المرور</h5>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success py-2"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger py-2"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('profile/update-password') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn-save w-100">حفظ التغييرات</button>
                </form>
            </div>
        </div>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

</body>
</html>