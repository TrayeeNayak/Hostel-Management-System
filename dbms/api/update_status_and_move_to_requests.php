<?php
include 'connect.php'; // Include your database connection script

// Check if the ID parameter is set

    $id = $_POST['id'];
    
    // Update the status in the outpass table to "accepted"
    $update_query = "UPDATE outpass SET status = 'approved' WHERE id = '$id'";
    $result = $con->query($update_query);
    
    if($result) {
        // Insert the corresponding outpass entry into the outpass_requests table
        $insert_query = "INSERT INTO outpass_requests (id, USN, reason, departure_date, departure_time, return_date, return_time) SELECT id, USN, reason, departure_date, departure_time, return_date, return_time FROM outpass WHERE id = '$id'";
        $result = $con->query($insert_query);
        
        if($result) {
            // Success response
            echo json_encode(array("success" => true));
        } else {
            // Error response
            echo json_encode(array("success" => false, "error" => "Error moving outpass request to outpass_requests table"));
        }
    } else {
        // Error response
        echo json_encode(array("success" => false, "error" => "Error updating status in outpass table"));
    }
// Close the database connection
$con->close();
?>
