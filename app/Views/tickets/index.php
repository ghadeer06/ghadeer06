<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بلاغاتي | نظام البلاغات التقنية</title>
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

        .dept-line { font-size: 0.82rem; color: #7a7367; margin-top: 2px; }

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

        .btn-edit {
            color: #B4513F;
            background: transparent;
            border-color: #B4513F;
        }
        .btn-edit:hover {
            background: #B4513F;
            border-color: #B4513F;
            color: #fff;
        }

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
            text-decoration: none;
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

        /* ===== الشارات ===== */
        .badge { font-weight: 600; padding: 0.45em 0.85em; border-radius: 20px; }

        .badge-priority-low    { background: #E6F3E3; color: #3C7A38; border: 1px solid #9FD297; }
        .badge-priority-medium { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-priority-high   { background: #F8E0DA; color: #A33B2A; border: 1px solid #E3A99D; }

        .badge-status-open        { background: #AA926D; color: #fff; }
        .badge-status-in_progress { background: #309C99; color: #fff; }
        .badge-status-resolved    { background: #5E9E5A; color: #fff; }

        .badge-review-pending  { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-review-rejected { background: #B4513F; color: #fff; }

        .badge-new-reply    { background: #B4513F; color: #fff; margin-right: 6px; }
        .badge-new-decision { background: #309C99; color: #fff; margin-right: 6px; }

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

    <nav class="navbar navbar-expand-lg px-4 mb-4">
        <span class="navbar-brand fw-bold">نظام البلاغات التقنية</span>
        <div class="d-flex align-items-center gap-3">
            <span>مرحبًا، <strong><?= esc(session()->get('name')) ?></strong></span>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0">بلاغاتي</h4>
            <a href="<?= site_url('tickets/create') ?>" class="btn-save">
                + فتح بلاغ جديد
            </a>
        </div>

        <div class="card card-box">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>الأولوية</th>
                                <th>الحالة</th>
                                <th>تاريخ الإرسال</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tickets)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        ما عندك بلاغات حتى الآن
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($tickets as $ticket) : ?>
                                    <tr>
                                        <td>#<?= $ticket['id'] ?></td>
                                        <td>
                                            <?= esc($ticket['title']) ?>
                                            <?php if (!empty($ticket['has_new_reply'])) : ?>
                                                <span class="badge badge-new-reply">رد جديد</span>
                                            <?php endif; ?>
                                            <?php if (!empty($ticket['has_new_decision'])) : ?>
                                                <span class="badge badge-new-decision">قرار جديد</span>
                                            <?php endif; ?>
                                            <div class="dept-line">
                                                القسم: <?= esc(\App\Models\TicketModel::DEPARTMENTS[$ticket['category']] ?? 'أخرى') ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-priority-<?= $ticket['priority'] ?>">
                                                <?= esc(\App\Models\TicketModel::PRIORITIES[$ticket['priority']] ?? $ticket['priority']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($ticket['review_status'] === 'pending') : ?>
                                                <span class="badge badge-review-pending">بانتظار التدقيق</span>
                                            <?php elseif ($ticket['review_status'] === 'rejected') : ?>
                                                <span class="badge badge-review-rejected">غير معتمد</span>
                                            <?php else : ?>
                                                <span class="badge badge-status-<?= $ticket['status'] ?>">
                                                    <?= esc(\App\Models\TicketModel::STATUSES[$ticket['status']] ?? $ticket['status']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('Y-m-d H:i', strtotime($ticket['created_at'])) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= site_url('tickets/show/' . $ticket['id']) ?>"
                                               class="btn btn-sm btn-outline-primary">عرض</a>
                                            <?php if ($ticket['review_status'] === 'rejected') : ?>
                                                <a href="<?= site_url('tickets/edit/' . $ticket['id']) ?>"
                                                   class="btn btn-sm btn-edit">تعديل وإعادة إرسال</a>
                                            <?php endif; ?>
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
                        <div class="list-footer">إجمالي البلاغات: <?= $pager->getTotal() ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

</body>
</html>