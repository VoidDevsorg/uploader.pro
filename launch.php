<?php
    define('ROOT_PATH', dirname(__DIR__) . '/');
    session_start();

    if (!isset($_POST['access_token'])) {
        $_SESSION['token'] = md5(time() . rand(0, 1000000));
    }

    // error_reporting(0);
?>