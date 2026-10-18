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

        /* الفوتر الثابت: الصفحة كلها عمود بارتفاع الشاشة، والمحتوى يتمدد */
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


        .card-box {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            background: #fff;
        }

        h4 { color: var(--dark-green); font-weight: 700; }
        table th { color: var(--dark-green); font-weight: 700; border-bottom: 2px solid var(--gold); }

        .stat-mini {
            border-radius: 12px;
            border-top: 4px solid var(--gold);
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            background: #fff;
            padding: 1.2rem;
            text-align: center;
            cursor: pointer;
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

        /* مربع البحث */
        .search-wrapper {
            position: relative;
            width: 230px;
        }
        .search-input {
            width: 100%;
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 6px 34px 6px 12px;
            font-size: 0.85rem;
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

        /* القائمة المخصصة */
        .custom-dropdown {
            position: relative;
            width: 150px;
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

        /* ===== أزرار النافبار ===== */
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

/* ===== أزرار الجدول والنماذج ===== */
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

.btn-outline-danger {
    color: #B4513F;
    background: transparent;
    border-color: #B4513F;
}
.btn-outline-danger:hover {
    background: #B4513F;
    border-color: #B4513F;
    color: #fff;
}

.btn-danger {
    background: #B4513F;
    border-color: #B4513F;
    color: #fff;
}
.btn-danger:hover {
    background: #9A4333;
    border-color: #9A4333;
    color: #fff;
}

/* ===== الشارات ===== */
.badge {
    font-weight: 600;
    padding: 0.45em 0.85em;
    border-radius: 20px;
}

/* الأولوية (ألوان ناعمة بحدود) */
.badge-priority-low    { background: #E6F3E3; color: #3C7A38; border: 1px solid #9FD297; }
.badge-priority-medium { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
.badge-priority-high   { background: #F8E0DA; color: #A33B2A; border: 1px solid #E3A99D; }

/* الحالة (ألوان ممتلئة) */
.badge-status-open        { background: #AA926D; color: #fff; }
.badge-status-in_progress { background: #309C99; color: #fff; }
.badge-status-resolved    { background: #5E9E5A; color: #fff; }
    
    /* ===== زر تصدير إكسل ===== */
.btn-export {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 14px;
    font-size: 0.85rem;
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

.btn-export:active {
    transform: translateY(0);
    box-shadow: none;
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
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php
            $openCount = 0;
            $progressCount = 0;
            $resolvedCount = 0;

            foreach ($tickets as $t) {
                if ($t['status'] === 'open') {
                    $openCount++;
                } elseif ($t['status'] === 'in_progress') {
                    $progressCount++;
                } elseif ($t['status'] === 'resolved') {
                    $resolvedCount++;
                }
            }
        ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4 col-4">
                <div class="stat-mini" data-status="open" onclick="filterTickets('open')">
                    <h3><?= $openCount ?></h3><p>بلاغات جديدة</p>
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="stat-mini" data-status="in_progress" onclick="filterTickets('in_progress')">
                    <h3><?= $progressCount ?></h3><p>قيد المعالجة</p>
                </div>
            </div>
            <div class="col-md-4 col-4">
                <div class="stat-mini" data-status="resolved" onclick="filterTickets('resolved')">
                    <h3><?= $resolvedCount ?></h3><p>تم الحل</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="m-0">جميع البلاغات</h4>
            <div class="d-flex gap-2 flex-wrap align-items-start">

                <div class="search-wrapper">
                    <span class="search-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" id="searchBox" class="search-input"
                           placeholder="ابحث بالعنوان أو الموظف..." onkeyup="searchTickets()">
                </div>

                <div class="custom-dropdown" id="priorityDropdown">
                    <input type="hidden" id="priorityFilter" value="all">
                    <div class="custom-dropdown-selected" onclick="toggleDropdown('priorityDropdown')">
                        <span id="prioritySelectedText">جميع الأولويات</span>
                    </div>
                    <div class="custom-dropdown-options">
                        <div class="custom-dropdown-option selected" data-value="all" onclick="selectPriority('all', 'جميع الأولويات')">جميع الأولويات</div>
                        <div class="custom-dropdown-option" data-value="high" onclick="selectPriority('high', 'عالية')">عالية</div>
                        <div class="custom-dropdown-option" data-value="medium" onclick="selectPriority('medium', 'متوسطة')">متوسطة</div>
                        <div class="custom-dropdown-option" data-value="low" onclick="selectPriority('low', 'منخفضة')">منخفضة</div>
                    </div>
                </div>

                <a href="<?= site_url('admin/tickets/export') ?>" class="btn-export">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
        <polyline points="7 10 12 15 17 10"></polyline>
        <line x1="12" y1="15" x2="12" y2="3"></line>
    </svg>
    تصدير إلى إكسل
</a>
            </div>
        </div>

        <div class="card card-box">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>النوع</th>
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
                                    <td colspan="8" class="text-center text-muted py-4">لا توجد بلاغات حتى الآن</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($tickets as $ticket) : ?>
                                    <tr class="ticket-row" data-status="<?= $ticket['status'] ?>" data-priority="<?= $ticket['priority'] ?>">
                                        <td>#<?= $ticket['id'] ?></td>
                                        <td><?= esc($ticket['title']) ?></td>
                                        <td>
                                            <?php
                                                $categoryLabels = [
                                                    'network' => 'شبكة', 'web_page' => 'موقع', 'printer' => 'طابعة',
                                                    'software' => 'برامج', 'hardware' => 'أجهزة', 'other' => 'أخرى',
                                                ];
                                                echo $categoryLabels[$ticket['category']] ?? 'أخرى';
                                            ?>
                                        </td>
                                        <td><?= esc($ticket['employee_name']) ?></td>
                                        <td>
                                            <span class="badge badge-priority-<?= $ticket['priority'] ?>">
                                                <?= $ticket['priority'] === 'low' ? 'منخفضة' : ($ticket['priority'] === 'medium' ? 'متوسطة' : 'عالية') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-status-<?= $ticket['status'] ?>">
                                                <?= $ticket['status'] === 'open' ? 'جديد' : ($ticket['status'] === 'in_progress' ? 'قيد المعالجة' : 'تم الحل') ?>
                                            </span>
                                        </td>
                                        <td><?= date('Y-m-d H:i', strtotime($ticket['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= site_url('admin/tickets/show/' . $ticket['id']) ?>"
                                               class="btn btn-sm btn-outline-primary">عرض</a>
                                            <a href="<?= site_url('admin/tickets/delete/' . $ticket['id']) ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('متأكد من حذف البلاغ نهائيًا؟')">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <tr id="noResultsRow" style="display:none">
                                    <td colspan="8" class="text-center text-muted py-4">لا توجد بلاغات مطابقة</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

    <script>
        let currentStatusFilter = 'all';

        function filterTickets(status) {
            currentStatusFilter = (currentStatusFilter === status) ? 'all' : status;

            document.querySelectorAll('.stat-mini').forEach(box => {
                box.classList.toggle('active', box.dataset.status === currentStatusFilter);
            });

            applyFilters();
        }

        function searchTickets() {
            applyFilters();
        }

        function applyFilters() {
            const searchText = document.getElementById('searchBox').value.trim().toLowerCase();
            const priorityValue = document.getElementById('priorityFilter').value;
            const rows = document.querySelectorAll('.ticket-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const matchesStatus = currentStatusFilter === 'all' || row.dataset.status === currentStatusFilter;
                const matchesPriority = priorityValue === 'all' || row.dataset.priority === priorityValue;
                const matchesSearch = searchText === '' || row.innerText.toLowerCase().includes(searchText);

                const show = matchesStatus && matchesPriority && matchesSearch;
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            const noResults = document.getElementById('noResultsRow');
            if (noResults) {
                noResults.style.display = (rows.length > 0 && visibleCount === 0) ? '' : 'none';
            }
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const isActive = dropdown.classList.contains('active');

            document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('active'));

            if (!isActive) {
                dropdown.classList.add('active');
            }
        }

        function selectPriority(value, label) {
            document.getElementById('priorityFilter').value = value;
            document.getElementById('prioritySelectedText').textContent = label;

            document.querySelectorAll('#priorityDropdown .custom-dropdown-option').forEach(opt => {
                opt.classList.toggle('selected', opt.dataset.value === value);
            });

            document.getElementById('priorityDropdown').classList.remove('active');
            applyFilters();
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>

</body>
</html>