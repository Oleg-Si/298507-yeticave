<?php
session_start();
$user_name = $_SESSION['user']['user_name'];
$user_avatar = $_SESSION['user']['user_avatar'];

require_once('functions.php');
require_once('connect.php');

// показываем лоты при запросе
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $safe_category_id = mysqli_real_escape_string($connect, $category_id);
    $get_category_name = mysqli_query($connect, 'SELECT category_name FROM categories WHERE id = "' . $safe_category_id . '"');

    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;
    $offset = ($cur_page - 1) * $page_items;
    $pagination_query = 'category_items.php?id=' . $category_id . '';

    $category_name = $get_category_name ? mysqli_fetch_array($get_category_name, MYSQLI_ASSOC) : NULL;
    $lots = get_data($connect, 'SELECT * FROM lots WHERE category_id = "' . $safe_category_id . '" ORDER BY date_craete DESC LIMIT ' . $page_items . ' OFFSET ' . $offset . '');

    $lots = add_timer($lots);

    // пагинация
    $query_count_lots = 'SELECT * FROM lots WHERE category_id = "' . $safe_category_id . '"';
    $count_lots = count(get_data($connect, $query_count_lots));

    $pages_count = ceil($count_lots / $page_items);

    $pages = range(1, $pages_count);
};

$get_categories = 'SELECT * FROM categories';
$categories = get_data($connect, $get_categories);

$pagination = include_template('pagination.php', [
    'pages_count' => $pages_count,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'pagination_query' => $pagination_query
]);

$page_content = include_template('category_items.php', [
    'categories' => $categories,
    'pagination' => $pagination,
    'category_name' => $category_name,
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'page_title' => 'Лоты в категории',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar
]);

echo $layout_content;
