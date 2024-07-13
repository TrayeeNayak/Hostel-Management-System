<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>outpass Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>OUTPASS Dashboard</h2>
    <?php
// Include database connection
include 'connect.php';

// Fetch pending outpass requests
$query = "SELECT * FROM outpass WHERE status = 'pending'";
$result = $con->query($query);

// Check if there are pending requests
if ($result->num_rows > 0) {
    // Display table header
    echo "<table>"; // Opening table tag
    echo "<tr>" .
        "<th>ID</th>" .
        "<th>USN</th>" .
        "<th>Reason</th>" .
        "<th>Departure Date</th>" .
        "<th>Departure Time</th>" .
        "<th>Return Date</th>" .
        "<th>Return Time</th>" .
        "<th>Action</th>" .
        "</tr>"; // Closing table row

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["USN"]."</td>";
        echo "<td>".$row["reason"]."</td>";
        echo "<td>".$row["departure_date"]."</td>";
        echo "<td>".$row["departure_time"]."</td>";
        echo "<td>".$row["return_date"]."</td>";
        echo "<td>".$row["return_time"]."</td>";
        echo "<td><button onclick='acceptRequest(\"".$row["id"]."\")'> Accept </button> <button onclick='rejectRequest(\"".$row["id"]."\")'>Reject</button></td>";

        echo "</tr>";
    }
    echo "</table>"; // Closing table
} else {
    echo "No pending outpass requests";
}

// Close database connection
$con->close();
?>


<script>
    function acceptRequest(id) {
    console.log("Accept button clicked for ID:", id); // Log the outpass ID to the console

    fetch('update_status_and_move_to_requests.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + id
    })
    .then(response => {
        if (response.ok) {
            console.log("Request successful"); // Log success message
            return response.json(); // Parse response body as JSON
        } else {
            console.error("Request failed:", response.statusText); // Log error message
            throw new Error('Error accepting outpass request');
        }
    })
    .then(data => {
        console.log("Response data:", data); // Log the response data to the console
        if (data.success) {
            alert("Outpass request accepted successfully");
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function rejectRequest(id) {
    console.log("Reject button clicked for ID:", id); // Log the outpass ID to the console

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + id
    })
    .then(response => {
        if (response.ok) {
            console.log("Request successful"); // Log success message
            return response.json(); // Parse response body as JSON
        } else {
            console.error("Request failed:", response.statusText); // Log error message
            throw new Error('Error rejecting outpass request');
        }
    })
    .then(data => {
        console.log("Response data:", data); // Log the response data to the console
        if (data.success) {
            alert("Outpass request rejected successfully");
        } else {
            console.error('Error:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


</script>


</body>
</html>
