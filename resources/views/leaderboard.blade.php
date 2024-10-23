<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
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
        background: linear-gradient(135deg, #ff0066, #ff9933, #ffff00, #33cc33, #0066ff, #9933ff);
        background-size: 400% 400%;
        animation: gradientAnimation 5s ease infinite;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 0%; }
        50% { background-position: 100% 100%; }
        100% { background-position: 0% 0%; }
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

    h1 {
        color: #00ffcc;
        text-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
        margin-bottom: 20px;
        font-size: 3.5em;
        font-family: 'Orbitron', sans-serif;
    }

    .leaderboard {
        background: rgba(0, 0, 0, 0.8);
        padding: 50px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 255, 204, 0.7);
        max-width: 600px;
        margin: auto;
        z-index: 2;
    }

    .leaderboard ul {
        list-style: none;
        padding: 0;
    }

    .leaderboard li {
        margin: 15px 0;
        color: #fff;
        font-size: 1.2em;
        transition: transform 0.2s, background-color 0.3s;
        padding: 10px;
        border-radius: 10px;
    }

    .leaderboard li:hover {
        transform: scale(1.05);
        background-color: rgba(255, 255, 255, 0.1); /* Slightly lighter background on hover */
    }

    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        cursor: pointer;
        text-align: center;
        line-height: 50px;
        font-size: 1.5em;
        color: #00ffcc;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
        z-index: 2;
    }

    .back-button:hover {
        background-color: #00d1b2;
        transform: scale(1.1);
    }

    .back-button:focus {
        outline: 2px solid #00ffcc;
        outline-offset: 4px;
    }

    .leaderboard i {
        color: gold; /* Change the color of the crown */
        margin-right: 5px; /* Space between the icon and username */
    }

    .leaderboard div {
        font-size: 0.9em; /* Slightly smaller font for progress */
        color: #ffcc00; /* Change color for progress text */
        margin-top: 5px; /* Space above the progress */
        font-weight: bold; /* Make the progress text bold */
    }

    .progress-label {
        margin-right: 10px; /* Space between progress indicators */
    }

    .separator {
        border-top: 1px solid rgba(255, 255, 255, 0.3); /* Separator line */
        margin: 20px 0; /* Spacing around the separator */
        padding: 10px 0; /* Padding above and below the separator */
        color: #fff; /* Color of the separator text */
        font-size: 1.2em; /* Size of the separator text */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

</head>
<body>
<audio id="bgMusic" src="{{ asset('music/background-music.mp3') }}" preload="auto" loop></audio>
    <audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
    <a href="{{ route('mainmenu') }}" class="back-button" title="Back">&larr;</a>
    <div class="leaderboard">
        <h1>Leaderboard</h1>
        <h2>TOP 3 HIGH SCORING</h2>
        <ul>
            @if (!empty($users) && is_array($users))
                @php
                    // Sort users by score in descending order
                    usort($users, function($a, $b) {
                        return $b['score'] <=> $a['score'];
                    });
                @endphp

                @foreach ($users as $index => $user)
                    <li>
                        @if ($index === 0)
                            <strong><i class="fas fa-crown"></i> {{ htmlspecialchars($user['username']) }} (Top 1)</strong>
                        @elseif ($user['id'] == $current_user_id)
                            <strong>{{ htmlspecialchars($user['username']) }} (You)</strong>
                        @else
                            {{ htmlspecialchars($user['username']) }}
                        @endif
                        - {{ htmlspecialchars($user['score']) }} points
                    </li>
                @endforeach
                <li class="separator"></li>
                @foreach ($users as $user)
                    @if ($user['id'] === $current_user_id) <!-- Check for current user ID -->
                        <li>
                            <strong>(You) {{ htmlspecialchars($user['username']) }}</strong> - {{ htmlspecialchars($user['score']) }} points
                        </li>
                    @endif
                @endforeach
                <p>Your Progress:</p>
                @foreach ($users as $index => $user)
                <div>
                    @if ($user['id'] === $current_user_id) 
                        <span class="progress-label">Easy: {{ $user['easy_finish'] ? '✔️' : '❌' }}</span>
                        <span class="progress-label">Medium: {{ $user['medium_finish'] ? '✔️' : '❌' }}</span>
                        <span class="progress-label">Hard: {{ $user['hard_finish'] ? '✔️' : '❌' }}</span>
                    @endif
                </div>
                @endforeach
            @else
                <li>No scores available yet.</li>
            @endif
        </ul>
    </div>
    <script>

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

        let isPageFullyLoaded = false;

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

        // Mark the page as fully loaded and attempt to play music
        window.onload = function() {
            isPageFullyLoaded = true; // Set the boolean flag to true
            playBackgroundMusic(); // Attempt to play music
        };

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

    </script>
</body>

</html>
