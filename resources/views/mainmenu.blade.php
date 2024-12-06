<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Menu</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

         @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Press Start 2P', cursive;
}

body {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    position: relative;
    background-color: #000;
}

/* Background Styles */
.game-background {
    position: absolute;
    inset: 0;
    background: #000;
    overflow: hidden;
}

/* Menu Container */
.menu-container {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 400px;
    background: rgba(0, 0, 0, 0.8);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 20px #00ffa3,
        inset 0 0 20px #00ffa3;
}

.menu-title {
    color: #00ffa3;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 0 10px #00ffa3;
}

/* Menu Buttons */
.menu-button {
    padding: 15px 30px;
    border: 2px solid #00ffa3;
    background: transparent;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-transform: uppercase;
    color: #00ffa3;
    text-decoration: none;
    text-shadow: 0 0 5px #00ffa3;
    box-shadow: 0 0 10px rgba(0, 255, 163, 0.3);
}

.menu-button:hover {
    background: #00ffa3;
    color: #000;
    box-shadow: 0 0 20px #00ffa3;
}

/* Bottom line effect */
.bottom-line {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 2px;
    background: #00ffa3;
    box-shadow: 0 0 20px #00ffa3;
}

/* Footer */
.footer {
    position: absolute;
    bottom: 20px;
    width: 100%;
    padding: 10px;
    color: #00ffa3;
    text-align: center;
    font-size: 12px;
    text-shadow: 0 0 5px #00ffa3;
}

/* Audio Controls */
#audio-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
}

.audio-btn {
    background: transparent;
    border: 2px solid #00ffa3;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    color: #00ffa3;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(0, 255, 163, 0.3);
}

.audio-btn:hover {
    background: #00ffa3;
    color: #000;
    box-shadow: 0 0 20px #00ffa3;
}

.audio-btn.disabled {
    border-color: #ff0000;
    color: #ff0000;
    box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
}

.audio-btn.disabled::after {
    content: '';
    position: absolute;
    width: 70%;
    height: 2px;
    background-color: #ff0000;
    transform: rotate(45deg);
    box-shadow: 0 0 5px #ff0000;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #000;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    color: #00ffa3;
    border: 2px solid #00ffa3;
    box-shadow: 0 0 20px #00ffa3,
        inset 0 0 20px #00ffa3;
}

.modal-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.modal-btn {
    padding: 10px 30px;
    border: 2px solid #00ffa3;
    background: transparent;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'Press Start 2P', cursive;
    font-size: 12px;
    color: #00ffa3;
    transition: all 0.3s ease;
}

.modal-btn:hover {
    background: #00ffa3;
    color: #000;
    box-shadow: 0 0 20px #00ffa3;
}

@media (max-width: 768px) {
    .menu-container {
        width: 90%;
        padding: 20px;
    }

    .menu-button {
        font-size: 14px;
        padding: 12px 20px;
    }
}

.dashboard-container {
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 10px;
}

.statistics {
    background-color: #fff;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<audio id="bgMusic" src="{{ asset('music/background-music.mp3') }}" autoplay loop></audio>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>

<!-- Modal for logout confirmation -->
<div id="logout-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.7); z-index:10; justify-content:center; align-items:center;">
    <div style="background-color:#333; padding:20px; border-radius:10px; color:#fff; text-align:center;">
        <p>Are you sure you want to log out?</p>
        <button onclick="confirmLogout()" style="margin-right:10px;">Yes</button>
        <button onclick="closeModal()">No</button>
    </div>
</div>
<div class="game-background">
<div class="menu-container">
<h1 class="menu-title">MAIN MENU</h1>
        <a href="{{ route('storylinestage1') }}" class="menu-button" onclick="playSound()"><i class="fas fa-gamepad"></i> PLAY</a>
        <a href="{{ route('leaderboard') }}" class="menu-button" onclick="playSound()"><i class="fas fa-trophy"></i> LEADERBOARD</a>
        <a href="{{ route('settings') }}" class="menu-button" onclick="playSound()"><i class="fas fa-cog"></i> SETTINGS</a>
        <a href="{{ route('dashboard') }}" class="menu-button" onclick="playSound()"><i class="fas fa-tachometer-alt"></i> DASHBOARD</a>
        <button class="menu-button" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> LOGOUT
            </button>

        <!-- Admin Panel Link -->
        @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('admin.users') }}">Admin Panel</a>
        @endif
</div>
<div id="audio-controls">
            <button class="audio-btn" onclick="toggleMusic()">
                <i class="fas fa-music"></i>
            </button>
            <button class="audio-btn" onclick="toggleSound()">
                <i class="fas fa-volume-up"></i>
            </button>
        </div>

        <div class="bottom-line"></div>
        <div class="footer">
            © 2024 Space Adventure Game. All Rights Reserved.
        </div>
    </div>
</div>

    <script>
let isPageFullyLoaded = false;
let isMusicPlaying = false;
let isSoundEnabled = true;
const backgroundMusic = document.getElementById('backgroundMusic');
const clickSound = document.getElementById('clickSound');
const musicBtn = document.querySelector('.audio-btn:nth-child(1)');
const soundBtn = document.querySelector('.audio-btn:nth-child(2)');

// Function to play background music
function playBackgroundMusic() {
    const bgMusic = document.getElementById('bgMusic');
    if (isPageFullyLoaded && bgMusic) {
        // Retrieve volume from local storage or set default value
        const savedVolume = localStorage.getItem('musicVolume');
        bgMusic.volume = savedVolume ? parseFloat(savedVolume) : 0.5; // Default volume is 0.5
        bgMusic.play().catch(function(error) {
            console.error("Music play failed:", error);
        });
    }
}
function closeModal(){
    document.getElementById('logout-modal').style.display = 'none';
}

// Mark the page as fully loaded and attempt to play music
window.onload = function() {
    isPageFullyLoaded = true; // Set the boolean flag to true
    playBackgroundMusic(); // Attempt to play music
};

function toggleMusic() {
    if (isMusicPlaying) {
        bgMusic.pause();
        isMusicPlaying = false;
        musicBtn.classList.add('disabled');
    } else {
        bgMusic.play().catch(error => console.log("Music play failed:", error));
        isMusicPlaying = true;
        musicBtn.classList.remove('disabled');
    }
}

function toggleSound() {
    isSoundEnabled = !isSoundEnabled;
    clickSound.muted = !isSoundEnabled;
    if (!isSoundEnabled) {
        soundBtn.classList.add('disabled');
    } else {
        soundBtn.classList.remove('disabled');
    }
}


// Function to play the click sound
function playClickSound() {
    var clickSound = document.getElementById('clickSound');
    const savedVolume = localStorage.getItem('sfxVolume');
    clickSound.volume = savedVolume ? parseFloat(savedVolume) : 0.5;
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
        localStorage.clear();
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
