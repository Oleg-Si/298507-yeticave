<?php
$is_auth = rand(0, 1);

$user_name = 'Олег';
$user_avatar = 'img/user.jpg';

require_once('functions.php');

$connect = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($connect, 'utf8');

if ($connect == false) {
    echo 'Ошибка подключения: ' . mysqli_connect_error();
}

if (isset($_GET['id'])) {
    $lot_id = $_GET['id'];
    $array_id = get_data($connect, 'SELECT id FROM lots');
    if (!in_array($lot_id, $array_id)) {
        http_response_code(404);
    }
} else {
    http_response_code(404);
};

$get_categories = 'SELECT category_name FROM categories';
$get_lot = 'SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = ' . $lot_id . '';

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
