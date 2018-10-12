<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?php echo $category['category_name']; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">

       <?php foreach ($lot as $value): ?>

        <h2><?php echo $value['title']; ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?php echo $value['image']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?php echo $value['category_name']; ?></span></p>
                <p class="lot-item__description"><?php echo $value['description']; ?></p>
            </div>
            <div class="lot-item__right">

                <?php if (isset($_SESSION['user']) && !$hide_block): ?>

                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?php echo $day; ?>д:<?php echo $hour; ?>ч:<?php echo $minute; ?>м
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?php echo $price; ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?php echo $min_price; ?></span>
                        </div>
                    </div>
                    <form class="lot-item__form <?php if (count($errors)){ echo 'form--invalid';}; ?>" action="" method="post">
                        <p class="lot-item__form-item <?php if(isset($errors['price'])){ echo 'form__item--invalid';}; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?php echo $min_price; ?>">
                            <span class="form__error"><?php if(isset($errors['price'])){ echo $errors['price'];}; ?></span>
                        </p>

                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>

                <?php endif ?>

                <div class="history">
                    <h3>История ставок (<span><?php echo count($bets); ?></span>)</h3>
                    <table class="history__list">

                        <?php foreach ($bets as $bet): ?>

                        <tr class="history__item">
                            <td class="history__name"><?php echo $bet['user_name']; ?></td>
                            <td class="history__price"><?php echo $bet['price']; ?></td>
                            <td class="history__time"><?php echo $bet['date_craete']; ?></td>
                        </tr>

                        <?php endforeach; ?>

                    </table>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </section>
</main>
