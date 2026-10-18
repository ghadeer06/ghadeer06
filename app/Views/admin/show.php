<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>جميع البلاغات | لوحة التقني</title>
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

        .page-content {
            flex: 1 0 auto;
            padding-bottom: 2rem;
        }

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

        /* ===== البطاقات والعناوين ===== */
        .card-box {
            border-radius: 12px;
            border: none;
            border-top: 4px solid var(--gold);
            box-shadow: 0 2px 12px rgba(26,60,52,0.1);
            background: #fff;
            max-width: 700px;
            margin: 0 auto;
        }

        h4, h5 { color: var(--dark-green); font-weight: 700; }

        /* ===== الشارات ===== */
        .badge {
            font-weight: 600;
            padding: 0.45em 0.85em;
            border-radius: 20px;
        }

        .badge-priority-low    { background: #E6F3E3; color: #3C7A38; border: 1px solid #9FD297; }
        .badge-priority-medium { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-priority-high   { background: #F8E0DA; color: #A33B2A; border: 1px solid #E3A99D; }

        .badge-status-open        { background: #AA926D; color: #fff; }
        .badge-status-in_progress { background: #309C99; color: #fff; }
        .badge-status-resolved    { background: #5E9E5A; color: #fff; }

        .badge-support { background: #02807A; color: #fff; }
        .badge-closed  { background: #ECE6DE; color: #7a6f5d; border: 1px solid #C5B298; }

        /* ===== المحادثة ===== */
        .reply-box {
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 10px;
            background: var(--bg-light);
            border-right: 3px solid var(--gold);
        }
        .reply-box.is-mine {
            border-right-color: var(--dark-green);
            background: #eef5f3;
        }
        .reply-box small { color: #888; }

        .form-label { color: var(--dark-green); font-weight: 600; }

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

        /* ===== أزرار الحفظ (تحديث / إرسال الرد) ===== */
        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 16px;
            font-size: 0.85rem;
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

        /* ===== زر إنهاء المحادثة ===== */
        .btn-close-ticket {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #B4513F;
            background: transparent;
            border: 1.5px solid #B4513F;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .btn-close-ticket:hover {
            background: #B4513F;
            color: #fff;
        }

        .status-form { flex-wrap: wrap; }

        /* ===== القائمة المخصصة ===== */
        .custom-dropdown {
            position: relative;
            width: 160px;
        }

        .custom-dropdown-selected {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.85rem;
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

        .custom-dropdown.active .custom-dropdown-selected::after {
            transform: rotate(180deg);
        }

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
            padding: 8px 12px;
            cursor: pointer;
            font-size: 0.85rem;
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

    <nav class="navbar navbar-expand-lg px-4 mb-4"> 
    <span>مرحبًا، <strong><?= esc(session()->get('name')) ?></strong></span>

        <span class="navbar-brand fw-bold">لوحة التقني</span>
        <div class="d-flex align-items-center gap-3">
            <a href="<?= site_url('profile') ?>" class="btn btn-outline-secondary btn-sm">حسابي</a>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">تسجيل الخروج</a>
        </div>
    </nav>

    <div class="container page-content">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" style="max-width:700px; margin:0 auto 1rem;"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" style="max-width:700px; margin:0 auto 1rem;"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4" style="max-width:700px; margin:0 auto;">
            <h4 class="m-0">البلاغ #<?= $ticket['id'] ?></h4>
            <a href="<?= site_url('admin/tickets') ?>" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                رجوع لكل البلاغات
            </a>
        </div>

        <div class="card card-box mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="m-0"><?= esc($ticket['title']) ?></h5>
                    <div class="d-flex gap-2">
                        <span class="badge badge-priority-<?= $ticket['priority'] ?>">
                            <?= $ticket['priority'] === 'low' ? 'منخفضة' : ($ticket['priority'] === 'medium' ? 'متوسطة' : 'عالية') ?>
                        </span>
                        <span class="badge badge-status-<?= $ticket['status'] ?>">
                            <?= $ticket['status'] === 'open' ? 'جديد' : ($ticket['status'] === 'in_progress' ? 'قيد المعالجة' : 'تم الحل') ?>
                        </span>
                    </div>
                </div>
                <p class="text-muted mb-2">
                    مقدّم من: <strong><?= esc($ticket['employee_name']) ?></strong>
                </p>
                <p class="mb-3"><?= nl2br(esc($ticket['description'])) ?></p>
                <small class="text-muted d-block mb-3">تاريخ الإرسال: <?= date('Y-m-d H:i', strtotime($ticket['created_at'])) ?></small>

                <hr>

                <?php
                    $statusLabels = ['open' => 'جديد', 'in_progress' => 'قيد المعالجة', 'resolved' => 'تم الحل'];
                ?>

                <form method="post" action="<?= site_url('admin/tickets/reply/' . $ticket['id']) ?>" class="status-form d-flex align-items-center gap-2">
                    <?= csrf_field() ?>
                    <label class="form-label m-0">تحديث حالة البلاغ:</label>

                    <?php if ($ticket['status'] !== 'resolved') : ?>
                        <div class="custom-dropdown" id="statusDropdown">
                            <input type="hidden" name="status" id="statusInput" value="<?= $ticket['status'] ?>">
                            <div class="custom-dropdown-selected" onclick="toggleStatusDropdown()">
                                <span id="statusSelectedText"><?= $statusLabels[$ticket['status']] ?></span>
                            </div>
                            <div class="custom-dropdown-options">
                                <div class="custom-dropdown-option <?= $ticket['status'] === 'open' ? 'selected' : '' ?>" data-value="open" onclick="selectStatus('open', 'جديد')">جديد</div>
                                <div class="custom-dropdown-option <?= $ticket['status'] === 'in_progress' ? 'selected' : '' ?>" data-value="in_progress" onclick="selectStatus('in_progress', 'قيد المعالجة')">قيد المعالجة</div>
                                <div class="custom-dropdown-option <?= $ticket['status'] === 'resolved' ? 'selected' : '' ?>" data-value="resolved" onclick="selectStatus('resolved', 'تم الحل')">تم الحل</div>
                            </div>
                        </div>

                        <button type="submit" name="update_status_only" value="1" class="btn-save">حفظ التغييرات</button>
                        <button type="submit" name="close_ticket" value="1" class="btn-close-ticket"
                                onclick="return confirm('متأكد تبي تنهي هذا البلاغ؟ ما راح يقدر الموظف يرد بعدها')">
                            إنهاء المحادثة
                        </button>
                    <?php else : ?>
                        <span class="badge badge-closed">البلاغ مغلق</span>
                    <?php endif; ?>
                </form>

            </div>
        </div>

        <div class="card card-box mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">المحادثة</h5>

                <?php if (empty($replies)) : ?>
                    <p class="text-muted">لا توجد ردود حتى الآن</p>
                <?php else : ?>
                    <?php foreach ($replies as $reply) : ?>
                        <div class="reply-box <?= $reply['sender_role'] === 'admin' ? 'is-mine' : '' ?>">
                            <strong><?= esc($reply['sender_name']) ?></strong>
                            <?= $reply['sender_role'] === 'admin' ? '<span class="badge badge-support">الدعم الفني</span>' : '' ?>
                            <br>
                            <?= nl2br(esc($reply['message'])) ?>
                            <br><small><?= date('Y-m-d H:i', strtotime($reply['created_at'])) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($ticket['status'] !== 'resolved') : ?>
        <div class="card card-box">
            <div class="card-body p-4">
                <h5 class="mb-3">إرسال رد</h5>
                <form method="post" action="<?= site_url('admin/tickets/reply/' . $ticket['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="3"
                                  placeholder="اكتب ردك هنا..." required></textarea>
                    </div>
                    <button type="submit" class="btn-save">إرسال الرد</button>
                </form>
            </div>
        </div>
        <?php else : ?>
        <div class="alert alert-secondary text-center" style="max-width:700px; margin:0 auto;">
            تم إنهاء هذا البلاغ ولا يمكن إضافة ردود جديدة
        </div>
        <?php endif; ?>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

    <script>
        function toggleStatusDropdown() {
            document.getElementById('statusDropdown').classList.toggle('active');
        }

        function selectStatus(value, label) {
            document.getElementById('statusInput').value = value;
            document.getElementById('statusSelectedText').textContent = label;

            document.querySelectorAll('#statusDropdown .custom-dropdown-option').forEach(opt => {
                opt.classList.toggle('selected', opt.dataset.value === value);
            });

            document.getElementById('statusDropdown').classList.remove('active');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>

</body>
</html>