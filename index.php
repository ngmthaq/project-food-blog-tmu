<?php

session_start();

require_once("./configs/constants.php");
require_once("./configs/helpers.php");
require_once("./configs/database.php");
require_once("./configs/upload.php");

try {
    // Điều hướng đến các trang theo url
    $uri = str_replace("/", "\\", $_SERVER["REQUEST_URI"]);
    $uri = explode("?", $uri);
    $uri = isLocalhost() ? str_replace("\\" . DIR_NAME, "", $uri[0]) : $uri[0];
    $page = DIR_PAGE_ROOT . $uri . "\\index.php";

    if (!file_exists($page)) {
        include(DIR_TEMPLATE_ROOT . "\\_404.php");
        die();
    }
} catch (\Throwable $th) {
    include(DIR_TEMPLATE_ROOT . "\\_500.php");
    consoleLog($th);
    die();
}

// Kiểm tra đăng nhập
if (empty($_SESSION['user_id']) || $_SESSION['user_id'] === "") {
    if (in_array(uri(), [ROUTE_ADMIN, ROUTE_GET_POSTS, ROUTE_CREATE_POST, ROUTE_UPDATE_POST])) {
        redirect(ROUTE_HOMEPAGE);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php publicPath("img/favicon.ico") ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php publicPath("libs/bootstrap-4.6.2/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php publicPath("libs/fontawesome-6.2.0/css/all.min.css") ?>">
    <link rel="stylesheet" href="<?php publicPath("css/template.css") ?>">
    <link rel="stylesheet" href="<?php publicPath("css/main.css") ?>">
    <script src="<?php publicPath("libs/jquery-2.2.4/jquery.min.js") ?>"></script>
    <script src="<?php publicPath("libs/bootstrap-4.6.2/js/bootstrap.min.js") ?>"></script>
    <script src="<?php publicPath("libs/fontawesome-6.2.0/js/all.min.js") ?>"></script>
    <script src="<?php publicPath("libs/ckeditor5-35.3.0/build/ckeditor.js") ?>"></script>
    <?php include("./components/_head.php") ?>
</head>

<body>
    <section id="app">
        <?php include($page) ?>
    </section>

    <script src="<?php publicPath("js/index.js") ?>"></script>
    <?php include("./components/_script.php") ?>
</body>

</html>
