<?php
$servername = "localhost";
$database = "videosys";
$username = "";
$password = "$";
$sql = "mysql:host=$servername;dbname=$database;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

$my_Db_Connection = "";
try {
  $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
  // echo "DB Connection Successful";
} catch (PDOException $error) {
  http_response_code(500);
  echo 'Connection error: ' . $error->getMessage();
  exit();
}

?>