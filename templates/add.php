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
    <form class="form form--add-lot container <?php if (count($errors)){ echo 'form--invalid';}; ?>" action="add.php" method="post" enctype="multipart/form-data">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?php if(isset($errors['lot-name'])){ echo 'form__item--invalid';}; ?>">
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?php if(isset($values['lot-name'])){ echo $values['lot-name'];}; ?>">
                <span class="form__error"><?php if(isset($errors['lot-name'])){ echo $errors['lot-name'];}; ?></span>
            </div>
            <div class="form__item <?php if(isset($errors['category'])){ echo 'form__item--invalid';}; ?>">
                <label for="category">Категория</label>
                <select id="category" name="category">

                    <option>Выберите категорию</option>

                    <?php foreach ($categories as $category) :
                    if ($values['category'] == $category['category_name']) { ?>
                        <option selected><?php echo $category['category_name']; ?></option>
                    <?php } else { ?>
                        <option><?php echo $category['category_name']; ?></option>
                    <?php }

                    endforeach; ?>

                </select>
                <span class="form__error"><?php if(isset($errors['category'])){ echo $errors['category'];}; ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?php if(isset($errors['message'])){ echo 'form__item--invalid';}; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота"><?php if(isset($values['message'])){ echo $values['message'];}; ?></textarea>
            <span class="form__error"><?php if(isset($errors['message'])){ echo $errors['message'];}; ?></span>
        </div>
        <div class="form__item form__item--file <?php if(isset($errors['img'])){ echo 'form__item--invalid';}; ?>"> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" name="img" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?php if(isset($errors['img'])){ echo $errors['img'];}; ?></span>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?php if(isset($errors['lot-rate'])){ echo 'form__item--invalid';}; ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?php if(isset($values['lot-rate'])){ echo $values['lot-rate'];}; ?>">
                <span class="form__error"><?php if(isset($errors['lot-rate'])){ echo $errors['lot-rate'];}; ?></span>
            </div>
            <div class="form__item form__item--small <?php if(isset($errors['lot-step'])){ echo 'form__item--invalid';}; ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?php if(isset($values['lot-step'])){ echo $values['lot-step'];}; ?>">
                <span class="form__error"><?php if(isset($errors['lot-step'])){ echo $errors['lot-step'];}; ?></span>
            </div>
            <div class="form__item <?php if(isset($errors['lot-date'])){ echo 'form__item--invalid';}; ?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?php if(isset($values['lot-date'])){ echo $values['lot-date'];}; ?>">
                <span class="form__error"><?php if(isset($errors['lot-date'])){ echo $errors['lot-date'];}; ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
