<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نموذج البلاغ | نظام البلاغات التقنية</title>
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

        .navbar .btn-outline-secondary {
            color: #F6F4F0;
            background: transparent;
            border: 1.5px solid rgba(246,244,240,0.55);
            font-weight: 600;
        }
        .navbar .btn-outline-secondary:hover {
            background: #F6F4F0;
            border-color: #F6F4F0;
            color: #02807A;
        }
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

        /* ===== البطاقة والحقول ===== */
        .card-box {
            border-radius: 12px;
            border: none;
            border-top: 4px solid var(--gold);
            box-shadow: 0 2px 12px rgba(26,60,52,0.1);
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
        }

        h4 { color: var(--dark-green); font-weight: 700; }
        .form-label { color: var(--dark-green); font-weight: 600; }

        .form-control {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
            color: #333;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:hover { border-color: var(--gold); }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }
        .form-control::placeholder { color: #a9a39a; }

        .prev-reason {
            background: #FBF1EE;
            border: 1px solid #E3A99D;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            color: #8A3A2C;
            margin-bottom: 1.2rem;
            line-height: 1.8;
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

        /* ===== زر الإرسال ===== */
        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            font-size: 0.95rem;
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

        /* ===== القائمة المخصصة ===== */
        .custom-dropdown { position: relative; width: 100%; }

        .custom-dropdown-selected {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
            color: var(--dark-green);
            background-color: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: border-color 0.2s ease;
        }
        .custom-dropdown-selected:hover { border-color: var(--gold); }
        .custom-dropdown.active .custom-dropdown-selected {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }
        .custom-dropdown-selected::after {
            content: "▾";
            color: var(--gold);
            margin-right: 5px;
            transition: transform 0.2s ease;
        }
        .custom-dropdown.active .custom-dropdown-selected::after { transform: rotate(180deg); }

        .custom-dropdown-options {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            left: 0;
            background: #fff;
            border: 1px solid var(--beige);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(26,60,52,0.15);
            overflow: hidden;
            z-index: 10;
        }
        .custom-dropdown.active .custom-dropdown-options { display: block; }

        .custom-dropdown-option {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 0.95rem;
            color: var(--dark-green);
            transition: background 0.15s ease;
        }
        .custom-dropdown-option:hover { background: var(--cream); }
        .custom-dropdown-option.selected {
            background: var(--gold);
            color: #fff;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <?php
        // وضع التعديل: يوصل $ticket من كنترولر edit
        $ticket  = $ticket ?? null;
        $isEdit  = !empty($ticket);

        $formAction = $isEdit ? site_url('tickets/resubmit/' . $ticket['id']) : site_url('tickets/store');
        $pageTitle  = $isEdit ? 'تعديل البلاغ وإعادة إرساله' : 'فتح بلاغ جديد';
        $backUrl    = $isEdit ? site_url('tickets/show/' . $ticket['id']) : site_url('tickets');
        $submitText = $isEdit ? 'إعادة إرسال البلاغ للتدقيق' : 'إرسال البلاغ';

        $categories = \App\Models\TicketModel::DEPARTMENTS;
        $priorities = [
            'low'    => 'منخفضة',
            'medium' => 'متوسطة',
            'high'   => 'عالية (عاجل)',
        ];

        $currentCategory = old('category', $ticket['category'] ?? 'support');
        if (!isset($categories[$currentCategory])) $currentCategory = 'support';

        $currentPriority = old('priority', $ticket['priority'] ?? 'medium');
        if (!isset($priorities[$currentPriority])) $currentPriority = 'medium';

        $titleValue = old('title', $ticket['title'] ?? '');
        $descValue  = old('description', $ticket['description'] ?? '');
    ?>

    <nav class="navbar navbar-expand-lg px-4 mb-4">
        <span class="navbar-brand fw-bold">نظام البلاغات التقنية</span>
        <div class="d-flex align-items-center gap-3">
            <span>مرحبًا، <strong><?= esc(session()->get('name')) ?></strong></span>
            <a href="<?= site_url('profile') ?>" class="btn btn-outline-secondary btn-sm">حسابي</a>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">تسجيل الخروج</a>
        </div>
    </nav>

    <div class="container page-content">

        <div class="d-flex justify-content-between align-items-center mb-4" style="max-width:600px; margin:0 auto;">
            <h4 class="m-0"><?= $pageTitle ?></h4>
            <a href="<?= $backUrl ?>" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                رجوع
            </a>
        </div>

        <div class="card card-box">
            <div class="card-body p-4">

                <?php if ($isEdit && !empty($ticket['review_note'])) : ?>
                    <div class="prev-reason">
                        <strong>سبب عدم الاعتماد السابق:</strong> <?= esc($ticket['review_note']) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= $formAction ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">عنوان البلاغ</label>
                        <input type="text" name="title" class="form-control"
                               placeholder="مثال: الطابعة لا تعمل" value="<?= esc($titleValue) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">القسم</label>
                        <div class="custom-dropdown">
                            <input type="hidden" name="category" value="<?= esc($currentCategory) ?>">
                            <div class="custom-dropdown-selected" onclick="toggleDropdown(this)">
                                <span><?= esc($categories[$currentCategory]) ?></span>
                            </div>
                            <div class="custom-dropdown-options">
                                <?php foreach ($categories as $value => $label) : ?>
                                    <div class="custom-dropdown-option <?= $value === $currentCategory ? 'selected' : '' ?>"
                                         data-value="<?= esc($value) ?>" onclick="selectOption(this)"><?= esc($label) ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تفاصيل المشكلة</label>
                        <textarea name="description" class="form-control" rows="5"
                                  placeholder="اشرحي المشكلة بالتفصيل..." required><?= esc($descValue) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">الأولوية</label>
                        <div class="custom-dropdown">
                            <input type="hidden" name="priority" value="<?= esc($currentPriority) ?>">
                            <div class="custom-dropdown-selected" onclick="toggleDropdown(this)">
                                <span><?= esc($priorities[$currentPriority]) ?></span>
                            </div>
                            <div class="custom-dropdown-options">
                                <?php foreach ($priorities as $value => $label) : ?>
                                    <div class="custom-dropdown-option <?= $value === $currentPriority ? 'selected' : '' ?>"
                                         data-value="<?= esc($value) ?>" onclick="selectOption(this)"><?= esc($label) ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-save w-100"><?= $submitText ?></button>
                </form>

            </div>
        </div>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

    <script>
        function toggleDropdown(selectedEl) {
            const dropdown = selectedEl.closest('.custom-dropdown');
            const isActive = dropdown.classList.contains('active');

            document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('active'));

            if (!isActive) {
                dropdown.classList.add('active');
            }
        }

        function selectOption(optionEl) {
            const dropdown = optionEl.closest('.custom-dropdown');

            dropdown.querySelector('input[type="hidden"]').value = optionEl.dataset.value;
            dropdown.querySelector('.custom-dropdown-selected span').textContent = optionEl.textContent.trim();

            dropdown.querySelectorAll('.custom-dropdown-option').forEach(opt => {
                opt.classList.toggle('selected', opt === optionEl);
            });

            dropdown.classList.remove('active');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>

</body>
</html>