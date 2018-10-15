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
/**
 * Форматирует цену с разбивкой по тыс. с добавлением знака рубля
 *
 * @param $price string Цена
 *
 * @return string Отформатированная цена
 */
function format_price($price) {
    $new_price = ceil($price);

    if ($new_price >= 1000) {
        $new_price = number_format($new_price, 0, '.', ' ') . ' ₽';
        return $new_price;
    }

    $new_price = $new_price . ' ₽';

    return $new_price;
}
/**
 * Убирает html теги
 *
 * @param $str string Данные из форм и т.д.
 *
 * @return string Отформатированные данные
 */
function filter($str) {
    $text = htmlspecialchars($str);

    return $text;
}
/**
 * Форматирует дату в таймер в формате дни:часы:минуты
 *
 * @param array $array Массив с данными
 *
 * @return array Отформатированный массив с таймером на месте дат
 */
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
/**
 * Получает данные из БД и преобразует в массив в массив
 *
 * @param $connect mysqli Ресурс соединения
 * @param $query string SQL запрос
 *
 * @return array Массив с данными из запроса
 */
function get_data($connect, $query) {
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $data;
}
