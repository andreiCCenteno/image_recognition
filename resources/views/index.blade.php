<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Start Page</title>
    <style>
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
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
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

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex: 1;
            z-index: 2;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            box-shadow: 0 0 20px #00ffcc;
        }

        h1 {
            font-size: 7em;
            margin: 0;
            padding-top: 20px;
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.7), 0 0 20px rgba(0, 255, 204, 0.5);
            font-weight: bold;
            font-family: 'Orbitron', sans-serif;
        }

        .start-button {
            font-size: 2em;
            margin: 20px 0;
            padding: 15px 30px;
            background-color: transparent;
            color: #00ffcc;
            border: 2px solid #00ffcc;
            border-radius: 10px;
            cursor: pointer;
            text-shadow: 1px 1px 2px rgba(0, 255, 204, 0.5);
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
            text-decoration: none;
            font-family: 'Roboto Mono', monospace;
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.7), inset 0 0 5px rgba(0, 255, 204, 0.3);
        }

        .start-button:hover {
            background-color: #00ffcc;
            color: #000;
            transform: scale(1.1);
            box-shadow: 0 0 25px rgba(0, 255, 204, 1), inset 0 0 10px rgba(0, 255, 204, 0.5);
        }

        .footer {
            text-align: center;
            width: 100%;
            font-size: 0.8em;
            color: #00ffcc;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 0;
            position: relative;
            z-index: 2;
            border-top: 2px solid #00ffcc;
            box-shadow: 0 0 15px #00ffcc;
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

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background: rgba(0, 0, 0, 0.9);
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.1);
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

        /* Responsive Styles */
        @media (max-width: 768px) {
            h1 {
                font-size: 4em;
            }

            .start-button {
                font-size: 1.5em;
                padding: 10px 20px;
            }

            .footer {
                font-size: 0.7em;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 3em;
            }

            .start-button {
                font-size: 1.2em;
                padding: 8px 15px;
            }

            .footer {
                font-size: 0.6em;
            }
        }
    </style>
</head>
<body>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
    <audio id="background-music" src="{{ asset('music/background-music.mp3') }}" preload="auto" loop></audio>
    <div class="container">
        <h1>WELCOME</h1>
        <a href="{{ url('login') }}" class="start-button">START GAME</a>
    </div>
    <div class="footer">
        <p>@ All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> | 
            <a href="#">Terms of Service</a> | 
            <a href="#">Contact Us</a>
        </p>
    </div>

    <!-- Modal -->
    <div id="welcomeModal" class="modal">
        <div class="modal-content">
            <span class="close" id="modalClose">&times;</span>
            <h2>Welcome to the Game!</h2>
            <p>Get ready to start your adventure. Click anywhere to continue.</p>
        </div>
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

        window.onload = function() {
            var modal = document.getElementById('welcomeModal');
            var closeModal = document.getElementById('modalClose');
            var music = document.getElementById('background-music');
            music.volume = 0.5;

            modal.style.display = 'block';

            closeModal.onclick = function() {
                modal.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
