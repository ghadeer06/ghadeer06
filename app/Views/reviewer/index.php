<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة المدقق | نظام البلاغات التقنية</title>
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

        h4 { color: var(--dark-green); font-weight: 700; }

        /* ===== زر تصدير إكسل ===== */
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
        .btn-export:active { transform: translateY(0); box-shadow: none; }

        /* ===== التبويبات ===== */
        .review-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .review-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-green);
            background: #fff;
            border: 1.5px solid var(--tan);
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        .review-tab:hover { border-color: var(--gold); color: var(--dark-green); }
        .review-tab.active {
            background: var(--dark-green);
            border-color: var(--dark-green);
            color: #fff;
        }
        .review-tab .count {
            background: var(--beige);
            color: var(--dark-green);
            border-radius: 20px;
            padding: 1px 9px;
            font-size: 0.8rem;
        }
        .review-tab.active .count { background: rgba(255,255,255,0.22); color: #fff; }

        /* ===== بطاقة البلاغ ===== */
        .ticket-card {
            background: #fff;
            border-radius: 12px;
            border-top: 4px solid var(--gold);
            box-shadow: 0 2px 12px rgba(26,60,52,0.08);
            padding: 1.4rem;
            margin-bottom: 1rem;
        }
        .ticket-card h5 { color: var(--dark-green); font-weight: 700; margin: 0; }
        .ticket-meta { color: #7a7367; font-size: 0.88rem; margin: 0.5rem 0 0.9rem; }
        .ticket-desc {
            background: var(--cream);
            border-radius: 8px;
            padding: 0.9rem 1rem;
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .badge { font-weight: 600; padding: 0.45em 0.85em; border-radius: 20px; }
        .badge-priority-low    { background: #E6F3E3; color: #3C7A38; border: 1px solid #9FD297; }
        .badge-priority-medium { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-priority-high   { background: #F8E0DA; color: #A33B2A; border: 1px solid #E3A99D; }
        .badge-dept { background: #E3F1F0; color: #02807A; border: 1px solid #9CCFCC; }

        .badge-review-approved { background: #5E9E5A; color: #fff; }
        .badge-review-rejected { background: #B4513F; color: #fff; }

        .reject-note {
            background: #FBF1EE;
            border: 1px solid #E3A99D;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            color: #8A3A2C;
            margin-top: 0.8rem;
        }

        /* ===== أزرار القرار ===== */
        .decision-actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }

        .btn-approve, .btn-reject, .btn-reject-confirm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
        }
        .btn-approve {
            color: #fff;
            background: #5E9E5A;
            border: 1.5px solid #5E9E5A;
        }
        .btn-approve:hover { background: #4B8648; border-color: #4B8648; transform: translateY(-1px); }

        .btn-reject {
            color: #B4513F;
            background: transparent;
            border: 1.5px solid #B4513F;
        }
        .btn-reject:hover { background: #B4513F; color: #fff; }

        .btn-reject-confirm {
            color: #fff;
            background: #B4513F;
            border: 1.5px solid #B4513F;
        }
        .btn-reject-confirm:hover { background: #9A4333; border-color: #9A4333; }

        .btn-cancel {
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #7a7367;
            background: transparent;
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-cancel:hover { background: var(--beige); }

        .reject-box {
            display: none;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px dashed var(--tan);
        }
        .reject-box.open { display: block; }

        .form-control {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 10px 14px;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }

        .empty-state {
            text-align: center;
            color: #7a7367;
            background: #fff;
            border-radius: 12px;
            padding: 2.5rem 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <?php
        $departments    = \App\Models\TicketModel::DEPARTMENTS;
        $priorityLabels = ['low' => 'منخفضة', 'medium' => 'متوسطة', 'high' => 'عالية'];
        $tabLabels      = [
            'pending'  => 'بانتظار التدقيق',
            'approved' => 'معتمدة',
            'rejected' => 'غير معتمدة',
        ];
        $exportLabels   = [
            'pending'  => 'تصدير بلاغات التدقيق إلى إكسل',
            'approved' => 'تصدير المعتمدة إلى إكسل',
            'rejected' => 'تصدير غير المعتمدة إلى إكسل',
        ];
    ?>

    <nav class="navbar navbar-expand-lg px-4 mb-4">           
         <span>مرحبًا، <strong><?= esc(session()->get('name')) ?></strong></span>

        <span class="navbar-brand fw-bold">لوحة المدقق</span>
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

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h4 class="m-0">تدقيق البلاغات</h4>

            <?php if (!empty($tickets)) : ?>
                <a href="<?= site_url('reviewer/tickets/export?tab=' . $tab) ?>" class="btn-export">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <?= $exportLabels[$tab] ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="review-tabs">
            <?php foreach ($tabLabels as $key => $label) : ?>
                <a href="<?= site_url('reviewer/tickets?tab=' . $key) ?>"
                   class="review-tab <?= $tab === $key ? 'active' : '' ?>">
                    <?= $label ?>
                    <span class="count"><?= $counts[$key] ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (empty($tickets)) : ?>
            <div class="empty-state">
                <?php if ($tab === 'pending') : ?>
                    ما فيه بلاغات بانتظار التدقيق حاليًا
                <?php else : ?>
                    ما فيه بلاغات بهذا التبويب
                <?php endif; ?>
            </div>
        <?php else : ?>

            <?php foreach ($tickets as $ticket) : ?>
                <div class="ticket-card">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <h5>#<?= $ticket['id'] ?> — <?= esc($ticket['title']) ?></h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge badge-dept"><?= esc($departments[$ticket['category']] ?? 'أخرى') ?></span>
                            <span class="badge badge-priority-<?= $ticket['priority'] ?>">
                                <?= $priorityLabels[$ticket['priority']] ?? $ticket['priority'] ?>
                            </span>
                            <?php if ($tab === 'approved') : ?>
                                <span class="badge badge-review-approved">معتمد</span>
                            <?php elseif ($tab === 'rejected') : ?>
                                <span class="badge badge-review-rejected">غير معتمد</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="ticket-meta">
                        مقدّم من: <strong><?= esc($ticket['employee_name']) ?></strong>
                        &nbsp;•&nbsp; <?= date('Y-m-d H:i', strtotime($ticket['created_at'])) ?>
                        <?php if ($tab !== 'pending' && $ticket['reviewed_at']) : ?>
                            &nbsp;•&nbsp; تم التدقيق: <?= date('Y-m-d H:i', strtotime($ticket['reviewed_at'])) ?>
                        <?php endif; ?>
                    </div>

                    <div class="ticket-desc"><?= nl2br(esc($ticket['description'])) ?></div>

                    <?php if ($tab === 'rejected' && !empty($ticket['review_note'])) : ?>
                        <div class="reject-note">
                            <strong>سبب الرفض:</strong> <?= esc($ticket['review_note']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($tab === 'pending') : ?>
                        <div class="decision-actions">
                            <form method="post" action="<?= site_url('reviewer/tickets/decide/' . $ticket['id']) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="decision" value="approved">
                                <button type="submit" class="btn-approve">معتمد</button>
                            </form>

                            <button type="button" class="btn-reject"
                                    onclick="toggleReject(<?= $ticket['id'] ?>)">غير معتمد</button>
                        </div>

                        <div class="reject-box" id="rejectBox<?= $ticket['id'] ?>">
                            <form method="post" action="<?= site_url('reviewer/tickets/decide/' . $ticket['id']) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="decision" value="rejected">
                                <label class="form-label" style="color:var(--dark-green); font-weight:600;">
                                    سبب عدم الاعتماد (اختياري، يظهر للموظف)
                                </label>
                                <textarea name="review_note" class="form-control mb-3" rows="2"
                                          placeholder="مثال: البلاغ مكرر، أو ليس من اختصاص الدعم الفني"></textarea>
                                <div class="decision-actions">
                                    <button type="submit" class="btn-reject-confirm">تأكيد عدم الاعتماد</button>
                                    <button type="button" class="btn-cancel"
                                            onclick="toggleReject(<?= $ticket['id'] ?>)">إلغاء</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

    <script>
        function toggleReject(id) {
            document.getElementById('rejectBox' + id).classList.toggle('open');
        }
    </script>

</body>
</html>