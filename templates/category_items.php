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
    <div class="container">
        <section class="lots">
            <h2>Все лоты в категории <span>«<?php echo $category_name['category_name']; ?>»</span></h2>
            <ul class="lots__list">

                <?php foreach ($lots as $lot): ?>

                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?php echo $lot['image']; ?>" width="350" height="260" alt="<?php echo $lot['title']; ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?php echo filter($lot['category']); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?php echo $lot['id']?>"><?php echo filter($lot['title']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"><?php if ((int)$lot['bets_count'] > 0) {echo 'ставок - ' . $lot['bets_count'];} else {echo 'Стартовая цена';} ?></span>
                                <span class="lot__cost"><?php echo format_price(filter($lot['price'])); ?></span>
                            </div>
                            <div class="lot__timer timer">
                                <?php echo $lot['date_closed']; ?>
                            </div>
                        </div>
                    </div>
                </li>

                <?php endforeach; ?>

            </ul>
        </section>

        <?php echo $pagination; ?>

    </div>
</main>
