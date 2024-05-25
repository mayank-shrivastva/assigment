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

    $sql = "SELECT SUM(tickets) AS total_tickets FROM bookings WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $bookingResult = $stmt->get_result();
    $bookingData = $bookingResult->fetch_assoc();
    $totalBookedTickets = $bookingData['total_tickets'];
    $availableTickets = $event['available'] - $totalBookedTickets;

    if ($availableTickets > 0) {
?>
        <div class="booking-container">
        <a href="logout.php" class="logout-btn">Logout</a>
            <h2>Book Tickets for <?php echo htmlspecialchars($event["Title"]); ?></h2>
            <p><strong>Total Available Tickets:</strong> <?php echo $availableTickets; ?></p>
            <form action="confirm_booking.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                <label for="name">Your Name:</label><br>
                <input type="text" id="name" name="name" required><br><br>
                <label for="email">Your Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                <label for="tickets">Number of Tickets (maximum <?php echo min(5, $availableTickets); ?>):</label><br>
                <input type="number" id="tickets" name="tickets" min="1" max="<?php echo min(5, $availableTickets); ?>" required><br><br>
                <input type="submit" value="Book Tickets" class="btn">
            </form>
        </div>
    <?php
    } else {
        echo "<p>Sorry, all tickets for this event have been booked.</p>";
    }
} else {
    echo "<p>Event not found.</p>";
}

$stmt->close();
$conn->close();
?>



<?php require_once '../templates/footer.php'; ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .booking-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 90%;
        max-width: 400px;
        text-align: center;
    }

    h2 {
        margin-top: 0;
        color: #333;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="submit"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #007BFF;
        color: white;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .logout-btn {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
    }
</style>
