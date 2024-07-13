<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    // Check if the required POST variables are set
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username']; // Assuming email is used as the username
        $password = $_POST['password'];
        $role = $_POST['loginrole']; 
    }

    if ($role == 'girls_warden'){
        $stmt = $con->prepare("SELECT STAFF_NAME, Wpassword, STAFF_GENDER FROM warden WHERE STAFF_NAME = ?");
    }else{
        $stmt = $con->prepare("SELECT STAFF_NAME, Wpassword, STAFF_GENDER FROM warden WHERE STAFF_NAME = ?");
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    if (password_verify($password, $row['Wpassword'])) {
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $row['STAFF_NAME'];
        $_SESSION['loginrole'] = ($row['STAFF_GENDER'] == 'm') ? 'boys_warden' : 'girls_warden';
        // Redirect based on the login role
        if ($_SESSION['loginrole'] == 'boys_warden') {
            header('Location: ./bwarden.php');
        } else{
            header('Location: ./warden.php');
        }
    } 
}
}


// If session variable 'role' is not set or invalid, proceed with login page
?>
<!-- Your login page HTML goes here -->
