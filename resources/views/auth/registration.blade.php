<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');

@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    font-family: 'Roboto Mono', monospace;
    color: #00ffcc;
    text-align: center;
    background: url('https://www.transparenttextures.com/patterns/circuits.png'), 
                linear-gradient(135deg, #0d1b2a 25%, #1b263b 100%);
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.registration-form {
    background: rgba(0, 0, 0, 0.8);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px #00ffcc;
    width: 100%;
    max-width: 500px;
    text-align: left;
    z-index: 2;
}

h2 {
    margin: 0 0 20px;
    color: #00ffcc;
    font-family: 'Orbitron', sans-serif;
    text-shadow: 0 0 10px rgba(0, 255, 204, 0.7), 0 0 20px rgba(0, 255, 204, 0.5);
    text-align: center;
}

label {
    display: block;
    margin: 10px 0 5px;
    color: #00ffcc;
}

input[type="email"], input[type="text"], input[type="password"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #00ffcc;
    border-radius: 5px;
    background: #1b263b;
    color: #00ffcc;
    font-family: 'Roboto Mono', monospace;
}

input[type="checkbox"] {
    margin-right: 10px;
    color: #00ffcc;
}

button {
    padding: 15px 20px;
    border: none;
    border-radius: 5px;
    background-color: #00ffcc;
    color: #000;
    cursor: pointer;
    font-size: 1.2em;
    font-family: 'Orbitron', sans-serif;
    width: 100%;
    text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 0 15px rgba(0, 255, 204, 0.7);
    margin-top: 10px;
}

button:hover {
    background-color: #00d1b2;
    transform: scale(1.05);
}

.google-button {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
    border: none;
    border-radius: 5px;
    background-color: #4285F4; /* Google Blue */
    color: #fff;
    cursor: pointer;
    font-size: 1.2em;
    width: 100%;
    margin-top: 20px;
    box-shadow: 0 0 15px rgba(66, 133, 244, 0.7);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.google-button i {
    margin-right: 10px;
}

.google-button:hover {
    background-color: #357AE8;
    transform: scale(1.05);
}

a {
    color: #00ffcc;
    text-decoration: none;
    display: block;
    text-align: center;
    margin-top: 10px;
    transition: color 0.3s ease;
}

a:hover {
    color: #00d1b2;
}

p {
    margin: 20px 0 0;
    text-align: center;
    color: #00ffcc;
}

.copyright {
    font-size: 0.8em;
    color: #00ffcc;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px 0;
    position: absolute;
    bottom: 0;
    width: 100%;
    text-align: center;
    z-index: 2;
    border-top: 2px solid #00ffcc;
    box-shadow: 0 0 15px #00ffcc;
}
/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background: rgba(0, 0, 0, 0.8);
    animation: fadeIn 0.5s;
}

.modal-content {
    background: rgba(255, 255, 255, 0.2);
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 20px;
    text-align: center;
    color: #0ff;
}

.close {
    color: #0ff;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #fff;
}

    </style>
</head>
<body>
    <div class="registration-form">
        <h2>Account Registration</h2>
        <form method="POST" action="{{ route('register') }}" id="registrationForm">
            @csrf <!-- CSRF token for security -->

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="userName" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="password_confirmation" required>

            <input type="checkbox" id="terms" name="terms" required> I agree to the terms and conditions.

            <button type="submit" name="register">Register Account</button>

            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </form>
    </div>

    <p class="copyright">@ All Rights Reserved</p>
    <script>
        // Show error modal
        function showError(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('errorModal').style.display = 'block';
        }

        // Close modal function
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Handle form validation
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            var email = document.getElementById('email').value;
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var terms = document.getElementById('terms').checked;

            if (!terms) {
                event.preventDefault();
                showError('You must agree to the terms and conditions.');
                return;
            }

            if (password !== confirmPassword) {
                event.preventDefault();
                showError('Passwords do not match.');
                return;
            }

            if (password.length < 8) {
                event.preventDefault();
                showError('Password must be at least 8 characters long.');
                return;
            }
        });
    </script>
</body>
</html>
