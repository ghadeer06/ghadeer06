<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل البلاغ | نظام البلاغات التقنية</title>
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
        .badge { font-weight: 600; padding: 0.45em 0.85em; border-radius: 20px; }

        .badge-dept { background: #E3F1F0; color: #02807A; border: 1px solid #9CCFCC; }

        .badge-priority-low    { background: #E6F3E3; color: #3C7A38; border: 1px solid #9FD297; }
        .badge-priority-medium { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-priority-high   { background: #F8E0DA; color: #A33B2A; border: 1px solid #E3A99D; }

        .badge-status-open        { background: #AA926D; color: #fff; }
        .badge-status-in_progress { background: #309C99; color: #fff; }
        .badge-status-resolved    { background: #5E9E5A; color: #fff; }

        .badge-review-pending  { background: #F6EBD6; color: #8A6420; border: 1px solid #D9BE86; }
        .badge-review-rejected { background: #B4513F; color: #fff; }

        .badge-support { background: #02807A; color: #fff; }

        /* ===== تنبيه حالة التدقيق ===== */
        .review-notice {
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            margin: 0 auto 1rem;
            max-width: 700px;
            line-height: 1.8;
        }
        .review-notice.pending  { background: #F6EBD6; border: 1px solid #D9BE86; color: #8A6420; }
        .review-notice.rejected { background: #FBF1EE; border: 1px solid #E3A99D; color: #8A3A2C; }

        /* ===== المحادثة ===== */
        .reply-box {
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 10px;
            background: var(--bg-light);
            border-right: 3px solid var(--gold);
        }
        .reply-box.is-admin {
            border-right-color: var(--dark-green);
            background: #eef5f3;
        }
        .reply-box small { color: #888; }

        .form-control {
            border: 1.5px solid var(--tan);
            border-radius: 8px;
            padding: 10px 14px;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(170,146,109,0.2);
        }

        /* ===== الأزرار ===== */
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

        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
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
        .btn-save:active { transform: translateY(0); box-shadow: none; }
    </style>
</head>
<body>

    <?php
        $departments = \App\Models\TicketModel::DEPARTMENTS;
        $isApproved  = $ticket['review_status'] === 'approved';
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

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" style="max-width:700px; margin:0 auto 1rem;"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4" style="max-width:700px; margin:0 auto;">
            <h4 class="m-0">تفاصيل البلاغ #<?= $ticket['id'] ?></h4>
            <a href="<?= site_url('tickets') ?>" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                رجوع
            </a>
        </div>

        <div class="card card-box mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <h5 class="m-0"><?= esc($ticket['title']) ?></h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge badge-dept"><?= esc($departments[$ticket['category']] ?? 'أخرى') ?></span>
                        <span class="badge badge-priority-<?= $ticket['priority'] ?>">
                            <?= esc(\App\Models\TicketModel::PRIORITIES[$ticket['priority']] ?? $ticket['priority']) ?>
                        </span>
                        <?php if ($ticket['review_status'] === 'pending') : ?>
                            <span class="badge badge-review-pending">بانتظار التدقيق</span>
                        <?php elseif ($ticket['review_status'] === 'rejected') : ?>
                            <span class="badge badge-review-rejected">غير معتمد</span>
                        <?php else : ?>
                            <span class="badge badge-status-<?= $ticket['status'] ?>">
                                <?= esc(\App\Models\TicketModel::STATUSES[$ticket['status']] ?? $ticket['status']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="mb-3"><?= nl2br(esc($ticket['description'])) ?></p>
                <small class="text-muted">تاريخ الإرسال: <?= date('Y-m-d H:i', strtotime($ticket['created_at'])) ?></small>
            </div>
        </div>

        <?php if ($ticket['review_status'] === 'pending') : ?>
            <div class="review-notice pending">
                بلاغك الآن <strong>بانتظار التدقيق</strong>. بعد اعتماده يصل للدعم الفني، وتقدرين تتابعين المحادثة هنا.
                <?php if ((int) $ticket['resubmit_count'] > 0) : ?>
                    <br><small>(تم تعديل البلاغ وإعادة إرساله)</small>
                <?php endif; ?>
            </div>
        <?php elseif ($ticket['review_status'] === 'rejected') : ?>
            <div class="review-notice rejected">
                <strong>لم يتم اعتماد هذا البلاغ.</strong>
                <?php if (!empty($ticket['review_note'])) : ?>
                    <br>السبب: <?= esc($ticket['review_note']) ?>
                <?php endif; ?>
                <br>
                <a href="<?= site_url('tickets/edit/' . $ticket['id']) ?>" class="btn-save mt-2">
                    تعديل البلاغ وإعادة إرساله
                </a>
            </div>
        <?php endif; ?>

        <?php if ($isApproved) : ?>
            <div class="card card-box mb-3">
                <div class="card-body p-4">
                    <h5 class="mb-3">المحادثة</h5>

                    <?php if (empty($replies)) : ?>
                        <p class="text-muted">لا توجد ردود حتى الآن</p>
                    <?php else : ?>
                        <?php foreach ($replies as $reply) : ?>
                            <div class="reply-box <?= $reply['sender_role'] === 'admin' ? 'is-admin' : '' ?>">
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
                        <form method="post" action="<?= site_url('tickets/reply/' . $ticket['id']) ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="3"
                                          placeholder="اكتبي رد أو استفسار إضافي..." required></textarea>
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
        <?php endif; ?>

    </div>

    <footer class="site-footer">
        نظام البلاغات التقنية — ghadeer06 © <?= date('Y') ?>
    </footer>

</body>
</html>