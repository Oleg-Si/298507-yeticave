<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');

$get_categories = 'SELECT * FROM categories';
$get_catalog = 'SELECT *, bets.date_craete FROM bets JOIN lots ON bets.lot_id = lots.id JOIN categories ON lots.category_id = categories.id JOIN users ON lots.user_id = users.id WHERE bets.user_id = "' . $_SESSION['user']['id'] . '" ORDER BY bets.date_craete DESC';

$categories = get_data($connect, $get_categories);
$lots = get_data($connect, $get_catalog);

// переводим дату ставок в "человеческую"
foreach ($lots as $key => $lot) {
    $date_create = strtotime($lot['date_craete']);
    $time_unix = time() - $date_create;

    $is_day = floor($time_unix / 86400);
    $is_hour = floor($time_unix / 3600);
    $is_minute = floor($time_unix / 60);

    if($is_day > 0) {
        $lots[$key]['date_craete'] = $is_day . ' дней назад';
    } else if ($is_hour <= 23 && $is_hour >= 1) {
        $lots[$key]['date_craete'] = $is_hour . ' часов назад';
    } else if ($is_minute <= 59 && $is_minute >= 1) {
        $lots[$key]['date_craete'] = $is_minute . ' минут назад';
    } else {
        $lots[$key]['date_craete'] = $time_unix . ' секунд назад';
    }
}

$lots = add_timer($lots);

$page_content = include_template('my_bets.php', [
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
