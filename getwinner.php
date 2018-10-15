<?php
require_once('functions.php');
require_once('connect.php');

$get_catalog = 'SELECT * FROM lots WHERE user_win IS NULL AND date_closed <= NOW() AND bets_count > 0';
$lots = get_data($connect, $get_catalog);

foreach ($lots as $key => $lot) {
    $get_last_bet = 'SELECT user_id FROM bets  WHERE lot_id = "' . $lot['id'] . '" ORDER BY id DESC  LIMIT 1' ;
    $last_bet = get_data($connect, $get_last_bet);

    $sql = 'UPDATE lots SET user_win = "' . $last_bet[0]['user_id'] . '" WHERE id = "' . $lot['id'] . '"';
    mysqli_query($connect, $sql);
}
