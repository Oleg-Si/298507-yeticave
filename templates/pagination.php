<?php if ((int)$pages_count > 1): ?>

<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a <?php if ((int)$cur_page !== 1): ?>href="<?php echo $pagination_query; ?>&page=<?=$cur_page - 1;?><?php endif; ?>">Назад</a></li>

    <?php foreach ($pages as $page): ?>

    <li class="pagination-item <?php if ((int)$page === (int)$cur_page): ?>pagination__item--active<?php endif; ?>"><a href="<?php echo $pagination_query; ?>&page=<?=$page;?>"><?=$page;?></a></li>

    <?php endforeach; ?>
    <li class="pagination-item pagination-item-next"><a <?php if (count($pages) !== (int)$cur_page): ?>href="<?php echo $pagination_query; ?>&page=<?=$cur_page + 1;?><?php endif; ?>">Вперед</a></li>
</ul>

<?php endif; ?>
