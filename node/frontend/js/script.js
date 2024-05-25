 
    document.addEventListener('DOMContentLoaded', () => {
      const loginForm = document.getElementById('login-form');
      loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(loginForm);
        try {
          const response = await fetch('http://localhost:3000/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
          });
          if (!response.ok) {
            throw new Error('Login failed');
          }
          const data = await response.json();
          alert('Login successful');
          localStorage.setItem('token', data.token);
          window.location.href = 'dashboard.html'; // Redirect to dashboard
        } catch (error) {
          console.error('Login error:', error);
          alert('Login failed');
        }
      });

      const signupForm = document.getElementById('signup-form');
      signupForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(signupForm);
        try {
          const response = await fetch('http://localhost:3000/signup', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
          });
          if (!response.ok) {
            throw new Error('Signup failed');
          }
          alert('Signup successful');
        } catch (error) {
          console.error('Signup error:', error);
          alert('Signup failed');
        }
      });
    });
   