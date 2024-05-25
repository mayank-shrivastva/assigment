// Admin Registration
document.getElementById('adminRegisterForm').addEventListener('submit', async (e) => {
    e.preventDefault();
  
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
  
    try {
      const response = await fetch('/admin/signup', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
      });
  
      const data = await response.json();
  
      if (response.ok) {
        alert(data.message);
        // Redirect to admin login page
        window.location.href = '/admin-login.html';
      } else {
        document.getElementById('message').innerText = data.message;
      }
    } catch (error) {
      console.error('Error:', error);
      document.getElementById('message').innerText = 'An error occurred. Please try again.';
    }
  });
  
  // Admin Logout
  document.getElementById('logout').addEventListener('click', () => {
    // Clear admin token from local storage
    localStorage.removeItem('adminToken');
    // Redirect to admin login page
    window.location.href = '/admin-login.html';
  });
  