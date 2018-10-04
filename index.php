<?php
$is_auth = rand(0, 1);

$user_name = 'Олег';
$user_avatar = 'img/user.jpg';

require_once('functions.php');
require_once('connect.php');

$get_categories = 'SELECT category_name FROM categories';
$get_catalog = 'SELECT * FROM lots';

$categories = get_data($connect, $get_categories);
$lots = get_data($connect, $get_catalog);

$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
