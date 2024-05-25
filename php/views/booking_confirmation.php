<?php
session_start();
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
?>

<h2>Booking Confirmation</h2>
<p>Your booking has been successfully confirmed!</p>
<p>Booking ID: <?php echo $booking_id; ?></p>

<?php
} else {
    header("Location: booking.php");
    exit();
}
?>

<a href="logout.php">Logout</a>

<?php require_once '../templates/footer.php'; ?>
