<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');

// показываем лот при запросе
if (isset($_GET['id'])) {
    $lot_id = $_GET['id'];
    $safe_lot_id = mysqli_real_escape_string($connect, $lot_id);
    $array_id = get_data($connect, 'SELECT id FROM lots');

    // переводим в простой массив
    foreach ($array_id as $id) {
        $simple_array_id[] = $id['id'];
    }
    // ищем наличие $lot_id в простом массиве, если не существует, выдаем 404
    if (!in_array($lot_id, $simple_array_id)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    };

    $query_lot = 'SELECT * FROM lots WHERE id = "' . $safe_lot_id . '"';
    $get_lot = mysqli_query($connect, $query_lot);
    $lot = $get_lot ? mysqli_fetch_array($get_lot, MYSQLI_ASSOC) : NULL;

    $price = $lot['price_now'];
    $min_price = $lot['price_now'] + $lot['step'];

} else {
    header("HTTP/1.0 404 Not Found");
    exit;
};

// если пользователь создал лот, не показывем блок добавления ставки
// если срок истек, скрываем блок добавления ставки
// если пользователь добавил ставку, скрываем блок добавления ставки
$query_user_id = 'SELECT user_id FROM bets WHERE lot_id = ' . $safe_lot_id . '';
$all_user_id = get_data($connect, $query_user_id);

// переводим в простой массив
if (count($all_user_id)) {
    foreach ($all_user_id as $id) {
        $simple_array_user_id[] = $id['user_id'];
    }
} else {
    $simple_array_user_id = [];
}

if($lot['user_id'] === $_SESSION['user']['id']) {
    $hide_block = true;
} else if (strtotime($lot['date_closed']) - time() <= 0) {
    $hide_block = true;
} else if (in_array($_SESSION['user']['id'], $simple_array_user_id)) {
    $hide_block = true;
} else {
    $hide_block = false;
}

// вывод таймера окончания торгов в формате дни:часы:минуты
$day = floor((strtotime($lot['date_closed']) - time()) / 86400);

$time_hour = (strtotime($lot['date_closed']) - time()) % 86400;
$hour = floor($time_hour / 3600);

$time_minute = $time_hour % 3600;
$minute = floor($time_minute / 60);

// выводим список ставок к лоту
$query_bets = "SELECT user_name, price, date_craete FROM bets JOIN users ON bets.user_id = users.id WHERE bets.lot_id = " . $safe_lot_id . " ORDER BY price DESC";
$bets = get_data($connect, $query_bets);

// переводим дату ставок в "человеческую"
foreach ($bets as $key => $bet) {
    $date_create = strtotime($bet['date_craete']);
    $a = time() - $date_create;

    $is_day = floor($a / 86400);
    $is_hour = floor($a / 3600);
    $is_minute = floor($a / 60);

    if($is_day > 0) {
        $bets[$key]['date_craete'] = $is_day . ' дней назад';
    } else if ($is_hour <= 23 && $is_hour >= 1) {
        $bets[$key]['date_craete'] = $is_hour . ' часов назад';
    } else if ($is_minute <= 59 && $is_minute >= 1) {
        $bets[$key]['date_craete'] = $is_minute . ' минут назад';
    } else {
        $bets[$key]['date_craete'] = $a . ' секунд назад';
    }
}

// проверяем форму и записываем в базу ставку
if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $cost = filter($_POST['cost']);
    $safe_cost = mysqli_real_escape_string($connect, $cost);
    $errors = [];

    if (!is_numeric($cost) || empty($cost) || $cost <= 0) {
        $errors['price'] = 'Укажите цену';
    } else if ($cost != round($cost)) {
        $errors['price'] = 'Введите целое число';
    } else if ($cost < $min_price) {
        $errors['price'] = 'Меньше минимальной ставки';
    } else {
        mysqli_query($connect, "START TRANSACTION");
        $query1 = mysqli_query($connect, 'UPDATE lots SET price_now = ' . $safe_cost . ' WHERE id = ' . $lot['id'] . '');
        $query2 = mysqli_query($connect, 'UPDATE lots SET bets_count = bets_count + 1 WHERE id = ' . $lot['id']. '');
        $query3 = mysqli_query($connect, 'INSERT INTO bets(date_craete, price, user_id, lot_id) VALUES (NOW(),' . $safe_cost . ',' . $_SESSION['user']['id'] . ',' . $lot['id']. ')');

        if ($query1 && $query2 && $query3) {
            mysqli_query($connect, "COMMIT");
            header("Location: /lot.php?id=" . $lot['id']);
            exit();
        }
        else {
            mysqli_query($connect, "ROLLBACK");
        }
    }
}

$get_categories = 'SELECT category_name FROM categories';
$get_lot = 'SELECT * FROM lots JOIN categories ON lots.category_id = categories.id WHERE lots.id = ' . $safe_lot_id . '';

$categories = get_data($connect, $get_categories);
$lot = get_data($connect, $get_lot);

$page_content = include_template('lot.php', [
    'categories' => $categories,
    'errors' => $errors,
    'bets' => $bets,
    'min_price' => $min_price,
    'price' => $price,
    'hide_block' => $hide_block,
    'day' => $day,
    'hour' => $hour,
    'minute' => $minute,
    'lot' => $lot
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Лот',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
//mysqli_query($connect, 'UPDATE lots SET price_now = 10999 WHERE id = 1');
//mysqli_query($connect, 'UPDATE lots SET price_now = 159999 WHERE id = 2');
//mysqli_query($connect, 'UPDATE lots SET price_now = 8000 WHERE id = 3');
//mysqli_query($connect, 'UPDATE lots SET price_now = 10999 WHERE id = 4');
//mysqli_query($connect, 'UPDATE lots SET price_now = 7500 WHERE id = 5');
//mysqli_query($connect, 'UPDATE lots SET price_now = 5400 WHERE id = 6');
//
//mysqli_query($connect, 'UPDATE lots SET price_now = 51000 WHERE id = 16');
