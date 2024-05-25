<?php
require_once '../includes/db.php';

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['operation'])) {
        // Update operation
        if ($_POST['operation'] === "update") {
            $id = $_POST['id'];
            $event_id = $_POST['event_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $tickets = $_POST['tickets'];
            $booking_id = $_POST['booking_id'];
            $booking_time = $_POST['booking_time'];

            $sql = "UPDATE `bookings` SET `event_id`=?, `name`=?, `email`=?, `tickets`=?, `booking_id`=?, `booking_time`=? WHERE `id`=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssisi", $event_id, $name, $email, $tickets, $booking_id, $booking_time, $id);
            if ($stmt->execute()) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            $stmt->close();
        }
        
        // Delete operation
        elseif ($_POST['operation'] === "delete") {
            $id = $_POST['id'];

            $sql = "DELETE FROM `bookings` WHERE `id`=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            $stmt->close();
        }
    }
    // Create operation
    elseif (isset($_POST['create'])) {
        $event_id = $_POST['event_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $tickets = $_POST['tickets'];
        $booking_id = $_POST['booking_id'];
        $booking_time = $_POST['booking_time'];

        $sql = "INSERT INTO `bookings` (`event_id`, `name`, `email`, `tickets`, `booking_id`, `booking_time`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssis", $event_id, $name, $email, $tickets, $booking_id, $booking_time);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch data
$query = "SELECT `id`, `event_id`, `name`, `email`, `tickets`, `booking_id`, `booking_time` FROM `bookings`";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management System</title>
   
    <style>
        header {
            background-color: #333;
            color: #fff;
            padding: 67px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            display: inline-block; /* Ensure title and buttons are on the same line */
        }

        .top-buttons {
            float: right;
        }

        .top-buttons button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .top-buttons button:hover {
            background-color: #45a049;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
        }

        form input[type="text"] {
            width: calc(100% - 10px);
            padding: 5px;
            margin-bottom: 10px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<header>
        <h1>Welcome admin</h1>
        <div class="top-buttons">
            <button onclick="location.href='user-display.php'">User Infomation</button>
            <button onclick="location.href='booking-info.php'">Booking information</button>
            <button onclick="location.href='eventinfo.php'">Event information</button>
            <button onclick="location.href='logout.php'">Logout</button>

            
        </div>
    </header><br><br>
<div class="container">
    <h1>Booking Management System</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Event ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Tickets</th>
            <th>Booking ID</th>
            <th>Booking Time</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"]. "</td>";
                echo "<td>" . $row["event_id"]. "</td>";
                echo "<td>" . $row["name"]. "</td>";
                echo "<td>" . $row["email"]. "</td>";
                echo "<td>" . $row["tickets"]. "</td>";
                echo "<td>" . $row["booking_id"]. "</td>";
                echo "<td>" . $row["booking_time"]. "</td>";
                echo "<td>";
                echo "<button onclick='openEditForm(" . $row["id"] . ", \"" . $row["event_id"] . "\", \"" . $row["name"] . "\", \"" . $row["email"] . "\", \"" . $row["tickets"] . "\", \"" . $row["booking_id"] . "\", \"" . $row["booking_time"] . "\")'>Edit</button>";
                echo "<form id='editForm_" . $row["id"] . "' method='post' action='".$_SERVER["PHP_SELF"]."' style='display: none;'>";
                echo "<input type='hidden' name='id' value='".$row["id"]."'>";
                echo "<input type='hidden' name='operation' value='update'>";
                echo "<input type='text' name='event_id' value='".$row["event_id"]."'>";
                echo "<input type='text' name='name' value='".$row["name"]."'>";
                echo "<input type='text' name='email' value='".$row["email"]."'>";
                echo "<input type='text' name='tickets' value='".$row["tickets"]."'>";
                echo "<input type='text' name='booking_id' value='".$row["booking_id"]."'>";
                echo "<input type='text' name='booking_time' value='".$row["booking_time"]."'>";
                echo "<input type='submit' value='Update'>";
                echo "</form>";
                echo "<form method='post' action='".$_SERVER["PHP_SELF"]."'>";
                echo "<input type='hidden' name='id' value='".$row["id"]."'>";
                echo "<input type='hidden' name='operation' value='delete'>";
                echo "<input type='submit' value='Delete'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No results</td></tr>";
        }
        ?>
    </table>

    <h2>Add New Booking</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="event_id">Event ID:</label>
        <input type="text" name="event_id" id="event_id"><br><br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name"><br><br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"><br><br>
        <label for="tickets">Tickets:</label>
        <input type="text" name="tickets" id="tickets"><br><br>
        <label for="booking_id">Booking ID:</label>
        <input type="text" name="booking_id" id="booking_id"><br><br>
        <label for="booking_time">Booking Time:</label>
        <input type="date" name="booking_time" id="booking_time"><br><br>
        <input type="submit" name="create" value="Create">
    </form>
</div>

<script>
    function openEditForm(id, event_id, name, email, tickets, booking_id, booking_time) {
        var form = document.getElementById('editForm_' + id);
        if (form.style.display === 'none') {
            // Set the values in the form fields
            form.querySelector('input[name="event_id"]').value = event_id;
            form.querySelector('input[name="name"]').value = name;
            form.querySelector('input[name="email"]').value = email;
            form.querySelector('input[name="tickets"]').value = tickets;
            form.querySelector('input[name="booking_id"]').value = booking_id;
            form.querySelector('input[name="booking_time"]').value = booking_time;
            // Show the form
            form.style.display = 'block';
        } else {
            // Hide the form if already open
            form.style.display = 'none';
        }
    }
</script>
</body>
</html>
