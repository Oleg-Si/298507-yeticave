<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

if (!$_SESSION['user']) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}

require_once('functions.php');
require_once('connect.php');
require_once('mysql_helper.php');

$get_categories = 'SELECT * FROM categories';

$categories = get_data($connect, $get_categories);

if ((string)$_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $values = [];

    // Проверяем на пустоту строки
    if (empty($_POST['lot-name'])) {
        $errors['lot-name'] = 'Введите наименование лота';
    } else {
        $values['lot-name'] = filter($_POST['lot-name']);
    }

    // Проверяем на пустоту строки
    if (empty($_POST['message'])) {
        $errors['message'] = 'Напишите описание лота';
    } else {
        $values['message'] = filter($_POST['message']);
    }

    // Проверяем на пустоту строки и число
    if (empty($_POST['lot-rate'])) {
        $errors['lot-rate'] = 'Введите начальную цену';
    } else if (is_numeric($_POST['lot-rate']) && (int)$_POST['lot-rate'] > 0) {
        $values['lot-rate'] = filter($_POST['lot-rate']);
    } else {
        $errors['lot-rate'] = 'Цена должна быть числом';
        $values['lot-rate'] = filter($_POST['lot-rate']);
    }

    // Проверяем на пустоту строки и число
    if (empty($_POST['lot-step'])) {
        $errors['lot-step'] = 'Введите шаг ставки';
    } else if (is_numeric($_POST['lot-step']) && (int)$_POST['lot-step'] > 0) {
        $values['lot-step'] = filter($_POST['lot-step']);
    } else {
        $errors['lot-step'] = 'Шаг должен быть числом';
        $values['lot-step'] = filter($_POST['lot-step']);
    }

    // Проверяем поле даты
    if (empty($_POST['lot-date'])) {
        $errors['lot-date'] = 'Введите дату завершения торгов';
    } else if (strtotime($_POST['lot-date']) - time() < 43200) {
        $errors['lot-date'] = 'Срок меньше 1 дня';
    } else {
        $values['lot-date'] = filter($_POST['lot-date']);
    }

    // Проверяем на пустоту строки
    if ((string)$_POST['category'] === 'Выберите категорию') {
        $errors['category'] = 'Вы не выбрали категорию';
    } else {
        $values['category'] = filter($_POST['category']);
    }

    // Проверяем картинку
    if (strlen($_FILES['img']['name'])) {
        $file_name = $_FILES['img']['name'];
        $file_path = __DIR__ . '/img/';
        $file_url = '/img/' . $file_name;

        $tmp_name = $_FILES['img']['tmp_name'];
        $file_type = mime_content_type($tmp_name);

        if ((string)$file_type !== 'image/jpeg' && (string)$file_type !== 'image/png') {
            $errors['img'] = 'Выберите изображение формата jpeg или png';
        }
    } else {
        $errors['img'] = 'Вы не выбрали изображение';
    }

    if (!count($errors)) {
        move_uploaded_file($_FILES['img']['tmp_name'], $file_path . $file_name);

        $category_id_query = 'SELECT id FROM categories WHERE categories.category_name = "' . mysqli_real_escape_string($connect, $values['category']) . '"';
        $category_id = get_data($connect, $category_id_query);

        $sql = 'INSERT INTO lots (date_craete, title, description, image, price, date_closed, step, bets_count, price_now, user_id, category_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($connect, $sql, [$values['lot-name'], $values['message'], $file_url, $values['lot-rate'], $values['lot-date'], $values['lot-step'], 0, $values['lot-rate'], $_SESSION['user']['id'], $category_id[0]['id']]);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $lot_id = mysqli_insert_id($connect);

            header("Location: lot.php?id=" . $lot_id);
        }
    }
}

$page_content = include_template('add.php', [
    'categories' => $categories,
    'errors' => $errors,
    'values' => $values
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Добавить лот',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
