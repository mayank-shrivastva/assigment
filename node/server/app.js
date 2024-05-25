const express = require('express');
const bodyParser = require('body-parser');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const cors = require('cors');
const mysql = require('mysql');
const cookieParser = require('cookie-parser');

const app = express();
app.use(bodyParser.json());
app.use(cors());

// Create MySQL connection
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root', // Your MySQL email
  password: '', // Your MySQL password
  database: 'nodeticket' // Name of your MySQL database
});

// Connect to MySQL
connection.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err);
    return;
  }
  console.log('Connected to MySQL database');
});

// Route for user signup
app.post('/signup', async (req, res) => {
  try {
    const existingUserQuery = 'SELECT * FROM users WHERE email = ?';
    connection.query(existingUserQuery, [req.body.email], async (err, results) => {
      if (err) {
        console.error('Error checking existing user:', err);
        res.status(500).json({ message: 'Server error' });
        return;
      }
      if (results.length > 0) {
        return res.status(400).json({ message: 'User already exists' });
      }

      const hashedPassword = await bcrypt.hash(req.body.password, 10);

      const insertUserQuery = 'INSERT INTO users (email, password) VALUES (?, ?)';
      connection.query(insertUserQuery, [req.body.email, hashedPassword], (err) => {
        if (err) {
          console.error('Error creating new user:', err);
          res.status(500).json({ message: 'Server error' });
          return;
        }
        res.status(201).json({ message: 'User created successfully' });
      });
    });
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Route for user login
app.post('/login', async (req, res) => {
  try {
    const getUserQuery = 'SELECT * FROM users WHERE email = ?';
    connection.query(getUserQuery, [req.body.email], async (err, results) => {
      if (err) {
        console.error('Error retrieving user:', err);
        res.status(500).json({ message: 'Server error' });
        return;
      }
      if (results.length === 0) {
        return res.status(401).json({ message: 'Invalid email or password' });
      }

      const user = results[0];
      const passwordMatch = await bcrypt.compare(req.body.password, user.password);
      if (!passwordMatch) {
        return res.status(401).json({ message: 'Invalid email or password' });
      }

      const token = jwt.sign({ email: user.email }, 'secret', { expiresIn: '1h' });

      res.json({ token });
    });
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: 'Server error' });
  }
});
// Route to get all events
app.get('/events', (req, res) => {
  const query = 'SELECT `id`, `Title`, `date`, `start-time`, `End-time`, `available`, `remaining-ticket`, `venue`, `Price` FROM `event-information`';
  connection.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching events:', err);
      res.status(500).json({ message: 'Server error' });
      return;
    }
    res.json(results);
  });
});
 // Route for purchasing tickets
app.post('/purchase', (req, res) => {
  const { eventId, name, email, quantity } = req.body;

  // Insert purchase data into booking table
  const insertBookingQuery = 'INSERT INTO booking (event_id, name, email, quantity) VALUES (?, ?, ?, ?)';
  connection.query(insertBookingQuery, [eventId, name, email, quantity], (error, results) => {
    if (error) {
      console.error('Error purchasing ticket:', error);
      res.status(500).json({ message: 'Failed to complete purchase' });
    } else {
      // Update remaining tickets count in event-information table
      const updateRemainingTicketsQuery = 'UPDATE `event-information` SET `remaining-ticket` = `remaining-ticket` - ? WHERE `id` = ? AND `remaining-ticket` >= ?';
      connection.query(updateRemainingTicketsQuery, [quantity, eventId, quantity], (updateError, updateResults) => {
        if (updateError) {
          console.error('Error updating remaining tickets:', updateError);
          res.status(500).json({ message: 'Failed to update remaining tickets count' });
        } else if (updateResults.affectedRows === 0) {
          // If no rows were affected, it means there weren't enough tickets available
          const getRemainingTicketsQuery = 'SELECT `remaining-ticket` FROM `event-information` WHERE `id` = ?';
          connection.query(getRemainingTicketsQuery, [eventId], (selectError, selectResults) => {
            if (selectError) {
              console.error('Error retrieving remaining tickets count:', selectError);
              res.status(500).json({ message: 'Failed to retrieve remaining tickets count' });
            } else {
              const remainingTickets = selectResults[0] ? selectResults[0]['remaining-ticket'] : 0;
              res.status(400).json({ message: `${remainingTickets} tickets left for this event` });
            }
          });
        } else {
          res.status(200).json({ message: 'Purchase completed successfully' });
        }
      });
    }
  });
});
app.get('/bookings', (req, res) => {
  try {
    const userEmail = req.query.email; // Extract email from query parameters
    // Check if email is provided
    if (!userEmail) {
      return res.status(400).json({ message: 'Email parameter is required' });
    }
    // Query database for bookings associated with the provided email
    const query = 'SELECT * FROM booking WHERE email = ?';
    connection.query(query, [userEmail], (err, results) => {
      if (err) {
        console.error('Error fetching bookings:', err);
        return res.status(500).json({ message: 'Server error' });
      }
      // Return bookings data to the client
      res.json(results);
    });
  } catch (error) {
    console.error('Error fetching bookings:', error);
    res.status(500).json({ message: 'Server error' });
  }
});
 
// Route for deleting a booking
app.delete('/bookings/:id', (req, res) => {
  const bookingId = req.params.id;

  // Delete the booking from the database
  const deleteBookingQuery = 'DELETE FROM booking WHERE id = ?';
  connection.query(deleteBookingQuery, [bookingId], (error, results) => {
    if (error) {
      console.error('Error deleting booking:', error);
      res.status(500).json({ message: 'Failed to delete booking' });
    } else {
      res.status(200).json({ message: 'Booking deleted successfully' });
    }
  });
});


// admin

// Route for user signup
app.post('/admin/signup', async (req, res) => {
  try {
    const existingUserQuery = 'SELECT * FROM admins WHERE email = ?';
    connection.query(existingUserQuery, [req.body.email], async (err, results) => {
      if (err) {
        console.error('Error checking existing user:', err);
        res.status(500).json({ message: 'Server error' });
        return;
      }
      if (results.length > 0) {
        return res.status(400).json({ message: 'User already exists' });
      }

      const hashedPassword = await bcrypt.hash(req.body.password, 10);

      const insertUserQuery = 'INSERT INTO admins (email, password) VALUES (?, ?)';
      connection.query(insertUserQuery, [req.body.email, hashedPassword], (err) => {
        if (err) {
          console.error('Error creating new user:', err);
          res.status(500).json({ message: 'Server error' });
          return;
        }
        res.status(201).json({ message: 'User created successfully' });
      });
    });
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Route for user login
app.post('/admin/login', async (req, res) => {
  try {
    const getUserQuery = 'SELECT * FROM admins WHERE email = ?';
    connection.query(getUserQuery, [req.body.email], async (err, results) => {
      if (err) {
        console.error('Error retrieving user:', err);
        res.status(500).json({ message: 'Server error' });
        return;
      }
      if (results.length === 0) {
        return res.status(401).json({ message: 'Invalid email or password' });
      }

      const user = results[0];
      const passwordMatch = await bcrypt.compare(req.body.password, user.password);
      if (!passwordMatch) {
        return res.status(401).json({ message: 'Invalid email or password' });
      }

      const token = jwt.sign({ email: user.email }, 'secret', { expiresIn: '1h' });

      res.json({ token });
    });
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: 'Server error' });
  }
});


// Route to get all events
app.get('/events', (req, res) => {
  const query = 'SELECT * FROM events';
  connection.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching events:', err);
      res.status(500).json({ message: 'Server error' });
      return;
    }
    res.json(results);
  });
});

// Route to add a new event
app.post('/events', (req, res) => {
  const eventData = req.body;
  const insertQuery = 'INSERT INTO events SET ?';
  connection.query(insertQuery, eventData, (err, result) => {
    if (err) {
      console.error('Error adding event:', err);
      res.status(500).json({ message: 'Failed to add event' });
      return;
    }
    res.status(201).json({ message: 'Event added successfully', eventId: result.insertId });
  });
});

// Route to update an existing event
// Route to update an existing event
app.put('/events/:id', (req, res) => {
  const eventId = req.params.id;
  const eventData = req.body;
  const updateQuery = 'UPDATE `event-information` SET ? WHERE id = ?';
  connection.query(updateQuery, [eventData, eventId], (err, result) => {
    if (err) {
      console.error('Error updating event:', err);
      res.status(500).json({ message: 'Failed to update event' });
      return;
    }
    res.status(200).json({ message: 'Event updated successfully' });
  });
});


app.delete('/events/:id', (req, res) => {
  const eventId = req.params.id;

  // Validate eventId (assuming it's a numeric ID)
  if (!/^\d+$/.test(eventId)) {
    return res.status(400).json({ message: 'Invalid event ID' });
  }

  const deleteQuery = 'DELETE FROM `event-information` WHERE id = ?';
  connection.query(deleteQuery, [eventId], (err, result) => {
    if (err) {
      console.error('Error deleting event:', err);
      return res.status(500).json({ message: 'Failed to delete event' });
    }

    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Event not found' });
    }

    res.status(200).json({ message: 'Event deleted successfully' });
  });
});



/// user

// Route to get all users
app.get('/users', (req, res) => {
  const query = 'SELECT * FROM users';
  connection.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching users:', err);
      res.status(500).json({ message: 'Server error' });
      return;
    }
    res.json(results);
  });
});

// Route for deleting a user
app.delete('/users/:id', (req, res) => {
  const userId = req.params.id;

  // Delete the user from the database
  const deleteQuery = 'DELETE FROM users WHERE id = ?';
  connection.query(deleteQuery, [userId], (error, result) => {
    if (error) {
      console.error('Error deleting user:', error);
      res.status(500).json({ message: 'Failed to delete user' });
    } else {
      res.status(200).json({ message: 'User deleted successfully' });
    }
  });
});

app.put('/users/:id', (req, res) => {
  const userId = req.params.id;
  const { email } = req.body;

  // Check if email is provided
  if (!email) {
    return res.status(400).json({ message: 'Email is required' });
  }

  // Log the data being updated
  console.log(`Updating user with id: ${userId}, email: ${email}`);

  // Construct the SQL query with the SET clause
  const updateUserQuery = 'UPDATE users SET email = ? WHERE id = ?';

  // Execute the query with the provided values
  connection.query(updateUserQuery, [email, userId], (err, result) => {
    if (err) {
      console.error('Error updating user:', err);
      res.status(500).json({ message: 'Failed to update user' });
      return;
    }

    // Check if the user was actually updated
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'User not found' });
    }

    console.log(`User with id: ${userId} updated successfully`);
    res.status(200).json({ message: 'User updated successfully' });
  });
});


const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});