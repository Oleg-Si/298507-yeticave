<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');

if (isset($_GET['id'])) {
    $lot_id = $_GET['id'];
    $safe_lot_id = mysqli_real_escape_string($connect, $lot_id);
    $array_id = get_data($connect, 'SELECT id FROM lots');

    // переводим в простой массив
    foreach ($array_id as $id) {
        $simple_array_id[] = $id['id'];
    }
    // ищем наличие $lot_id в простом массиве
    if (!in_array($lot_id, $simple_array_id)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    };

} else {
    header("HTTP/1.0 404 Not Found");
    exit;
};

$get_categories = 'SELECT category_name FROM categories';
$get_lot = 'SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = ' . $safe_lot_id . '';

$categories = get_data($connect, $get_categories);
$lot = get_data($connect, $get_lot);

$page_content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot
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
