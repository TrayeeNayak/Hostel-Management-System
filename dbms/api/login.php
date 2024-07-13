<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Debugging - Print POST data
print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    // Check if the required POST variables are set
    if(isset($_POST['id']) && isset($_POST['password']) && isset($_POST['loginrole'])) {
        $id = $_POST['id']; // Assuming email is used as the username
        $password = $_POST['password'];
        $role = $_POST['loginrole']; 
    }

    if ($role == 'student') {
        $stmt = $con->prepare("SELECT USN, Spassword FROM student WHERE USN = ?");
    } else {
        $stmt = $con->prepare("SELECT STAFF_ID, Wpassword, STAFF_GENDER FROM warden WHERE STAFF_ID = ?");
    }
    
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($role == 'student') {
            if (password_verify($password, $row['Spassword'])) {
                $_SESSION['id'] = $id;
                
                $_SESSION['id'] = $row['USN'];
                $_SESSION['loginrole'] = 'student';
                header('Location: ./student.php');
                exit();
            } 

        } else {
            if (password_verify($password, $row['Wpassword'])) {
                $_SESSION['id'] = $id;
                $_SESSION['id'] = $row['STAFF_ID'];
                $_SESSION['loginrole'] = ($row['STAFF_GENDER'] == 'm') ? 'boys_warden' : 'girls_warden';
                // Redirect based on the login role
                if ($_SESSION['loginrole'] == 'boys_warden') {
                    header('Location: ./bwarden.php');
                } elseif ($_SESSION['loginrole'] == 'girls_warden') {
                    header('Location: ./warden.php');
                } else {
                    header('Location: ./student.php');
                }
                exit();
            } 
        }
    }
    // Invalid credentials
    header('Location: login.html');
    exit();
}
?>
