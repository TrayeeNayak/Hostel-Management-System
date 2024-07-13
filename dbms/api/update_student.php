<?php

// Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection script
include 'connect.php';

// Check if the required POST data is set
if (isset($_POST['name']) && isset($_POST['usn']) && isset($_POST['branch']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['room']) && isset($_POST['phone']) && isset($_POST['semester']) && isset($_POST['gender']) && isset($_POST['father_name']) && isset($_POST['father_phone']) && isset($_POST['intake_date']) && isset($_POST['hostel_id'])) {
    // Prepare SQL statement to update student information
    $sql = "UPDATE student SET SNAME=?, SBRANCH=?, SEMAIL=?, SADDRESS=?, SROOM=?, SPHONE=?, SSEM=?, SGENDER=?, FNAME=?, FPHONE=?, INTAKE_DATE=?, HOSTEL_ID=? WHERE USN=?";

    // Prepare the SQL statement
    $stmt = $con->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("sssssssssssss", $_POST['name'], $_POST['branch'], $_POST['email'], $_POST['address'], $_POST['room'], $_POST['phone'], $_POST['semester'], $_POST['gender'], $_POST['father_name'], $_POST['father_phone'], $_POST['intake_date'], $_POST['hostel_id'], $_POST['usn']);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $con->error]);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Required POST data is missing
    echo json_encode(["success" => false, "error" => "Required POST data is missing"]);
}

// Close the database connection
$con->close();

?>
