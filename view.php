<?php
include_once './functions/manager.uploader.php';

$full = $_SERVER['REQUEST_URI'];
$full = explode('/', $full);
$full = array_filter($full);
$extension = explode('.', $full[2]);

$image = getImage($full[2]);



if (!$image || $image == 0 || $image == "0") {
    $filepath = 'https://cdn.dribbble.com/users/844846/screenshots/2855815/media/b9ebecfa74ba38d612c2286545893dde.jpg';
} else {
    $filepath = $image['download_url'];
}

header('Content-Type: image/' . $extension[1]);
$image = file_get_contents($filepath);
echo $image;
?>