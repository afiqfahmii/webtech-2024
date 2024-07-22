<?php
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");

// Include database configuration and StatusCRUD class
require_once 'dbconfig.php';
require_once 'StatusCRUD.php';

// Sleep for 1 second to simulate slow AJAX connection (optional)
sleep(1);

$data = null;

if (isset($_REQUEST["jsonStr"])) {
    $jsonStr = $_REQUEST["jsonStr"];
    $data = json_decode($jsonStr);
}

// Initialize StatusCRUD instance
$crudStatus = new StatusCRUD('update', null, null, null);

if ($data != null) {
    $crudStatus->data = $data;
    
    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement for updating data
        $stmt = $conn->prepare("UPDATE marks SET name = :name, session = :session, cw = :cw, fe = :fe WHERE id = :id");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':session', $session);
        $stmt->bindParam(':cw', $cw);
        $stmt->bindParam(':fe', $fe);
        $stmt->bindParam(':id', $id);

        foreach ($data as $item) {
            $id = $item->id;  // Ensure that the id is provided in the data
            $name = $item->name;
            $cw = $item->cw;
            $fe = $item->fe;
            $session = $item->session;

            // Execute the SQL statement
            $stmt->execute();
        }

        $crudStatus->status = 'success';
    } catch (PDOException $e) {
        // Handle any exceptions and set the status to fail
        $crudStatus->status = 'fail';
        $crudStatus->error_msg = $e->getMessage();
    }
} else {
    // If data is null, set status to fail
    $crudStatus->status = 'fail';
    $crudStatus->error_msg = 'Invalid JSON input';
}

// Output the result as JSON
echo json_encode($crudStatus);
?>
