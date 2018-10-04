<?php
$is_auth = rand(0, 1);

$user_name = 'Олег';
$user_avatar = 'img/user.jpg';

require_once('functions.php');
require_once('connect.php');
require_once('mysql_helper.php');

$get_categories = 'SELECT category_name FROM categories';

$categories = get_data($connect, $get_categories);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $values = [];

    // Проверяем на пустоту строки
    if (empty($_POST['lot-name'])) {
        $errors['lot-name'] = 'Введите наименование лота';
    } else {
        $values['lot-name'] = $_POST['lot-name'];
    }

    // Проверяем на пустоту строки
    if (empty($_POST['message'])) {
        $errors['message'] = 'Напишите описание лота';
    } else {
        $values['message'] = $_POST['message'];
    }

    // Проверяем на пустоту строки и число
    if (empty($_POST['lot-rate'])) {
        $errors['lot-rate'] = 'Введите начальную цену';
    } else if (is_numeric($_POST['lot-rate'])) {
        $values['lot-rate'] = $_POST['lot-rate'];
    } else {
        $errors['lot-rate'] = 'Цена должна быть числом';
        $values['lot-rate'] = $_POST['lot-rate'];
    }

    // Проверяем на пустоту строки и число
    if (empty($_POST['lot-step'])) {
        $errors['lot-step'] = 'Введите шаг ставки';
    } else if (is_numeric($_POST['lot-step'])) {
        $values['lot-step'] = $_POST['lot-step'];
    } else {
        $errors['lot-step'] = 'Шаг должен быть числом';
        $values['lot-step'] = $_POST['lot-step'];
    }

    // Проверяем на пустоту строки
    if (empty($_POST['lot-date'])) {
        $errors['lot-date'] = 'Введите дату завершения торгов';
    } else {
        $values['lot-date'] = $_POST['lot-date'];
    }

    // Проверяем на пустоту строки
    if ($_POST['category'] == 'Выберите категорию') {
        $errors['category'] = 'Вы не выбрали категорию';
    } else {
        $values['category'] = $_POST['category'];
    }

    // Проверяем картинку
    if (isset($_FILES['img'])) {
        $file_name = $_FILES['img']['name'];
        $file_path = __DIR__ . '/img/';
        $file_url = '/img/' . $file_name;
    }

    if (!count($errors)) {
        move_uploaded_file($_FILES['img']['tmp_name'], $file_path . $file_name);

        $category_id_query = 'SELECT id FROM categories WHERE categories.category_name = "' . mysqli_real_escape_string($connect, $values['category']) . '"';
        $category_id = get_data($connect, $category_id_query);

        $sql = 'INSERT INTO lots (date_craete, title, category_id, description, image, price, step, date_closed) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($connect, $sql, [$values['lot-name'], $category_id[0]['id'], $values['message'], $file_url, $values['lot-rate'], $values['lot-step'], $values['lot-date']]);
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
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
