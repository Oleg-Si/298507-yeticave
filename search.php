<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');

$get_categories = 'SELECT * FROM categories';
$get_catalog = 'SELECT * FROM lots';

$categories = get_data($connect, $get_categories);

// поиск
$search = filter(trim($_GET['search'])) ?? '';
$safe_search = mysqli_real_escape_string($connect, $search);

if ((string)$search && (string)$search !== '') {
    // пагинация
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;
    $offset = ($cur_page - 1) * $page_items;
    $pagination_query = 'search.php?search=' . $search . '';

    $query_lots = 'SELECT *, lots.id FROM lots JOIN categories ON lots.category_id = categories.id WHERE MATCH(title, description) AGAINST("' . $safe_search . '") ORDER BY date_craete DESC LIMIT ' . $page_items . ' OFFSET ' . $offset . '';

    $lots = get_data($connect, $query_lots);

    // пагинация
    $query_count_lots = 'SELECT * FROM lots JOIN categories ON lots.user_id = categories.id WHERE MATCH(title, description) AGAINST("' . $safe_search . '")';
    $count_lots = count(get_data($connect, $query_count_lots));

    $pages_count = ceil($count_lots / $page_items);

    $pages = range(1, $pages_count);

    $lots = add_timer($lots);

    if (!count($lots)) {
        $not_result = '<p>Ничего не найдено по вашему запросу</p>';
    }
}
if ((string)$search === '') {
    $not_result = '<p>Вы не ввели ни одного символа</p>';
}

$pagination = include_template('pagination.php', [
    'pages_count' => $pages_count,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'pagination_query' => $pagination_query
]);

$page_content = include_template('search.php', [
    'categories' => $categories,
    'search' => $search,
    'not_result' => $not_result,
    'pagination' => $pagination,
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Результаты поиска',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
