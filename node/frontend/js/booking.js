document.addEventListener('DOMContentLoaded', async () => {
    try {
      const userEmail = getCookie('email');
      if (!userEmail) {
        throw new Error('User email not found');
      }
  
      const [bookingsResponse, eventsResponse] = await Promise.all([
        fetch(`http://localhost:3000/bookings?email=${userEmail}`),
        fetch('http://localhost:3000/events')
      ]);
  
      if (!bookingsResponse.ok || !eventsResponse.ok) {
        throw new Error('Failed to fetch data');
      }
  
      const bookings = await bookingsResponse.json();
      const events = await eventsResponse.json();
  
      const bookingsBody = document.getElementById('bookings-body');
      bookings.forEach(booking => {
        const event = events.find(event => event.id === booking.event_id);
        if (event) {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${event.Title}</td>
            <td>${event.date}</td>
            <td>${event['start-time']}</td>
            <td>${event['End-time']}</td>
            <td>${event['venue']}</td>
            <td>${event['Price']}</td>
            <td>${booking.quantity}</td>
            <td>${booking.created_at}</td>
            <td><button class="delete-button" data-booking-id="${booking.id}">Delete</button></td>
          `;
          bookingsBody.appendChild(row);
        }
      });
  
      document.getElementById('bookings-body').addEventListener('click', async (event) => {
        const target = event.target;
        if (target.classList.contains('edit-button')) {
          const bookingId = target.getAttribute('data-booking-id');
          window.location.href = `edit_booking.html?bookingId=${bookingId}`;
        } else if (target.classList.contains('delete-button')) {
          const bookingId = target.getAttribute('data-booking-id');
          const confirmation = confirm('Are you sure you want to cancel this booking?');
          if (confirmation) {
            try {
              const response = await fetch(`http://localhost:3000/bookings/${bookingId}`, {
                method: 'DELETE',
              });
              if (response.ok) {
                target.closest('tr').remove();
              } else {
                throw new Error('Failed to delete booking');
              }
            } catch (error) {
              console.error('Error deleting booking:', error);
            }
          }
        }
      });
  
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
    } catch (error) {
      console.error('Error:', error);
    }
  });
  
  document.addEventListener('DOMContentLoaded', () => {
    const navbarToggle = document.querySelector('.menu-toggle');
    const navbarLinks = document.querySelector('#nav-links');
  
    navbarToggle.addEventListener('click', () => {
      navbarLinks.classList.toggle('active');
    });
  
    document.getElementById('logout').addEventListener('click', () => {
      localStorage.removeItem('token');
      document.cookie = 'email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
      window.location.href = 'index.html';
    });
  });
  