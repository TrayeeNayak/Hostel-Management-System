<?php
session_start();
$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    if (isset($_POST['id']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['role'])) {
        $id = $_POST['id'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $username = $_POST['username']; 
        $role = $_POST['role'];

        if ($role == 'student') 
        {
            $stmt = $con->prepare("SELECT * FROM `student` WHERE USN = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = 1;
            } else {
                $stmt = $con->prepare("INSERT INTO `student` (USN, Spassword, SNAME) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $id, $password, $username);
                $stmt->execute();
                $success = 1;
                
            }
        } else {
            $stmt = $con->prepare("SELECT * FROM `warden` WHERE STAFF_ID = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = 1;
            } else {
                $stmt = $con->prepare("INSERT INTO `warden` (STAFF_ID, Wpassword, STAFF_NAME, STAFF_GENDER) VALUES (?, ?, ?, ?)");
                $gender = ($role == "boys_warden") ? "male" : "female";
                $stmt->bind_param("ssss", $id, $password, $username, $gender);
                $stmt->execute();
                $success = 1;
            }
        }
    }
}

if ($user) {
    $_SESSION['message'] = "User already exists.";
}

if ($success) {
    $_SESSION['message'] = "You are successfully signed up as $username.";
    header('Location: ../login.html');
    exit();
} else {
    $_SESSION['message'] = "Unable to sign up.";
}
?>
