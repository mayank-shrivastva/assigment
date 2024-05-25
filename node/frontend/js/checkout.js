// Function to generate the invoice HTML
function generateInvoice(eventDetails, name, email, quantity) {
    return `
      <center><h2>Invoice</h2></center>
      <h2>You have successfully booked tickets</h2>
      <p><strong>Name:</strong> ${name}</p>
      <p><strong>Email:</strong> ${email}</p>
      <p><strong>Quantity:</strong> ${quantity}</p>
    `;
  }
  
  document.addEventListener('DOMContentLoaded', async () => {
    // Function to get cookie value by name
    function getCookie(name) {
      const cookies = document.cookie.split(';').map(cookie => cookie.trim());
      for (const cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split('=');
        if (cookieName === name) {
          return cookieValue;
        }
      }
      return null;
    }
  
    const urlParams = new URLSearchParams(window.location.search);
    const eventId = urlParams.get('eventId');
    if (!eventId) {
      alert('Event ID is missing');
      return;
    }
  
    try {
      const response = await fetch('http://localhost:3000/events');
      if (!response.ok) {
        throw new Error('Failed to fetch events');
      }
      const events = await response.json();
  
      console.log('Fetched Events:', events); // Log fetched events
  
      const eventDetails = events.find(e => e.id == eventId);
  
      console.log('Event Details:', eventDetails); // Log event details
  
      if (eventDetails) {
        document.getElementById('eventDetails').innerHTML = `
          <p><strong>Title:</strong> ${eventDetails.Title}</p>
          <p><strong>Date:</strong> ${eventDetails.date}</p>
          <p><strong>Start Time:</strong> ${eventDetails['start-time']}</p>
          <p><strong>End Time:</strong> ${eventDetails['End-time']}</p>
          <p><strong>Venue:</strong> ${eventDetails.venue}</p>
          <p><strong>Price:</strong> ${eventDetails.Price}</p>
        `;
  
        document.getElementById('eventId').value = eventId;
        // Populate quantity options, limiting to available tickets or 5, whichever is smaller
        const quantitySelect = document.getElementById('quantity');
        const maxQuantity = Math.min(eventDetails.available, 5);
        for (let i = 1; i <= maxQuantity; i++) {
          const option = document.createElement('option');
          option.value = i;
          option.textContent = i;
          quantitySelect.appendChild(option);
        }
      } else {
        alert('Event not found');
      }
    } catch (error) {
      console.error('Error fetching event details:', error);
    }
  
    // Retrieve email from cookie and pre-fill the email field
    const storedEmail = getCookie('email');
    if (storedEmail) {
      document.getElementById('email').value = storedEmail;
    }
  
    document.getElementById('checkoutForm').addEventListener('submit', async (event) => {
      event.preventDefault();
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const quantity = document.getElementById('quantity').value;
  
      if (quantity > 5) {
        alert('You can only buy up to 5 tickets at a time');
        return;
      }
  
      try {
        const response = await fetch('http://localhost:3000/purchase', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            eventId: document.getElementById('eventId').value,
            name,
            email,
            quantity
          })
        });
  
        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message);
        }
  
        // Show success message with invoice
        const invoiceDetails = generateInvoice(eventDetails, name, email, quantity);
        document.getElementById('container').innerHTML = invoiceDetails;
      } catch (error) {
        console.error('Purchase error:', error);
        alert(error.message);
      }
    });
  });
  