<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <h1>Поздравляем с победой</h1>

        <?php foreach ($data as $val): ?>

        <p>Здравствуйте, <?php echo $val['user_name']; ?></p>
        <p>Ваша ставка для лота <a href="http://yeticave.loc/lot.php?id=<?php echo $val['id']; ?>"><?php echo $val['title']; ?></a> победила.</p>
        <p>Перейдите по ссылке <a href="http://yeticave.loc/my_bets.php">мои ставки</a>,
            чтобы связаться с автором объявления</p>

        <?php endforeach; ?>

        <small>Интернет Аукцион "YetiCave"</small>
    </body>
</html>