<?php
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");

// Include database configuration and StatusCRUD class
include 'dbconfig.php';
include 'StatusCRUD.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM fruits"); 
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $crudStatus = new StatusCRUD('read', $result, 'success', null);
} catch(PDOException $e) {
    $crudStatus = new StatusCRUD('read', null, 'error', $e->getMessage());
}

// Encode the StatusCRUD instance to JSON and output it
echo json_encode($crudStatus);
?>
