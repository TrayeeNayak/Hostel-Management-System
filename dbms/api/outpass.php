<?php
session_start(); // Start the session

// Function to generate a random alphanumeric string
function generateRandomString($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    // Loop to generate random characters
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

// Check if the user is logged in
if(isset($_SESSION['id'])) {
    // Include your database connection script
    include 'connect.php';

    // Retrieve the USN based on the user's login credentials
    $id = $_SESSION['id'];

    // Assuming you have a table named 'student' with columns 'username' and 'USN'
    $query = "SELECT USN FROM student WHERE USN = '$id'";
    $result = $con->query($query);

    if (!$result) {
        echo "Error: " . $con->error;
    } elseif ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usn = $row['USN'];

        // Check if the form is submitted
        if(isset($_POST['submit'])) {
            // Retrieve form data
            $reason = $_POST['reason'];
            $departure_date = $_POST['departure_date'];
            $departure_time = $_POST['departure_time'];
            $return_date = $_POST['return_date'];
            $return_time = $_POST['return_time'];

            // Generate a random outpass ID
            $outpass_id = generateRandomString();

            // Insert outpass application into the database
            $insert_query = "INSERT INTO outpass (id, USN, reason, departure_date, departure_time, return_date, return_time) VALUES ('$outpass_id','$usn', '$reason', '$departure_date', '$departure_time', '$return_date', '$return_time')";
            $result = $con->query($insert_query);

            if($result) {
                // echo "Outpass application submitted successfully. Outpass ID: $outpass_id";
            } else {
                echo "Error submitting outpass application: " . $con->error;
            }
        }
    } else {
        echo "No matching records found for the logged-in user.";
    }

    // Close the database connection
    $con->close();
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Outpass Application</title>
</head>
<body>
    <h2>Hostel Outpass Application</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <!-- <label for="usn">USN:</label><br>
    <input type="usn" id="usn" name="usn" required><br> -->
    <label for="reason">Reason for Leaving:</label><br>
    <textarea id="reason" name="reason" required></textarea><br>
    <label for="departure_date">Departure Date:</label><br>
    <input type="date" id="departure_date" name="departure_date" required><br>
    <label for="departure_time">Departure Time:</label><br>
    <input type="time" id="departure_time" name="departure_time" required><br>
    <label for="return_date">Return Date:</label><br>
    <input type="date" id="return_date" name="return_date" required><br>
    <label for="return_time">Return Time:</label><br>
    <input type="time" id="return_time" name="return_time" required><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
