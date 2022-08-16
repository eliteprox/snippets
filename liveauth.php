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

//Decode the owner and key
$owner = substr($stream_k, 0, 1);
$psk = right($stream_k, strlen($stream_k) - 1);

//you can use this for logging and debugging
// $checkExists = $GLOBALS['my_Db_Connection']->prepare("insert into logs VALUES(:textstr)");
// $checkExists->bindParam(':textstr', $psk);
// $checkExists->execute();

try {
    //Running queries
    $checkExists = $GLOBALS['my_Db_Connection']->prepare("SELECT id FROM videosys.channels WHERE stream_name=:streamname and owner_id=:ownerid and stream_key=:streamkey");
    $checkExists->bindParam(':ownerid', $owner);
    $checkExists->bindParam(':streamname', $stream_name);
    $checkExists->bindParam(':streamkey', $psk);
    $checkExists->execute();
    $count = $checkExists->rowCount();
    if ($count == 1) {
        //Update channel to LIVE mode
        $updateme = $GLOBALS['my_Db_Connection']->prepare("UPDATE videosys.channels SET live=1 where stream_name=:streamname and owner_id=:ownerid and stream_key=:streamkey");
    	$updateme ->bindParam(':ownerid', $owner);
    	$updateme ->bindParam(':streamname', $stream_name);
    	$updateme ->bindParam(':streamkey', $psk);
        $updateme->execute();

        $my_Db_Connection = NULL;

        //if auto-notifications enabled then
        //Send notifications...
        //$msg = "First line of text\nSecond line of text";
        // use wordwrap() if lines are longer than 70 characters
        //$msg = wordwrap($msg,70);
        // send email
        //mail("eliteproxy@gmail.com","My subject",$msg);
        //REFER TO SENDMAIL.PHP ON THE SERVER
    } else {
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