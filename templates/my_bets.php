<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="category_items.php?id=<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">

            <?php foreach ($lots as $lot): ?>

            <tr class="rates__item <?php if ($_SESSION['user']['id'] == $lot['user_win']) { echo 'rates__item--win';} else if ($lot['date_closed'] < 0) { echo 'rates__item--end';} ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?php echo $lot['image']; ?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?php echo $lot['lot_id']; ?>"><?php echo $lot['title']; ?></a></h3>
                    <?php if ($_SESSION['user']['id'] == $lot['user_win']) { ?>
                        <p><?php echo $lot['user_contact']; ?></p>
                    <?php } ?>
                </td>
                <td class="rates__category">
                    <?php echo $lot['category_name']; ?>
                </td>
                <td class="rates__timer">
                    <?php if ($_SESSION['user']['id'] == $lot['user_win']) { ?>
                        <div class="timer timer--win">Ставка выиграла</div>
                    <?php } else if ($lot['date_closed'] < 0) { ?>
                        <div class="timer timer--end">Торги окончены</div>
                    <?php } else { ?>
                        <div class="timer timer--finishing"><?php echo $lot['date_closed']; ?></div>
                    <?php } ?>
                </td>
                <td class="rates__price">
                    <?php echo format_price($lot['price_now']); ?>
                </td>
                <td class="rates__time">
                    <?php echo $lot['date_craete']; ?>
                </td>
            </tr>

            <?php endforeach; ?>

        </table>
    </section>
</main>
