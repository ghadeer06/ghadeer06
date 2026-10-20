<?php $pager->setSurroundCount(2); ?>

<nav aria-label="تنقل الصفحات">
    <ul class="pagination justify-content-center mb-0">

        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>">الأولى</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>">السابق</a>
            </li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>">التالي</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>">الأخيرة</a>
            </li>
        <?php endif; ?>

    </ul>
</nav>