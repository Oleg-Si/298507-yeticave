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


function get_data($connect, $query) {
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $data;
}
