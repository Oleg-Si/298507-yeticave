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
    <form class="form container <?php if (count($errors)){ echo 'form--invalid';}; ?>" action="enter.php" method="post">
        <h2>Вход</h2>
        <div class="form__item <?php if(isset($errors['email']) || isset($errors['wrong_email'])){ echo 'form__item--invalid';}; ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?php if(isset($values['email'])){ echo $values['email'];}; ?>">
            <span class="form__error"><?php if(isset($errors['email'])){ echo $errors['email'];} elseif (isset($errors['wrong_email'])) {echo $errors['wrong_email'];}; ?></span>
        </div>
        <div class="form__item form__item--last <?php if(isset($errors['password']) || isset($errors['wrong_password'])){ echo 'form__item--invalid';}; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error"><?php if(isset($errors['password'])){ echo $errors['password'];} elseif (isset($errors['wrong_password'])) {echo $errors['wrong_password'];}; ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
