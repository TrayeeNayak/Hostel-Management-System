<!DOCTYPE html>
<html>
<head>
    <title>Hostel Room Occupancy</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Hostel Room Occupancy</h2>

<?php
 include 'connect.php';
// Sample data of rooms in 5 hostels
$hostels = array(
    array("hostel_id" => 1, "room_type" => "Single", "total_rooms" => 10, "occupied_rooms" => 5),
    array("hostel_id" => 2, "room_type" => "Double", "total_rooms" => 15, "occupied_rooms" => 8),
    array("hostel_id" => 3, "room_type" => "Triple", "total_rooms" => 20, "occupied_rooms" => 15),
    array("hostel_id" => 4, "room_type" => "Single", "total_rooms" => 12, "occupied_rooms" => 10),
    array("hostel_id" => 5, "room_type" => "Double", "total_rooms" => 18, "occupied_rooms" => 12)
);

// Displaying the table
echo "<table>";
echo "<tr><th>Hostel ID</th><th>Room Type</th><th>Total Rooms</th><th>Occupied Rooms</th><th>Status</th><th>Action</th></tr>";
foreach ($hostels as $hostel) {
    echo "<tr>";
    echo "<td>" . $hostel['hostel_id'] . "</td>";
    echo "<td>" . $hostel['room_type'] . "</td>";
    echo "<td>" . $hostel['total_rooms'] . "</td>";
    echo "<td>" . $hostel['occupied_rooms'] . "</td>";
    if ($hostel['occupied_rooms'] < $hostel['total_rooms']) {
        echo "<td>Empty</td>";
        echo "<td><a href='allot_room.php?hostel_id=" . $hostel['hostel_id'] . "&room_type=" . $hostel['room_type'] . "'>Allot Room</a></td>";
    } else {
        echo "<td>Full</td>";
        echo "<td>Room Full</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

</body>
</html>
