<?php
session_start();
include 'connect.php';

// Create the upload directory if it doesn't exist
$upload_directory = 'upload';

if (!file_exists($upload_directory)) {
    if (!mkdir($upload_directory, 0777, true)) {
        die('Failed to create upload directory...');
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id'] ?? '';
    
    // Check if a new profile picture is uploaded
    if ($_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $profile_picture_filename = basename($_FILES['profile_image']['name']);
        $target_path = $upload_directory . '/' . $profile_picture_filename;
        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
           // If not set, assign an empty string

            die('Failed to move uploaded file...');
        }
    } else {
        $profile_picture_filename = $_POST['current_profile_image']; // If no new file uploaded, retain the existing profile picture filename from the database
    }

    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $id = $_POST['id'] ?? '';
    $course = $_POST['course'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $email = $_POST['email'] ?? '';
    $sem = $_POST['sem'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $religion = $_POST['religion'] ?? '';
    $fname = $_POST['fname'] ?? '';
    $fphone = $_POST['fphone'] ?? '';
    $mname = $_POST['mname'] ?? '';
    $room = $_POST['room'] ?? '';
    $intake = $_POST['intake'] ?? '';
    $hid = $_POST['hid'] ?? '';

    // Prepare and execute the SQL statement to update the data in the student table
    $stmt = $con->prepare("UPDATE student SET SNAME=?, SBRANCH=?, SPHONE=?, DOB=?, SEMAIL=?, SSEM=?, SGENDER=?, SADDRESS=?, SRELIGION=?, FNAME=?, FPHONE=?, MNAME=?, SROOM=?, INTAKE_DATE=?, HOSTEL_ID=?, PROFILE=? WHERE USN=?");

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssssssssssssssss", $username, $course, $contact, $dob, $email, $sem, $gender, $address, $religion, $fname, $fphone, $mname, $room, $intake, $hid, $profile_picture_filename, $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to dash.php
            header("Location: student.php");
            exit();
        } else {
            // Error occurred during execution
            echo "Error: " . $stmt->error;
        }
        // Close the statement
        $stmt->close();
    } else {
        // Error occurred during preparation
        echo "Error: " . $con->error;
    }
}

// Fetch the details from the database if the form is not submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id = $_SESSION['id'] ?? '';

    // Prepare and execute the query to fetch user details
    $stmt = $con->prepare("SELECT SNAME, SBRANCH, SPHONE, DOB, SEMAIL, SSEM, SGENDER, SADDRESS, SRELIGION, FNAME, FPHONE, MNAME, SROOM, INTAKE_DATE, HOSTEL_ID, PROFILE FROM student WHERE USN = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($username, $course, $contact, $dob, $email, $sem, $gender, $address, $religion, $fname, $fphone, $mname, $room, $intake, $hid, $profile_picture_filename);
    $stmt->fetch();

    // Close the statement
    $stmt->close();
}

// Close the database connection
$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="./images/logo.png">
    <link rel="stylesheet" href="./css/account.css">
    

    <style>
        @import  url('https"//fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        *{ 
            margin: 0;
            padding:0;
            box-sizing: border-box;
            font-family: 'Poppins',sans-serif;
        
        }
        body{
            display: flex;
            height: 110vh;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            
        }
        .container{
            max-width: 900px;
            width: 100%;
            background: #fff;
            padding: 20px 40px;
            border-radius: 10px;
        }
        .container .title{
            font-size: 25px;
            font-weight: 500;
            position: relative;
        }
        .container .title::before{
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            width: 30px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }
        .container form .user-details{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        form .user-details .input-box{
            margin: 10px 0 3px 0;
            width: calc(100% / 2 - 30px);
        }
        .user-details .input-box .details{
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }
        .user-details .input-box input{
            height: 35px;
            width: 100%;
            outline: none;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding-left: 15px;
            font-size: 16px;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
        }
        .user-details .input-box input:focus,
        .user-details .input-box input:valid{
            border-color: #9b59b6;
        }
        form .button{
            height:15px;
            margin:15px 0;
        }
        form .button input{
            height: 100%;
            width:20%;
            outline: none;
            color: #fff;
            border: none;
            font-size: 18px;
            font-weight: 500;
            border-radius: 5px;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }
        form .button input:hover{
            background: linear-gradient(-135deg, #71b7e6, #9b59b6);
        }
        @media (max-width: 584px) {
            .container{
                max-width: 100%;
            }
            form .user-details .input-box{
            margin: 10px 0 3px 0;
            width: 100%;
        }
        .container form .user-details{
            max-height: 300px;
            overflow-y: scroll;
        }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="./images/logo.png" alt="">
            <h2>CANARA<span class="danger">HOSTEL</span></h2>
        </div>
        <div class="navbar">
            <a href="student.php">
                <span class="material-icons-sharp"></span>
                <h3>Home</h3>
            </a>
            
        </div>
        <div id="profile-btn" style="display: none;">
            <span class="material-icons-sharp">person</span>
        </div>
    </header>
    <div class="container">
        <div class="title">Registration</div>
            <form method="post" action="account.php" enctype="multipart/form-data">

                <div class = "user-details">
                    <div class="input-box">
                        <span class="details">Profile</span>
                        <label for="profile_image"></label>
                        <input type="hidden" name="current_profile_image" value="<?php echo htmlspecialchars($profile_picture_filename); ?>">
                        <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <label for="username"></label>
                        <input type="text" id="username" name="username" value="<?php echo $username; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">USN</span>
                        <label for="usn"></label>
                        <input type="varchar" id="id" name="id" value="<?php echo $id; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Branch</span>
                        <label for="course"></label>
                         <input type="text" id="course" name="course" value="<?php echo $course; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Contact</span>
                        <label for="contact"></label>
                        <input type="number" id="contact" name="contact" value="<?php echo $contact; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Date Of Birth</span>
                        <label for="dob"></label>
                        <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Email</span>
                        <label for="email"></label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Address</span>
                        <label for="address"></label>
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Semester</span>
                        <label for="sem"></label>
                        <input type="number" id="sem" name="sem" value="<?php echo $sem; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Gender:</span>
                        <label for="gender"></label>
                        <input type="text" id="gender" name="gender" value="<?php echo $gender; ?>">
                    </div>    

                    <!-- <div class="input-box">
                        <span class="details">Address:</span>
                        <label for="address"></label>
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                    </div> -->

                    <div class="input-box">
                        <span class="details">Religion</span>
                        <label for="religion"></label>
                        <input type="text" id="religion" name="religion" value="<?php echo $religion; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Fathers's Name</span>
                        <label for="fname"></label>
                        <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Father's Phone</span>
                        <label for="fphone"></label>
                        <input type="number" id="fphone" name="fphone" value="<?php echo $fphone; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Mother's Name</span>
                        <label for="mname"></label>
                        <input type="text" id="mname" name="mname" value="<?php echo $mname; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Room Number</span>
                        <label for="room"></label>
                        <input type="number" id="room" name="room" value="<?php echo $room; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Intake_Date</span>
                        <label for="intake"></label>
                        <input type="date" id="intake" name="intake" value="<?php echo $intake; ?>">
                    </div>

                    <div class="input-box">
                        <span class="details">Hostel ID</span>
                        <label for="hid"></label>
                        <input type="number" id="hid" name="hid" value="<?php echo $hid; ?>">
                    </div>
                </div>
                <div class="button">
                    <button type="submit" class="btn" >Save</button>
                </div>
            </form>
       </div>
    </div>
 </body>

<script src="../js/app.js"></script>
</html>
          
            
    
