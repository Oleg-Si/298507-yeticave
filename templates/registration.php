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
    <form class="form container <?php if (count($errors)){ echo 'form--invalid';}; ?>" action="registration.php" method="post" enctype="multipart/form-data">
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?php if(isset($errors['email']) || isset($errors['user'])){ echo 'form__item--invalid';}; ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?php if(isset($values['email'])){ echo $values['email'];}; ?>">
            <span class="form__error"><?php if(isset($errors['email'])){ echo $errors['email'];} elseif(isset($errors['user'])){ echo $errors['user'];}; ?></span>
        </div>
        <div class="form__item <?php if(isset($errors['password'])){ echo 'form__item--invalid';}; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error"><?php if(isset($errors['password'])){ echo $errors['password'];}; ?></span>
        </div>
        <div class="form__item <?php if(isset($errors['name'])){ echo 'form__item--invalid';}; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?php if(isset($values['name'])){ echo $values['name'];}; ?>">
            <span class="form__error"><?php if(isset($errors['name'])){ echo $errors['name'];}; ?></span>
        </div>
        <div class="form__item <?php if(isset($errors['message'])){ echo 'form__item--invalid';}; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?php if(isset($values['message'])){ echo $values['message'];}; ?></textarea>
            <span class="form__error"><?php if(isset($errors['message'])){ echo $errors['message'];}; ?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?php if(isset($errors['img'])){ echo 'form__item--invalid';}; ?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
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
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="enter.php">Уже есть аккаунт</a>
    </form>
</main>
