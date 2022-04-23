<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connect.php';

//Parse POST data json
$json = file_get_contents('php://input');
$webhook = json_decode($json);
$event = $webhook->event;

if ($event == "recording.ready") {
    //Look up channel in our database by livepeer stream id
    $livepeerid = $webhook->stream->id;

    $checkExists = $GLOBALS['my_Db_Connection']->prepare("SELECT id FROM videosys.channels WHERE livepeerid=:livepeer_id");
    $checkExists->bindParam(':livepeer_id', $livepeerid);
    $checkExists->execute();
    $count = $checkExists->rowCount();
    if ($count == 1) { 
        $insertrec = $GLOBALS['my_Db_Connection']->prepare("insert into recordings (recordingId, livepeerid, createdAt, title, recordingUrl, mp4Url) VALUES(UUID(),:livepeerid, :createdAt, :title, :recordingUrl, :mp4Url)");
        $insertrec->bindParam(':livepeerid', $livepeerid);
        $insertrec->bindParam(':createdAt', $webhook->createdAt);
        $insertrec->bindParam(':title', $webhook->stream->name);
        $insertrec->bindParam(':recordingUrl', $webhook->payload->recordingUrl);
        $insertrec->bindParam(':mp4Url', $webhook->payload->mp4Url);
        $insertrec->execute();
    }
}

if ($event == "stream.started") {
    $livepeerid = $webhook->stream->id;

    $checkExists = $GLOBALS['my_Db_Connection']->prepare("SELECT id FROM videosys.channels WHERE livepeerid=:livepeer_id");
    $checkExists->bindParam(':livepeer_id', $livepeerid);
    $checkExists->execute();
    $count = $checkExists->rowCount();
    if ($count == 1) {
        $update = $GLOBALS['my_Db_Connection']->prepare("update channels SET live=1 WHERE livepeerid=:livepeerid");
        $update->bindParam(':livepeerid', $livepeerid);
        $update->execute();
    }
}

if ($event == "stream.idle") {
    $livepeerid = $webhook->stream->id;
    $checkExists = $GLOBALS['my_Db_Connection']->prepare("SELECT id FROM videosys.channels WHERE livepeerid=:livepeer_id");
    $checkExists->bindParam(':livepeer_id', $livepeerid);
    $checkExists->execute();
    $count = $checkExists->rowCount();
    if ($count == 1) {
        $update = $GLOBALS['my_Db_Connection']->prepare("update channels SET live=0 WHERE livepeerid=:livepeerid");
        $update->bindParam(':livepeerid', $livepeerid);
        $update->execute();
    }
}

?>