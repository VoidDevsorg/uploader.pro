<?php
$config = json_decode(file_get_contents('../static/config.json'), true);

require_once '../functions/response.uploader.php';
require_once '../functions/str.uploader.php';
require_once '../functions/manager.uploader.php';

session_start();

if (!isset($_GET['access_token'])) {
    echo NewError('No token provided');
    exit;
}

if (!$_SESSION['token']) {
    echo NewError('No token provided');
    exit;
}

if ($_SESSION['token'] !== $_GET['access_token']) {
    echo NewError("Token doesn't match");
    exit;
}

if (!isset($_GET['deletionKey']) || !isset($_GET['id'])) {
    echo NewError('No delete key or id provided');
    exit;
}

if (!$_GET['deletionKey'] || !$_GET['id']) {
    echo NewError('No delete key or id provided');
    exit;
}

$deleteKey = $_GET['deletionKey'];
$id = $_GET['id'];

$delete = deleteImage($id, $deleteKey);

if ($delete == 0 || $delete == "0") {
    echo NewError('Invalid image');
    exit;
}

if ($delete == "1") {
    echo NewError('Invalid delete key');
    exit;
}

echo NewSuccess($delete);