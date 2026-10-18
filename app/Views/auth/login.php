<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول | نظام البلاغات التقنية</title>
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
            margin: 0;
        }

        .login-wrapper {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .site-footer {
            flex-shrink: 0;
            background: var(--dark-green);
            color: #fff;
            font-size: 0.85rem;
            text-align: center;
            padding: 1rem 0;
        }

        /* ===== بطاقة الدخول ===== */
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            border-radius: 12px;
            border-top: 4px solid var(--gold);
            box-shadow: 0 4px 20px rgba(26,60,52,0.15);
            background: #fff;
        }

        .login-card h3 {
            font-weight: 700;
            margin-bottom: 0.3rem;
            text-align: center;
            color: var(--dark-green);
        }

        .login-card p.subtitle {
            text-align: center;
            color: #7a7367;
            margin-bottom: 1.8rem;
            font-size: 0.95rem;
        }

        .form-label {
            color: var(--dark-green);
            font-weight: 600;
        }

        .form-control {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 1rem;
            color: #333;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:hover { border-color: var(--gold); }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }

        /* ===== زر تسجيل الدخول ===== */
        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px 18px;
            font-size: 1rem;
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

    <div class="login-wrapper">
        <div class="login-card">

            <h3>نظام البلاغات التقنية</h3>
            <p class="subtitle">تسجيل الدخول للموظفين والتقنيين</p>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success py-2"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('login') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= esc(old('email')) ?>" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-save">تسجيل الدخول</button>
            </form>
        </div>
    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

</body>
</html>