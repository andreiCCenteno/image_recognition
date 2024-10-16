<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Menu</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    font-family: 'Roboto Mono', monospace;
    color: #00ffcc;
    text-align: center;
    background: linear-gradient(135deg, #ff0066, #ff9933, #ffff00, #33cc33, #0066ff, #9933ff);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
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

.menu-container {
    flex: 1;
    width: 97%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    z-index: 2;
    padding: 20px;
    border: 2px solid #00ffcc;
    border-radius: 15px;
    background-color: rgba(0, 0, 0, 0.7);
    box-shadow: 0 0 20px #00ffcc;
    animation: pulse 2s infinite;
    max-width: 100%; /* Responsive max width */
    margin: auto; /* Center the container */
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 20px #00ffcc, inset 0 0 10px #00ffcc;
    }
    50% {
        box-shadow: 0 0 30px #00ffcc, inset 0 0 20px #00ffcc;
    }
    100% {
        box-shadow: 0 0 20px #00ffcc, inset 0 0 10px #00ffcc;
    }
}

a {
    text-decoration: none;
    color: inherit;
}

h1 {
    color: #00ffcc;
    font-family: 'Orbitron', sans-serif;
    text-shadow: 0 0 10px rgba(0, 255, 204, 0.7), 0 0 20px rgba(0, 255, 204, 0.5);
    margin-bottom: 40px;
    font-size: 3.5em;
}

.buttons {
    display: flex;
    flex-wrap: wrap; /* Allow buttons to wrap */
    justify-content: center;
    align-items: center;
    gap: 20px; /* Reduced gap for smaller screens */
}

.menu-button {
    width: 220px;
    margin: 10px;
    padding: 15px;
    font-size: 1.3em;
    color: #00ffcc;
    background-color: transparent;
    border: 2px solid #00ffcc;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 0 15px rgba(0, 255, 204, 0.7), inset 0 0 5px rgba(0, 255, 204, 0.3);
    text-transform: uppercase;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.menu-button:hover {
    background-color: #00d1b2;
    transform: scale(1.05);
    box-shadow: 0 0 25px rgba(0, 255, 204, 1), inset 0 0 10px rgba(0, 255, 204, 0.5);
}

.menu-button i {
    font-size: 1.2em;
}

.footer {
    text-align: center;
    width: 100%;
    font-size: 0.8em;
    color: #00ffcc;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px 0;
    position: relative;
    z-index: 2;
    border-top: 2px solid #00ffcc;
    animation: slideInUp 1s ease-out;
}

.footer a {
    color: #00ffcc;
    text-decoration: none;
    margin: 0 10px;
    transition: color 0.3s ease;
}

.footer a:hover {
    color: #00d1b2;
}

@keyframes slideInUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive styles */
@media (max-width: 600px) {
    h1 {
        font-size: 2.5em; /* Smaller font size for smaller screens */
    }

    .menu-button {
        width: 80%; /* Full width on small screens */
        font-size: 1.1em; /* Smaller font size for buttons */
    }

    .buttons {
        flex-direction: column; /* Stack buttons vertically */
        gap: 15px; /* Reduced gap for smaller screens */
    }
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<audio id="bgMusic" src="{{ asset('music/background-music.mp3') }}" preload="auto" loop></audio>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>

<!-- Modal for logout confirmation -->
<div id="logout-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.7); z-index:10; justify-content:center; align-items:center;">
    <div style="background-color:#333; padding:20px; border-radius:10px; color:#fff; text-align:center;">
        <p>Are you sure you want to log out?</p>
        <button onclick="confirmLogout()" style="margin-right:10px;">Yes</button>
        <button onclick="closeModal()">No</button>
    </div>
</div>

<div class="menu-container">
    <h1>Welcome, you wanna play? Let's play!</h1>
    
    <div class="buttons">
        <a href="{{ route('play') }}" class="menu-button" onclick="playSound()"><i class="fas fa-gamepad"></i> PLAY</a>
        <a href="{{ route('leaderboard') }}" class="menu-button" onclick="playSound()"><i class="fas fa-trophy"></i> LEADERBOARD</a>
        <a href="{{ route('settings') }}" class="menu-button" onclick="playSound()"><i class="fas fa-cog"></i> SETTINGS</a>
        <button class="menu-button" onclick="logout()"><i class="fas fa-sign-out-alt"></i> LOGOUT</button>

        <!-- Admin Panel Link -->
        @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('admin.users') }}">Admin Panel</a>
        @endif
    </div>
</div>

<div class="footer">
    <p>@All Rights Reserved</p>
    <p>
        <a href="#">Privacy Policy</a> | 
        <a href="#">Terms of Service</a> | 
        <a href="#">Contact Us</a>
    </p>
</div>

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

        document.addEventListener('DOMContentLoaded', function() {
        // Retrieve user ID from localStorage
        @if(session('user_id'))
            localStorage.setItem('user_id', '{{ session('user_id') }}'); // Store user ID in local storage
        @endif

        const userId = localStorage.getItem('user_id');
        // Optional: Use the user ID (for example, display it or use it in game logic)
        if (userId) {
            console.log("User ID:", userId); // Log the user ID or use it as needed
            // You can add your code here that requires the user ID
        } else {
            console.warn("User ID is not set in local storage.");
        }
    });

    function logout() {
        // Clear user ID from localStorage on logout
        localStorage.removeItem('userId');
        // Show the logout modal
        document.getElementById('logout-modal').style.display = 'flex';
    }
    
    function confirmLogout() {
        fetch('/logout', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/login'; // Adjust to your login route
                } else {
                    console.error('Logout failed');
                }
        });
    }
    </script>
</body>
</html>
