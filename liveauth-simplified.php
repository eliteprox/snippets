<?php 
include 'connect.php';

// Takes raw data from the POST request
$json = file_get_contents('php://input');
$data = json_decode($json);
$url = $data->{'url'};
$stream_details = parse_url($url, PHP_URL_PATH);
$stream_arr = explode("/", $stream_details);

$stream_name = $stream_arr[1];
$stream_k = $stream_arr[2];

try {
    //Running queries
    $checkExists = $GLOBALS['my_Db_Connection']->prepare("SELECT id FROM videosys.channels WHERE stream_name=:streamname and stream_key=:streamkey");
    $checkExists->bindParam(':streamname', $stream_name);
    $checkExists->bindParam(':streamkey', $stream_k);
    $checkExists->execute();
    $count = $checkExists->rowCount();
    if ($count == 1) {
        //Access Granted
        http_response_code(200);
    } else {
        //Access Denied
        http_response_code(401);
    }
} catch (Exception $e) {
    $my_Db_Connection = NULL;
    http_response_code(500);
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

function right($str, $length) {
    return substr($str, -$length);
}

?>