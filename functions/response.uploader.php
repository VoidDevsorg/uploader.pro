<?php
    function NewError($error) {
        $error = array(
            'success' => false,
            'message' => $error
        );
        $error = json_encode($error);
        return $error;
    }

    function NewSuccess($response, $data = null) {
        $response = array(
            'success' => true,
            'message' => $response,
            'data' => json_decode($data)
        );
        $response = json_encode($response);
        return $response;
    }
?>