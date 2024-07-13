<?php
session_start();
$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $username = $_POST['username'];

        // Check if student email already exists
        $stmt = $con->prepare("SELECT * FROM `student` WHERE SEMAIL = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = 1;
        } else {
            // Insert new student record
            $stmt = $con->prepare("INSERT INTO `student` (SEMAIL, Spassword, SNAME) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $password, $username);
            $stmt->execute();
            $success = 1;
        }
    }
}

if ($user) {
    $_SESSION['message'] = "User already exists.";
}

if ($success) {
    $_SESSION['message'] = "You are successfully signed up as $username.";
    header('Location: ../student_login.html');
    exit();
} else {
    $_SESSION['message'] = "Unable to sign up.";
    header('Location: ../student_signup.html');
    exit();
}
?>
