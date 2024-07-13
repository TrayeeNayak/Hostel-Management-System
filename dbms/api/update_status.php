<?php
include 'connect.php'; // Include your database connection script

// Check if the ID parameter is set

    $id = $_POST['id'];
    
    // Update the status in the outpass table to "accepted"
    $update_query = "UPDATE outpass SET status = 'rejected' WHERE id = '$id'";
    $result = $con->query($update_query);
        
        if($result) {
            // Success response
            echo json_encode(array("success" => true));
        } else {
            // Error response
            echo json_encode(array("success" => false, "error" => "Error moving outpass request to outpass_requests table"));
        }
    
// Close the database connection
$con->close();
?>
