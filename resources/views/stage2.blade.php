<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Image Processing Card Game</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Roboto Mono', monospace;
            /* Retained your font */
            color: #00ffcc;
            /* Bright, neon-like text color */
            text-align: center;
            background: linear-gradient(135deg, #141e30, #243b55, #4b79a1, #00c853, #ff007f, #ff4081);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            /* Dynamic background animation */
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 0 30px rgba(255, 255, 255, 0.1);
            /* Subtle depth effect */
        }

        /* Keyframes for gradient animation */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Optional: Glow effect for text */
        h1,
        h2,
        h3,
        p {
            text-shadow: 0 0 20px rgba(0, 255, 204, 0.6), 0 0 30px rgba(0, 255, 204, 0.6);
            /* Neon glow */
        }

        #gameContainer {
            width: 1200px;
            margin: 20px auto;
            /* Centered horizontally */
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: rgba(255, 255, 255, 0.1);
            /* Light translucent background */
            border-radius: 15px;
            /* Rounded corners */
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        #imageDisplay {
            width: 100%;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        #targetImage {
            max-width: 180px;
            max-height: 180px;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        #gameScene {
    width: 90%; /* Make the width responsive */
    max-width: 800px; /* Max width for larger screens */
    height: 300px; /* Fixed height or adjust as needed */
    margin: auto; /* Centers horizontally within flex container */
    border: 2px solid #333;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    backdrop-filter: blur(15px);
    box-sizing: border-box;
    box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2); /* Subtle inner shadow */
}


        .victory {
            transform: scale(1.2) translateY(-30px);
            box-shadow: 0 0 30px #FFD700;
            z-index: 100;
        }

        #stats {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-weight: bold;
        }

        #message {
            text-align: center;
            font-size: 1.2em;
            margin: 10px 0;
            min-height: 30px;
            color: #fff;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.5s;
        }

        .modal h2 {
            color: #4CAF50;
            margin-top: 0;
        }

        .modal button {
            padding: 10px 20px;
            font-size: 16px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s;
        }

        .modal button:hover {
            background: #45a049;
        }

        /* Add this to your existing styles */
        .celebration {
            position: fixed;
            pointer-events: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #f00;
            animation: confetti-fall 3s linear forwards;
        }

        #learning-modal {
            display: none;
            /* Initially hidden */
            position: fixed;
            /* Fixed position */
            z-index: 1;
            /* Ensure modal is on top */
            left: 0;
            /* Align to the left */
            top: 0;
            /* Align to the top */
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: hidden;
            /* Enable scrolling if necessary */
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.9), rgba(30, 30, 30, 0.9));
            /* Dark gradient for a futuristic look */
            backdrop-filter: blur(15px);
            /* Blur effect for background */
            animation: fadeIn 0.5s;
            /* Fade-in animation */
        }

        /* Animation keyframes for fade-in effect */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: rgba(20, 20, 20, 0.95);
            /* Darker, semi-transparent background without white */
            padding: 30px;
            /* Increased padding for better spacing */
            border: none;
            /* Remove default border */
            width: 90%;
            /* Slightly less than full width */
            position: fixed;
            /* Fixed position */
            left: 50%;
            /* Center horizontally */
            transform: translateX(-50%);
            /* Adjust for centering */
            bottom: 5%;
            /* Align to the bottom with some margin */
            border-radius: 15px;
            /* Rounded corners for a modern look */
            box-shadow: 0 8px 30px rgba(0, 255, 204, 0.5);
            /* Subtle glowing shadow for depth */
            color: #00ffcc;
            /* Futuristic text color */
            display: flex;
            /* Flexbox for alignment */
            flex-direction: column;
            /* Column layout */
            align-items: center;
            /* Center items */
            font-size: 1.2em;
            /* Font size */
            text-align: justify;
            /* Justified text alignment */
            overflow-wrap: break-word;
            /* Prevent overflow */
            word-wrap: break-word;
            /* For compatibility */
        }

        .character {
            width: 100px;
            /* Adjust character size */
            margin-right: 20px;
            /* Space between character and text */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        #start-level-btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #start-level-btn:hover {
            background-color: #45a049;
        }

        #game-area {
            display: none;
            /* Initially hide game area */
        }

        #colorContainer {
            display: flex;
            /* Enables flexbox layout */
            justify-content: center;
            /* Centers content horizontally */
            align-items: center;
            /* Centers content vertically */
            height: 300px;
            /* Set the height of the container */
        }

        #colorImage,
        #selectedColorImage {
            width: 300px;
            /* Width of the color display */
            height: 300px;
            /* Height of the color display */
            background-color: rgb(0, 0, 0);
            /* Default background color */
        }

        .modal-overlay-result {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Ensure the modal is above other content */
        }

        .modal {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.5s;
        }

        button {
            background-color: #0f3460;
            /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1a1a2e;
            /* Change color on hover */
        }

        /* Animation for modal appearance */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #level4Content {
            height: auto;
            width: auto;
            padding: 20px;
            text-align: center;
            color: #fff;
        }

        /* Color Container */
        #colorContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px;
            margin-bottom: 20px;
        }

        #colorImage {
            width: 150px;
            height: 150px;
            background-color: rgb(0, 0, 0);
            /* Default black */
            border: 2px solid #4CAF50;
            /* Neon green border */
            margin-right: 20px;
            box-shadow: 0 0 15px rgba(0, 255, 127, 0.7);
            /* Glowing effect */
        }

        #selectedColorImage {
            width: 100px;
            height: 100px;
            border: 2px solid #4CAF50;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
            /* Subtle glow */
        }

        /* Color Sliders */
        .color-sliders {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .slider-group {
            margin: 10px 0;
            width: 400px;
        }

        .slider-group label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="range"] {
            width: 60%;
            margin: 0 15px;
            background-color: #222;
            border-radius: 10px;
            transition: background 0.3s;
        }

        input[type="range"]::-webkit-slider-thumb {
            background: #4CAF50;
            border: 2px solid #fff;
            width: 15px;
            height: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="range"]::-moz-range-thumb {
            background: #4CAF50;
            border: 2px solid #fff;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        #scoreModal {
            display: none;
            /* Hide the modal by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            /* Black background with transparency */
            justify-content: center;
            /* Center modal content horizontally */
            align-items: center;
            /* Center modal content vertically */
        }

        /* Enhanced Submit Button */
        .btn-submit {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            border-radius: 25px;
            transition: background-color 0.3s, box-shadow 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #45a049;
            box-shadow: 0 0 10px rgba(0, 255, 127, 0.7);
        }

        .options label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #postTestContainer {
                width: 90%;
            }

            .question p {
                font-size: 16px;
            }

            .options label {
                font-size: 14px;
            }

            #submitTest {
                font-size: 16px;
                padding: 8px;
            }
        }

        .settings-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .settings-modal {
            background: linear-gradient(135deg, #1a1a1a, #2b2b2b);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        #settingsIcon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            /* Make the icon bigger */
            z-index: 1000;
            /* Ensure it stays on top of other elements */
            padding: 10px;
        }

        /* Optional hover effect */
        #settingsIcon:hover {
            transform: scale(1.1);
        }

        .gameover-modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.8);
            /* Dark background with more opacity */
            justify-content: center;
            /* Center modal content */
            align-items: center;
            /* Center modal content */
        }

        .gameover-modal-content {
            background: linear-gradient(135deg, rgba(0, 0, 50, 0.8), rgba(0, 0, 100, 0.6));
            /* Futuristic gradient */
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            /* Light border with transparency */
            border-radius: 15px;
            /* Rounded corners */
            width: 300px;
            /* Could be more or less, depending on screen size */
            text-align: center;
            /* Center text */
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
            /* Center text */
        }

        .modal-background {
            position: absolute;
            /* Allows positioning relative to modal */
            top: 0;
            /* Align to the top of the modal */
            left: 0;
            /* Align to the left of the modal */
            right: 0;
            /* Stretch to the right */
            bottom: 0;
            /* Stretch to the bottom */
            z-index: -1;
            /* Send the background image behind the modal content */
        }

        .modal-image {
            width: 70%;
            /* Set the width to 70% of the modal */
            height: auto;
            /* Maintain aspect ratio */
            /* opacity: 0.1; Make the image semi-transparent         */
            position: absolute;
            transform: translateY(-50%) scaleX(-1);
            /* Center and flip */
            position: absolute;
            /* Position it absolutely within the modal background */
            top: 70%;
            /* Adjusted to lower the image */
            right: 0%;
            /* Align to the right */
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

</head>

<body>
        <!-- Add these audio elements to your HTML -->
    <audio id="playerAttackSound" src="{{ asset('audio/player-attack.mp3') }}" preload="auto"></audio>
    <audio id="monsterAttackSound" src="{{ asset('audio/monster-attack.mp3') }}" preload="auto"></audio>
    <audio id="backgroundMusic" src="{{ asset('audio/background-music.mp3') }}" loop preload="auto"></audio>
<audio id="intenseFightMusic" src="{{ asset('audio/intense-fight-music.mp3') }}" loop preload="auto"></audio>

    <div id="gameOverModal" class="gameover-modal">
        <div class="gameover-modal-content">
            <h2>GAME OVER!</h2>
            <button id="playAgainButton">Play Again</button>
            <button id="exitGameButton">Exit Game</button>
        </div>
    </div>

    <div class="settings-modal-overlay" id="settingsModal" style="display: none;">
        <div class="settings-modal">
            <h2>Settings</h2>
            <button id="resumeButton">Resume</button>
            <button id="quitGameButton">Quit Game</button>
            <span class="close" onclick="closeSettingsModal()"></span>
        </div>
    </div>


    <audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
    <div id="learning-modal">
            <div class="modal-background">
                <img id="modal-character-image" src="{{ asset('images/characters/player.png') }}" alt="Player" class="modal-image" />
            </div>
            <div class="modal-content">
                <p id="learning-text"></p>
                <button id="skip-monologue-btn">Skip Monologue</button>
                <button id="start-level-btn">Start Level</button>
            </div>
        </div>
    <button id="settingsIcon" class="btn btn-light">
        <i class="bi bi-gear"></i>
    </button>
    <div id="gameContainer">

        <div id="stats">
            <div>Level: <span id="level">1</span></div>
            <div>Player HP: <span id="playerHp">100</span></div>
            <div>Monster HP: <span id="monsterHp">100</span></div>
            <div>Time Left: <span id="countdownTimer">0</span> seconds</div>
            <div id="scoreDisplay">Score: 0</div>
        </div>

        <canvas id="gameScene" width="800" height="300"></canvas>

        <!-- Level 1 Content -->
        <div id="level1Content">
            <div id="imageDisplay">
                <img id="targetImage" src="" alt="Target image">
            </div>
            <div id="message">Find the correct outline!</div>
            <div id="cardsContainer"></div>
        </div>

        <!-- Level 2 Content -->
        <div id="level2Content" style="display: none; text-align: center;">
        </div>
        <div id="level3Content">
        </div>

        <div id="level4Content" style="display: none;">
            <h2>Level 4: Color Identification</h2>
            <p>Use the sliders to select the dominant color in the image below:</p>

            <div id="colorContainer">
                <div id="colorImage"></div>
                <div id="selectedColorImage"></div>
            </div>

            <div class="color-sliders">
                <div class="slider-group">
                    <label for="redSlider">Red</label>
                    <input type="range" id="redSlider" min="0" max="255" value="0">
                    <span id="redValue">0</span>
                </div>
                <div class="slider-group">
                    <label for="greenSlider">Green</label>
                    <input type="range" id="greenSlider" min="0" max="255" value="0">
                    <span id="greenValue">0</span>
                </div>
                <div class="slider-group">
                    <label for="blueSlider">Blue</label>
                    <input type="range" id="blueSlider" min="0" max="255" value="0">
                    <span id="blueValue">0</span>
                </div>
                <button id="submitColor" class="btn-submit">Submit Color</button>
            </div>
        </div>
    </div>

    <div id="celebration"></div>

    <div id="celebration"></div>

    
    </div>

    <div class="modal-overlay" id="level4CompleteModal">
        <div class="modal">
            <h2>Level 4 Complete!</h2>
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Quiz: Feature Extraction Challenge!</p>
            <button onclick="nextstage()">Continue</button>
        </div>
    </div>

    <div id="level5Content" style="display: block;">
    </div>
    </div>
    </div>

    <div class="modal-overlay-result" id="resultsModal" style="display: none;">
        <div class="modal-result">
            <h1>Congratulations! You have completed the Game!</h1>
            <p id="score">Your total score: </p>
            <button onclick="closeModal()">Close</button>
            <button onclick="playAgain()">Play Again</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
let playerGender = '{{ auth()->user()->gender }}'; 
const modalCharacterImage = document.getElementById('modal-character-image');

if (playerGender === 'male') {
    modalCharacterImage.src = "{{ asset('images/characters/playerMale.png') }}";  // Male image
    modalCharacterImage.alt = "Player Male";
} else if (playerGender === 'female') {
    modalCharacterImage.src = "{{ asset('images/characters/playerFemale.png') }}";  // Female image
    modalCharacterImage.alt = "Player Female";
}

        let quizOn = false;

function showGameOverModal() {
            const modal = document.getElementById('gameOverModal');
            modal.style.display = 'flex'; // Show modal with flexbox for centering
            gameOver.play();
            // Set up button event listeners
            document.getElementById('playAgainButton').addEventListener('click', function () {
                window.location.href = "{{ url('stage2') }}"; // Reset the game state (you'll need to implement this)
                modal.style.display = 'none'; // Hide modal
            });

            document.getElementById('exitGameButton').addEventListener('click', function () {
                window.close(); // Close the game window
                // Or you can redirect to a specific URL
                window.location.href = "{{ url('play') }}"; // Redirect to the main page
            });
        }
        $(document).ready(function () {
            // Show settings modal when settings icon is clicked
            $('#settingsIcon').click(function () {
                $('#settingsModal').show();
                if(quizOn === false){
                    pauseTimer();
                }
                
            });

            // Close settings modal
            window.closeSettingsModal = function () {
                $('#settingsModal').hide();
            }

            // Resume button functionality
            $('#resumeButton').click(function () {
                if(quizOn === false){
                    resumeTimer();
                }
                closeSettingsModal(); // Close the modal
                // Additional logic to resume the game can go here
            });

            // Quit game button functionality
            $('#quitGameButton').click(function () {
                window.location.href = "{{ url('play') }}";
            });
        });

        function playClickSound() {
            var clickSound = document.getElementById('clickSound');
            clickSound.play();
        }
        document.querySelectorAll('button, a').forEach(function (element) {
            element.addEventListener('click', playClickSound);
        });
        const gameState = {
            playerHp: 100,
            monsterHp: 100,
            isAttacking: false,
            attackFrame: 0,
            shuffling: false,
            canClick: false,
            playerX: 100,
            playerY: 150,
            monsterX: 600,
            monsterY: 120,
            playerHurt: false,
            monsterHurt: false

        };

        const gameScene = document.getElementById('gameScene');
        const ctx = gameScene.getContext('2d');
        const targetImage = document.getElementById('targetImage');
        const level4Content = document.getElementById('level4Content');
        let intenseFightMusic = document.getElementById("intenseFightMusic");
        intenseFightMusic.volume = 0.2;

        const wrongAnswer = new Audio("{{ asset('audio/wrong-answer.mp3') }}");
        const correctAnswer = new Audio("{{ asset('audio/correct-answer.mp3') }}");
        const levelComplete = new Audio("{{ asset('audio/level-complete.mp3') }}");
        const gameOver = new Audio("{{ asset('audio/game-over.mp3') }}");

        const cardWidth = 150;
        const cardGap = 50;
        const totalWidth = (cardWidth * 3) + (cardGap * 2);
        const startX = (1150 - totalWidth) / 2;


        let timerDuration = 30; // Set duration for the timer (in seconds)
        let timerId;
        let timeLeft; // Variable to hold the remaining time
        let isPaused = false; // Flag to track if the timer is paused
        let score = 0; // Initialize score
        let currentLevel = 1;
        let isStartLevel = false;

        function updateScore(points) {
            gameState.totalScore = (gameState.totalScore || 0) + points;
            document.getElementById('scoreDisplay').textContent = `Score: ${gameState.totalScore}`;
        }

        function startTimer() {
    let elapsedTime = 0; // Track elapsed time in seconds
    document.getElementById('countdownTimer').textContent = elapsedTime;

    timerId = setInterval(() => {
        if (!isPaused) { // Check if the timer is not paused
            elapsedTime++;
            document.getElementById('countdownTimer').textContent = elapsedTime;

            // Optional: Add any specific actions after a certain elapsed time
        }
    }, 1000); // Update every second
}
        function nextstage() {
            window.location.href = "{{ route('storylinestage3') }}";// Set the paused flag to true
        }

        function pauseTimer() {
            intenseFightMusic.pause(); 
            isPaused = false; // Set the paused flag to true
        }

        function resumeTimer() {
            intenseFightMusic.play(); 
            isPaused = true; // Set the paused flag to false
        }

        function endLevel() {
            clearInterval(timerId);
            timeLeft = timerDuration;
            document.getElementById('countdownTimer').textContent = timeLeft;
            // Stop the timer
            // Add your logic to transition to the next level or handle level completion here
        }

        // Call startTimer when the player starts a new level
        function startNewLevel(level) {
            document.getElementById('level').textContent = level;
            startTimer(); // Start the timer for the new level
        }


        function startLevel5() {
            const modal = document.getElementById('level4CompleteModal');
            modal.style.display = 'none';
            gameState.level = 5;
            showLearningMaterial(5);
            updateStats();
            initializeLevel5();
        }


        function initializeGame() {
            intenseFightMusic.play(); 
            // Hide all content first
            gameState.level = 4;
            level1Content.style.display = 'none';
            level2Content.style.display = 'none';
            level3Content.style.display = 'none';
            level4Content.style.display = 'none';
            level5Content.style.display = 'none';

            // Show appropriate level content
            if (gameState.level === 1) {
                level1Content.style.display = 'block';
                initializeLevel1();
            } else if (gameState.level === 2) {
                level2Content.style.display = 'block';
                switchToLevel2();
            } else if (gameState.level === 3) {
                level3Content.style.display = 'block';
                initializeLevel3();
            } else if (gameState.level === 4) {
                level4Content.style.display = 'block';
                initializeLevel4(); 
            }

            currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
                        draw();
        }

        function enableSkipLevelHotkey() {
    document.addEventListener('keydown', (event) => {
        // Check if Shift + L is pressed
        if (event.shiftKey && event.key === 'L') {
            skipLevel();
        }
    });
}

        function createConfetti() {
            const celebration = document.getElementById('celebration');
            celebration.innerHTML = '';

            const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];

            for (let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDelay = Math.random() * 2 + 's';
                celebration.appendChild(confetti);
            }

            setTimeout(() => {
                celebration.innerHTML = '';
            }, 5000);
        }

        function showLevel4CompleteModal() {
            intenseFightMusic.pause();
            levelComplete.play();
            pauseTimer();
            const modal = document.getElementById('level4CompleteModal');
            modal.style.display = 'flex';
            createConfetti();
        }

        function initializeLevel4() {
    intenseFightMusic.play(); // Start playing the intense fight music
    const level4Content = document.getElementById('level4Content');
    level1Content.style.display = 'none';
    level2Content.style.display = 'none';
    level3Content.style.display = 'none';
    level4Content.style.display = 'block';

    // Reset the monster's HP to 100 at the start of Level 4
    gameState.monsterHp = 100;
    updateStats();

    // Start the timer for Level 4
    startNewLevel(4);

    const colorImage = document.getElementById('colorImage');
    const submitColorButton = document.getElementById('submitColor');

    // Function to generate and set a new random color
    function generateNewColor() {
        const randomRed = Math.floor(Math.random() * 256);
        const randomGreen = Math.floor(Math.random() * 256);
        const randomBlue = Math.floor(Math.random() * 256);
        const randomColor = `rgb(${randomRed}, ${randomGreen}, ${randomBlue})`;

        // Set the random color to the color image
        colorImage.style.backgroundColor = randomColor;

        // Save the generated RGB values to the game state for comparison
        gameState.randomColor = { r: randomRed, g: randomGreen, b: randomBlue };

        console.log(`New color generated: ${randomColor}`); // Debugging log
    }

    // Initialize with the first random color
    generateNewColor();

    // Update the displayed values of the sliders in real-time and update the selected color image
    document.getElementById('redSlider').addEventListener('input', updateSelectedColor);
    document.getElementById('greenSlider').addEventListener('input', updateSelectedColor);
    document.getElementById('blueSlider').addEventListener('input', updateSelectedColor);

    function updateSelectedColor() {
        const red = parseInt(document.getElementById('redSlider').value);
        const green = parseInt(document.getElementById('greenSlider').value);
        const blue = parseInt(document.getElementById('blueSlider').value);

        const selectedColor = `rgb(${red}, ${green}, ${blue})`;

        // Update the background color of the selected color image
        const selectedColorImage = document.getElementById('selectedColorImage');
        selectedColorImage.style.backgroundColor = selectedColor;

        // Update the displayed RGB values
        document.getElementById('redValue').textContent = red;
        document.getElementById('greenValue').textContent = green;
        document.getElementById('blueValue').textContent = blue;
    }

    // Add the event listener for color submission
    submitColorButton.addEventListener('click', () => {
        const red = parseInt(document.getElementById('redSlider').value);
        const green = parseInt(document.getElementById('greenSlider').value);
        const blue = parseInt(document.getElementById('blueSlider').value);

        const selectedRGB = { r: red, g: green, b: blue };

        // Check if the selected color is (0, 0, 0) for an automatic pass
        const isAutoCorrect = selectedRGB.r === 0 && selectedRGB.g === 0 && selectedRGB.b === 0;

        // Set a tolerance level for other colors
        const tolerance = 50;

        // Check if the selected color is within the tolerance range
        const isCorrect =
            Math.abs(selectedRGB.r - gameState.randomColor.r) <= tolerance &&
            Math.abs(selectedRGB.g - gameState.randomColor.g) <= tolerance &&
            Math.abs(selectedRGB.b - gameState.randomColor.b) <= tolerance;

        // If the guess is either the automatic pass or within tolerance
        if (isAutoCorrect || isCorrect) {
            correctAnswer.play();
            attackMonster(25); // Reduce monster's HP by 25 on a correct guess
            updateScore(15); // Add points for a correct match
            document.getElementById('message').textContent = "Correct! You've matched the color!";

            // Check if monster's HP reaches 0 to complete the level
            if (gameState.monsterHp <= 0) {
                levelComplete.play();
                document.getElementById('message').textContent = "You've defeated the monster! Level Complete!";
                // Progress to the next level or show level complete modal
                showLevel4CompleteModal();
                gameState.level++; // Progress to the next level
            } else {
                generateNewColor(); // Generate a new color for the next round
            }
        } else {
            wrongAnswer.play();
            document.getElementById('message').textContent = "Incorrect color! Try again!";
            takeDamage(); // Handle incorrect color guess (player damage or penalty)
            monsterAttack();
        }
    });
}



        function showModal(score) {
            document.getElementById('score').textContent = "Your total score: " + score; // Set the score
            document.getElementById('resultsModal').style.display = 'flex'; // Show modal
        }

        function closeModal() {
            document.getElementById('resultsModal').style.display = 'none';
            window.location.href = "{{ route('play') }}"; // Hide modal
        }

        function playAgain() {
            window.location.href = "{{ route('stage2') }}"; // Redirect to medium.blade.php
        }

        function attackMonster(damage) {
            gameState.isAttacking = true;
            gameState.attackFrame = 0;
            gameState.monsterHp = Math.max(0, gameState.monsterHp - damage);

            if (gameState.monsterHp == 100) {
                levelComplete.play();
                if (gameState.level === 1) {
                    showLevel1CompleteModal();
                } else if (gameState.level === 2) {
                    showLevel2CompleteModal();
                } else if (gameState.level === 3) {
                    showLevel3CompleteModal();
                } else if (gameState.level === 4) {
                    showLevel4CompleteModal();
                } else if (gameState.level === 5) {
                    showLevel5CompleteModal();
                    alert("Congratulations! You've completed all levels!");
                    resetGame();
                }
            }
            if (!gameState.isPlayerAttacking && !gameState.isMonsterAttacking) {
                gameState.isPlayerAttacking = true;
                gameState.attackFrame = 0;
                animateAttack('player');
            }
            updateStats();
        }

        function takeDamage() {
            gameState.playerHp = Math.max(0, gameState.playerHp - 25);
            updateStats();

            if (gameState.playerHp <= 0) {
                setTimeout(() => {
                    showGameOverModal();
                    resetGame();
                }, 500);
            }
        }

        const learningMaterials = {
    1: [
        "Monster: So, you dare to challenge me? Let’s see if you’re up to the task!",
        "Player: Bring it on, monster! I’ve trained for this—your tricks won’t fool me.",
        "Monster: We’ll see about that. I’ve hidden the perfect color match. Can you find it?",
        "Player: Oh, I’m not just finding it—I’m nailing it. Watch and learn!",
        "Monster: Bold words, human. Let’s see if your skills are as sharp as your tongue!"
  ]
    
};

let currentMonologueIndex = 0;
let monologueInterval;
let availableVoices = [];

// Function to display monologues one by one for a given level
function showMonologuesInSequence(level, delay = 10000) {
    const monologues = learningMaterials[level];
    const monologueElement = document.getElementById("learning-text");
    const startButton = document.getElementById("start-level-btn");

    // Reset the index and initial monologue
    currentMonologueIndex = 0;
    monologueElement.innerText = monologues[currentMonologueIndex];
    document.getElementById("learning-modal").style.display = "block"; // Show modal
    startButton.style.display = "none"; // Hide start button initially

    // Speak the first monologue with a slight delay
    setTimeout(() => speakText(monologues[currentMonologueIndex]), 500);

    // Display each monologue with a delay
    monologueInterval = setInterval(() => {
        currentMonologueIndex++;
        if (currentMonologueIndex < monologues.length) {
            monologueElement.innerText = monologues[currentMonologueIndex];
            speakText(monologues[currentMonologueIndex]); // Speak each new monologue
        } else {
            clearInterval(monologueInterval); // Stop interval when done
            startButton.style.display = "block"; // Show the start button
        }
    }, delay);
}

// Text-to-Speech function with voice selection by index or name
function speakText(text) {
    const utterance = new SpeechSynthesisUtterance(text);

    // Fetch available voices
    availableVoices = window.speechSynthesis.getVoices();

    // Select a specific voice by index or name
    const selectedVoiceName = "Google UK English Female";
    const selectedVoice = availableVoices.find(voice => voice.name === selectedVoiceName);

    if (selectedVoice) {
        utterance.voice = selectedVoice;
    } else if (availableVoices.length > 0) {
        utterance.voice = availableVoices[0]; // Default to first available voice
    }

    utterance.rate = 1; // Adjust the speech rate if necessary
    window.speechSynthesis.speak(utterance);
}

// Ensure the game doesn't start before learning materials are shown
window.onload = function () {
    // Load available voices asynchronously
    window.speechSynthesis.onvoiceschanged = function() {
        availableVoices = window.speechSynthesis.getVoices();
        if (availableVoices.length === 0) {
            console.error("No voices found. Speech synthesis may not work.");
        } else {
            console.log("Voices loaded successfully.");
        }
        showMonologuesInSequence(1); // Automatically start the monologues for level 1
    };
};

// Function to start the game when the button is clicked
document.getElementById("start-level-btn").onclick = function () {
    clearInterval(monologueInterval); // Stop any remaining intervals
    document.getElementById("learning-modal").style.display = "none"; // Hide modal
    document.getElementById("start-level-btn").style.display = "none"; // Hide the start button for next time
    resumeTimer(); // Resume the game timer
    startLevel(currentLevel); // Start the level
    gameState.monsterHp = 100; // Reset monster's health
    startTimer(); // Start the level timer
    updateStats(); // Update game stats
};

function showMonologuesInSequence(level, delay = 10000) {
                endLevel();
                const monologues = learningMaterials[level];
                const monologueElement = document.getElementById("learning-text");
                const startButton = document.getElementById("start-level-btn");
                const skipButton = document.getElementById("skip-monologue-btn");

                
                currentMonologueIndex = 0;
                monologueElement.innerText = monologues[currentMonologueIndex];
                document.getElementById("learning-modal").style.display = "block";
                startButton.style.display = "none";
                skipButton.style.display = "inline-block";

                
                setTimeout(() => speakText(monologues[currentMonologueIndex]), 500);

                
                monologueInterval = setInterval(() => {
                    currentMonologueIndex++;
                    if (currentMonologueIndex < monologues.length) {
                        monologueElement.innerText = monologues[currentMonologueIndex];
                        speakText(monologues[currentMonologueIndex]); 
                    } else {
                        clearInterval(monologueInterval); 
                        startButton.style.display = "block"; 
                        skipButton.style.display = "none"; 
                    }
                }, delay);

                // Add a click event listener to the skip button
                skipButton.onclick = function () {

        window.speechSynthesis.cancel(); 
        clearInterval(monologueInterval); 
        document.getElementById("learning-modal").style.display = "none";
        skipButton.style.display = "none"; 
        resumeTimer(); 
        startLevel(currentLevel);
        gameState.monsterHp = 100; 
        startTimer();
        updateStats(); 
        };
        }

function startLevel(level) {
console.log("Starting level:", level);
}

        function resetGame() {
            gameState.level = 1;
            gameState.playerHp = 100;
            gameState.monsterHp = 100;
            gameState.level3.matchedFeatures = new Set(); // Reset level 3 progress
            updateStats();

            // Hide all level content
            level1Content.style.display = 'none';
            level2Content.style.display = 'none';
            level3Content.style.display = 'none';
            level4Content.style.display = 'none';

            // Reset modals
            document.getElementById('levelCompleteModal').style.display = 'none';
            document.getElementById('level2CompleteModal').style.display = 'none';

            document.getElementById('message').textContent = "Game reset! Watch the cards carefully!";
            initializeGame();
        }

        function updateStats() {
            document.getElementById('level').textContent = gameState.level;
            document.getElementById('playerHp').textContent = gameState.playerHp;
            document.getElementById('monsterHp').textContent = gameState.monsterHp;
        }

        let playerImage = new Image();

// Initialize the player image based on the gender
fetch('/get-game-state') // Example API to fetch user state, assuming it returns the gender
    .then(response => response.json())
    .then(data => {
        if (data.playerGender === 'male') {
            playerImage.src = 'images/characters/playerMale.png';
        } else if (data.playerGender === 'female') {
            playerImage.src = 'images/characters/playerFemale.png';
        } else {
            playerImage.src = 'images/characters/defaultPlayer.png'; // Fallback image
        }
    })
    .catch(error => console.error('Error fetching game state:', error));

// Event listener to ensure player image is loaded before drawing
playerImage.onload = function() {
    console.log("Player image loaded successfully.");
}; // Replace with the correct path

        const monsterImages = [
            'images/characters/medium/monster1.png', // Replace with correct paths
            'images/characters/medium/monster2.png',
            'images/characters/medium/monster3.png',
            'images/characters/medium/monster4.png', // Replace with correct paths
            'images/characters/medium/monster5.png',
        ];

        const backgroundImage = new Image();
        backgroundImage.src = 'images/background2.png';

        let currentMonsterImage = new Image();
        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];

        class RainParticle {
    constructor(x, y) {
        this.x = x; // Initial x position
        this.y = y; // Initial y position
        this.size = Math.random() * 1 + 1; // Smaller size for rain drops (1 to 2)
        this.length = Math.random() * 10 + 10; // Length of rain drop (10 to 20)
        this.speed = Math.random() * 5 + 4; // Speed of rain (4 to 9)
    }

    update() {
        this.y += this.speed; // Move particle downwards
        // Reset particle position to the top when it moves off screen
        if (this.y > gameScene.height) {
            this.y = 0; // Reappear from the top
            this.x = Math.random() * gameScene.width; // Random horizontal position
        }
    }

    draw(ctx) {
        ctx.strokeStyle = 'rgba(173, 216, 230, 0.6)'; // Light blue color with some transparency
        ctx.lineWidth = 1; // Thin rain drop line
        ctx.beginPath();
        ctx.moveTo(this.x, this.y);
        ctx.lineTo(this.x, this.y - this.length); // Draw a line to represent the rain drop
        ctx.stroke();
    }
}

// Array to hold rain particles
let rainParticles = [];

// Function to initialize rain particles
function initRain() {
    for (let i = 0; i < 100; i++) { // Create 100 rain particles initially
        let x = Math.random() * gameScene.width; // Random initial x position
        let y = Math.random() * gameScene.height; // Random initial y position
        rainParticles.push(new RainParticle(x, y));
    }
}

// Update and draw rain particles
function drawRain(ctx) {
    rainParticles.forEach(particle => {
        particle.update(); // Update position
        particle.draw(ctx); // Draw particle
    });
}
function draw() {
    // Clear the game scene
    ctx.clearRect(0, 0, gameScene.width, gameScene.height);

    // Swaying effect for the background
    const swayOffset = 5 * Math.sin(Date.now() / 1000); // Adjust sway speed and distance
    ctx.drawImage(backgroundImage, swayOffset, 0, gameScene.width, gameScene.height);

    // Draw sand particles in the background
    drawRain(ctx);

    // Calculate breathing effect for the player and monster
    const breathingScale = 1 + 0.02 * Math.sin(Date.now() / 300); // Adjust scale and speed as needed

    // Shadow for player
    ctx.fillStyle = 'rgba(0, 0, 0, 0.3)'; // Dark gray with transparency
    ctx.beginPath();
    ctx.ellipse(gameState.playerX + 60, gameState.playerY + 113, 30, 3, 0, 0, 2 * Math.PI); // Simple ellipse shadow
    ctx.fill();

    // Draw player with breathing effect
    if (playerImage.complete) {
        // Draw player with breathing effect
        const playerWidth = 120 * breathingScale;
        const playerHeight = 120 * breathingScale;
        ctx.drawImage(
            playerImage,
            gameState.playerX - (playerWidth - 120) / 2, // Center breathing effect
            gameState.playerY - (playerHeight - 120) / 2,
            playerWidth,
            playerHeight
        );
    } else {
        console.error("Player image is not loaded yet.");
    }

    // Shadow for monster
    ctx.fillStyle = 'rgba(0, 0, 0, 0.3)'; // Dark gray with transparency
    ctx.beginPath();
    ctx.ellipse(gameState.monsterX + 80, gameState.monsterY + 160, 20, 7, 0, 0, 2 * Math.PI); // Smaller ellipse shadow
    ctx.fill();

    // Draw monster with breathing effect
    const monsterWidth = 150 * breathingScale;
    const monsterHeight = 150 * breathingScale;
    ctx.drawImage(
        currentMonsterImage,
        gameState.monsterX - (monsterWidth - 150) / 2,
        gameState.monsterY - (monsterHeight - 150) / 2,
        monsterWidth,
        monsterHeight
    );

    // If the player is hurt, overlay a red tint
    if (gameState.playerHurt) {
        ctx.fillStyle = 'rgba(255, 153, 153, 0.5)';
        ctx.fillRect(gameState.playerX, gameState.playerY, 120, 120);
    }

    // If the monster is hurt, overlay a red tint
    if (gameState.monsterHurt) {
        ctx.fillStyle = 'rgba(255, 0, 0, 0.5)';
        ctx.fillRect(gameState.monsterX, gameState.monsterY, 150, 150);
    }

    // Check for player or monster attack
    if (gameState.isPlayerAttacking || gameState.isMonsterAttacking) {
        // Play sound effects when attacking
        if (gameState.isPlayerAttacking) {
            let playerAttackSound = document.getElementById("playerAttackSound");
            if (playerAttackSound.paused) {
                playerAttackSound.play();
            }
        }

        if (gameState.isMonsterAttacking) {
            let monsterAttackSound = document.getElementById("monsterAttackSound");
            if (monsterAttackSound.paused) {
                monsterAttackSound.play();
            }
        }

        // Draw attack line
        ctx.beginPath();
        ctx.moveTo(gameState.playerX + 60, gameState.playerY + 40);
        ctx.lineTo(gameState.monsterX, gameState.monsterY + 50);

        // Draw blood splash
        if (gameState.bloodSplash) {
            const numberOfDroplets = 10;
            for (let i = 0; i < numberOfDroplets; i++) {
                const dropletX = gameState.bloodSplash.x + (Math.random() - 0.5) * 60;
                const dropletY = gameState.bloodSplash.y + (Math.random() - 0.5) * 60;
                const dropletRadius = Math.random() * 10 + 5;

                const gradient = ctx.createRadialGradient(dropletX, dropletY, dropletRadius / 4, dropletX, dropletY, dropletRadius);
                gradient.addColorStop(0, 'rgba(255, 0, 0, 0.9)');
                gradient.addColorStop(1, 'rgba(139, 0, 0, 0.6)');

                ctx.globalAlpha = gameState.bloodSplash.opacity;
                ctx.fillStyle = gradient;
                ctx.beginPath();
                ctx.arc(dropletX, dropletY, dropletRadius, 0, 2 * Math.PI);
                ctx.fill();
            }
            ctx.globalAlpha = 1;
        }

        // Draw damage text
        if (gameState.damageText) {
            ctx.globalAlpha = gameState.damageText.opacity;
            ctx.fillStyle = '#FF0000';
            ctx.font = 'bold 24px Arial';
            ctx.fillText(25, gameState.damageText.x, gameState.damageText.y);
            ctx.globalAlpha = 1;
        }
    }

    requestAnimationFrame(draw);
}

// Initialize particles on game start
initRain();

    function animateAttack(attacker, damage) {
    const attackDuration = 30; // Number of frames for the attack animation
    const moveDistance = 400; // Distance to move
    const frameRate = 60; // Assuming 60 FPS
    const bloodSplashDuration = 10; // Frames for blood splash
    const damageTextDuration = 60; // Frames for damage text to fade out

    // Variables to track blood splash and damage text animation
    let bloodSplashOpacity = 1;
    let damageTextOpacity = 1;
    let damageTextY = 0;

    function animate() {
        gameState.attackFrame++;

    if (gameState.attackFrame <= attackDuration / 2) {
        // Move towards the target
        if (attacker === 'player') {
            gameState.playerX += moveDistance / (attackDuration / 2);
        } else {
            gameState.monsterX -= moveDistance / (attackDuration / 2);
        }
    } else if (gameState.attackFrame === Math.floor(attackDuration / 2) + 1) {
        // Hit the target and trigger blood splash and damage text
        if (attacker === 'player') {
            gameState.monsterHurt = true;
            gameState.bloodSplash = {
                x: gameState.monsterX + 50, // Adjust this position to ensure it aligns with the monster's body
                y: gameState.monsterY + 30, // Adjust Y as needed
                opacity: 1
            };
            gameState.damageText = {
                text: `-${damage}`,
                x: gameState.monsterX + 50, // Ensure the text is positioned centrally
                y: gameState.monsterY - 50,
                opacity: 1
            };
        } else {
            gameState.playerHurt = true;
            gameState.bloodSplash = {
                x: gameState.playerX + 50, // Adjust this position to align with the player's body
                y: gameState.playerY + 30,
                opacity: 1
            };
            gameState.damageText = {
                text: `-${damage}`,
                x: gameState.playerX + 50,
                y: gameState.playerY - 50,
                opacity: 1
            };
        }
        updateStats();
    } else if (gameState.attackFrame <= attackDuration) {
        // Move back to original position
        if (attacker === 'player') {
            gameState.playerX -= moveDistance / (attackDuration / 2);
        } else {
            gameState.monsterX += moveDistance / (attackDuration / 2);
        }
    }

    // Animate blood splash (fade out)
    if (gameState.attackFrame > Math.floor(attackDuration / 2)) {
        if (gameState.bloodSplash) {
            gameState.bloodSplash.opacity -= 1 / bloodSplashDuration;
            if (gameState.bloodSplash.opacity <= 0) {
                gameState.bloodSplash = null; // Remove blood splash
            }
        }

        // Animate floating damage text (move up and fade out)
        if (gameState.damageText) {
            gameState.damageText.opacity -= 1 / damageTextDuration;
            gameState.damageText.y -= 2; // Move damage text upwards
            if (gameState.damageText.opacity <= 0) {
                gameState.damageText = null; // Remove damage text
            }
        }
    }

    // End of animation
    if (gameState.attackFrame >= attackDuration) {
        if (attacker === 'player') {
            gameState.isPlayerAttacking = false;
            gameState.monsterHurt = false;
            gameState.playerX = 100; // Reset to initial position
        } else {
            gameState.isMonsterAttacking = false;
            gameState.playerHurt = false;
            gameState.monsterX = 600; // Reset to initial position
        }
        return;
    }

    // Continue the animation
    requestAnimationFrame(animate);
}

// Call the animation to start it
animate();
}

        function monsterAttack() {
            if (!gameState.isPlayerAttacking && !gameState.isMonsterAttacking) {
                gameState.isMonsterAttacking = true;
                gameState.attackFrame = 0;
                animateAttack('monster');
            }
        }

        // Start the game
        draw();
        initializeGame();

    </script>
</body>

</html>