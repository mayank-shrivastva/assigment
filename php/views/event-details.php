<?php
session_start();
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

require_once '../templates/header.php';
require_once '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid event ID.</p>";
    require_once '../templates/footer.php';
    exit();
}

$eventId = intval($_GET['id']);

$sql = "SELECT * FROM `event-information` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    ?>
    <div class='container'>
        <div class='event-details'>
        <a href="logout.php" class="logout-btn">Logout</a>
            <h2><?php echo htmlspecialchars($event["Title"]); ?></h2>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($event["date"]); ?></p>
            <p><strong>Start Time:</strong> <?php echo htmlspecialchars($event["start-time"]); ?></p>
            <p><strong>End Time:</strong> <?php echo htmlspecialchars($event["End-time"]); ?></p>
            <p><strong>Available:</strong> <?php echo htmlspecialchars($event["available"]); ?></p>
            <p><strong>Venue:</strong> <?php echo htmlspecialchars($event["venue"]); ?></p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($event["Price"]); ?></p>
            <a href='booking.php?id=<?php echo $event['id']; ?>' class='btn'>Book Now</a>
        </div>
    </div>
    <?php
} else {
    echo "<p>Event not found.</p>";
}

$stmt->close();
$conn->close();
?>



<?php require_once '../templates/footer.php'; ?>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 600px;
    }

    .event-details {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
    }

    .event-details h2 {
        color: #333;
    }

    .event-details p {
        color: #666;
        margin-bottom: 10px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .logout-btn {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .logout-btn:hover {
        color: #0056b3;
    }
</style>
