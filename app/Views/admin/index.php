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

        /* ===== البطاقات والجدول ===== */
        .card-box {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            background: #fff;
        }

        h4 { color: var(--dark-green); font-weight: 700; }
        table th { color: var(--dark-green); font-weight: 700; border-bottom: 2px solid var(--gold); }

        .btn-outline-primary {
            color: #02807A;
            background: transparent;
            border-color: #02807A;
        }
        .btn-outline-primary:hover {
            background: #02807A;
            border-color: #02807A;
            color: #fff;
        }
        .card-box .btn-outline-danger {
            color: #B4513F;
            background: transparent;
            border-color: #B4513F;
        }
        .card-box .btn-outline-danger:hover {
            background: #B4513F;
            border-color: #B4513F;
            color: #fff;
        }

        /* ===== الشارات ===== */
        .badge { font-weight: 600; padding: 0.45em 0.85em; border-radius: 20px; }

        .badge-dept { background: #E3F1F0; color: #02807A; border: 1px solid #9CCFCC; }

        .badge-priority-low    { background: #E6F3E3; color: #3C7A38; border: 1px solid #9FD297; }
        .badge-priority-medium { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-priority-high   { background: #F8E0DA; color: #A33B2A; border: 1px solid #E3A99D; }

        .badge-status-open        { background: #AA926D; color: #fff; }
        .badge-status-in_progress { background: #309C99; color: #fff; }
        .badge-status-resolved    { background: #5E9E5A; color: #fff; }

        /* ===== مربعات الحالة (روابط تفعّل الفلتر وتلغيه) ===== */
        .stat-mini {
            display: block;
            border-radius: 12px;
            border-top: 4px solid var(--gold);
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            background: #fff;
            padding: 1.2rem;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, border-color 0.15s ease;
            user-select: none;
        }
        .stat-mini:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(26,60,52,0.12);
        }
        .stat-mini.active {
            background: var(--beige);
            border-top-color: var(--teal-dark);
            box-shadow: 0 0 0 2px var(--teal-dark), 0 6px 16px rgba(26,60,52,0.15);
        }
        .stat-mini h3 { color: #000; font-weight: 800; margin-bottom: 0.2rem; }
        .stat-mini p { color: #7a8a86; margin: 0; font-size: 0.9rem; }

        /* ===== الفلاتر ===== */
        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-start;
            background: #fff;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.2rem;
        }

        .search-wrapper { position: relative; width: 240px; }
        .search-input {
            width: 100%;
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 7px 34px 7px 12px;
            font-size: 0.88rem;
            color: var(--dark-green);
            background-color: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .search-input::placeholder { color: #a9a39a; }
        .search-input:hover { border-color: var(--gold); }
        .search-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }
        .search-icon {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            pointer-events: none;
            display: flex;
        }

        .btn-filter {
            padding: 7px 16px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #02807A;
            background: transparent;
            border: 1.5px solid #02807A;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .btn-filter:hover { background: #02807A; color: #fff; }

        .btn-clear {
            padding: 7px 4px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #B4513F;
            text-decoration: none;
        }
        .btn-clear:hover { text-decoration: underline; color: #9A4333; }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #fff;
            background: #02807A;
            border: 1.5px solid #02807A;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
        }
        .btn-export:hover {
            background: #026B66;
            border-color: #026B66;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2,128,122,0.25);
        }

        /* ===== القائمة المخصصة ===== */
        .custom-dropdown { position: relative; width: 170px; }

        .custom-dropdown-selected {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 0.88rem;
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
            padding: 8px 12px;
            cursor: pointer;
            font-size: 0.88rem;
            color: var(--dark-green);
            transition: background 0.15s ease;
        }
        .custom-dropdown-option:hover { background: var(--cream); }
        .custom-dropdown-option.selected {
            background: var(--gold);
            color: #fff;
            font-weight: 600;
        }

        /* ===== تقسيم الصفحات ===== */
        .pagination .page-link { color: #02807A; border-color: var(--tan); }
        .pagination .page-link:hover { background: var(--beige); color: #02807A; }
        .pagination .page-item.active .page-link {
            background: #02807A;
            border-color: #02807A;
            color: #fff;
        }
        .list-footer { color: #7a7367; font-size: 0.88rem; }
    </style>
</head>
<body>

    <?php
        $departments = \App\Models\TicketModel::DEPARTMENTS;
        $priorities  = \App\Models\TicketModel::PRIORITIES;
        $statuses    = \App\Models\TicketModel::STATUSES;

        $hasFilters = $filters['q'] !== '' || $filters['dept'] !== ''
                   || $filters['priority'] !== '' || $filters['status'] !== '';

        // رابط الصفحة مع الفلاتر الحالية (مع إمكانية تغيير قيمة معيّنة)
        $buildUrl = static function (string $path, array $filters, array $override = []): string {
            $params = array_merge(array_filter($filters, static fn($v) => $v !== ''), $override);
            $params = array_filter($params, static fn($v) => $v !== '' && $v !== null);

            return site_url($path) . ($params ? '?' . http_build_query($params) : '');
        };

        $exportUrl = $buildUrl('admin/tickets/export', $filters);

        // قائمة منسدلة تعيد إرسال نموذج الفلاتر عند الاختيار
        $renderDropdown = static function (string $name, array $options, string $current, string $allLabel): string {
            $label = ($current !== '' && isset($options[$current])) ? $options[$current] : $allLabel;

            $html  = '<div class="custom-dropdown">';
            $html .= '<input type="hidden" name="' . esc($name, 'attr') . '" value="' . esc($current, 'attr') . '">';
            $html .= '<div class="custom-dropdown-selected" onclick="toggleDropdown(this)"><span>' . esc($label) . '</span></div>';
            $html .= '<div class="custom-dropdown-options">';
            $html .= '<div class="custom-dropdown-option ' . ($current === '' ? 'selected' : '') . '" data-value="" onclick="pickFilter(this)">' . esc($allLabel) . '</div>';

            foreach ($options as $value => $text) {
                $selected = ($current === (string) $value) ? 'selected' : '';
                $html .= '<div class="custom-dropdown-option ' . $selected . '" data-value="' . esc((string) $value, 'attr') . '" onclick="pickFilter(this)">' . esc($text) . '</div>';
            }

            return $html . '</div></div>';
        };

        $statBoxes = [
            'open'        => 'بلاغات جديدة',
            'in_progress' => 'قيد المعالجة',
            'resolved'    => 'تم الحل',
        ];
    ?>

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
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="row g-3 mb-4">
            <?php foreach ($statBoxes as $key => $label) : ?>
                <?php
                    $isActive = $filters['status'] === $key;
                    // ضغطة تفعّل الفلتر، وضغطة ثانية على نفس المربع تلغيه
                    $boxUrl = $buildUrl('admin/tickets', $filters, ['status' => $isActive ? '' : $key]);
                ?>
                <div class="col-md-4 col-4">
                    <a href="<?= $boxUrl ?>" class="stat-mini <?= $isActive ? 'active' : '' ?>">
                        <h3><?= $counts[$key] ?></h3><p><?= $label ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h4 class="m-0">جميع البلاغات</h4>

            <a href="<?= $exportUrl ?>" class="btn-export">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                تصدير إلى إكسل
            </a>
        </div>

        <form method="get" action="<?= site_url('admin/tickets') ?>" id="filterForm" class="filter-bar">
            <input type="hidden" name="status" value="<?= esc($filters['status'], 'attr') ?>">

            <div class="search-wrapper">
                <span class="search-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="7"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" name="q" class="search-input" value="<?= esc($filters['q'], 'attr') ?>"
                       placeholder="ابحث بالعنوان أو الموظف أو التفاصيل...">
            </div>

            <?= $renderDropdown('dept', $departments, $filters['dept'], 'جميع الأقسام') ?>
            <?= $renderDropdown('priority', $priorities, $filters['priority'], 'جميع الأولويات') ?>

            <button type="submit" class="btn-filter">بحث</button>

            <?php if ($hasFilters) : ?>
                <a href="<?= site_url('admin/tickets') ?>" class="btn-clear">مسح الفلاتر</a>
            <?php endif; ?>
        </form>

        <div class="card card-box">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>القسم</th>
                                <th>الموظف</th>
                                <th>الأولوية</th>
                                <th>الحالة</th>
                                <th>تاريخ الإرسال</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tickets)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <?= $hasFilters ? 'لا توجد بلاغات مطابقة' : 'لا توجد بلاغات معتمدة حتى الآن' ?>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($tickets as $ticket) : ?>
                                    <tr>
                                        <td>#<?= $ticket['id'] ?></td>
                                        <td><?= esc($ticket['title']) ?></td>
                                        <td>
                                            <span class="badge badge-dept"><?= esc($departments[$ticket['category']] ?? 'أخرى') ?></span>
                                        </td>
                                        <td><?= esc($ticket['employee_name']) ?></td>
                                        <td>
                                            <span class="badge badge-priority-<?= $ticket['priority'] ?>">
                                                <?= esc($priorities[$ticket['priority']] ?? $ticket['priority']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-status-<?= $ticket['status'] ?>">
                                                <?= esc($statuses[$ticket['status']] ?? $ticket['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('Y-m-d H:i', strtotime($ticket['created_at'])) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= site_url('admin/tickets/show/' . $ticket['id']) ?>"
                                               class="btn btn-sm btn-outline-primary">عرض</a>
                                            <a href="<?= site_url('admin/tickets/delete/' . $ticket['id']) ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('متأكد من حذف البلاغ نهائيًا؟')">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pager->getPageCount() > 1) : ?>
                    <div class="d-flex flex-column align-items-center gap-2 mt-3">
                        <?= $pager->links('default', 'custom_full') ?>
                        <div class="list-footer">إجمالي النتائج: <?= $pager->getTotal() ?></div>
                    </div>
                <?php endif; ?>
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

        // اختيار قيمة من قائمة الفلتر ثم إعادة إرسال النموذج
        function pickFilter(optionEl) {
            const dropdown = optionEl.closest('.custom-dropdown');
            dropdown.querySelector('input[type="hidden"]').value = optionEl.dataset.value;
            document.getElementById('filterForm').submit();
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>

</body>
</html>