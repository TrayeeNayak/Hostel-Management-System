<?php
session_start(); // Start the session

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Fetch username from session

    // Include your database connection script
    include 'connect.php';

    // Prepare and execute the query to fetch user details
    $stmt = $con->prepare("SELECT STAFF_NAME, STAFF_GENDER, STAFF_EMAIL FROM warden WHERE STAFF_NAME = ?");
    $stmt->bind_param("s", $username);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result( $username, $wgender, $wemail);

    // Fetch the values
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Query to get total number of students
    $total_students_query = "SELECT COUNT(*) AS total_students FROM student";
    $total_students_result = $con->query($total_students_query);
    $total_students_row = $total_students_result->fetch_assoc();
    $total_students = $total_students_row['total_students'];

    // Query to get total number of boys
$total_boys_query = "SELECT COUNT(*) AS total_boys FROM student WHERE SGENDER = 'm'";
$total_boys_result = $con->query($total_boys_query);
$total_boys_row = $total_boys_result->fetch_assoc();
$total_boys = $total_boys_row['total_boys'];

// Query to get total number of girls
$total_girls_query = "SELECT COUNT(*) AS total_girls FROM student WHERE SGENDER = 'f'";
$total_girls_result = $con->query($total_girls_query);
$total_girls_row = $total_girls_result->fetch_assoc();
$total_girls = $total_girls_row['total_girls'];


    // Query to get total number of students in a particular hostel ID
    $hostel_id = 1; // Change this to the desired hostel ID
    $students_in_hostel_query = "SELECT COUNT(*) AS students_in_hostel FROM student WHERE HOSTEL_ID= $hostel_id";
    $students_in_hostel_result = $con->query($students_in_hostel_query);
    $students_in_hostel_row = $students_in_hostel_result->fetch_assoc();
    $students_in_hostel = $students_in_hostel_row['students_in_hostel'];


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
    <link rel="shortcut icon" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap');

:root{
    --color-primary: #7380ec;
    --color-danger: #ff7782;
    --color-success: #41f1b6;
    --color-warning: #ffbb55;
    --color-white: #fff;
    --color-info: #7d8da1;
    --color-dark: #363949;
    --color-light: rgba(132, 139, 200, 0.18);
    --color-dark-varient: #677483;
    --color-background: #f6f6f9;
    
    --card-border-radius: 2rem;
    --border-radius-1: 0.4rem;
    --border-radius-2: 1.2rem;

    --card-padding: 1.8rem;
    --box-shadow: 0 2rem 3rem var(--color-light)    
}

.dark-theme{
    --color-background: #181a1e;
    --color-white: #202528;
    --color-dark: #edeffd;
    --color-dark-varient: #a3bdcc;
    --color-light: rgba(0,0,0,0.4);
    --box-shadow: 0 2rem 3rem var(--color-light)
}


*{
    margin:0;
    padding: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}

html{
    font-size: 14px;
    scroll-behavior: smooth;
}
body{
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    background: var(--color-background);
    user-select: none;
    overflow-x: hidden;
    color: var(--color-dark);
}
*{
    color: var(--color-dark);
}
img{
    display: block;
    width: 100%;
}
h1{
    font-weight: 800;
    font-size: 1.8rem;
}
h2{font-size: 1.4rem;}
h3{font-size: .87rem;}
h4{font-size: .8rem;}
h5{font-size: .77rem;}
small{font-size: .75rem;}

.text-muted{color: var(--color-info);}
p{color: var(--color-dark-varient);}
b{color: var(--color-dark);}

.primary{color: var(--color-primary);}
.danger{color: var(--color-danger);}
.success{color: var(--color-success)}
.warning{color: var(--color-warning);}

.container{
    position: relative;
    display: grid;
    width: 93%;
    margin: 0 3rem;
    gap: 1.8rem;
    grid-template-columns: 14rem auto 23rem;
    padding-top: 4rem;
}
header h3{font-weight: 500;} 
header{
    position: fixed;
    width: 100vw;
    z-index: 1000;
    background-color: var(--color-background);
}
header.active{box-shadow: var(--box-shadow);}
header .logo{
    display: flex;
    gap: .8rem;
    margin-right: auto;
}
header .logo img{
    width: 2rem;
    height: 2rem;
}

header,
header .navbar{
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 3rem;
    color: var(--color-info);
}
header .navbar a{
    display: flex;
    margin-left: 2rem;
    gap: 1rem;
    align-items: center;
    justify-content: space-between;
    position: relative;
    height: 3.7rem;
    transition: all 300ms ease;
    padding: 0 2rem;
}
header .navbar a:hover {
    padding-top: 1.5rem;
}
header .navbar a.active{
    background: var(--color-light);
    color: var(--color-primary);
}
header .navbar a.active::before{
    content: "";
    background-color: var(--color-primary);
    position: absolute;
    height: 5px;
    width: 100%;
    left: 0;top: 0;
}
header #profile-btn{
    display: none;
    font-size: 2rem;
    margin: .5rem 2rem 0 0;
    cursor: pointer;
}
header .theme-toggler{
    background: var(--color-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 1.6rem;
    width: 4.2rem;
    cursor: pointer;
    border-radius: var(--border-radius-1);
    margin-right: 2rem;
}
header .theme-toggler span{
    font-size: 1.2rem;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
header .theme-toggler span.active{
    background-color: var(--color-primary);
    color: white;
    border-radius: var(--border-radius-1);
}

/* Profile section  */
aside .profile{
    margin-top: 2rem;
    width: 13rem;
    position: fixed;
}
aside .profile .top{
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 1px solid var(--color-light);
    padding-bottom: 1rem;
}
aside .profile .top:hover .profile-photo{
    scale: 1.05;
}
aside .profile .top .profile-photo{
    width: 6rem;
    height: 6rem;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid var(--color-light);
    transition: all 400ms ease;
}
aside .profile .about p{
    padding-bottom: 1rem;
}
aside .profile .about{
    margin-top: 1rem;
}

/* Home Section  */
main{
    position: relative;
    margin-top: 1.4rem;
}
main .subjects{
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1.6rem;
}

main .subjects > div{
    background-color: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    margin-top: 1rem;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}
main .subjects > div:hover{
    box-shadow: none;
}
main .subjects > div span{
    background-color: var(--color-primary);
    padding: .5rem;
    border-radius: 50%;
    color: var(--color-white);
    font-size: 1.5rem;
}
main .subjects > div.mth span,main .subjects > div.cg span{background: var(--color-danger);}
main .subjects > div.cs span{background: var(--color-success);}

main .subjects h3{
    margin: 1rem 0 0.6rem;
    font-size: 1rem;
}
main .subjects .progress{
    position: relative;
    width: 89px;
    height: 89px;
    border-radius: 50%;
    margin: auto;
}
main .subjects svg circle{
    fill: none;
    stroke: var(--color-primary);
    stroke-width: 8;
    stroke-linecap: round;
    transform: translate(5px, 5px);
    stroke-dasharray: 110;
    stroke-dashoffset: 92;
}
main .subjects .eg svg circle{
    stroke-dashoffset: 25;
    stroke-dasharray: 210;
}
main .subjects .mth svg circle{
    stroke-dashoffset: 7;
    stroke-dasharray: 210;
}
main .subjects .cs svg circle{
    stroke-dashoffset: 35;
    stroke-dasharray: 210;
}
main .subjects .cg svg circle{
    stroke-dashoffset: 0;
    stroke-dasharray: 210;
}
main .subjects .net svg circle{
    stroke-dashoffset: 5;
    stroke-dasharray: 210;
}
main .subjects .progress .number{
    position: absolute;
    top: 0;left: 0;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
main .subjects small{
    margin-top: 1rem;
    display: block;
}
main .timetable{
    margin-top: 2rem;
}
main .timetable h2{
    margin-bottom: .8rem;
}
main .timetable table{
    background-color: var(--color-white);
    width: 100%;
    border-radius: var(--card-border-radius);
    padding: var(--card-padding);
    text-align: center;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}
main .timetable span{display: none;}
main .timetable table:hover{box-shadow: none;}
main table tbody td{
    height: 2.8rem;
    border-bottom: 1px solid var(--color-light);
    color: var(--color-dark-varient);
}
main table tbody tr:last-child td{border: none;}

main .timetable.active{
    width: 100%;
    height: 100vh;
    position: fixed;
    top: 0;left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
main .timetable.active h2{
    color: var(--color-dark);
}
main .timetable.active table{
    width: 90%;
    max-width: 1000px;
    position: relative;
}
main .timetable.active span{
    display: block;
    font-size: 2rem;
    color: var(--color-dark);
    cursor: pointer;
}
.timetable div{
    position: relative;
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
main .timetable.active .closeBtn{
    position: absolute;
    top: 5%;right: 5%;
}


/* Right  */
.right{margin-top: 2.2rem;padding-left: 1.5rem;}

.right .announcements h2{margin-bottom: .8rem;}
.right .announcements .updates{
    background-color: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}
.right .announcements .updates:hover{box-shadow: none;}
.right .announcements .updates .message{
    gap: 1rem;
    line-height: 1.5;
    padding: .5rem 0;
}

/* Teachers on leave  */
.right .leaves{margin-top: 2rem;}
.right .leaves h2{margin-bottom: .8rem;}
.right .leaves .teacher{
    background: var(--color-white);
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: .7rem;
    padding: 1.4rem var(--card-padding);
    border-radius: var(--border-radius-2);
    transition: all 300ms ease;
    box-shadow: var(--box-shadow);
}
.right .profile-photo{
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    overflow: hidden;
}
.right .leaves .teacher:hover{box-shadow: none;}





/* MEDIA QUERIES  */
@media screen and (max-width: 1200px) {
    html{font-size: 12px;}
    .container{
        grid-template-columns: 13rem auto 20rem;
    }
    header{position: fixed;}
    .container{padding-top: 4rem;}
    header .logo h2{display: none;}
    header .navbar h3{display: none;}
    header .navbar a{width: 4.5rem; padding: 0 1rem;}

    main .subjects{
        grid-template-columns: repeat(2, 1fr);
        gap: 1;
    }
    main .timetable{
        width: 150%;
        position: absolute;
        padding: 4rem 0 0 0;
    }
}


@media screen and (max-width: 768px){
    html{font-size: 10px;}
    header{padding: 0 .8rem;}
    .container{width: 100%; grid-template-columns: 1fr;margin: 0;}
    header #profile-btn{display: inline;}
    header .navbar{padding: 0;}
    header .navbar a{margin: 0 .5rem 0 0;}
    header .theme-toggler{margin: 0;}
    aside{
        position: absolute;
        top: 4rem;left: 0;right: 0;
        background-color: var(--color-white);
        padding-left: 2rem;
        transform: translateX(-100%);
        z-index: 10;
        width:18rem;
        height: 100%;
        box-shadow: 1rem 3rem 4rem var(--color-light);
        transition: all 2s ease;
    }
    aside.active{
        transform: translateX(0);
    }
    main{padding: 0 2rem;}
    main .timetable{
        position: relative;
        margin: 3rem 0 0 0;
        width: 100%;
    }
    main .timetable table{
        width: 100%;
        margin: 0;
    }
    .right{
        width: 100%;
        padding: 2rem;
    }
}
</style>
</head>
<body>


    <header>
        <div class="logo" title="University Management System">
            <img src="../images/CEC.jpg" alt="Description">
            <h2>CANARA<span class="danger">HOSTEL</span></h2>
        </div>
        <div class="navbar">
            <a href="../index.html" class="active">
                <span class="material-icons-sharp"></span>
                <h3>Home</h3>
            </a>
          
         
            <a href="../password.html">
                <span class="material-icons-sharp"></span>
                <h3>Change Password</h3>
            </a>
            <a href="info.php">
                <span class="material-icons-sharp"></span>
                <h3>Create Account</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp" onclick=""></span>
                <h3>Logout</h3>
            </a>
        </div>
        <div id="profile-btn">
            <span class="material-icons-sharp">person</span>
        </div>
        <div class="theme-toggler">
            <span class="material-icons-sharp active"></span>
            <span class="material-icons-sharp"></span>
        </div>
        
    </header>
    <div class="container">
        <aside>
            <div class="profile">
                <div class="top">
                    <div class="profile-photo">
                        <img src="../images/profile-1.jpg" alt="Description">
                    </div>
                    <!-- <div class="profile-photo">
                        <img src="../images/profile-1.jpg" alt="Description">
                        <button class="edit-btn" onclick="toggleEditMode()">Edit</button>
                    </div> -->
                    <div class="profile-edit" id="profile-edit">
                        <form method="post" action="dash.php" enctype="multipart/form-data">
                            <!-- <div class="profile-photo">
                                <img src="C:\xampp1\htdocs\harbor-lights-master\Student-Dashboard-main\images\profile-1.jpg" alt="">
                                <input type="file" id="profile-image" accept="image/*">
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="profile-name">Name</label>
                                <input type="text" id="profile-name" name="username">
                            </div> -->
                            <div>
            
                            

                            
                            <script>
                                function toggleEditMode() {
                                    var editForm = document.getElementById("profile-edit");
                                    if (editForm.style.display === "none") {
                                        editForm.style.display = "block";
                                    } else {
                                        editForm.style.display = "none";
                                    }
                                }
                            
                                function saveProfile() {
                                    // Get the updated profile data
                                    var name = document.getElementById("profile-name").value;
                                    // You can get other updated data similarly
                                    
                                    // Here, you can send this data to the server using AJAX or perform any other action to save it
                                    
                                    // For now, let's just log the updated data
                                    console.log("Saving profile...");
                                    console.log("Name: " + name);
                                    // Log other data if needed
                                    
                                    // Hide the edit form after saving
                                    toggleEditMode();
                                }
                            </script>
                            
                        </form>

                    </div>
                    <div class="info">
                        <p>Hey, <b><?php echo $username; ?></b> </p>
                        
                    </div>
                </div>
                </aside>
        <main>
                <div class="about">
                        <p>Email: <?php echo $wemail; ?></p>
                        <p>Gender: <?php echo $wgender; ?></p>
                    <div>
                      <p>Total Students: <?php echo $total_students; ?></p>
                        <p>Total Boys: <?php echo $total_boys; ?></p>
                        <p>Total Girls: <?php echo $total_girls; ?></p>
                         <p>Total Students in Hostel ID <?php echo $hostel_id; ?>: <?php echo $students_in_hostel; ?></p>
                    </div>
                </div>
           </div> 
         
        </main>
    </div>
</div>

    <script src="../js/timeTable.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>



