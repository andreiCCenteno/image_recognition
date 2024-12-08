<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post-Prediction Analysis Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .game-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: transparent;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .level {
            margin-bottom: 30px;
        }

        table {
            margin: 20px 0;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
        }

        input {
            padding: 5px;
            margin: 10px 0;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            font-size: 1.2em;
            font-weight: bold;
        }

        .bbox {
            display: inline-block;
            padding: 5px;
            margin: 5px;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
        }

        .formula {
            font-style: italic;
            color: #333;
        }

        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

        body,html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Roboto Mono', monospace;
            color: #00ffcc;
            text-align: center;
            background: linear-gradient(135deg, #141e30, #243b55, #4b79a1, #00c853, #ff007f, #ff4081);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 0 30px rgba(255, 255, 255, 0.1);
        }

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

        h1,h2,h3,p {
            text-shadow: 0 0 20px rgba(0, 255, 204, 0.6), 0 0 30px rgba(0, 255, 204, 0.6);
        }

        #gameContainer {
            width: 1800px;
            height: auto;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
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

        .modal-content {
            background: rgba(20, 20, 20, 0.95);
            padding: 30px;
            border: none;
            width: 90%;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 5%;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 255, 204, 0.5);
            color: #00ffcc;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 1.2em;
            text-align: justify;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .character {
            width: 100px;
            margin-right: 20px;
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
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1a1a2e;
        }

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
    /* Overlay for the settings modal (background shade) */
    .settings-modal-overlay {
            position: fixed; /* Fix position to cover the entire screen */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            display: flex; /* Using flexbox to center the modal */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            z-index: 1000; /* Ensure the modal is on top */
        }

        /* Modal container */
        .settings-modal {
            background: linear-gradient(135deg, #1a1a1a, #2b2b2b); /* Gradient background */
            color: white; /* Text color */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px; /* Set fixed width for the modal */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Shadow effect */
            position: relative; /* For the close button positioning */
        }

        /* Close button inside the modal */
        .settings-modal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: white;
            cursor: pointer;
            background: transparent;
            border: none;
        }

        /* Hover effect for the close button */
        .settings-modal .close:hover {
            color: #ff0000; /* Red color on hover */
        }

        /* Buttons inside the modal */
        .settings-modal button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            background-color: #007bff; /* Button background */
            color: white; /* Button text color */
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Hover effect on the buttons */
        .settings-modal button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        #settingsIcon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            z-index: 1000;
            padding: 10px;
        }

        #settingsIcon:hover {
            transform: scale(1.1);
        }

        .gameover-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .gameover-modal-content {
            background: linear-gradient(135deg, rgba(0, 0, 50, 0.8), rgba(0, 0, 100, 0.6));
            margin: 15% auto;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 15px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
        }

        .modal-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }

        .modal-image {
            width: 70%;
            height: auto;
            position: absolute;
            transform: translateY(-50%) scaleX(-1);
            position: absolute;
            top: 70%;
            right: 0%;
        }

        #scoreModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

            /* Settings Button Styling */
            .settings-button {
            font-size: 24px; /* Larger font size for the icon */
            width: 60px; /* Increased width */
            height: 60px; /* Increased height */
            border-radius: 50%; /* Circular button */
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add some shadow for a 3D effect */
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .settings-button i {
            font-size: 28px; /* Adjust the gear icon size */
        }

        /* Hover Effect */
        .settings-button:hover {
            transform: scale(1.1); /* Slightly enlarge on hover */
            background-color: #e0e0e0; /* Change background color on hover */
        }

        /* Focus Effect */
        .settings-button:focus {
            outline: none;
            box-shadow: 0 0 0 3px #007bff; /* Add focus ring */
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
</head>
<body>
<!-- Settings Button -->
<button id="settingsIcon" class="btn btn-light settings-button" onclick="openSettingsModal()" aria-label="Settings">
    <i class="bi bi-gear"></i>
</button>

<!-- Settings Modal -->
<div class="settings-modal-overlay" id="settingsModal" style="display: none;">
    <div class="settings-modal">
        <h2>Settings</h2>
        <button id="resumeButton" onclick="resumeGame()">Resume</button>
        <button id="quitGameButton" onclick="quitGame()">Quit Game</button>
        <span class="close" onclick="closeSettingsModal()">✖️</span>
    </div>
</div>
<div id="introModal">
    <div class="modal-content">
      <h2>Welcome to Post-Prediction Analysis in Image Recognition!</h2>
      <p>Welcome, players! Today, we’ll explore the concept of <strong>post-prediction analysis</strong> in image recognition, a critical step in evaluating and refining the performance of recognition models.</p>
      <p>In image recognition, once a prediction is made, it’s important to assess how well the model performed. <strong>Post-prediction analysis</strong> involves evaluating the outcomes of the model’s predictions, understanding any errors, and refining the model's performance to improve accuracy.</p>
      <p>This analysis can include reviewing false positives, false negatives, and the confidence levels of predictions, as well as adjusting the model based on this feedback. The goal is to identify patterns in prediction errors and optimize the model to be more accurate in future predictions.</p>
      <p>In this game, you’ll perform post-prediction analysis on a set of image recognition results. Your task will be to assess the predictions, identify any mistakes, and understand how to refine the model's performance for better accuracy in recognizing objects, textures, and patterns.</p>
      <p>By the end of this game, you’ll have a deeper understanding of how post-prediction analysis contributes to improving the effectiveness of image recognition systems, ensuring that they are more reliable and efficient in real-world applications.</p>
      <button onclick="startGame()">Start Game</button>
    </div>
</div>

    <div class="game-container">
      <div id="stats">
        <div>Player HP: <span id="playerHp">100</span></div>
        <div>Monster HP: <span id="monsterHp">100</span></div>
        <div>Time :<span id="timeElapsed"> 0</span> seconds</div>
        <div id="scoreDisplay">Score: 0</div>
      </div>
      <canvas id="gameScene" width="800" height="300"></canvas>
        <h1>Post-Prediction Analysis</h1>

        <!-- Level 1: Confusion Matrix Quiz -->
        <div id="confusion-matrix-level" class="level">
            <h2>Level 1: Calculate Precision, Recall, F1-Score</h2>
            <p>Confusion Matrix:</p>
            <table id="confusion-matrix">
                <tr>
                    <td>True Positives (TP): <span id="tp"></span></td>
                    <td>False Positives (FP): <span id="fp"></span></td>
                </tr>
                <tr>
                    <td>False Negatives (FN): <span id="fn"></span></td>
                    <td>True Negatives (TN): <span id="tn"></span></td>
                </tr>
            </table>
            <div>
                <p><strong>Formulas:</strong></p>
                <p class="formula">Precision = TP / (TP + FP)</p>
                <p class="formula">Recall = TP / (TP + FN)</p>
                <p class="formula">F1-Score = 2 * (Precision * Recall) / (Precision + Recall)</p>
            </div>
            <label for="precision">Precision:</label>
            <input type="number" id="precision" placeholder="Enter Precision" />
            <label for="recall">Recall:</label>
            <input type="number" id="recall" placeholder="Enter Recall" />
            <label for="f1score">F1-Score:</label>
            <input type="number" id="f1score" placeholder="Enter F1-Score" />
            <button onclick="checkConfusionMatrixAnswers()">Submit Answers</button>
        </div>

        <!-- Level 2: IoU Quiz -->
        <div id="iou-level" class="level" style="display:none;">
            <h2>Level 2: Calculate IoU (Intersection over Union)</h2>
            <p>Bounding Box 1 (Ground Truth):</p>
            <div id="bbox1" class="bbox"></div>
            <p>Bounding Box 2 (Predicted):</p>
            <div id="bbox2" class="bbox"></div>
            <p>Calculate IoU (Intersection over Union):</p>
            <input type="number" id="iou" placeholder="Enter IoU" />
            <button onclick="checkIoUAnswer()">Submit IoU</button>
        </div>

        <div id="result" class="result"></div>
    </div>
 </div>
    <script>
        let gameState = {
            playerHp: 100,
            monsterHp: 100,
            isAttacking: false,
            attackFrame: 0,
            shuffling: false,
            canClick: false,
    
            playerX: 100,
            playerY: 150,
            monsterX: 550,
            monsterY: 185,
            playerHurt: false,
            monsterHurt: false

        };
        let timeElapsed = 0;
        const timeSpan = document.getElementById("timeElapsed");

        function startGame() {
      document.getElementById('introModal').style.display = 'none'; // Hide intro modal
      loadTask(); // Start the first task
    }

        // Function to update the timer
        function startTimer() {
            setInterval(function() {
                timeElapsed++;
                timeSpan.textContent = timeElapsed;
            }, 1000); // Update every second (1000 milliseconds)
        }

        const gameScene = document.getElementById('gameScene');
        const ctx = gameScene.getContext('2d');
        // Randomize confusion matrix values
        function generateRandomValues() {
            const tp = Math.floor(Math.random() * 100);
            const fp = Math.floor(Math.random() * 50);
            const fn = Math.floor(Math.random() * 30);
            const tn = Math.floor(Math.random() * 80);

            document.getElementById("tp").textContent = tp;
            document.getElementById("fp").textContent = fp;
            document.getElementById("fn").textContent = fn;
            document.getElementById("tn").textContent = tn;

            return { tp, fp, fn, tn };
        }

        // Function to check confusion matrix answers (Precision, Recall, F1-Score)
        function checkConfusionMatrixAnswers() {
            const { tp, fp, fn } = generateRandomValues(); // Generate random values again
            const tn = Math.floor(Math.random() * 80); // Random TN

            const precisionInput = parseFloat(document.getElementById("precision").value);
            const recallInput = parseFloat(document.getElementById("recall").value);
            const f1scoreInput = parseFloat(document.getElementById("f1score").value);

            // Calculate the correct values
            const correctPrecision = tp / (tp + fp);
            const correctRecall = tp / (tp + fn);
            const correctF1 = 2 * (correctPrecision * correctRecall) / (correctPrecision + correctRecall);

            // Check answers
            const precisionCorrect = Math.abs(precisionInput - correctPrecision) < 0.01;
            const recallCorrect = Math.abs(recallInput - correctRecall) < 0.01;
            const f1scoreCorrect = Math.abs(f1scoreInput - correctF1) < 0.01;

            let resultMessage = "Results: ";
            if (precisionCorrect && recallCorrect && f1scoreCorrect) {
                resultMessage = "Correct! You've mastered the confusion matrix analysis.";
                document.getElementById("iou-level").style.display = "block";
                document.getElementById("confusion-matrix-level").style.display = "none";
            } else {
                resultMessage = "Incorrect, please try again. Precision, Recall, and F1-Score need to be calculated properly.";
            }

            document.getElementById("result").innerHTML = resultMessage;
        }

        // Function to calculate and check IoU
        function checkIoUAnswer() {
            const bbox1 = [0, 0, 100, 100]; // Ground truth box
            const bbox2 = [50, 50, 150, 150]; // Predicted box

            // Calculate the intersection area
            const x1 = Math.max(bbox1[0], bbox2[0]);
            const y1 = Math.max(bbox1[1], bbox2[1]);
            const x2 = Math.min(bbox1[2], bbox2[2]);
            const y2 = Math.min(bbox1[3], bbox2[3]);

            const intersectionArea = Math.max(0, x2 - x1) * Math.max(0, y2 - y1);
            const bbox1Area = (bbox1[2] - bbox1[0]) * (bbox1[3] - bbox1[1]);
            const bbox2Area = (bbox2[2] - bbox2[0]) * (bbox2[3] - bbox2[1]);

            // Calculate IoU
            const unionArea = bbox1Area + bbox2Area - intersectionArea;
            const iou = intersectionArea / unionArea;

            const iouInput = parseFloat(document.getElementById("iou").value);

            // Check if IoU is correct
            if (Math.abs(iouInput - iou) < 0.01) {
                document.getElementById("result").innerHTML = "Correct! You've mastered the IoU calculation.";
            } else {
                document.getElementById("result").innerHTML = "Incorrect, please try again. IoU should be calculated as Intersection / Union.";
            }
        }

        // Initialize the game by generating random values
        generateRandomValues();
        function updateStats() {
            document.getElementById('level').textContent = gameState.level;
            document.getElementById('playerHp').textContent = gameState.playerHp;
            document.getElementById('monsterHp').textContent = gameState.monsterHp;
        }

        const playerImage = new Image();
        playerImage.src = 'images/characters/player.png'; // Replace with the correct path

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
    const playerWidth = 120 * breathingScale;
    const playerHeight = 120 * breathingScale;
    ctx.drawImage(
        playerImage,
        gameState.playerX - (playerWidth - 120) / 2, // Center breathing effect
        gameState.playerY - (playerHeight - 120) / 2,
        playerWidth,
        playerHeight
    );

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
// Settings Functionality
function openSettingsModal() {
    const settingsModal = document.getElementById('settingsModal');
    settingsModal.style.display = 'flex'; // Show the settings modal

    if (typeof quizOn !== 'undefined' && quizOn === false) {
        pauseTimer(); // Pause the timer if the quiz is ongoing
    }
}

function closeSettingsModal() {
    const settingsModal = document.getElementById('settingsModal');
    settingsModal.style.display = 'none'; // Hide the settings modal
}

function resumeGame() {
    closeSettingsModal(); // Close the settings modal

    if (typeof quizOn !== 'undefined' && quizOn === false) {
        resumeTimer(); // Resume the timer if paused
    }
}

function quitGame() {
    window.location.href = "{{ url('play') }}"; // Redirect to the main menu
}

        // Start the game
        draw();
    </script>
</body>
</html>