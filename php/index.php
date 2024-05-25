<?php
session_start();
require_once 'includes/functions.php';

 

require_once 'templates/header.php';
require_once 'includes/db.php';  

// Fetch all event information
$sql = "SELECT * FROM `event-information`";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  <nav>
    <div class="nav-container">
        <div class="logo">Logo</div>
        <div class="menu-toggle">&#9776;</div>
        <ul id="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#recent-events">Recent Events</a></li>
            <li><a href="#how-to-buy">How to Buy</a></li>
            <li><a href="views/login.php">Login</a></li>
             
        </ul>
    </div>
  </nav>
  <div class="hero-image">
    <div class="hero-content">
        <h1>Welcome to Our Website</h1>
    </div>
  </div>

  <h1 class="center"><u>Recent event</u></h1> 
  <div class="mk">
    <div id="event-container">
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo "<div class='event-card'>";
              echo "<h3>" . htmlspecialchars($row["Title"]) . "</h3>";
              echo "<p><strong>Date:</strong> " . htmlspecialchars($row["date"]) . "</p>";
              echo "<p><strong>Time:</strong> " . htmlspecialchars($row["start-time"]) . " - " . htmlspecialchars($row["End-time"]) . "</p>";
              echo "<p><strong>Available:</strong> " . htmlspecialchars($row["available"]) . "</p>";
              
              echo "<p><strong>Venue:</strong> " . htmlspecialchars($row["venue"]) . "</p>";
              echo "<p><strong>Price:</strong> $" . htmlspecialchars($row["Price"]) . "</p>";
              
              echo "</div>";
          }
      } else {
          echo "<p>No events found.</p>";
      }
      ?>
    </div>
  </div>

  <div id="popup" class="popup">
    <div class="popup-content">
      <span class="close">&times;</span>
      <h2>Event Details</h2>
      <p id="popup-event-details"></p>
      <button id="popup-checkoutButton">Checkout</button>
    </div>
  </div>
  <div class="how-to-buy" id="how-to-buy">
    <h2>How to Buy a Ticket</h2>
    <div class="steps">
        <div class="step"><p><strong>Step 1:</strong> Visit our website and navigate to the 'Tickets' section.</p></div>
        <div class="step"><p><strong>Step 2:</strong> Select the event you want to attend and click 'Buy Ticket'.</p></div>
        <div class="step"><p><strong>Step 3:</strong> Check the available ticket.</p></div>
        <div class="step"><p><strong>Step 4:</strong> Make the payment through our secure payment gateway.</p></div>
        <div class="step"><p><strong>Step 5:</strong> Receive a confirmation email with your ticket.</p></div>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 Mayank Kumar Shrivastva. All rights reserved.</p>
  </footer>

  <script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        document.querySelector('nav ul').classList.toggle('active');
    });

    document.addEventListener('DOMContentLoaded', () => {
        const token = localStorage.getItem('token');
        const loginLink = document.getElementById('login-link');
        const signupLink = document.getElementById('signup-link');
        const logoutLink = document.getElementById('logout-link');

        if (token) {
            loginLink.style.display = 'none';
            signupLink.style.display = 'none';
            logoutLink.style.display = 'block';

            logoutLink.addEventListener('click', () => {
                localStorage.removeItem('token');
                window.location.href = 'login.html';
            });
        } else {
            loginLink.style.display = 'block';
            signupLink.style.display = 'block';
            logoutLink.style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', async () => {
        const eventCards = document.querySelectorAll('.event-card');
        eventCards.forEach(card => {
            card.addEventListener('click', () => {
                const eventId = card.querySelector('.buy-now').getAttribute('data-id');
                window.location.href = `event-details.php?id=${eventId}`;
            });
        });
    });
  </script>
</body>
</html>
