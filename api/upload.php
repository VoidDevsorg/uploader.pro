<?php
require_once '../functions/response.uploader.php';
require_once '../functions/str.uploader.php';

$config = json_decode(file_get_contents('../static/config.json'), true);


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

if (!isset($_FILES['file'])) {
    echo NewError('No file was uploaded');
    exit;
}

$max_file_size = (25 * 1024 * 1024);
$gh_key = $config['gh_key'];
$gh_owner = $config['gh_owner'];
$gh_repo = $config['gh_repo'];
$gh_path = $config['gh_path'];

$file = $_FILES['file'];
$file_name = $file['name'];
$file_tmp = $file['tmp_name'];
$file_size = $file['size'];
$file_error = $file['error'];

$file_ext = explode('.', $file_name);
$file_ext = strtolower(end($file_ext));

$allowed = array('png', 'jpg', 'jpeg', 'gif');

$new_file_name = randomStr() . '.' . $file_ext;

if (!in_array($file_ext, $allowed)) {
    echo NewError('File type not allowed');
    exit;
}

if ($file_error !== 0) {
    echo NewError('There was an error uploading your file');
    exit;
}

if ($file_size > $max_file_size) {
    echo NewError('File is too big (max: ' . $max_file_size . ')');
    exit;
}


$file_data = file_get_contents($file_tmp);
$file_data = base64_encode($file_data);

$date = date('Y-m-d H:i:s');


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/' . $gh_owner . '/' . $gh_repo . '/contents/' . $gh_path . $new_file_name);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

// return print_r('<img src="data:image/png;base64,' . $file_data . '" alt="image">');

$postFields = array(
    'message' => 'Uploaded file ' . $new_file_name . ' via uploader.pro - ' . $date,
    'committer' => array(
        'name' => 'uploader.pro',
        'email' => 'upload@uploader.pro'
    ),
    'content' => $file_data
);

$postFields = json_encode($postFields);

$curl = curl_init();
curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => "https://api.github.com/repos/" . $gh_owner . "/" . $gh_repo . "/contents/" . $gh_path . $new_file_name,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $gh_key,
            'Content-Type: application/json',
            'Accept: application/vnd.github.v3+json',
            'User-Agent: uploader.pro'
        ),
    )
);

$response = curl_exec($curl);

curl_close($curl);

$response = json_decode($response, true);
$download_url = $response['content']['download_url'];

$data = array(
    'file_name' => $new_file_name,
    'file_go_url' => 'https://i.uploader.pro/' . $new_file_name,
    'file_view_url' => 'https://uploader.pro/' . $new_file_name,
    'deletion_key' => $response['content']['sha']
);

$data = json_encode($data);

if (!$download_url)
    echo NewError('There was an error uploading your file');
else
    echo NewSuccess('File uploaded successfully', $data);
?>