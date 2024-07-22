<?php
header("Content-type:text/plain");
header("Access-Control-Allow-Origin: *");

// set the $servername, $dbname, $username, and $password
include 'dbconfig.php';
include 'StatusCRUD.php';

$jsonStr = $_REQUEST["jsonStr"];

$data = json_decode($jsonStr);

// debug json data
//var_dump($data);
//echo json_encode($data);
//exit();

// option to directly create $crudStatus instance 
// by using jsone_decode function
//$crudStatus = json_decode('{"type":"create", "data":null, "status":null, "error_msg": null}');

// crudStatus instance creation  using OOP approach
$crudStatus = new StatusCRUD('create', null, null, null);

$crudStatus->data = $data;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // prepare sql and bind parameters
  $name = null;
  $stmt = $conn->prepare("INSERT INTO fruits (name) VALUES (:name)");
  $stmt->bindParam(':name', $name);

  foreach($data as $item) {
    $name = $item->name;
    $stmt->execute();
  }

  $crudStatus->status = 'success';

  // return "OK" string message if successful
  echo json_encode($crudStatus);

} catch(PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
  $crudStatus->status = 'fail';
  echo json_encode($crudStatus);
}

?>
