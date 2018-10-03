<?php
$connect = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($connect, 'utf8');

if ($connect == false) {
    echo 'Ошибка подключения: ' . mysqli_connect_error();
}
