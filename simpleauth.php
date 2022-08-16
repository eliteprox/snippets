<?php 

// Takes raw data from the POST request
$json = file_get_contents('php://input');
$data = json_decode($json);
$url = $data->{'url'};
$stream_details = parse_url($url, PHP_URL_PATH);
$stream_arr = explode("/", $stream_details);

$stream_name = $stream_arr[1];
$stream_key = $stream_arr[2];

try {
        if ($stream_key == "secretkey") {
            http_response_code(200);
        }
    } else {
        http_response_code(401);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

function right($str, $length) {
    return substr($str, -$length);
}

?>