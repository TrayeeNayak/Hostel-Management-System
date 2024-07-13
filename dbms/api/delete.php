<?php
// Include your database connection script
include 'connect.php';

// Check if the USN parameter is set in the URL
if(isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $usn = $_GET['id'];

    // Prepare and execute the SQL query to delete the student record
    $sql = "DELETE FROM student WHERE USN = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $usn);

    if ($stmt->execute()) {
        // Return a success message as JSON
        echo json_encode(array("success" => true));
    } else {
        // Log the error
        error_log("Error deleting student: " . $stmt->error);

        // Return an error message as JSON
        echo json_encode(array("success" => false, "error" => "Error deleting student"));
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // If the USN parameter is not set, return an error message as JSON
    echo json_encode(array("success" => false, "message" => "USN parameter is missing"));
}

// Close the database connection
$con->close();
?>
