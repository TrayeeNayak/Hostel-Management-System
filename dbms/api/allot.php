<?php
session_start();

// Include the database connection file
include("connect.php");

// Check if form is submitted
if(isset($_POST['allocate_room'])) {
    $usn = $_POST['usn'];
    $hostel_id = $_POST['hostel_id'];
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $attached = $_POST['attached'];

    // Fetch room capacity based on hostel ID, room type, and attached status
    $capacity_query = "SELECT CAPACITY FROM room_capacity WHERE HOSTEL_ID = $hostel_id AND ROOM_TYPE = '$room_type' AND ATTACHED = '$attached'";
    $capacity_result = mysqli_query($con, $capacity_query);
    $row = mysqli_fetch_assoc($capacity_result);
    $capacity = $row['CAPACITY'];

    // Check if the room is available*
    $occupancy_query = "SELECT COUNT(*) AS occupied FROM room WHERE HOSTEL_ID = $hostel_id AND ROOM_NUMBER = '$room_number'";
    $occupancy_result = mysqli_query($con, $occupancy_query);
    $row = mysqli_fetch_assoc($occupancy_result);
    $occupied = $row['occupied'];

    if ($occupied < $capacity) {
        // Insert room allocation into rooms table
        $query = "INSERT INTO room (USN, HOSTEL_ID, ROOM_NUMBER, ROOM_TYPE, attched) VALUES ('$usn','$hostel_id', '$room_number', '$room_type', '$attached')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Update student's table with allocated room details
            $update_query = "UPDATE student SET HOSTEL_ID = '$hostel_id', SROOM = '$room_number' WHERE usn = '$usn'";
            $update_result = mysqli_query($con, $update_query);

            if ($update_result) {
                // Redirect to the dashboard
                if ($_SESSION['loginrole'] == 'girls_warden') {
                    header('Location: warden.php');
                } else {
                    header('Location: bwarden.php');
                }
                exit();
            } else {
                $error_message = "Error updating student table: " . mysqli_error($con);
            }
        } else {
            $error_message = "Error allocating room: " . mysqli_error($con);
        }
    } else {
        $error_message = "Room is already occupied.";
    }
}

// Debugging: Output error message if any
if (isset($error_message)) {
    echo "<script>console.error('" . $error_message . "');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room Allocation</title>
</head>
<body>

<h2>Allocate Room</h2>

<form method="POST" action="allot.php">
    <label for="usn">Enter Student USN:</label>
    <input type="text" name="usn" required><br>

    <label for="hostel_id">Enter Hostel ID:</label>
    <input type="text" name="hostel_id" required><br>

    <label for="room_number">Enter Room Number:</label>
    <input type="text" name="room_number" required><br>

    <label for="room_type">Select Room Type:</label>
    <select name="room_type" required>
        <option value="single">Single</option>
        <option value="double">Double</option>
        <option value="triple">Triple</option>
    </select><br>

    <label for="attached">Select Attached Status:</label>
    <select name="attached" required>
        <option value="attached">Attached</option>
        <option value="non-attached">Non-Attached</option>
    </select><br>

    <button type="submit" name="allocate_room">Allocate Room</button>
</form>

</body>
</html>
