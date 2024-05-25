<?php
session_start();
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tickets = $_POST['tickets'];

    if (!is_numeric($event_id)) {
        header("Location: booking.php?id=$event_id&error=invalid_event");
        exit();
    }

    $booking_id = uniqid();

    $sql = "INSERT INTO bookings (event_id, name, email, tickets, booking_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issis", $event_id, $name, $email, $tickets, $booking_id);

    if ($stmt->execute()) {
        header("Location: booking_confirmation.php?booking_id=$booking_id");
        exit();
    } else {
        echo "Booking failed. Please try again.";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: booking.php");
    exit();
}
?>
