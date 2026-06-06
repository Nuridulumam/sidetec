<?php

use CodeIgniter\Pager\PagerRenderer;

/** @var PagerRenderer $pager */
$pager->setSurroundCount(2);
?>
<nav class="flex items-center justify-between border-t border-slate-100 bg-white px-4 py-3 sm:px-6 mt-4">
    <div class="flex flex-1 justify-between sm:hidden">
        <?php if ($pager->hasPrevious()) : ?>
            <a href="<?= esc($pager->getPrevious(), 'attr') ?>" class="relative inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-705 hover:bg-slate-50">Sebelumnya</a>
        <?php endif; ?>
        <?php if ($pager->hasNext()) : ?>
            <a href="<?= esc($pager->getNext(), 'attr') ?>" class="relative ml-3 inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-705 hover:bg-slate-50">Selanjutnya</a>
        <?php endif; ?>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-xs text-slate-500">
                Menampilkan halaman <span class="font-semibold text-slate-900"><?= esc((string) $pager->getCurrentPageNumber()) ?></span> dari <span class="font-semibold text-slate-900"><?= esc((string) $pager->getPageCount()) ?></span>
            </p>
        </div>
        <div>
            <span class="isolate inline-flex -space-x-px rounded-xl border border-slate-200 bg-white overflow-hidden text-xs">
                <?php if ($pager->hasPrevious()) : ?>
                    <a href="<?= esc($pager->getFirst(), 'attr') ?>" class="relative inline-flex items-center px-3 py-2 text-slate-500 hover:bg-slate-50 border-r border-slate-200">« Pertama</a>
                    <a href="<?= esc($pager->getPrevious(), 'attr') ?>" class="relative inline-flex items-center px-3 py-2 text-slate-505 hover:bg-slate-50 border-r border-slate-200">‹</a>
                <?php endif; ?>

                <?php foreach ($pager->links() as $link) : ?>
                    <a href="<?= esc($link['uri'], 'attr') ?>" class="relative inline-flex items-center px-3.5 py-2 border-r border-slate-200 <?= $link['active'] ? 'bg-mint text-white font-semibold' : 'text-slate-700 hover:bg-slate-50' ?>">
                        <?= esc($link['title']) ?>
                    </a>
                <?php endforeach; ?>

                <?php if ($pager->hasNext()) : ?>
                    <a href="<?= esc($pager->getNext(), 'attr') ?>" class="relative inline-flex items-center px-3 py-2 text-slate-505 hover:bg-slate-50 border-r border-slate-200">›</a>
                    <a href="<?= esc($pager->getLast(), 'attr') ?>" class="relative inline-flex items-center px-3 py-2 text-slate-500 hover:bg-slate-50">Terakhir »</a>
                <?php endif; ?>
            </span>
        </div>
    </div>
</nav>
