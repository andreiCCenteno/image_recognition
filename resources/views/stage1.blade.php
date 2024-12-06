<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shape Classification with CNN Simulation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 1800px;
      margin: 0 auto;
      padding: 20px;
    }
    .matrix {
      display: grid;
      grid-template-columns: repeat(3, 50px);
      gap: 5px;
      justify-content: center;
      margin: 20px auto;
    }
    .matrix div {
      width: 50px;
      height: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 1px solid #ccc;
      font-size: 20px;
      position: relative;
    }
    .clear {
      background-color: #ffffff;
    }
    .light {
      background-color: #b3b3b3;
    }
    .dark {
      background-color: #666666;
    }
    .darker {
      background-color: #333333;
    }
    .input-field {
      margin-top: 20px;
    }
    .input-field input {
      padding: 10px;
      font-size: 16px;
      width: 100px;
      margin-right: 10px;
    }
    button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    .result {
      margin-top: 20px;
      font-size: 1.2em;
    }
    .computation-steps {
      margin-top: 20px;
      text-align: left;
    }
    .computation-steps span {
      font-size: 16px;
      display: block;
      margin: 5px 0;
    }
    .value-label {
      position: absolute;
      bottom: 5px;
      font-size: 10px;
      color: white;
    }
    #timer {
      font-size: 20px;
      margin-top: 20px;
      font-weight: bold;
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

/* SHELL GAME*/

#cardsContainer {
            position: relative;
            height: 200px;
            margin: 20px 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .card {
            width: 150px;
            height: 200px;
            position: absolute;
            cursor: pointer;
            transform-style: preserve-3d;
            transition: transform 0.6s, left 0.5s ease;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 2px solid #333;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .card-front img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 5px;
        }

        .card-back {
            background: #4CAF50;
            transform: rotateY(180deg);
        }

        .card-back::after {
            content: "?";
            font-size: 48px;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        .flipped {
            transform: rotateY(180deg);
        }

        .wrong {
            transform: scale(0.95);
            box-shadow: 0 0 20px #ff0000;
        }

        .correct-reveal {
            transform: scale(1.1);
            box-shadow: 0 0 20px #00ff00;
            z-index: 99;
        }


        /* FEATURE EXTRACTIONn*/

        #level3Content {
    display: none;
    max-width: 100%; /* Matches most of the width of #gameScene */
    width: 800px; 
    height: auto; /* Increased height to occupy more vertical space */
    margin: 0 auto;
    padding: 20px; /* Adequate padding for readability */
    background: rgba(0, 0, 0, 0.8);
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
    color: white;
    word-wrap: break-word;
    font-size: 12px;
}

@media (max-width: 1024px) {
    #level3Content {
        width: 85%;
        max-height: 65vh; /* Increased for smaller screens */
        padding: 15px;
    }
}

@media (max-width: 768px) {
    #level3Content {
        width: 90%;
        max-height: 50vh; /* Increased for smaller screens */
        padding: 10px;
        margin: 10px;
    }
}

@media (max-width: 480px) {
    #level3Content {
        width: 95%;
        max-height: 65vh; /* Increased for very small screens */
        padding: 8px;
        margin: 5px;
        font-size: 20px;
    }
}



.feature-matching-container {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    flex-wrap: wrap;
}

.main-image-container {
    width: 100%;
    max-width: 350px; /* Reduced max width for the main image */
    height: 350px; /* Set a specific height for consistent dropzone positioning */
    position: relative; /* Allows absolutely positioned child elements to be positioned relative to this container */
    border: 2px solid #333; /* Border for visibility */
    margin-right: 10px; /* Margin to the right */
    margin-bottom: 15px; /* Margin to the bottom */
    overflow: hidden; /* Optional: Ensures that any overflowing content is hidden */
}

@media (max-width: 768px) {
    .main-image-container {
        width: 50%;
        max-width: none;
        height: auto;
    }

    .feature-matching-container {
        flex-direction: column;
        align-items: center;
    }
}


.main-image {
    width: 100%;  /* Set the width of the main image */
    height: 100%; /* Set the height of the main image */
    object-fit: cover;  /* Ensures the image covers the area without distortion */
}

.feature-dropzone {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0; /* Or set specific dimensions like 300px */
    border: 3px dashed #E57373; /* Soft red border */
    background: rgba(229, 115, 115, 0.35); /* Light red background with transparency */
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    border-radius: 8px; /* Rounded corners for a smooth look */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    transition: background-color 0.3s, border-color 0.3s; /* Smooth transitions */
}

.feature-dropzone:hover {
    background: rgba(229, 115, 115, 0.25); /* Darker red background on hover */
    border-color: #D32F2F; /* Darker red border on hover */
}

.feature-dropzone::before {
    font-size: 18px;
    color: #D32F2F; /* Dark red text for visibility */
    font-weight: 600;
    line-height: 1.4;
    padding: 10px;
    text-align: center;
    font-family: 'Arial', sans-serif; /* Modern sans-serif font */
}

.features-panel {
    width: 150px; /* Slightly reduced width */
    padding: 6px; /* Reduced padding */
    background: rgba(0, 0, 0, 0.8);
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.feature-item {
    width: 130px; /* Reduced width */
    height: 70px; /* Reduced height */
    margin: 8px 0;
    border: 2px solid #333;
    cursor: grab;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, background 0.3s ease, border-color 0.3s ease; /* Smooth transitions */
}

.feature-item:hover {
    transform: scale(1.05); /* Slight zoom effect on hover */
    background: rgba(0, 0, 0, 0.05); /* Light background change on hover */
    border-color: #007BFF; /* Border color change on hover */
}

.feature-item img {
    width: 80px;
    height: 80px;
    transition: transform 0.2s ease; /* Smooth image transition */
}

.feature-item.dragging {
    opacity: 0.5;
    cursor: grabbing;
}

.feature-matched {
    border-color: #4CAF50;
    opacity: 0.7;
    pointer-events: none;
}

.dropzone-highlight {
    background: rgba(76, 175, 80, 0.3);
}

.level3-instructions {
    text-align: center;
    margin-bottom: 15px;
    padding: 8px;
    background: rgba(0, 0, 0, 0.8);
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.progress-bar {
    width: 100%;
    height: 16px; /* Reduced height */
    background: linear-gradient(145deg, #222, #555);
    border-radius: 8px; /* Reduced border radius */
    margin: 10px 0;
    overflow: hidden;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
    border: 1px solid #4CAF50;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00ff7f, #32cd32, #228b22);
    width: 0%;
    transition: width 0.3s ease, background 0.6s ease;
    box-shadow: 0px 3px 12px rgba(0, 255, 127, 0.8);
    border-radius: 8px; /* Reduced border radius */
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 4px rgba(0, 255, 127, 0.8);
    }
    50% {
        box-shadow: 0 0 15px rgba(0, 255, 127, 1);
    }
    100% {
        box-shadow: 0 0 4px rgba(0, 255, 127, 0.8);
    }
}

.progress-fill.active {
    animation: pulse 1s infinite ease-in-out;
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


        #postTestContainer {
            width: 600px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
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

        .container {
        display: flex;
        justify-content: center;  
        align-items: center;      
        height: 100vh;            
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

<audio id="playerAttackSound" src="{{ asset('audio/player-attack.mp3') }}" preload="auto"></audio>
    <audio id="monsterAttackSound" src="{{ asset('audio/monster-attack.mp3') }}" preload="auto"></audio>
<audio id="intenseFightMusic" src="{{ asset('audio/intense-fight-music.mp3') }}" loop preload="auto"></audio>

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
      <h2>Welcome to CNN Feature Extraction Game!</h2>
      <p>Welcome, players! Today, we're exploring the fascinating world of <strong>Convolutional Neural Networks (CNNs)</strong>, a powerful tool used in computer vision to automatically extract features from images.</p>
      <p>In computer vision, we often need to understand the important elements of an image, like edges, textures, and patterns. A <strong>CNN</strong> is designed to automatically learn and extract these features by using layers of filters that pass over an image.</p>
      <p>The key idea behind CNNs is the use of <strong>convolutional layers</strong>. These layers apply small filters to the image, looking for specific patterns such as edges, shapes, and textures. As the image moves through the network, it learns increasingly complex features, from simple lines to complex objects like faces or animals.</p>
      <p>In this game, you’ll work with CNNs to extract features from various images. Your task will be to identify the relevant features and understand how the network processes and interprets them. You’ll explore how each layer of a CNN contributes to recognizing different aspects of the image.</p>
      <p>By the end of this game, you’ll have a better understanding of how CNNs are used to automatically detect and classify features in images, which is an essential technique in modern AI and machine learning!</p>
      <button onclick="startGame()">Start Game</button>
    </div>
</div>

  <div class="container">
    <div id="gameContainer">
      <div id="stats">
        <div>Player HP: <span id="playerHp">100</span></div>
        <div>Monster HP: <span id="monsterHp">100</span></div>
        <div>Time :<span id="timer"> 0</span> seconds</div>
        <div id="scoreDisplay">Score: 0</div>
      </div>

      <canvas id="gameScene" width="800" height="300"></canvas>
        
      <div id="level1Content">
    <div id="imageDisplay">
        <img id="targetImage" src="" alt="Target image" style="display:none;">
    </div>
    <canvas id="tracingCanvas"></canvas>
    <div id="message">Trace the outline of the image!</div>
    <button id="submitTrace">Submit Trace</button>
</div>

    <div id="celebration"></div>
    <div class="modal-overlay" id="levelCompleteModal">
        <div class="modal">
            <h2>Level 1 Complete!</h2>
            <p>Congratulations! You've mastered the outline matching challenge.</p>
            <p>Get ready for Level 2: Feature Extractionn!</p>
            <button onclick="startGame()">Start Level 2</button>
        </div>
    </div>

    <div id="level3Content">
            <div class="level3-instructions">
                <h2>Level 3: Feature Extraction Challenge</h2>
                <p>Match the visual features to their correct locations in the image!</p>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressBar"></div>
            </div>
            <div class="feature-matching-container">
                <div class="main-image-container">
                    <img class="main-image" id="mainImage" src="/api/placeholder/400/400" alt="Main image">
                    <!-- Dropzones will be added dynamically -->
                </div>
                <div class="features-panel">
                    <h3>Visual Features</h3>
                    <div id="featuresList">
                        <!-- Features will be added dynamically -->
                    </div>
                </div>
            </div>
        </div>
        <div id="celebration"></div>
    <div class="modal-overlay" id="level3CompleteModal">
        <div class="modal">
            <h2>Level 3 Complete!</h2>
            <p>Excellent work! You've mastered the FEATURE EXTRACTION.</p>
            <p>You can now proceed to the next Stage!</p>
            <button onclick="startGame()">NEXT STAGE!</button>
        </div>
    </div>
    </div>
  </div>
  <script>
        const level1Content = document.getElementById('level1Content');
        const level3Content = document.getElementById('level3Content');
        const cnncontainer = document.getElementById('cnn-container');
        let intenseFightMusic = document.getElementById("intenseFightMusic");
        const cardsContainer = document.getElementById('cardsContainer');
        const targetImage = document.getElementById('targetImage');

        const wrongAnswer = new Audio("{{ asset('audio/wrong-answer.mp3') }}");
        const correctAnswer = new Audio("{{ asset('audio/correct-answer.mp3') }}");
        const levelComplete = new Audio("{{ asset('audio/level-complete.mp3') }}");
        const gameOver = new Audio("{{ asset('audio/game-over.mp3') }}");

        const cardWidth = 150;
        const cardGap = 50;
        const totalWidth = (cardWidth * 3) + (cardGap * 2);
        let startX = (1800 - totalWidth) / 2;

        let cards = [];
        let cardNumber = 3;
        let currentBlurLevel = 20;
        let shuffleCount = 5;
        let shuffleTime = 800;


    let gameState = {
            level: 1,
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
            monsterHurt: false,
            isAttacking: false,
            attackFrame: 0,
            shuffling: false,
            canClick: false,
            images: [

                {
                    original: 'images/easy/ball.png',
                    outlines: [
                        'images/easy/ball_outline.jpg',
                        'images/easy/apple_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/bicycle_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/triangle.webp',
                    outlines: [
                        'images/easy/triangle_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/bicycle_outline.webp',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/box.jpg',
                    outlines: [
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/house_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/laptop_outline.jpg',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/vase.jpg',
                    outlines: [
                        'images/easy/vase_outline.jpg',
                        'images/easy/apple_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/easy/laptop_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },
                {
                    original: 'images/easy/balloon.jpg',
                    outlines: [
                        'images/easy/balloon_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/apple_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/bicycle_outline.webp',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                }, {
                    original: 'images/easy/box.jpg',
                    outlines: [
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/bicycle_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/pizza.png',
                    outlines: [
                        'images/easy/pizza_outline.jpg',
                        'images/easy/house_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/bicycle_outline.webp',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },
                {
                    original: 'images/easy/bicycle.webp',
                    outlines: [
                        'images/easy/bicycle_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/pizza_outline.jpg',
                        'images/easy/house_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/coffeemug.webp',
                    outlines: [
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/bicycle_outline.webp',
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/house.webp',
                    outlines: [
                        'images/easy/house_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/laptop_outline.jpg',
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/laptop.jpg',
                    outlines: [
                        'images/easy/laptop_outline.jpg',
                        'images/easy/coffeemug_outline.webp',
                        'images/easy/house_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/easy/smartphone_outline.jpg',
                        'images/easy/sandwich_outline.jpg',
                        'images/easy/burger_outline.jpg'
                    ]
                }

            ],
            playerX: 100,
            playerY: 150,
            monsterX: 550,
            monsterY: 185,
            playerHurt: false,
            monsterHurt: false
        };
        const gameScene = document.getElementById('gameScene');
        const ctx = gameScene.getContext('2d');
        
    // Shape values
    const shapeValues = {
      'clear': 0,
      'light': 2,
      'dark': 1,
      'darker': 3
    };

    let score = 0; // Initialize the score
    let timer = 0; // Initialize the timer

    function initializeGame() {
            intenseFightMusic.play(); 
            updateStats();
            // Hide all content first
            level1Content.style.display = 'none';
            level3Content.style.display = 'none';


            // Show appropriate level content
            if (gameState.level === 1) {
                level1Content.style.display = 'block';
                initializeLevel1();
            } else if (gameState.level === 2) {
                level3Content.style.display = 'block';
                initializeLevel3();
            } else if (gameState.level === 3) {
                window.location.href = "{{ route('storylinestage2') }}"; // Restart the game
            } 

            currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
                        draw();
        }

        //LEVEL 1

        

        function initializeLevel1() {
    intenseFightMusic.play(); // Play the intense background music
    level1Content.style.display = 'block';
    message.textContent = "Trace the outline of the image!";

    // Fetch and display a random image
    fetchRandomImageForTracing();

    const traceCanvas = document.getElementById('tracingCanvas');
    const ctx = traceCanvas.getContext('2d');
    const targetImage = document.getElementById('targetImage');

    // Set up canvas size
    traceCanvas.width = 400;
    traceCanvas.height = 300;

    // Enable tracing on the canvas
    let tracing = false;

    traceCanvas.addEventListener('mousedown', startTracing);
    traceCanvas.addEventListener('mousemove', trace);
    traceCanvas.addEventListener('mouseup', stopTracing);

    function startTracing(event) {
        tracing = true;
        ctx.beginPath();
        ctx.moveTo(event.offsetX, event.offsetY);
    }

    function trace(event) {
        if (!tracing) return;
        ctx.lineTo(event.offsetX, event.offsetY);
        ctx.strokeStyle = '#FF0000'; // Red for tracing
        ctx.lineWidth = 2;
        ctx.stroke();
    }

    function stopTracing() {
        tracing = false;
    }

    // Add submission logic
    document.getElementById('submitTrace').addEventListener('click', evaluateTrace);

    function evaluateTrace() {
        // Placeholder: Evaluate trace accuracy
        const success = Math.random() > 0.5; // Simulate success/failure for now

        if (success) {
            message.textContent = "Great job! You traced the outline well!";
            updateScore(10); // Award points
            setTimeout(nextRound, 2000);
            attackMonster(25);
        } else {
            message.textContent = "Try again! Your trace needs improvement.";
            monsterAttack();
        }
    }

    function fetchRandomImageForTracing() {
        fetch(`https://picsum.photos/400/300?random=${Date.now()}`)
            .then(response => response.url)
            .then(url => {
                targetImage.src = url;
                targetImage.onload = () => {
                    // Draw the image on the canvas
                    ctx.drawImage(targetImage, 0, 0, traceCanvas.width, traceCanvas.height);
                };
            })
            .catch(error => {
                message.textContent = "Failed to load image. Try again!";
                console.error(error);
            });
    }
}

        function nextRound() {
            initializeGame();
        }

        //FEATURE EXTRACTION

        const featureSets = [
    {
        mainImage: 'https://cdn.pixabay.com/photo/2019/12/29/06/02/tree-4726335_1280.jpg',
        features: [
            {
                id: 'featurelevel11',
                type: 'edge',
                image: 'images/level3/edge/tree_edge.png',
                correctZone: { x: 30, y: 70, width: 100, height: 100 }
            },
            {
                id: 'featurelevel12',
                type: 'texture',
                image: 'images/level3/texture/tree_texture.png',
                correctZone: { x: 230, y: 185, width: 100, height: 100 }
            },
            {
                id: 'featurelevel13',
                type: 'color',
                image: 'images/level3/color/tree_color.png',
                correctZone: { x: 150, y: 20, width: 100, height: 100 }
            }
        ]
    },
    {
        mainImage: 'https://m.media-amazon.com/images/I/613JPrgkWFL._SX522_.jpg',
        features: [
            {
                id: 'featurelevel21',
                type: 'edge',
                image: 'images/level3/edge/oregano_edge.png',
                correctZone: { x: 70, y: 60, width: 100, height: 100 }
            },
            {
                id: 'featurelevel22',
                type: 'texture',
                image: 'images/level3/texture/oregano_texture.png',
                correctZone: { x: 230, y: 60, width: 100, height: 100 }
            },
            {
                id: 'featurelevel23',
                type: 'color',
                image: 'images/level3/color/oregano_color.png',
                correctZone: { x: 30, y: 200, width: 100, height: 100 }
            },
        ]
    },
    {
        mainImage: 'https://th.bing.com/th/id/OIP.S2ETHA7VZURStDrTXOch0gAAAA?rs=1&pid=ImgDetMain',
        features: [
            {
                id: 'featurelevel31',
                type: 'edge',
                image: 'images/level3/edge/window_edge.png',
                correctZone: { x: 35, y: 45, width: 100, height: 100 }
            },
            {
                id: 'featurelevel32',
                type: 'texture',
                image: 'images/level3/texture/window_texture.png',
                correctZone: { x: 180, y: 120, width: 100, height: 100 }
            },
            {
                id: 'featurelevel33',
                type: 'color',
                image: 'images/level3/color/window_color.png',
                correctZone: { x: 110, y: 220, width: 100, height: 100 }
            },
        ]
    },
    {
        mainImage: 'https://www.handmadebrick.com/files/2372/Image/2015-09-16%2010_27_31.jpg',
        features: [
            {
                id: 'featurelevel41',
                type: 'edge',
                image: 'images/level3/edge/brick_edge.png',
                correctZone: { x: 60, y: 80, width: 100, height: 100 }
            },
            {
                id: 'featurelevel42',
                type: 'texture',
                image: 'images/level3/texture/brick_texture.png',
                correctZone: { x: 200, y: 180, width: 100, height: 100 }
            },
            {
                id: 'featurelevel43',
                type: 'color',
                image: 'images/level3/color/brick_color.png',
                correctZone: { x: 110, y: 260, width: 100, height: 100 }
            },
        ]
    },
];

// Initialize the current feature set index
let currentFeatureSetIndex = 1; // Tracks the current feature set
let featureTracker = 0;

/// Function to generate a new set of features from predefined sets
function generateNewFeatures() {
    // Load the current feature set into the game state
    const currentFeatureSet = featureSets[currentFeatureSetIndex];
    gameState.level3.features = currentFeatureSet.features; // Set the features
    gameState.level3.mainImage = currentFeatureSet.mainImage; // Set the main image

    // Update the index to cycle through the sets
    currentFeatureSetIndex = (currentFeatureSetIndex + 1) % featureSets.length;
}

// Initialization of gameState for Level 3
gameState.level3 = {
    features: featureSets[featureTracker].features, // Initial set of features
    matchedFeatures: new Set(),
    mainImage: featureSets[featureTracker].mainImage // Initial main image
};

function initializeLevel3() {
    const level3Content = document.getElementById('level3Content');
    level3Content.style.display = 'block';
    level1Content.style.display = 'none';
    const modal = document.getElementById('levelCompleteModal');
    modal.style.display = 'none';


    const mainImage = document.getElementById('mainImage');
    console.log("Setting main image source to:", gameState.level3.mainImage); // Log the image URL
    mainImage.src = gameState.level3.mainImage; // This should use the new image URL

    // Create dropzones for the main image
    gameState.level3.features.forEach(feature => {
        const dropzone = createDropzone(feature);
        document.querySelector('.main-image-container').appendChild(dropzone);
    });

    // Create draggable features
    gameState.level3.features.forEach(feature => {
        const featureElement = createFeatureElement(feature);
        document.getElementById('featuresList').appendChild(featureElement);
    });

    // Update the progress bar or any level-specific info
    updateLevel3Progress();

    // Start the timer for Level 3
}

function resetLevel3() {
    const mainImageContainer = document.querySelector('.main-image-container');
    const featuresList = document.getElementById('featuresList');

    // Clear previous dropzones and draggable features
    mainImageContainer.innerHTML = '';
    featuresList.innerHTML = '';

    // Reset matched features
    gameState.level3.matchedFeatures.clear();

    // Generate a new set of features
    generateNewFeatures();

    // Create dropzones for the new features
    gameState.level3.features.forEach(feature => {
        const dropzone = createDropzone(feature);
        mainImageContainer.appendChild(dropzone);
    });

    // Create draggable features for the new features
    gameState.level3.features.forEach(feature => {
        const featureElement = createFeatureElement(feature);
        featuresList.appendChild(featureElement);
    });

    // Reset progress
    updateLevel3Progress();

    // Ensure mainImage element exists, or create it if it doesn't
    let mainImage = document.getElementById('mainImage');
    if (!mainImage) {
        mainImage = document.createElement('img');
        mainImage.id = 'mainImage';
        mainImageContainer.appendChild(mainImage);
    }

    // Update the main image
    mainImage.src = gameState.level3.mainImage;
}

        function updateLevel3Progress() {
            // Set progress to 0% on reset
            if (gameState.level3.matchedFeatures.size === 0) {
                document.querySelector('.progress-fill').style.width = '0%';
            } else {
                // Update progress based on matched features
                const progress = (gameState.level3.matchedFeatures.size / gameState.level3.features.length) * 100;
                document.querySelector('.progress-fill').style.width = `${progress}%`;
            }
        }

        function handleDrop(e) {
    e.preventDefault();
    e.target.classList.remove('dropzone-highlight');

    const featureId = e.dataTransfer.getData('text/plain');
    const dropzone = e.target;

    if (dropzone.dataset.featureId === featureId) {
        // Correct match
        const featureElement = document.querySelector(`.feature-item[data-feature-id="${featureId}"]`);
        featureElement.classList.add('feature-matched');
        gameState.level3.matchedFeatures.add(featureId);

        document.getElementById('message').textContent = "Correct match!";
        correctAnswer.play();
        updateLevel3Progress();
        
        // Update score for a correct match
        updateScore(15); // Example: 15 points for a correct match

        // Remove the dropzone from the DOM
        dropzone.style.display = 'none';  // Hide the dropzone when a correct match is made

        if (gameState.level3.matchedFeatures.size === gameState.level3.features.length) {
            // Level complete
            setTimeout(() => {
                attackMonster(25);
                featureTracker++;

                // Delay and reset level for the next attempt until the monster is defeated
                if (gameState.monsterHp > 0) {
                    setTimeout(() => {
                        resetLevel3();
                    }, 500);
                }

                if (gameState.monsterHp === 0) {
                    showLevel3CompleteModal();
                    gameState.level = 3;
                }
            }, 500);
        }
    } else {
        wrongAnswer.play();
        // Wrong match
        document.getElementById('message').textContent = "Wrong match! Try again.";
        monsterAttack();
        takeDamage(); // Deduct HP or handle damage
    }
}


        function handleDragStart(e) {
            e.target.classList.add('dragging');
            e.dataTransfer.setData('text/plain', e.target.dataset.featureId);
        }

        function handleDragEnd(e) {
            e.target.classList.remove('dragging');
        }

        function handleDragOver(e) {
            e.preventDefault();
        }

        function handleDragEnter(e) {
            e.preventDefault();
            e.target.classList.add('dropzone-highlight');
        }

        function handleDragLeave(e) {
            e.target.classList.remove('dropzone-highlight');
        }
        function createDropzone(feature) {
    const dropzone = document.createElement('div');
    dropzone.className = 'feature-dropzone';
    dropzone.dataset.featureId = feature.id;
    dropzone.style.width = feature.correctZone.width + 'px';
    dropzone.style.height = feature.correctZone.height + 'px';
    dropzone.style.position = 'absolute';
    dropzone.style.left = feature.correctZone.x + 'px';
    dropzone.style.top = feature.correctZone.y + 'px';

    // Create a label for the dropzone
    const label = document.createElement('span');
    label.className = 'dropzone-label';
    label.textContent = feature.type; // Set label text based on feature type (e.g., "edges", "texture", "color")
    dropzone.appendChild(label);

    // Style the label to appear at the top of the dropzone
    label.style.position = 'absolute';
    label.style.top = '-20px'; // Position the label slightly above the dropzone
    label.style.left = '50%';
    label.style.transform = 'translateX(-50%)'; // Center horizontally
    label.style.color = '#fff';
    label.style.fontSize = '14px';
    label.style.fontWeight = 'bold';
    label.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
    label.style.padding = '4px 8px';
    label.style.borderRadius = '4px';

    // Append the dropzone to the main image container
    const mainImageContainer = document.querySelector('.main-image-container');
    if (mainImageContainer) {
        mainImageContainer.appendChild(dropzone);
    }

    // Add event listeners for drag-and-drop functionality
    dropzone.addEventListener('dragover', handleDragOver);
    dropzone.addEventListener('drop', handleDrop);
    dropzone.addEventListener('dragenter', handleDragEnter);
    dropzone.addEventListener('dragleave', handleDragLeave);

    return dropzone;
}

function createFeatureElement(feature) {
    const featureElement = document.createElement('div');
    featureElement.className = 'feature-item';
    featureElement.draggable = true; // Make the parent div draggable
    featureElement.dataset.featureId = feature.id;

    const featureImage = document.createElement('img');
    featureImage.src = feature.image;
    featureImage.alt = `${feature.type} feature`;

    // Prevent the image itself from being draggable to avoid conflicts
    featureImage.draggable = false;

    // Add the image to the feature element
    featureElement.appendChild(featureImage);

    // Add drag event listeners to featureElement (the parent div)
    featureElement.addEventListener('dragstart', handleDragStart);
    featureElement.addEventListener('dragend', handleDragEnd);

    // Optional: Add cursor style for better user feedback
    featureElement.style.cursor = 'grab';

    return featureElement;
}
    
    // Update the score display
    function updateScore() {
      const scoreDisplay = document.getElementById("scoreDisplay");
      scoreDisplay.textContent = `Score: ${score}`;
    }

  // Function to start the game
  function startGame() {
    const modal = document.getElementById('level3CompleteModal');
            modal.style.display = 'none';
      document.getElementById('introModal').style.display = 'none'; // Hide intro modal
      initializeGame();
    }
    // Timer function to update every second
    function startTimer() {
      setInterval(function() {
        timer++;
        document.getElementById("timer").textContent = ` ${timer}`;
      }, 1000); // Update every second
    }

    // Randomly generate shapes in a 3x3 matrix
    function updateStats() {
            document.getElementById('playerHp').textContent = gameState.playerHp;
            document.getElementById('monsterHp').textContent = gameState.monsterHp;
        }

        const playerImage = new Image();
        playerImage.src = 'images/characters/player.png'; // Replace with the correct path

        const monsterImages = [
            'images/characters/easy/monster1.png', // Replace with correct paths
            'images/characters/easy/monster2.png',
            'images/characters/easy/monster3.png'
        ];

        const backgroundImage = new Image();
        backgroundImage.src = 'images/background.jpg';

        let currentMonsterImage = new Image();
        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];

        // Particle class to handle individual sand particles
// Particle class to handle individual sand particles
class Particle {
    constructor(x, y) {
        this.x = x; // Initial x position
        this.y = y; // Initial y position
        this.size = Math.random() * 3 + 1; // Random small size for the particle (1 to 4)
        this.speed = Math.random() * 4 + 2; // Increased speed of the particle (now 2 to 6)
    }

    update() {
        this.x -= this.speed; // Move particle to the left
        // Reset particle position to the right when it moves off screen
        if (this.x < 0) {
            this.x = gameScene.width; // Reappear from the right
            this.y = Math.random() * gameScene.height; // Random vertical position
        }
    }

    draw(ctx) {
        ctx.fillStyle = 'rgba(222, 184, 135, 0.8)'; // Light sand color with some transparency
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

// Array to hold particles
let particles = [];

// Function to initialize particles
function initParticles() {
    for (let i = 0; i < 100; i++) { // Create 100 particles initially
        let x = Math.random() * gameScene.width; // Random initial x position
        let y = Math.random() * gameScene.height; // Random initial y position
        particles.push(new Particle(x, y));
    }
}

// Update and draw sand particles
function drawParticles(ctx) {
    particles.forEach(particle => {
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
    drawParticles(ctx);

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
    ctx.ellipse(gameState.monsterX + 35, gameState.monsterY + 70, 20, 7, 0, 0, 2 * Math.PI); // Smaller ellipse shadow
    ctx.fill();

    // Draw monster with breathing effect
    const monsterWidth = 70 * breathingScale;
    const monsterHeight = 70 * breathingScale;
    ctx.drawImage(
        currentMonsterImage,
        gameState.monsterX - (monsterWidth - 70) / 2,
        gameState.monsterY - (monsterHeight - 70) / 2,
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
        ctx.fillRect(gameState.monsterX, gameState.monsterY, 70, 70);
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
            ctx.fillText("FATAL!", gameState.damageText.x, gameState.damageText.y);
            ctx.globalAlpha = 1;
        }
    }

    requestAnimationFrame(draw);
}

// Initialize particles on game start
initParticles();



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


        // Call this function to trigger the attack
        function triggerAttack() {
            gameState.isAttacking = true;
        }

        function attackMonster(damage) {
            gameState.isAttacking = true;
            gameState.attackFrame = 0;
            gameState.monsterHp = Math.max(0, gameState.monsterHp - damage);

            if (gameState.monsterHp === 0) {
                if (gameState.level === 1) {
                    showLevel1CompleteModal();
                } else if (gameState.level === 2) {
                    showLevel2CompleteModal();
                    // alert("Congratulations! You've completed all levels!");
                    // resetGame();
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
            gameState.playerHp = Math.max(0, gameState.playerHp - 10);
            updateStats();
            if (gameState.playerHp <= 0) {
                setTimeout(() => {
                    showGameOverModal();
                    resetGame();
                }, 500);
            }
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

function pauseTimer() {
            intenseFightMusic.pause();
            isPaused = false; // Set the paused flag to true
        }

function quitGame() {
    window.location.href = "{{ url('play') }}"; // Redirect to the main menu
}

        function showLevel1CompleteModal() {
            gameState.monsterHp = 100;
            levelComplete.play();
            pauseTimer();
            const modal = document.getElementById('levelCompleteModal');
            modal.style.display = 'flex';
            createConfetti();
            gameState.level++;
        }

        function showLevel2CompleteModal() {
            levelComplete.play();
            pauseTimer();
            const modal = document.getElementById('level3CompleteModal');
            modal.style.display = 'flex';
            createConfetti();
            gameState.level = 3;
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


draw();

    startTimer();
  </script>
</body>
</html>
