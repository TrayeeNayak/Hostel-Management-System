<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['id'])) {
    $id = $_SESSION['id']; // Fetch username from session

    // Include your database connection script
    include 'connect.php';

    // Prepare and execute the query to fetch outpass details
    $query = "SELECT * FROM outpass WHERE USN IN (SELECT USN FROM student WHERE USN = '$id')";
    $result = $con->query($query);

    // Check if there are any errors in the query execution
    if(!$result) {
        echo "Error: " . $con->error;
    } else {
        // Check if there are any outpass records for the student
        if($result->num_rows > 0) {
            $outpass_details = array();
            while($row = $result->fetch_assoc()) {
                $outpass_details[] = $row;
            }
        } else {
            // echo "No outpass records found for the student.";
        }
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
            overflow:hidden;
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
        .main {
    position: relative;
    padding: 30px;
    width: 100%;
}

.main-top {
    display: flex;
    width: 100%;
}

.main-top i {
    position: absolute;
    right: 0;
    margin: 10px 30px;
    color: rgb(11,109,109);
    cursor: pointer;
}

.main-table {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}
.main-table .content-tables {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9en;
    min-width: 400px;
    margin-top: 100px;
}
.center-heading {
    text-align: center;
}

.content-tables thead tr {
    background-color: #009879;
    color: #fff;
    text-align: left;
    font-weight: bold;
}

.content-tables th,
.content-tables td {
    padding: 12px 15px;
    border: 1px solid #fff; /* Add border to all four sides */
}

.content-tables tbody tr {
    border-bottom: 1px solid #dddd;
}

.content-tables tbody tr:nth-of-type(even) {
    background-color: #f2f2f2;
}

.content-tables tbody tr:last-child {
    border-bottom: 2px solid #fff; /* Only border-bottom for the last row */
}

.content-tables tbody tr.active-row {
    font-weight: bold;
    color: #009879;
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
                <li><a href="profile.php">
                    <i class = "fas fa-user"></i>
                    <span class="nav-item">Profile</span>
                </a></li>
                <li><a href="account.php">
                    <i class = "fas fa-home"></i>
                    <span class="nav-item">Update Account</span>
                </a></li>
                <li><a href="outpass.php">
                    <i class = "fas fa-out"></i>
                    <span class="nav-item">OUTPASS</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class = "fas fa-sign-out-alt"></i>
                    <span class="nav-item">LOGOUT</span>
                </a></li> -->
            </ul>
        </nav>
    <section class="main">
        <div class="main-top">
            <i class = "fas fa-user-cog"></i>
        </div>
        <div class = "main-table">
        <h2 class="center-heading">Outpass Details</h2>
           <?php if(!empty($outpass_details)): ?>
           <table class="content-tables">
        <tr>
            <th>ID</th>
            <th>Reason</th>
            <th>Departure Date</th>
            <th>Departure Time</th>
            <th>Return Date</th>
            <th>Return Time</th>
            <th>Status</th>
        </tr>
        <?php foreach($outpass_details as $outpass): ?>
        <tr>
            <td><?php echo $outpass['id']; ?></td>
            <td><?php echo $outpass['reason']; ?></td>
            <td><?php echo $outpass['departure_date']; ?></td>
            <td><?php echo $outpass['departure_time']; ?></td>
            <td><?php echo $outpass['return_date']; ?></td>
            <td><?php echo $outpass['return_time']; ?></td>
            <td><?php echo $outpass['status']; ?></td>
        </tr>
        <?php endforeach; ?>

    </table>
    <?php else: ?>
    <p>No outpass records found for the student.</p>
    <?php endif; ?>
    </div>
    </section>
    </div>

    </body>
    </html>
