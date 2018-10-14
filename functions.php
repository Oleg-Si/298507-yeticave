<?php

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require_once $name;

    $result = ob_get_clean();

    return $result;
}

function format_price($price) {
    $new_price = ceil($price);

    if ($new_price >= 1000) {
        $new_price = number_format($new_price, 0, '.', ' ') . ' ₽';
        return $new_price;
    }

    $new_price = $new_price . ' ₽';

    return $new_price;
}

function filter($str) {
    $text = htmlspecialchars($str);

    return $text;
}

function add_timer($array) {
    foreach ($array as $key => $lot) {
        $day = floor((strtotime($lot['date_closed']) - time()) / 86400);

        $time_hour = (strtotime($lot['date_closed']) - time()) % 86400;
        $hour = floor($time_hour / 3600);

        $time_minute = $time_hour % 3600;
        $minute = floor($time_minute / 60);

        $array[$key]['date_closed'] = $day . 'д:' . $hour . 'ч:' . $minute . 'м';
    }
    return $array;
}

function get_data($connect, $query) {
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $data;
}
