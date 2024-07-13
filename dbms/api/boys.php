<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Male Student Information</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins" , sans-serif;
        }
        .content-tables{
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9en;
            min-width: 400px;
            margin-top: 100px;
        }
        .content-tables thead tr{
            background-color:#009879;
            color:#fff;
            text-align: left;
             font-weight: bold;
        }
        .content-tables th,
        .content-tables td{
            padding: 12px 15px;
            border: 1px solid #dddd;
        }
        .content-tables tbody tr{
            border-bottom: 1px solid #dddd;
        }
        .content-tables tbody tr: nth-of-type(even){
            background-color: #f2f2f2;
        }
        .content-tables tbody tr:last-of-type{
            border-bottom: 2px solid #009879;
        }
        .content-tables tbody tr.active-row{
            font-weight: bold;
            color: #009879;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            display: none;
        }

        .editing input[type="text"], .editing input[type="email"], .editing input[type="date"] {
            display: inline-block;
        }
        
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 100px;
    /* Remove background color */
    background: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
    /* Add transition effect */
    transition: background-color 0.3s;
    /* Add additional styles to ensure content is visible */
    backdrop-filter: blur(10px); /* Apply blur effect to the content behind the header */
    -webkit-backdrop-filter: blur(10px); /* For Safari */
}


.navbar{
    position:fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 100px;
    background: #009879;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
}
.navbar a{
    position: relative;
    font-size: 14px;
    color: #fff;
    font-weight:500;
    text-decoration: none;
    margin-left: 40px;
}
.navbar a::before{
    content:'';
    position: absolute;
    top: 100%;
    left: 0;
    width: 0;
    height: 2px;
    background: #fff;
    transition: 0.3s;
}
.navbar a:hover::before{
    width: 100%;

}

    </style>
</head>
<body>
<header class="header">
        <!-- <div class="logo" title="University Management System">
            <img src="../images/CEC.jpg" alt="Description">
            <h2>CANARA<span class="danger">HOSTEL</span></h2>
        </div> -->
        <div class="navbar">
            <a href="./bwarden.php" class="active">
                <span class="material-icons-sharp"></span>
                <h3>Home</h3>
            </a>
          
         
            <!-- <a href="../password.html">
                <span class="material-icons-sharp"></span>
                <h3>Change Password</h3>
            </a>
            <a href="account.php">
                <span class="material-icons-sharp"></span>
                <h3>Create Account</h3>
            </a> -->
            <!-- <a href="#">
                <span class="material-icons-sharp" onclick=""></span>
                <h3>Logout</h3>
            </a> -->
        </div>
        <div id="profile-btn">
            <span class="material-icons-sharp"></span>
        </div>
    </header>

<table class="content-tables">
    <thead>
        <tr>
            <th>Name</th>
            <th>USN</th>
            <th>Branch</th>
            <th>Email</th>
            <th>Address</th>
            <th>Room</th>
            <th>Phone</th>
            <th>Semester</th>
            <th>Gender</th>
            <th>Father's Name</th>
            <th>Father's Phone</th>
            <th>Intake Date</th>
            <th>Hostel ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr class="active-row">
        <?php
        // Include your database connection script
        include 'connect.php';

        // Prepare and execute the query to fetch male student details
        $sql = "SELECT * FROM student WHERE SGENDER = 'm'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each male student
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><span class='text'>".$row["SNAME"]."</span><input type='text' name='name' value='".$row["SNAME"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["USN"]."</span><input type='text' name='usn' value='".$row["USN"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SBRANCH"]."</span><input type='text' name='branch' value='".$row["SBRANCH"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SEMAIL"]."</span><input type='email' name='email' value='".$row["SEMAIL"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SADDRESS"]."</span><input type='text' name='address' value='".$row["SADDRESS"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SROOM"]."</span><input type='text' name='room' value='".$row["SROOM"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SPHONE"]."</span><input type='text' name='phone' value='".$row["SPHONE"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SSEM"]."</span><input type='text' name='semester' value='".$row["SSEM"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["SGENDER"]."</span><input type='text' name='gender' value='".$row["SGENDER"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["FNAME"]."</span><input type='text' name='father_name' value='".$row["FNAME"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["FPHONE"]."</span><input type='text' name='father_phone' value='".$row["FPHONE"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["INTAKE_DATE"]."</span><input type='date' name='intake_date' value='".$row["INTAKE_DATE"]."' class='editing'></td>";
                echo "<td><span class='text'>".$row["HOSTEL_ID"]."</span><input type='text' name='hostel_id' value='".$row["HOSTEL_ID"]."' class='editing'></td>";
                echo "<td><button onclick='editRow(this)'>Edit</button>
                          <button onclick='saveRow(this)'>Save</button>
                          <button onclick='deleteRow(this)'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='13'>No male students found</td></tr>";
        }
        $con->close();
        ?>
        </tr>
    </tbody>
</table>

<script>
    function editRow(button) {
        var row = button.parentNode.parentNode;
        var inputs = row.querySelectorAll('input.editing');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].style.display = 'inline-block';
            row.cells[i].querySelector('.text').style.display = 'none';
        }
        button.style.display = 'none';
        button.parentNode.querySelector('button:last-of-type').style.display = 'inline-block';
        row.classList.add('editing');
    }

    function saveRow(button) {
    var row = button.parentNode.parentNode;
    var inputs = row.querySelectorAll('input.editing');
    var formData = new FormData();  // Create a new FormData object
    for (var i = 0; i < inputs.length; i++) {
        formData.append(inputs[i].name, inputs[i].value);  // Append each input field and its value to the FormData object
    }

    // Perform AJAX request to update the database with the FormData object
    fetch('update_student.php', {
        method: 'POST',
        body: formData,  // Send the FormData object instead of JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update row cells with new values
            for (var i = 0; i < inputs.length; i++) {
                var textSpan = row.cells[i].querySelector('.text');
                textSpan.innerText = inputs[i].value;
                inputs[i].style.display = 'none';
                textSpan.style.display = 'inline-block'; // Show the span containing the text
            }
            button.style.display = 'none';
            button.parentNode.querySelector('button:first-of-type').style.display = 'inline-block';
            row.classList.remove('editing');
        } else {
            alert('Failed to save data');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


function deleteRow(button) {
    var row = button.parentNode.parentNode;
    var usn = row.cells[1].querySelector('.text').innerText; // Assuming USN is in the second cell
    console.log('Deleting student with USN:', usn); // Log the USN value to console
    // Perform AJAX request to delete the row from the database
    fetch('delete.php?id=' + usn, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            row.remove();
        } else {
            alert('Failed to delete row');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
</script>



</body>
</html>
