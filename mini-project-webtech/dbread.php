<?php
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");

// set the $servername, $dbname, $username, and $password
include 'dbconfig.php';
include 'StatusCRUD.php';

// option to directly create $crudStatus instance 
// by using jsone_decode function
//$crudStatus = json_decode('{"type":"read", "data":null, "status":null, "error_msg": null}');

// crudStatus instance creation  using OOP approach
$crudStatus = new StatusCRUD('read', null, null, null);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute SQL to fetch data from the 'fruits' table
    $stmt = $conn->prepare("SELECT * FROM marks");
    $stmt->execute();

    // Fetch all rows as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Populate the CRUD status data
    $crudStatus->data = $result;
    $crudStatus->status = 'success';

} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
    $crudStatus->status = 'fail';
    $crudStatus->error_msg = $e->getMessage();
}

echo json_encode($crudStatus);

?>