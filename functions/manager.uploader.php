<?php
$gh_key = $config['gh_key'];
$gh_owner = $config['gh_owner'];
$gh_repo = $config['gh_repo'];
$gh_path = $config['gh_path'];

function getTotalImagesCount()
{
    global $gh_key, $gh_owner, $gh_repo, $gh_path, $config;
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "https://api.github.com/repos/" . $gh_owner . "/" . $gh_repo . "/contents/" . $gh_path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $gh_key,
                'Content-Type: application/json',
                'Accept: application/vnd.github.v3+json',
                'User-Agent: uploader.pro'
            ),
        )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "0";
    } else {
        $response = json_decode($response, true);
        return count($response);
    }
}

function getImage($id)
{
    global $gh_key, $gh_owner, $gh_repo, $gh_path, $config;
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "https://api.github.com/repos/" . $gh_owner . "/" . $gh_repo . "/contents/" . $gh_path . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $gh_key,
                'Content-Type: application/json',
                'Accept: application/vnd.github.v3+json',
                'User-Agent: uploader.pro'
            ),
        )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "0";
    } else {
        if (strpos($response, 'Not Found') !== false) {
            return "0";
        }
        if (!json_decode($response, true)['name']) {
            return "0";
        } else {
            $response = json_decode($response, true);
            return $response;
        }
    }
}

function deleteImage($id, $sha)
{
    $image = getImage($id);
    if ($image == 0 || $image == "0") {
        return "0";
    }
    $imageSha = $image['sha'];
    if ($imageSha != $sha) {
        return "1";
    }

    global $gh_key, $gh_owner, $gh_repo, $gh_path, $config;
    $curl = curl_init();

    $postFields = array(
        'message' => 'Delete image ' . $id,
        'committer' => array(
            'name' => 'uploader.pro',
            'email' => 'upload@uploader.pro'
        ),
        'sha' => $sha
    );

    $postFields = json_encode($postFields);

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "https://api.github.com/repos/" . $gh_owner . "/" . $gh_repo . "/contents/" . $gh_path . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $gh_key,
                'Content-Type: application/json',
                'Accept: application/vnd.github.v3+json',
                'User-Agent: uploader.pro'
            ),
        )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "0";
    } else {
        if (!json_decode($response, true)['content']) {
            return "0";
        } else {
            $response = json_decode($response, true);
            return $response;
        }
    }
}

?>