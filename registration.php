<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');
require_once('mysql_helper.php');

$get_categories = 'SELECT category_name FROM categories';

$categories = get_data($connect, $get_categories);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $values = [];

    // Проверяем поле email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите e-mail';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный e-mail';
    } else {
        $values['email'] = filter($_POST['email']);
    }

    // Проверяем существование пользователя с таким email
    $safe_email = mysqli_real_escape_string($connect, $_POST['email']);
    $get_email = 'SELECT id FROM users WHERE user_email = "' . $safe_email . '"';
    $email = mysqli_query($connect, $get_email);

    if (mysqli_num_rows($email) > 0) {
        $errors['user'] = 'Пользователь с этим email уже зарегистрирован';
    }

    // Проверяем поле password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите пароль';
    }

    // Проверяем поле message
    if (empty($_POST['message'])) {
        $errors['message'] = 'Напишите как с вами связаться';
    } else {
        $values['message'] = filter($_POST['message']);
    }

    // Проверяем поле name
    if (empty($_POST['name'])) {
        $errors['name'] = 'Введите имя';
    } else {
        $values['name'] = filter($_POST['name']);
    }

    // Проверяем аватар
    if (strlen($_FILES['img']['name'])) {
        $file_name = $_FILES['img']['name'];
        $file_path = __DIR__ . '/img/avatars/';
        $file_url = '/img/avatars/' . $file_name;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmp_name = $_FILES['img']['tmp_name'];
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== 'image/jpeg' && $file_type !== 'image/png') {
            $errors['img'] = 'Выберите изображение формата jpeg или png';
        }
    } else {
        $file_url = '';
    }

    if (!count($errors)) {
        move_uploaded_file($_FILES['img']['tmp_name'], $file_path . $file_name);

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (date_registr, user_email, user_name, user_password, user_avatar, user_contact) VALUES (NOW(), ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($connect, $sql, [$values['email'], $values['name'], $password, $file_url, $values['message']]);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $lot_id = mysqli_insert_id($connect);

            header('Location: /enter.php');
        }
    }
}

$page_content = include_template('registration.php', [
    'categories' => $categories,
    'errors' => $errors,
    'values' => $values
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Регистрация аккаунта',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
