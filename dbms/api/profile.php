<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['id'])) {
    $id = $_SESSION['id']; // Fetch username from session

    // Include your database connection script
    include 'connect.php';

    // Prepare and execute the query to fetch user details
    $stmt = $con->prepare("SELECT SBRANCH, DOB, SEMAIL, SADDRESS, USN, SNAME, SROOM, SPHONE, SSEM, SGENDER, FNAME, FPHONE, MNAME, SRELIGION, INTAKE_DATE, PROFILE FROM student WHERE USN = ?");
    $stmt->bind_param("s", $id);
    // Execute the prepared statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($sbranch, $dob, $semail, $saddress, $usn, $sname, $sroom, $sphone, $ssem, $sgender, $fname, $fphone, $mname, $sreligion, $intake_date, $profile_picture_filename);

    // Fetch the values
    $stmt->fetch();

    // Close the statement
    $stmt->close();

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
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="shortcut icon" href="./images/logo.png">
    <link rel="stylesheet" href="style.css">

    <style>
        body{
            margin-top:20px;
            background-color:lightgray;
            padding 0;
            margin: 0;
            font-family: 'Lato', sans-serif;
            color: black;

        }
        .main{
            padding: 15px;
            font-family: Arial,Helvetica, sans-serif;
        }
        .topbar{
            background-color:teal;
            overflow:hidden;
        }
        .topbar a{
            float: right;
            color:whitesmoke;
            text-align: center;
            padding: 20px 26px;
            text-decoration: none;
            font-size:26px;
        }
        .container{
            display: flex;
        }
        .student-profile .card{
            border-radius: 10px;
        }
        .student-profile .card .card-header .profile_img{
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 10px auto;
            border: 10px solid #ccc;
            border-radius: 50%;

        }
        .student-profile .card h3{
            font-size: 20px;
            font-weight: 700;
        }
        .student-profile .card p{
            font-size: 16px;
            color: #000;
        }
        .table table-bordered{
            width: 80px;
            margin-left: 20px;
            padding: 20px;
        }
        

        
        
    </style>
</head>
<body>
<div class = "topbar">
     <a href="student.php">Home</a>
    <!-- <a href="logout.php">Logout</a> -->
</div>
    <div class = "student-profile py-4">
        <div class= "container">
            <div class="row">
                <div class = "col-lg-4">
                    <div class = "card shadow-sm">
                        <div class ="card-header bg-transparent text-center">
                           <?php if (!empty($profile_picture_filename)): ?>
                           <img src="./upload/<?php echo $profile_picture_filename; ?>" class= "profile_img" width="150" alt="Profile Picture"><?php endif; ?>
                            <div class = "mt-3">
                               <h3><?php echo $sname; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                        <div class = "col-lg-8">
                            <div class= "card-shadow-sm">
                                <div class = "card-header bg-transparent border-0">
                                    <h3 class="mb-0"><i class="fa-sharp fa-solid fa-clone"></i>General Information</h3>
                                </div>
                                <div class="card-body pt-0">
                                    <table class="table table-bordered">
                                        <tr>
                                           <th width="40%">USN</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $usn; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="40%">Email</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $semail; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Branch</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $sbranch; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Semester</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $ssem; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Contact</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $sphone; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="50%">Date Of Birth</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $dob; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Gender</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $sgender; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Address</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $saddress; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Religion</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $sreligion; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Father's Name</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $fname; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Father's Phone</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $fphone; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Mother's Name</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $mname; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Room</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $sroom; ?></td>
                                        </tr>
                                        <tr>
                                           <th width="30%">Intake Date</th>
                                           <td width = "2%">:</td>
                                           <td><?php echo $intake_date; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                           </div>
            
        </div>
    
    </body>
</html>    

<!-- <div class="about">

    <main>
    <p>USN: <?php echo $usn; ?></p>
    <p>Course: <?php echo $sbranch; ?></p>
    <p>Contact: <?php echo $sphone; ?></p>
    <p>Date of Birth: <?php echo $dob; ?></p>
    <p>Email: <?php echo $semail; ?></p>
    <p>Semester: <?php echo $ssem; ?></p>
    <p>Gender: <?php echo $sgender; ?></p>
    <p>Address: <?php echo $saddress; ?></p>
    <p>Religion: <?php echo $sreligion; ?></p>
    <p>Father's Name: <?php echo $fname; ?></p>
    <p>Father's Phone: <?php echo $fphone; ?></p>
    <p>Mother's Name: <?php echo $mname; ?></p>
    <p>Room: <?php echo $sroom; ?></p>
    <p>Intake Date: <?php echo $intake_date; ?></p>
     
</main>
</div>
</div>  -->
         