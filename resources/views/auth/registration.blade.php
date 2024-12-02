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

/* General styles (default for larger screens) */
/* General styles (default for larger screens) */
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
    flex-direction: column; /* Ensure vertical stacking */
    justify-content: space-between; /* Push footer to the bottom */
    position: relative;
    overflow-x: hidden; /* Prevent horizontal overflow */
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
    max-width: 500px; /* Limits width on large screens */
    text-align: left;
    z-index: 2;
    box-sizing: border-box; /* Ensures padding is included in total width */
    overflow: hidden; /* Prevent content overflow */
    margin: auto; /* Center the form vertically if possible */
    display: flex;
    flex-direction: column; /* Stack elements vertically */
}

h2 {
    margin: 0 0 20px;
    color: #00ffcc;
    font-family: 'Orbitron', sans-serif;
    text-shadow: 0 0 10px rgba(0, 255, 204, 0.7), 0 0 20px rgba(0, 255, 204, 0.5);
    text-align: center;
}

/* Input Fields */
input[type="email"], input[type="text"], input[type="password"] {
    width: calc(100% - 20px); /* Ensures input adapts to container width */
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #00ffcc;
    border-radius: 5px;
    background: #1b263b;
    color: #00ffcc;
    font-family: 'Roboto Mono', monospace;
    box-sizing: border-box;
}

/* Button styles */
#submit {
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
#submit:hover {
    background-color: #00d1b2;
    transform: scale(1.05);
}

a {
    color: #00ffcc;
    text-decoration: none;
    display: block;
    text-align: center;
    margin-top: 10px;
    transition: color 0.3s ease;
    font-size: 1em; /* Ensure links are readable on mobile */
}

a:hover {
    color: #00d1b2;
}

p {
    margin: 20px 0 0; /* Add spacing to prevent text being cut off */
    text-align: center;
    color: #00ffcc;
    font-size: 1em; /* Ensure text scales properly on mobile */
    word-wrap: break-word; /* Handle long text gracefully */
}

@media (max-width: 480px) {
    .registration-form {
        padding: 15px; /* Reduce padding for small screens */
        width: 95%; /* Adjust width to fit within the viewport */
    }

    p {
        font-size: 0.9em; /* Slightly smaller text for mobile */
        margin-bottom: 10px; /* Add spacing for better layout */
    }

    a {
        font-size: 0.9em; /* Adjust link font size for readability */
    }
}

.copyright {
    font-size: 0.8em;
    color: #00ffcc;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px 0;
    width: 100%;
    text-align: center;
    z-index: 2;
    border-top: 2px solid #00ffcc;
    box-shadow: 0 0 15px #00ffcc;
    position: relative; /* Remove absolute positioning */
    margin-top: 20px; /* Add some spacing from the form */
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
/* Responsive Breakpoints */
@media (max-width: 768px) {
    .registration-form {
        padding: 20px;
        width: 90%; /* Reduce width for tablets */
    }

    h2 {
        font-size: 1.8em;
    }

    button {
        font-size: 1em;
        padding: 12px;
    }
}

@media (max-width: 480px) {
    .registration-form {
        padding: 15px;
        width: 95%; /* Further reduce width for small phones */
    }

    h2 {
        font-size: 1.5em;
    }

    label {
        font-size: 0.9em;
    }

    button {
        font-size: 0.9em;
        padding: 10px;
    }

    input[type="email"], input[type="text"], input[type="password"] {
        padding: 8px;
        font-size: 0.9em;
    }
}

.modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }
    .password-container {
        display: flex;
        align-items: center;
        position: relative;
    }

    .password-container input {
        flex: 1;
    }

    .toggle-icon {
        position: absolute;
        right: 10px;
        cursor: pointer;
        color: #007bff;
    }

    .toggle-icon:hover {
        color: #0056b3;
    }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
<audio id="background-music" src="{{ asset('music/background-music.mp3') }}" preload="auto" loop></audio>
<!-- Error Modal -->
<div id="errorModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('errorModal').style.display='none'">&times;</span>
        <p id="modalMessage" style="color: red;"></p>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
        <p id="successMessage" style="color: green;"></p>
    </div>
</div>

<div class="registration-form">
    <h2>Account Registration</h2>
    <form method="POST" action="{{ route('register') }}" id="registrationForm">
        @csrf <!-- CSRF token for security -->

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename">

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="userName" required>

        <label for="password">Password:</label>
        <div class="password-container">
            <input type="password" id="password" name="password" required>
            <i class="fa-solid fa-eye toggle-icon" onclick="togglePasswordVisibility('password', this)"></i>
        </div>

        <label for="confirmPassword">Confirm Password:</label>
        <div class="password-container">
            <input type="password" id="confirmPassword" name="password_confirmation" required>
            <i class="fa-solid fa-eye toggle-icon" onclick="togglePasswordVisibility('confirmPassword', this)"></i>
        </div>

        <input type="checkbox" id="terms" name="terms" required> I agree to the terms and conditions.

        <button type="submit" id="submit" name="register">Register Account</button>

        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </form>
</div>


    <p class="copyright">@ All Rights Reserved</p>
    <script>

        let isPageFullyLoaded = false;

        // Function to play background music
        function playBackgroundMusic() {
            const bgMusic = document.getElementById('bgMusic');
            if (isPageFullyLoaded && bgMusic) {
                bgMusic.play().catch(function(error) {
                    console.error("Music play failed:", error);
                });
            }
        }

        // Mark the page as fully loaded and attempt to play music
        window.onload = function() {
            isPageFullyLoaded = true; // Set the boolean flag to true
            playBackgroundMusic(); // Attempt to play music
        };

        // Function to play the click sound
        function playClickSound() {
            var clickSound = document.getElementById('clickSound');
            clickSound.play();
        }

        // Attach the playClickSound function to all buttons and anchor tags on the page
        document.querySelectorAll('button, a').forEach(function(element) {
            element.addEventListener('click', playClickSound);
        });

        // Show error modal
        function showError(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('errorModal').style.display = 'block';
        }

        // Close modal function
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }


        function togglePasswordVisibility(fieldId, icon) {
    const passwordField = document.getElementById(fieldId);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

        // Handle form validation
        document.getElementById('registrationForm').addEventListener('submit', function (event) {
    try {
        const email = document.getElementById('email').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const terms = document.getElementById('terms').checked;

        // Basic email validation
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            throw new Error('Please enter a valid email address.');
        }

        // Username validation: alphanumeric, 3-15 characters
        const usernamePattern = /^[a-zA-Z0-9_]{3,15}$/;
        if (!usernamePattern.test(username)) {
            throw new Error('Username must be 3-15 characters long and can only contain letters, numbers, and underscores.');
        }

        // Password validation: at least 8 characters, with uppercase, lowercase, number, and special character
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_-$!%*?&])[A-Za-z\d@_-$!%*?&]{8,}$/;
        if (!passwordPattern.test(password)) {
            throw new Error('Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.');
        }

        // Confirm password validation
        if (password !== confirmPassword) {
            throw new Error('Passwords do not match.');
        }

        // Terms and conditions validation
        if (!terms) {
            throw new Error('You must agree to the terms and conditions.');
        }

        // If all validations pass
        showSuccess('Registration successful!');
    } catch (error) {
        event.preventDefault(); // Prevent form submission
        showError(error.message); // Show custom error popup
    }
});

// Function to show error messages
function showError(message) {
    const modal = document.getElementById('errorModal');
    const modalMessage = document.getElementById('modalMessage');
    modalMessage.innerText = message;
    modal.style.display = 'block'; // Show modal
}

// Function to show success messages
function showSuccess(message) {
    const modal = document.getElementById('successModal');
    const modalMessage = document.getElementById('successMessage');
    modalMessage.innerText = message;
    modal.style.display = 'block'; // Show modal
}
    </script>
</body>
</html>
