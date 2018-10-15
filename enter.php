<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');
require_once('mysql_helper.php');

$get_categories = 'SELECT * FROM categories';
$categories = get_data($connect, $get_categories);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $values = [];

    // Проверяем поле email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите e-mail';
    } else {
        $values['email'] = filter($_POST['email']);
    }

    // Проверяем поле password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите пароль';
    }

    $safe_email = mysqli_real_escape_string($connect, $_POST['email']);
    $get_user = 'SELECT * FROM users WHERE user_email = "' . $safe_email . '"';
    $query_user = mysqli_query($connect, $get_user);
    $user = $query_user ? mysqli_fetch_array($query_user, MYSQLI_ASSOC) : NULL;

    if ($user) {
        if (password_verify($_POST['password'], $user['user_password'])) {
            $_SESSION['user'] = $user;
            header("Location: /");
            exit();
        } else {
            $errors['wrong_password'] = 'Неверный пароль';
        }
    } else {
        $errors['wrong_email'] = 'Пользователь не найден';
    }
} else {
    if (isset($_SESSION['user'])) {
        header("Location: /");
        exit();
    }
}

$page_content = include_template('enter.php', [
    'categories' => $categories,
    'errors' => $errors,
    'values' => $values
]);

$user_name = $user['user_name'];

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Вход',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
