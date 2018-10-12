<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');

$get_categories = 'SELECT * FROM categories';
$get_catalog = 'SELECT * FROM lots';

$categories = get_data($connect, $get_categories);
$lots = get_data($connect, $get_catalog);

$query_lot_date_closed = 'SELECT date_closed FROM lots';
$lot_date_closed = get_data($connect, $query_lot_date_closed);

$lots = add_timer($lots);

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
