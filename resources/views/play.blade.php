<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Difficulty</title>
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

        .difficulty-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.7);
            max-width: 600px;
            margin: auto;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            margin-bottom: 30px;
            font-size: 3.5em;
            font-family: 'Orbitron', sans-serif;
        }

        .difficulty-button {
            width: 250px;
            margin: 15px;
            padding: 20px;
            font-size: 1.5em;
            color: #00ffcc;
            background: linear-gradient(135deg, #1a1a1a 25%, #333 100%);
            border: 2px solid #00ffcc;
            border-radius: 10px;
            cursor: pointer;
            text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .difficulty-button:disabled {
            color: #888;
            border-color: #888;
            cursor: not-allowed;
        }

        .difficulty-button i {
            font-size: 1.2em;
        }

        .difficulty-button:hover:enabled {
            background: linear-gradient(135deg, #333 25%, #1a1a1a 100%);
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            transform: scale(1.05);
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
    </style>
</head>
<body>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
<a href="{{ route('mainmenu') }}" class="back-button" title="Back">&larr;</a>

    <div class="difficulty-container">
        <h1>Select Difficulty</h1>

        <!-- Easy Button (always enabled) -->
        <button class="difficulty-button" onclick="startGame('easy')">Easy</button>

        <!-- Medium Button (disabled by default, enabled after easy_finish) -->
        <button class="difficulty-button" id="mediumButton" @if(!$easy_finish) disabled @endif>
            @if(!$easy_finish)
                <i class="fas fa-lock"></i> Medium
            @else
                Medium
            @endif
        </button>

        <!-- Hard Button (disabled by default, enabled after medium_finish) -->
        <button class="difficulty-button" id="hardButton" @if(!$medium_finish) disabled @endif>
            @if(!$medium_finish)
                <i class="fas fa-lock"></i> Hard
            @else
                Hard
            @endif
        </button>
    </div>

    <script>
        // Play click sound on all buttons and anchor tags
        function playClickSound() {
            var clickSound = document.getElementById('clickSound');
            clickSound.play();
        }

        // Attach click sound function to all buttons and links
        document.querySelectorAll('button, a').forEach(item => {
            item.addEventListener('click', playClickSound);
        });

        function startGame(difficulty) {
            console.log('Starting ' + difficulty + ' game');
            // If the player completes the 'easy' game, unlock medium and hard
            if (difficulty === 'easy') {
                completeEasyGame();
            }
        }

        function completeEasyGame() {
            unlockDifficultyLevels();
        }

        function unlockDifficultyLevels() {
            // Enable Medium and Hard buttons after Easy game completion
            document.getElementById('mediumButton').disabled = false;
            document.getElementById('hardButton').disabled = false;

            // Update button text by removing lock icon
            document.getElementById('mediumButton').innerHTML = 'Medium';
            document.getElementById('hardButton').innerHTML = 'Hard';
        }
    </script>

    <!-- Add FontAwesome CDN for lock icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
