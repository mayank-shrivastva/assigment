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
            $title = $_POST['title'];
            $date = $_POST['date'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $available = $_POST['available'];
             
            $venue = $_POST['venue']; // Ensure that venue is properly retrieved
            $price = $_POST['price'];
        
            $sql = "UPDATE `event-information` SET `Title`=?, `date`=?, `start-time`=?, `End-time`=?, `available`=?,  `venue`=?, `Price`=? WHERE `id`=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssisii", $title, $date, $start_time, $end_time, $available, $venue, $price, $id);
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

            $sql = "DELETE FROM `event-information` WHERE `id`=?";
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
        $title = $_POST['title'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $available = $_POST['available'];
        $venue = $_POST['venue'];
        $price = $_POST['price'];

        $sql = "INSERT INTO `event-information` (`Title`, `date`, `start-time`, `End-time`, `available`,   `venue`, `Price`) VALUES (?, ?, ?, ?, ?,  ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $title, $date, $start_time, $end_time, $available, $venue, $price);
        
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch data
$query = "SELECT * FROM `event-information`";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
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
    <h1>Event Management System</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Available</th>
            
            <th>Venue</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"]. "</td>";
                echo "<td>" . $row["Title"]. "</td>";
                echo "<td>" . $row["date"]. "</td>";
                echo "<td>" . $row["start-time"]. "</td>";
                echo "<td>" . $row["End-time"]. "</td>";
                echo "<td>" . $row["available"]. "</td>";
                
                echo "<td>" . $row["venue"]. "</td>";
                echo "<td>" . $row["Price"]. "</td>";
                echo "<td>";
                echo "<button onclick='openEditForm(" . $row["id"] . ", \"" . $row["Title"] . "\", \"" . $row["date"] . "\", \"" . $row["start-time"] . "\", \"" . $row["End-time"] . "\", \"" . $row["available"] . "\", \"" . $row["venue"] . "\", \"" . $row["Price"] . "\")'>Edit</button>";
                echo "<form id='editForm_" . $row["id"] . "' method='post' action='".$_SERVER["PHP_SELF"]."' style='display: none;'>";
                echo "<input type='hidden' name='id' value='".$row["id"]."'>";
                echo "<input type='hidden' name='operation' value='update'>";
                echo "<input type='text' name='title' value='".$row["Title"]."'>";
                echo "<input type='text' name='date' value='".$row["date"]."'>";
                echo "<input type='text' name='start_time' value='".$row["start-time"]."'>";
                echo "<input type='text' name='end_time' value='".$row["End-time"]."'>";
                echo "<input type='text' name='available' value='".$row["available"]."'>";
                echo "<input type='text' name='venue' value='".$row["venue"]."'>";
                echo "<input type='text' name='price' value='".$row["Price"]."'>";
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
            echo "<tr><td colspan='10'>No results</td></tr>";
        }
        ?>
    </table>

    <h2>Add New Event</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title"><br><br>
    <label for="date">Date:</label>
    <input type="date" name="date" id="date"><br><br>
    <label for="start_time">Start Time:</label>
    <input type="time" name="start_time" id="start_time"><br><br>
    <label for="end_time">End Time:</label>
    <input type="time" name="end_time" id="end_time"><br><br>
    <label for="available">Available:</label>
    <input type="text" name="available" id="available"><br><br>
    <label for="venue">Venue:</label>
    <input type="text" name="venue" id="venue"><br><br>
    <label for="price">Price:</label>
    <input type="text" name="price" id="price"><br><br>
    <input type="submit" name="create" value="Create">
</form>

</div>

<script>
    function openEditForm(id, title, date, start_time, end_time, available,  venue, price) {
        var form = document.getElementById('editForm_' + id);
        if (form.style.display === 'none') {
            // Set the values in the form fields
            form.querySelector('input[name="title"]').value = title;
            form.querySelector('input[name="date"]').value = date;
            form.querySelector('input[name="start_time"]').value = start_time;
            form.querySelector('input[name="end_time"]').value = end_time;
            form.querySelector('input[name="available"]').value = available;
             
            form.querySelector('input[name="venue"]').value = venue;
            form.querySelector('input[name="price"]').value = price;
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
