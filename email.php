<?php
require_once('vendor/autoload.php');
require_once('connect.php');
require_once('functions.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$sql = 'SELECT lots.id, title, price, user_name, user_email FROM lots JOIN users ON users.id = lots.user_win WHERE user_win IS NOT NULL';

$res = mysqli_query($connect, $sql);

if ($res && mysqli_num_rows($res)) {
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);

    foreach ($data as $val) {
        $message = new Swift_Message();
        $message->setSubject("Поздравляем с победой");
        $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
        $message->setBcc($val['user_email']);

        $msg_content = include_template('email.php', ['val' => $val]);
        $message->setBody($msg_content, 'text/html');

        $result = $mailer->send($message);

        if ($result) {
            print("Рассылка успешно отправлена");
        }
        else {
            print("Не удалось отправить рассылку: " . $logger->dump());
        }
    }
}
