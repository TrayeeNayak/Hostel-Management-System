<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['id'])) {
    $id = $_SESSION['id']; // Fetch username from session

    // Include your database connection script
    include 'connect.php';

    // Prepare and execute the query to fetch user details
    $stmt = $con->prepare("SELECT STAFF_ID, STAFF_GENDER, STAFF_EMAIL FROM warden WHERE STAFF_ID = ?");
    $stmt->bind_param("s", $id);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($id, $wgender, $wemail);

    // Fetch the values
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Query to get total number of students
    $total_students_query = "SELECT COUNT(*) AS total_students FROM student";
    // echo "total_students_query: $total_students_query<br>";
    $total_students_result = $con->query($total_students_query);

    if (!$total_students_result) {
        // echo "Error in total_students_query: " . $con->error;
    } else {
        $total_students_row = $total_students_result->fetch_assoc();
        $total_students = $total_students_row['total_students'];
    }

    // Query to get total number of boys
    $total_boys_query = "SELECT COUNT(*) AS total_boys FROM student WHERE SGENDER = 'm'";
    // echo "total_boys_query: $total_boys_query<br>";
    $total_boys_result = $con->query($total_boys_query);

    if (!$total_boys_result) {
        echo "Error in total_boys_query: " . $con->error;
    } else {
        $total_boys_row = $total_boys_result->fetch_assoc();
        $total_boys = $total_boys_row['total_boys'];
    }

    // Query to get total number of girls
    $total_girls_query = "SELECT COUNT(*) AS total_girls FROM student WHERE SGENDER = 'f'";
    // echo "total_girls_query: $total_girls_query<br>";
    $total_girls_result = $con->query($total_girls_query);

    if (!$total_girls_result) {
        // echo "Error in total_girls_query: " . $con->error;
    } else {
        $total_girls_row = $total_girls_result->fetch_assoc();
        $total_girls = $total_girls_row['total_girls'];
    }

    // Array to store hostel-wise student count
    $students_in_hostel = array();

    // Loop through each hostel ID to get total number of students
    for ($hostel_id = 1; $hostel_id <= 5; $hostel_id++) {
        $students_in_hostel_query = "SELECT COUNT(*) AS students_in_hostel FROM student WHERE HOSTEL_ID = $hostel_id";
        // echo "students_in_hostel_query for hostel ID $hostel_id: $students_in_hostel_query<br>";
        $students_in_hostel_result = $con->query($students_in_hostel_query);

        if (!$students_in_hostel_result) {
            // echo "Error in students_in_hostel_query for hostel ID $hostel_id: " . $con->error;
        } else {
            $students_in_hostel_row = $students_in_hostel_result->fetch_assoc();
            $students_in_hostel[$hostel_id] = $students_in_hostel_row['students_in_hostel'];
        }
    }

//     echo "Total Students: " . $total_students . "<br>";
// echo "Total Boys: " . $total_boys . "<br>";
// echo "Total Girls: " . $total_girls . "<br>";

foreach ($students_in_hostel as $hostel_id => $count) {
    // echo "Total students in hostel $hostel_id: $count <br>";
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
    <title>Student Dashboard</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
        *{
            margin: 0;
            padding: 0;
            outline: none;
            border: none;
            text-decoration: none;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body{
            background: #dfe9f5;
        }
        .container{
            display: flex;
            

        }
        nav{
            position:relative;
            top: 0;
            bottom: 0;
            height: 100vh;
            left: 0;
            background: #fff;
            width: 320px;
            
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
        }
        .logo{
            text-align: center;
            display: flex;
            margin: 10px 0 0 10px;
        }
        .logo img{
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
        .logo span{
            font-weight:bold;
            padding-left: 15px;
            font-size: 18px;
            text-transform: uppercase;
        }
        a{
            position: relative;
            color: rgba(85, 83, 83);
            font-size: 14px;
            display: table;
            width: 280px;
            padding: 10px;
        }
        nav .fas{
            position: relative;
            width: 70px;
            height: 40px;
            top: 14px;
            font-size:20px;
            text-align: center;
        }
        .nav-item{
            position: relative;
            top: 12px;
            margin-left: 10px;
        }
        a:hover{
            background: #eee;
        }
        .logout{
            position: absolute;
            bottom: 0;
        }
        
        /* main section */
        .main{
            position: relative;
            padding: 30px;
            width: 100%;
            
            
        }
        .main-top{
            display: flex;
            width: 100%;
        }
        .main-top i{
            position: absolute;
            right: 0;
            margin: 10px 30px;
            color: rgb(11,109,109);
            cursor: pointer;
        }
        .main-skills {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}

.main-skills .card {
    flex-basis: calc(20% - 40px); /* Set the initial width for each card */
    max-width: calc(20% - 40px); /* Set the maximum width for each card */
    margin: 20px;
    background: #fff;
    text-align: center;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
}

        .main-skills .card h3{
            margin: 10px;
            text-transform: capitalize;
        }
        .main-skills .card p{
            font-size:16px;
        }
        .main-skills .card i{
            font-size:22px;
            padding: 20px;
        }


    </style>
</head>

<body>
    <div class = "container">
        <nav>
            <ul>
                <li><a href="#" class = "logo">
                    <img src="../images/CEC.jpg" alt="">
                    <span class ="nav-item">Dashboard</span>
                </a></li>
                <li><a href="../index.html">
                    <i class = "fas fa-home"></i>
                    <span class="nav-item">HOME</span>
                </a></li>
                <li><a href="./boys.php">
                    <i class = "fas fa-user"></i>
                    <span class="nav-item">STUDENT DETAILS</span>
                </a></li>
                <li><a href="outpass_request.php">
                    <i class = "fas fa-out"></i>
                    <span class="nav-item">OUTPASS</span>
                </a></li>
                <li><a href="allot.php">
                    <i class = "fas fa-sign-out-alt"></i>
                    <span class="nav-item">Room-Allot</span>
                </a></li>
            </ul>
        </nav>
        <section class="main">
            <div class="main-top">
                
                <i class="fas fa-user-cog"></i>
            </div>
            <div class="main-skills">
                <div class="card">
                <h3>Total students</h3>
                    <i class="fas fa-laptop-code"></i>
                    <p><?php echo $total_students; ?></p>
                </div>
                <div class="card">
                <h3>Female Students</h3>
                    <i class="fas fa-female"></i>
                    <p><?php echo $total_girls; ?></p>
                </div>
                <div class="card">
                    <h3>Male Students</h3>
                    <i class="fas fa-female"></i>
                    <p><?php echo $total_boys; ?></p>
                </div>
                <?php foreach ($students_in_hostel as $hostel_id => $count) { ?>
                <div class="card">
                    <h3>Students in Hostel <?php echo $hostel_id; ?></h3>
                    <i class="fas fa-users"></i>
                    <p><?php echo $count; ?></p>
                </div>
            <?php } ?>
                
            </div>
            
        </section>
    </div>
 </body>
</html>
                