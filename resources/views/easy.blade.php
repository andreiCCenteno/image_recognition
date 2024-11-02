<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Image Processing Card Game</title>
    <style>
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
            border: 2px solid #333;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            backdrop-filter: blur(15px);
        }

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

        #guessContainer {
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        #guessInput {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #333;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        #submitGuess {
            padding: 10px 20px;
            font-size: 16px;
            background: linear-gradient(145deg, #4CAF50, #45a049);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        #submitGuess:hover {
            background: linear-gradient(145deg, #45a049, #4CAF50);
            transform: translateY(-2px);
        }

        #blurredImage {
            max-width: 300px;
            max-height: 300px;
            filter: blur(20px);
            transition: filter 10s linear;
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

        #level3Content {
    display: none;
    max-width: 600px; /* Reduced max width */
    width: 80%; /* Reduced width for smaller screens */
    margin: 0 auto;
    padding: 15px; /* Reduced padding for better fit */
    background: rgba(0, 0, 0, 0.8);
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
    color: white;
    word-wrap: break-word;
}

@media (max-width: 1024px) {
    #level3Content {
        width: 85%;
        padding: 15px;
    }
}

@media (max-width: 768px) {
    #level3Content {
        width: 90%;
        padding: 10px;
        margin: 10px;
    }
}

@media (max-width: 480px) {
    #level3Content {
        width: 95%;
        padding: 8px;
        margin: 5px;
        font-size: 14px;
    }
}

.feature-matching-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    flex-wrap: wrap;
}

.main-image-container {
    width: 100%;
    max-width: 350px; /* Reduced max width for the main image */
    height: auto;
    position: relative;
    border: 2px solid #333;
    margin-right: 15px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .main-image-container {
        width: 100%;
        max-width: none;
        height: auto;
    }

    .feature-matching-container {
        flex-direction: column;
        align-items: center;
    }
}

.main-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.feature-dropzone {
    position: absolute;
    border: 2px dashed #4CAF50;
    background: rgba(76, 175, 80, 0.1);
    cursor: pointer;
}

.features-panel {
    width: 180px; /* Slightly reduced width */
    padding: 8px; /* Reduced padding */
    background: rgba(0, 0, 0, 0.8);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.feature-item {
    width: 160px; /* Slightly reduced width */
    height: 90px; /* Slightly reduced height */
    margin: 10px 0;
    border: 2px solid #333;
    cursor: grab;
    position: relative;
    overflow: hidden;
}

.feature-item img {
    width: 50px; 
    height: 50px; 
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
    margin-bottom: 20px;
    padding: 10px;
    background: rgba(0, 0, 0, 0.8);
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.progress-bar {
    width: 100%;
    height: 20px; /* Reduced height */
    background: linear-gradient(145deg, #222, #555);
    border-radius: 10px; /* Reduced border radius */
    margin: 15px 0;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    border: 1px solid #4CAF50;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00ff7f, #32cd32, #228b22);
    width: 0%;
    transition: width 0.3s ease, background 0.6s ease;
    box-shadow: 0px 4px 15px rgba(0, 255, 127, 0.8);
    border-radius: 10px; /* Reduced border radius */
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 5px rgba(0, 255, 127, 0.8);
    }

    50% {
        box-shadow: 0 0 20px rgba(0, 255, 127, 1);
    }

    100% {
        box-shadow: 0 0 5px rgba(0, 255, 127, 0.8);
    }
}

.progress-fill.active {
    animation: pulse 1s infinite ease-in-out;
}


        #level2CompleteModal {
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

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100%) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        #postTestContainer {
            width: 600px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .detection-zone {
            position: absolute;
            background-color: transparent;
            pointer-events: none;
        }

        #learning-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.9), rgba(30, 30, 30, 0.9));
            backdrop-filter: blur(15px);
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

        #colorContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        #colorImage,
        #selectedColorImage {
            width: 300px;
            height: 300px;
            background-color: rgb(0, 0, 0);
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

        #level4Content {
            width: 100%;
            padding: 20px;
            text-align: center;
            color: #fff;
        }

        #colorContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
            margin-bottom: 20px;
        }

        #colorImage {
            width: 300px;
            height: 300px;
            background-color: rgb(0, 0, 0);
            border: 2px solid #4CAF50;
            margin-right: 20px;
            box-shadow: 0 0 15px rgba(0, 255, 127, 0.7);
        }

        #selectedColorImage {
            width: 200px;
            height: 200px;
            border: 2px solid #4CAF50;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
        }

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

        #level5Content {
            text-align: center;
            padding: 20px;
            color: #fff;
        }

        #targetZoneMessage {
            font-size: 18px;
            color: #ff9800;
        }

        .object-detection-container {
            position: relative;
            display: inline-block;
            margin: 0 auto;
            border: 2px solid #4CAF50;
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 127, 0.5);
        }

        .object-image {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
        }

        .detection-zone {
            position: absolute;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .detection-zone:hover {
            background-color: rgba(255, 255, 255, 0.5);
            border-color: #FFC300;
        }


        .detected-objects {
            margin-top: 20px;
            padding: 15px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
        }

        .detected-objects h3 {
            margin-bottom: 10px;
            color: #4CAF50;
        }

        .detected-objects ul {
            list-style: none;
            padding: 0;
            color: #fff;
        }

        .detected-objects ul li {
            padding: 5px 0;
            font-size: 16px;
            border-bottom: 1px solid #555;
        }

        .detected-objects ul li:last-child {
            border-bottom: none;
        }

        #postTestWrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.1); /* Slightly darker for more contrast */
}

#postTestContainer {
    max-height: 80vh;
    width: 80%;
    overflow-y: auto;
    padding: 30px;
    background: rgba(30, 30, 30, 0.9);
    border-radius: 12px;
    box-shadow: 0 4px 30px rgba(0, 255, 204, 0.6);
    color: #e0f7fa; /* Light color for improved readability */
    font-size: 18px;
}

.test-form-container {
    display: flex;
    flex-direction: column;
    gap: 25px; /* Increased gap for better separation */
}

.question {
    background: rgba(40, 40, 40, 0.95);
    padding: 20px;
    border: 1px solid #00ffa3;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 255, 163, 0.5); /* Subtle glow effect */
}

.question p {
    font-size: 20px; /* Slightly larger font for readability */
    color: #d4ffd6; /* Light green for readability */
    margin-bottom: 12px;
    line-height: 1.6;
}

/* Optional: Adjust scrollbar style for a more polished look */
#postTestContainer::-webkit-scrollbar {
    width: 8px;
}

#postTestContainer::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

#postTestContainer::-webkit-scrollbar-thumb {
    background: #00ffa3;
    border-radius: 10px;
    box-shadow: inset 0 0 5px rgba(0, 255, 163, 0.5);
}

        .options label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        #submitTest {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        #submitTest:hover {
            background-color: #45a049;
        }

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
            <img src="{{ asset('images/characters/player.png') }}" alt="Player" class="modal-image" />
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
            <div>Time Left: <span id="countdownTimer">60</span> seconds</div>
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
            <div id="blurredImageContainer">
                <img id="blurredImage" src="" alt="Blurred image">
            </div>
            <div id="guessContainer">
                <input type="text" id="guessInput" placeholder="What's in the image?">
                <button id="submitGuess">Submit Guess</button>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="levelCompleteModal">
        <div class="modal">
            <h2>Level 1 Complete!</h2>
            <p>Congratulations! You've mastered the outline matching challenge.</p>
            <p>Get ready for Level 2: Image Recognition Challenge!</p>
            <button onclick="startLevel2()">Start Level 2</button>
        </div>
    </div>

    <div id="celebration"></div>

    <div class="modal-overlay" id="level2CompleteModal">
        <div class="modal">
            <h2>Level 2 Complete!</h2>
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 3: Feature Extraction Challenge!</p>
            <button onclick="takeposttest()">Take Post Test!</button>
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
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 3: Feature Extraction Challenge!</p>
            <button onclick="startLevel4()">Start Level 4</button>
        </div>
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

    <div class="modal-overlay" id="level4CompleteModal">
        <div class="modal">
            <h2>Level 4 Complete!</h2>
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 5: Feature Extraction Challenge!</p>
            <button onclick="startLevel5()">Start Level 5</button>
        </div>
    </div>

    <div id="level5Content" style="display: block;">
        <h2>Level 5: Object Detection</h2>
        <div id="targetZoneMessage" style="margin-bottom: 10px;"></div>
        <div class="object-detection-container" style="position: relative;">
            <img id="objectImage" src="{{ asset('images/easy/scenery.avif') }}"
                style="max-width: 100%; cursor: pointer;">

            <!-- Large Detection Zones -->
            <div id="mediumTree" class="detection-zone" style="left: 32px; top: 90px; width: 35px; height: 200px;">
            </div>
            <div id="smallTree" class="detection-zone" style="left: 110px; top: 150px; width: 300px; height: 100px;">
            </div>
            <div id="largestTree" class="detection-zone" style="left: 520px; top: 20px; width: 100px; height: 350px;">
            </div>

            <!-- Small Detection Zones -->
            <div id="bench" class="detection-zone" style="left: 20px; top: 250px; width: 95px; height: 30px;"></div>
            <div id="sun" class="detection-zone" style="left: 415px; top: 12px; width: 50px; height: 50px;"></div>

        </div>
    </div>

    <div id="detectedObjectsList"></div>

    </div>

    <div id="postTestWrapper">
        <div id="postTestContainer" style="display: none;">
            <h2>Quiz Game</h2>
            <p id="questionText"></p>
            <canvas id="gameCanvas" width="800" height="500"></canvas>
            <div id="scoreModal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Your Score</h2>
                    <p id="finalScoreText"></p>
                </div>
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
    


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

        function showGameOverModal() {
            const modal = document.getElementById('gameOverModal');
            modal.style.display = 'flex'; // Show modal with flexbox for centering

            // Set up button event listeners
            document.getElementById('playAgainButton').addEventListener('click', function () {
                window.location.href = "{{ url('easy') }}"; // Reset the game state (you'll need to implement this)
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
                pauseTimer();
            });

            // Close settings modal
            window.closeSettingsModal = function () {
                $('#settingsModal').hide();
            }

            // Resume button functionality
            $('#resumeButton').click(function () {
                closeSettingsModal(); // Close the modal
                // Additional logic to resume the game can go here
                resumeTimer();
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
        let gameState = {
            level: 1,
            playerHp: 100,
            monsterHp: 100,
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
                        'images/medium/bicycle_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/coffeemug_outline.webp'
                    ]
                },

                {
                    original: 'images/easy/triangle.webp',
                    outlines: [
                        'images/easy/triangle_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/bicycle_outline.webp'
                    ]
                },

                {
                    original: 'images/easy/box.jpg',
                    outlines: [
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/medium/house_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/laptop_outline.jpg'
                    ]
                },

                {
                    original: 'images/easy/vase.jpg',
                    outlines: [
                        'images/easy/vase_outline.jpg',
                        'images/easy/apple_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/medium/laptop_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/house_outline.jpg',
                    ]
                },
                {
                    original: 'images/easy/balloon.jpg',
                    outlines: [
                        'images/easy/balloon_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/apple_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/bicycle_outline.webp'
                    ]
                }, {
                    original: 'images/easy/box.jpg',
                    outlines: [
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                        'images/medium/bicycle_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/coffeemug_outline.webp'
                    ]
                },

                {
                    original: 'images/easy/pizza.png',
                    outlines: [
                        'images/easy/pizza_outline.png',
                        'images/medium/house_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/bicycle_outline.webp'
                    ]
                },
                {
                    original: 'images/medium/bicycle.webp',
                    outlines: [
                        'images/medium/bicycle_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/easy/pizza_outline.jpg',
                        'images/easy/house_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                    ]
                },

                {
                    original: 'images/medium/coffeemug.webp',
                    outlines: [
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/medium/bicycle_outline.webp',
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                    ]
                },

                {
                    original: 'images/medium/house.webp',
                    outlines: [
                        'images/medium/house_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/laptop_outline.jpg',
                        'images/easy/box_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                    ]
                },

                {
                    original: 'images/medium/laptop.jpg',
                    outlines: [
                        'images/medium/laptop_outline.jpg',
                        'images/medium/coffeemug_outline.webp',
                        'images/medium/house_outline.jpg',
                        'images/easy/triangle_outline.jpg',
                        'images/easy/ball_outline.jpg',
                        'images/easy/vase_outline.jpg',
                    ]
                }

            ],

            level2Images: [
                {
                    image: 'images/easy/balloon.jpg',
                    answer: 'balloon'
                },

                {
                    image: 'images/easy/vase.jpg',
                    answer: 'vase'
                },

                {
                    image: 'images/easy/ball.png',
                    answer: 'ball'
                },

                {
                    image: 'images/easy/apple.jpg',
                    answer: 'apple'
                },

                {
                    image: 'images/easy/box.jpg',
                    answer: 'box'
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
        const cardsContainer = document.getElementById('cardsContainer');
        const targetImage = document.getElementById('targetImage');
        let level1Content = document.getElementById('level1Content');
        let level2Content = document.getElementById('level2Content');
        let intenseFightMusic = document.getElementById("intenseFightMusic");
        intenseFightMusic.volume = 0.2;
        const level4Content = document.getElementById('level4Content');
        const blurredImage = document.getElementById('blurredImage');
        const guessContainer = document.getElementById('guessContainer');
        const guessInput = document.getElementById('guessInput');
        const submitGuess = document.getElementById('submitGuess');
        const timeInterval = 1000;
        const cardWidth = 150;
        const cardGap = 50;
        const totalWidth = (cardWidth * 3) + (cardGap * 2);
        let startX = (1800 - totalWidth) / 2;

        let cards = [];
        let cardNumber = 3;
        let currentBlurLevel = 20;

        // Set duration for the timer (in seconds)
        let timerId;
        let timeLeft; // Variable to hold the remaining time
        let isPaused = false; // Flag to track if the timer is paused
        let score = 0; // Initialize score
        let currentLevel = 1;
        let isStartLevel = false;
        let damage = 25;
        let shuffleCount = 5;
        let shuffleTime = 800;

        function updateScore(points) {
            gameState.totalScore = (gameState.totalScore || 0) + points;
            document.getElementById('scoreDisplay').textContent = `Score: ${gameState.totalScore}`;
        }

        function startTimer() {
            intenseFightMusic.play();
            const timerDuration = 60;
            timeLeft = timerDuration; // Reset time left to initial duration
            document.getElementById('countdownTimer').textContent = timeLeft;

            timerId = setInterval(() => {
                if (isPaused) { // Check if the timer is not paused
                    timeLeft--;
                    document.getElementById('countdownTimer').textContent = timeLeft;

                    if (timeLeft <= 0) {
                        showGameOverModal();
                        pauseTimer();// Notify player when time runs out
                        endLevel(); // Call a function to end the level
                    }
                }
            }, 1000); // Update every second
        }

        function pauseTimer() {
            intenseFightMusic.pause();
            isPaused = false; // Set the paused flag to true
        }

        function resumeTimer() {
            isPaused = true; // Set the paused flag to false
        }

        function endLevel() {
            clearInterval(timerId);
            // timeLeft = timerDuration;
            // document.getElementById('countdownTimer').textContent = timeLeft;
            // Stop the timer
            // Add your logic to transition to the next level or handle level completion here
        }

        // Call startTimer when the player starts a new level
        function startNewLevel(level) {
            document.getElementById('level').textContent = level;
            // startTimer(); // Start the timer for the new level
        }

        // Example of starting a new level (update accordingly in your game logic)
        // startNewLevel(1); // Call this when a new level starts



        function takeposttest() {
            const modal = document.getElementById('level2CompleteModal');
            modal.style.display = 'none';
            document.getElementById('gameContainer').style.display = 'none';
            document.getElementById('postTestContainer').style.display = 'block';
            initializePostTest();
        }

        function startLevel6() {
            const modal = document.getElementById('level5CompleteModal');
            modal.style.display = 'none';
            // gameState.level = 5;
            // showLearningMaterial(5); 
            updateStats();
            initializeGame();
        }

        function startLevel5() {
            const modal = document.getElementById('level4CompleteModal');
            modal.style.display = 'none';
            // gameState.level = 5;
            showLearningMaterial(5);
            updateStats();
            initializeGame();
        }

        function startLevel4() {
            const modal = document.getElementById('level3CompleteModal');
            modal.style.display = 'none';
            // gameState.level = 4;
            showLearningMaterial(4);
            updateStats();
            initializeGame();
        }


        function startLevel3() {
            const modal = document.getElementById('level2CompleteModal');
            modal.style.display = 'none';
            // gameState.level = 3;
            showLearningMaterial(3);
            updateStats();
            initializeGame();
        }


        function createCard(index, isCorrect, outlineSrc) {
            const card = document.createElement('div');
            card.className = 'card';
            card.style.left = `${startX + (index * (cardWidth + cardGap))}px`;

            const front = document.createElement('div');
            front.className = 'card-face card-front';

            const outlineImg = document.createElement('img');
            outlineImg.src = outlineSrc; // Set the outline image passed from initializeLevel1()
            front.appendChild(outlineImg);

            const back = document.createElement('div');
            back.className = 'card-face card-back';

            card.appendChild(front);
            card.appendChild(back);

            return { element: card, isCorrect: isCorrect };
        }



        function initializeGame() {
            // Hide all content first
            level1Content.style.display = 'none';
            level2Content.style.display = 'none';
            level3Content.style.display = 'none';
            level4Content.style.display = 'none';
            level5Content.style.display = 'none';

            // Show appropriate level content
            if (gameState.level === 1) {
                // level1Content.style.display = 'block';
                initializeLevel1(cardNumber);
            } else if (gameState.level === 2) {
                // level2Content.style.display = 'block';
                switchToLevel2();
            }

            draw();
            console.log(gameState.level);
            console.log(currentLevel);
        }

        function enableSkipLevelHotkey() {
    document.addEventListener('keydown', (event) => {
        // Check if Shift + L is pressed
        if (event.shiftKey && event.key === 'L') {
            skipLevel();
        }
    });
}
function skipLevel() {
    if (gameState.level === 1) { // Assuming level 5 is the maximum level
        clearInterval(monologueInterval); // Stop any remaining intervals
    document.getElementById("learning-modal").style.display = "none"; // Hide modal
    document.getElementById("start-level-btn").style.display = "none"; // Hide the start button for next time
    resumeTimer(); // Resume the game timer
    startLevel(currentLevel); // Start the level
    gameState.monsterHp = 100; // Reset monster's health
    startTimer(); // Start the level timer
    updateStats(); // Update game stats

    // Play background music
    

    // If the level starts, play the background music
    if (currentLevel === 1) {
        draw();
        intenseFightMusic.play(); // Start playing the calm background music
        setTimeout(() => {
            flipAllCards(true); // Flip all cards face up
            setTimeout(shuffle, 1000); // Shuffle after a delay
        }, 1000);
        showLevel1CompleteModal();
        currentLevel++;
    }
        console.log(`Skipped to level ${gameState.level}`);
    }else if(gameState.level === 2){
        clearInterval(monologueInterval); // Stop any remaining intervals
    document.getElementById("learning-modal").style.display = "none"; // Hide modal
    document.getElementById("start-level-btn").style.display = "none"; // Hide the start button for next time
    resumeTimer(); // Resume the game timer
    startLevel(currentLevel); // Start the level
    gameState.monsterHp = 100; // Reset monster's health
    startTimer(); // Start the level timer
    updateStats(); // Update game stats
        if (currentLevel === 2) {
        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
        draw();
        isStartLevel = true;
        switchToLevel2();
        currentLevel++;
        gameState.level++;
        showLevel2CompleteModal();
    }
    }
}

// Call this function once to enable the hotkey
enableSkipLevelHotkey();

        gameState.level3 = {
            features: [
                {
                    id: 'feature1',
                    type: 'edge',
                    image: '/api/placeholder/180/100',
                    correctZone: { x: 50, y: 50, width: 100, height: 100 }
                },
                {
                    id: 'feature2',
                    type: 'texture',
                    image: '/api/placeholder/180/100',
                    correctZone: { x: 200, y: 150, width: 100, height: 100 }
                },
                {
                    id: 'feature3',
                    type: 'color',
                    image: '/api/placeholder/180/100',
                    correctZone: { x: 100, y: 250, width: 100, height: 100 }
                }
            ],
            matchedFeatures: new Set(),
            mainImage: '/api/placeholder/400/400'
        };

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

        function startLevel2() {
            const modal = document.getElementById('levelCompleteModal');
            modal.style.display = 'none';
            showMonologuesInSequence(2);
            monsterHp = 100;
            // initializeGame();
            // currentLevel++;
        }

        function showLevel1CompleteModal() {
            pauseTimer();
            const modal = document.getElementById('levelCompleteModal');
            modal.style.display = 'flex';
            createConfetti();
            console.log(gameState.level);
            gameState.level++;
        }

        function showLevel2CompleteModal() {
            pauseTimer();
            const modal = document.getElementById('level2CompleteModal');
            modal.style.display = 'flex';
            // gameState.level++;
            console.log(gameState.level);
            createConfetti();

        }

        function showLevel3CompleteModal() {
            pauseTimer();
            const modal = document.getElementById('level3CompleteModal');
            modal.style.display = 'flex';
            gameState.level++;
            console.log(gameState.level);
            createConfetti();
        }

        function showLevel4CompleteModal() {
            pauseTimer();
            const modal = document.getElementById('level4CompleteModal');
            modal.style.display = 'flex';
            gameState.level++;

            createConfetti();
        }

        function showLevel5CompleteModal() {
            pauseTimer();
            const modal = document.getElementById('level5CompleteModal');
            modal.style.display = 'flex';
            gameState.level++;
            createConfetti();
        }

        function flipAllCards(faceDown = true) {
            cards.forEach(card => {
                if (faceDown) {
                    card.element.classList.add('flipped');
                } else {
                    card.element.classList.remove('flipped');
                }
            });
        }

        function shuffle() {
            if (gameState.shuffling) return;

            gameState.shuffling = true;
            gameState.canClick = false;
            document.getElementById('message').textContent = "Watch the cards shuffle...";

            let shuffles = 0;
            const maxShuffles = shuffleCount;

            const shuffleInterval = setInterval(() => {
                const pos1 = Math.floor(Math.random() * cardNumber);
                const pos2 = Math.floor(Math.random() * cardNumber);

                if (pos1 !== pos2) {
                    // Update visual positions
                    const left1 = cards[pos1].element.style.left;
                    const left2 = cards[pos2].element.style.left;

                    cards[pos1].element.style.left = left2;
                    cards[pos2].element.style.left = left1;

                    // Swap cards in array
                    [cards[pos1], cards[pos2]] = [cards[pos2], cards[pos1]];
                }

                shuffles++;
                if (shuffles >= maxShuffles) {
                    clearInterval(shuffleInterval);
                    gameState.shuffling = false;
                    gameState.canClick = true;
                    document.getElementById('message').textContent = "Select the card with the correct Outline!";
                }
            }, shuffleTime);
        }

        function initializeLevel1(cardNumber) {
            cardsContainer.innerHTML = '';
            cards = [];

            // Randomly select an image from the gameState.images array
            const randomImageIndex = Math.floor(Math.random() * cardNumber);
            const selectedImage = gameState.images[randomImageIndex];

            // Set the target image to the randomly selected one
            targetImage.src = selectedImage.original;

            level1Content.style.display = 'block';

            // Randomize the correct position for the correct outline
            const correctPosition = Math.floor(Math.random() * cardNumber);

            // Create an array of outlines for this image and shuffle them
            const outlines = [...selectedImage.outlines]; // Copy the outlines array

            for (let i = 0; i < cardNumber; i++) {
                let outlineSrc;

                if (i === correctPosition) {
                    // Assign the correct outline for the correct card
                    outlineSrc = selectedImage.outlines[0]; // First outline is always the correct one
                } else {
                    // Shuffle the remaining outlines for the incorrect cards
                    outlineSrc = selectedImage.outlines[i === 0 ? 1 : 2]; // Pick incorrect outlines
                }

                const cardData = createCard(i, i === correctPosition, outlineSrc); // Pass outlineSrc to createCard
                cards.push(cardData);

                cardData.element.addEventListener('click', function () {
                    handleCardClick(cardData);
                });
                cardsContainer.appendChild(cardData.element);
            }
        }

        function handleCardClick(cardData) {
            if (!gameState.canClick || gameState.shuffling) return;

            gameState.canClick = false;
            flipAllCards(false);

            if (cardData.isCorrect) {
                document.getElementById('message').textContent = "Correct! You found the Outline";
                cardData.element.classList.add('victory');

                // Update score for correct answer

                updateScore(10); // Award 10 points for correct guess

                setTimeout(() => {
                    if (cardNumber === 3) {
                        startX = (1150 - totalWidth) / 2;
                        attackMonster(damage);
                        cardNumber += 3;
                        shuffleCount += 5;
                        shuffleTime -= 300;
                    }
                    else if (cardNumber === 6) {
                        startX = (590 - totalWidth) / 2;
                        attackMonster(damage);
                        cardNumber += 3;
                        shuffleCount += 5;
                        shuffleTime -= 150;
                    } else if (cardNumber === 9) {
                        attackMonster(damage + 25);
                    }
                }, 500);

                setTimeout(() => {
                    cardData.element.classList.remove('victory');
                    if (gameState.monsterHp > 0 && gameState.playerHp > 0) {
                        nextRound();
                    }
                }, 2500);
            } else {
                document.getElementById('message').textContent = "Wrong card! Try again!";
                cardData.element.classList.add('wrong');

                const correctCard = cards.find(card => card.isCorrect);
                setTimeout(() => {
                    correctCard.element.classList.add('correct-reveal');
                }, 500);

                setTimeout(() => {

                    monsterAttack();
                    takeDamage();
                }, 1000);

                setTimeout(() => {
                    cardData.element.classList.remove('wrong');
                    correctCard.element.classList.remove('correct-reveal');
                    flipAllCards(true);
                    shuffle();
                    gameState.canClick = true;
                }, 3000);
            }
        }
        let attackCount = 0;
        function switchToLevel2() {
            // Ensure that the timer and level 1 state are cleared
            level1Content.style.display = 'none'; // Hide Level 1 content
            level2Content.style.display = 'block'; // Show Level 2 content
            guessContainer.style.display = 'flex'; // Display guess container for level 2

            // Randomly select an image from the level2Images array
            const randomImageIndex = Math.floor(Math.random() * gameState.level2Images.length);
            const selectedImage = gameState.level2Images[randomImageIndex];

            // Set up level 2 with the randomly selected image
            blurredImage.src = selectedImage.image;

            // **Reset the blur to 100px at the start to ensure consistent animation**
            blurredImage.style.transition = 'none'; // Remove any existing transition
            blurredImage.style.filter = 'blur(100px)'; // Reset the blur to 100px

            // Delay the blur reduction to create the animation effect
            setTimeout(() => {
                if (isStartLevel) {
                    if (attackCount === 0) {
                        blurredImage.style.transition = 'filter 13s ease'; // Ensure smooth transition

                        attackCount++;
                    } else {
                        blurredImage.style.transition = 'filter 7s ease';
                    }
                    blurredImage.style.filter = 'blur(0px)';

                }// Reduce the blur to 0px
            }, 10);

            // Start the timer for Level 2
            startNewLevel(2);

            // Store the selected image in the game state for later use
            gameState.currentLevel2Image = selectedImage;

            // Event listener for when the blur animation ends
            blurredImage.addEventListener('transitionend', () => {
                // Handle when blur finishes
                endLevel();
                pauseTimer();
                showGameOverModal();
            }, { once: true }); // Ensure the event only fires once per call
        }


        // Event listener for submitting a guess
        submitGuess.addEventListener('click', () => {
            const guess = guessInput.value.toLowerCase().trim();
            const currentImage = gameState.currentLevel2Image;

            if (guess === currentImage.answer) {
                document.getElementById('message').textContent = "Correct! You identified the image!";
                level2Content.style.display = 'none';
                attackMonster(50);
                // Force monster defeat to trigger level completion

                // Update score for correct answer
                updateScore(10); // Award 20 points for correct guess
                // showLevel2CompleteModal(); // Show level 2 completion modal
            } else {
                document.getElementById('message').textContent = "Wrong guess! Try again!";
                monsterAttack();
                takeDamage(); // Handle player damage on wrong guess
            }
            if (gameState.monsterHp > 0) {
                switchToLevel2();
            }
            guessInput.value = ''; // Clear input field after submission
        });

        function initializeLevel3() {
            const level3Content = document.getElementById('level3Content');
            level1Content.style.display = 'none';
            level2Content.style.display = 'none';
            level3Content.style.display = 'block';

            const mainImage = document.getElementById('mainImage');
            mainImage.src = gameState.level3.mainImage;

            // Clear any existing dropzones and draggable features
            const mainImageContainer = document.querySelector('.main-image-container');
            mainImageContainer.innerHTML = ''; // Clear previous dropzones if any
            const featuresList = document.getElementById('featuresList');
            featuresList.innerHTML = ''; // Clear previous feature elements if any

            // Create dropzones for the main image
            gameState.level3.features.forEach(feature => {
                const dropzone = createDropzone(feature);
                mainImageContainer.appendChild(dropzone);
            });

            // Create draggable features
            gameState.level3.features.forEach(feature => {
                const featureElement = createFeatureElement(feature);
                featuresList.appendChild(featureElement);
            });

            // Update the progress bar or any level-specific info
            updateLevel3Progress();

            // Start the timer for Level 3
            startNewLevel(3); // This function handles starting the countdown timer for the level
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
                updateLevel3Progress();

                // Update score for a correct match
                updateScore(10); // Example: 10 points for a correct match

                if (gameState.level3.matchedFeatures.size === gameState.level3.features.length) {
                    // Level complete
                    setTimeout(() => {
                        showLevel3CompleteModal();
                        gameState.level++;
                        attackMonster(); // Assuming this triggers the next stage of the game
                    }, 500);
                }
            } else {
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
            dropzone.style.left = feature.correctZone.x + 'px';
            dropzone.style.top = feature.correctZone.y + 'px';

            dropzone.addEventListener('dragover', handleDragOver);
            dropzone.addEventListener('drop', handleDrop);
            dropzone.addEventListener('dragenter', handleDragEnter);
            dropzone.addEventListener('dragleave', handleDragLeave);

            return dropzone;
        }

        function createFeatureElement(feature) {
            const featureElement = document.createElement('div');
            featureElement.className = 'feature-item';
            featureElement.draggable = true;
            featureElement.dataset.featureId = feature.id;

            const featureImage = document.createElement('img');
            featureImage.src = feature.image;
            featureImage.alt = `${feature.type} feature`;
            featureElement.appendChild(featureImage);

            featureElement.addEventListener('dragstart', handleDragStart);
            featureElement.addEventListener('dragend', handleDragEnd);

            return featureElement;
        }


        function nextRound() {
            initializeGame();
            setTimeout(() => {
                flipAllCards(true);
                setTimeout(shuffle, 1000);
            }, 1000);
        }

        function updateLevel3Progress() {
            const progress = (gameState.level3.matchedFeatures.size / gameState.level3.features.length) * 100;
            document.querySelector('.progress-fill').style.width = `${progress}%`;
        }

        function initializeLevel4() {
            const level4Content = document.getElementById('level4Content');
            level1Content.style.display = 'none';
            level2Content.style.display = 'none';
            level3Content.style.display = 'none';
            level4Content.style.display = 'block';

            // Start the timer for Level 4
            startNewLevel(4);

            // Generate a random RGB color for the image
            const randomRed = Math.floor(Math.random() * 256);
            const randomGreen = Math.floor(Math.random() * 256);
            const randomBlue = Math.floor(Math.random() * 256);
            const randomColor = `rgb(${randomRed}, ${randomGreen}, ${randomBlue})`;

            // Set the random color to the color image
            const colorImage = document.getElementById('colorImage');
            colorImage.style.backgroundColor = randomColor;

            const submitColorButton = document.getElementById('submitColor');

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
                    Math.abs(selectedRGB.r - randomRed) <= tolerance &&
                    Math.abs(selectedRGB.g - randomGreen) <= tolerance &&
                    Math.abs(selectedRGB.b - randomBlue) <= tolerance;

                // If the guess is either the automatic pass or within tolerance
                if (isAutoCorrect || isCorrect) {
                    document.getElementById('message').textContent = "Correct! You've matched the color!";

                    // Update score if needed
                    updateScore(10); // Example: 20 points for correct color match

                    showLevel4CompleteModal(); // Show completion modal
                    // gameState.level++; // Progress to the next level
                    attackMonster(); // Move to the next stage or action
                } else {
                    document.getElementById('message').textContent = `Incorrect color! Try again!`;
                    monsterAttack();
                    takeDamage(); // Handle incorrect color guess
                }
            });
        }

        function initializeLevel5() {
            level1Content.style.display = 'none';
            level2Content.style.display = 'none';
            level3Content.style.display = 'none';
            level4Content.style.display = 'none';
            level5Content.style.display = 'block';

            // Start the timer for Level 5
            startNewLevel(5); // Reset and start the countdown timer for Level 5

            const objectImage = document.getElementById('objectImage');
            const targetZoneMessage = document.getElementById('targetZoneMessage'); // Message element

            // Define all detection zones and their respective IDs
            const detectionZones = [
                { id: 'mediumTree', name: 'Medium Tree' },
                { id: 'smallTree', name: 'Small Tree' },
                { id: 'largestTree', name: 'Largest Tree' },
                { id: 'bench', name: 'Bench' },
                { id: 'sun', name: 'Sun' }
            ];

            // Randomly select a target from the detection zones
            const randomIndex = Math.floor(Math.random() * detectionZones.length);
            const selectedTarget = detectionZones[randomIndex];

            targetZoneMessage.innerText = `Click on the: ${selectedTarget.name}`;

            // Event listener for image click
            objectImage.addEventListener('click', function (event) {
                const rect = objectImage.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;

                // Get the target zone using getBoundingClientRect()
                const targetZone = document.getElementById(selectedTarget.id);
                const targetRect = targetZone.getBoundingClientRect();

                // Check if the clicked area is within the target zone
                const detected = (x >= targetRect.left - rect.left && x <= targetRect.right - rect.left) &&
                    (y >= targetRect.top - rect.top && y <= targetRect.bottom - rect.top);

                if (detected) {
                    // Update score for successful detection
                    updateScore(10); // Example: Award 20 points for detecting the object

                    showLevel5CompleteModal(); // Trigger the completion modal for Level 5
                    gameState.level++; // Move to the next level
                } else {
                    monsterAttack();
                    takeDamage();
                }
            });
        }

        function initializePostTest() {
            const quizSound = new Audio("{{ asset('music/quizBackgroundMusic.mp3') }}");
            quizSound.play();
            pauseTimer(); // Pause any timers if applicable
            const totalScore = gameState.totalScore || 0;

            // Hide level content
            document.getElementById('level1Content').style.display = 'none';
            document.getElementById('level2Content').style.display = 'none';
            document.getElementById('level3Content').style.display = 'none';
            document.getElementById('level4Content').style.display = 'none';
            document.getElementById('level5Content').style.display = 'none';

            const canvas = document.getElementById('gameCanvas');
            const ctx = canvas.getContext('2d');

            const shootSound = new Audio("{{ asset('audio/shootSound.mp3') }}");

            const questions = [
              {
                    question: "1. Why are outlines essential in image recognition?",
                    answers: ["A. Define shape", "B. Add color", "C. Highlight details", "D. Remove textures"],
                    correct: 0
                },
                {
                    question: "2. What is pixelation in image recognition?",
                    answers: ["A. Enhancing details", "B. Transforming to blocks", "C. Increasing size", "D. Improving color"],
                    correct: 1
                },
                {
                    question: "3. What role do outlines play in feature extraction?",
                    answers: ["A. They obscure details", "B. They help identify shapes", "C. They add complexity", "D. They reduce processing time"],
                    correct: 1
                },
                {
                    question: "4. Which of the following best describes pixelation?",
                    answers: ["A. A smoothing technique", "B. A method to reduce noise", "C. A way to create block-like images", "D. A technique for enhancing edges"],
                    correct: 2
                },
                {
                    question: "5. Why is it important to recognize outlines in image processing?",
                    answers: ["A. To remove background noise", "B. To improve image resolution", "C. To extract essential features", "D. To enhance color saturation"],
                    correct: 2
                },
                {
                    question: "6. How does pixelation affect image quality?",
                    answers: ["A. It improves sharpness", "B. It makes images clearer", "C. It reduces detail", "D. It has no effect"],
                    correct: 2
                },
                {
                    question: "7. Which method is commonly used for detecting outlines?",
                    answers: ["A. Histogram equalization", "B. Edge detection algorithms", "C. Noise reduction", "D. Image segmentation"],
                    correct: 1
                },
                {
                    question: "8. What happens to pixelated images when you zoom in?",
                    answers: ["A. They become clearer", "B. They show blocks of color", "C. They lose detail", "D. They remain unchanged"],
                    correct: 1
                },
              
            ];

            let currentQuestion = 0;
    let score = 0;
    const totalQuestions = questions.length;
    let gameActive = true;
    let crosshairX = 400;
    let crosshairY = 300;
    let hitAnimationActive = false;
    let hitAnimationX = 0;
    let hitAnimationY = 0;
    let hitAnimationFrame = 0;

            // Function to draw the game
            function drawGame() {
        if (!gameActive) return;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (currentQuestion < totalQuestions) {
            document.getElementById('questionText').innerText = questions[currentQuestion].question;

            questions[currentQuestion].answers.forEach((answer, i) => {
                const xPos = 100 + (i * 200);
                drawTarget(xPos, 300, answer);
            });

            drawCrosshair(crosshairX, crosshairY);

            if (hitAnimationActive) {
                drawHitAnimation(hitAnimationX, hitAnimationY);
                hitAnimationFrame++;

                if (hitAnimationFrame > 5) {
                    hitAnimationActive = false;
                    hitAnimationFrame = 0;
                }
            }
        }
    }

// Function to draw targets with answers inside
function drawTarget(x, y, answer) {
    const targetSize = 100; // Increased size of the target shape
    const innerCircleSize = 80; // Increased size of the inner circle
    const outerCircleColor = "white"; // Color for the outer circle
    const innerCircleColor = "rgba(255, 0, 0, 0.7)"; // Semi-transparent red for inner circle outline
    const textColor = "black"; // Text color
    const fontSize = "20px"; // Increased font size for better readability

    // Draw outer target (white circle)
    ctx.fillStyle = outerCircleColor; // Fill color for the outer target
    ctx.beginPath();
    ctx.arc(x, y, targetSize, 0, Math.PI * 2); // Draw the outer circle
    ctx.fill();
    ctx.closePath();

    // Draw inner target (red circle outline)
    ctx.strokeStyle = innerCircleColor; // Outline color for the inner circle
    ctx.lineWidth = 8; // Width of the circle outline
    ctx.beginPath();
    ctx.arc(x, y, innerCircleSize, 0, Math.PI * 2); // Draw the inner circle outline
    ctx.stroke();
    ctx.closePath();

    // Draw the answer inside the target
    ctx.fillStyle = textColor; // Text color
    ctx.font = `${fontSize} Arial`; // Font style with increased size
    ctx.textAlign = "center"; // Center text alignment
    ctx.textBaseline = "middle"; // Vertically center the text
    ctx.fillText(answer, x, y); // Center the text vertically
}

            // Function to draw crosshair
            function drawCrosshair(x, y) {
                ctx.strokeStyle = "red"; // Crosshair color
                ctx.lineWidth = 2; // Crosshair line width
                ctx.beginPath();
                ctx.moveTo(x - 10, y);
                ctx.lineTo(x + 10, y);
                ctx.moveTo(x, y - 10);
                ctx.lineTo(x, y + 10);
                ctx.stroke();
            }

            function drawHitAnimation(x, y) {
    // Explosion burst effect
    const maxBurstRadius = 50;
    const burstRadius = 10 + hitAnimationFrame * 3;
    const burstOpacity = 1 - hitAnimationFrame / 10;

    // Draw expanding burst
    ctx.fillStyle = `rgba(255, 69, 0, ${burstOpacity})`; // Orange-red color
    ctx.beginPath();
    ctx.arc(x, y, Math.min(burstRadius, maxBurstRadius), 0, Math.PI * 2);
    ctx.fill();
    ctx.closePath();

    // Simulate "hole" in the target
    const holeRadius = hitAnimationFrame * 2;
    ctx.fillStyle = "black";
    ctx.beginPath();
    ctx.arc(x, y, holeRadius, 0, Math.PI * 2);
    ctx.fill();
    ctx.closePath();

    // Particle debris effect
    for (let i = 0; i < 8; i++) {
        const angle = (Math.PI / 4) * i;
        const particleX = x + Math.cos(angle) * burstRadius;
        const particleY = y + Math.sin(angle) * burstRadius;
        const particleSize = 2 + Math.random() * 2;

        ctx.fillStyle = `rgba(169, 169, 169, ${burstOpacity})`; // Gray debris
        ctx.beginPath();
        ctx.arc(particleX, particleY, particleSize, 0, Math.PI * 2);
        ctx.fill();
        ctx.closePath();
    }

    hitAnimationFrame++;

    if (hitAnimationFrame > 10) {
        hitAnimationActive = false;
        hitAnimationFrame = 0;
    }
}

            canvas.addEventListener('mousemove', function (event) {
                const rect = canvas.getBoundingClientRect();
                crosshairX = event.clientX - rect.left; // Update crosshair X position
                crosshairY = event.clientY - rect.top;  // Update crosshair Y position
                drawGame(); // Redraw the game to update the crosshair position
            });

            // Click event to handle answer selection
            canvas.addEventListener('click', function () {
            shootSound.play();
                const targetSize = 80; // Size of the target shape

                 let hit = false;

                // Check if a target was clicked
                questions[currentQuestion].answers.forEach((answer, i) => {
                    const xPos = 100 + (i * 200); // Calculate X position for the target

                    if (
                        crosshairX > xPos - targetSize &&
                        crosshairX < xPos + targetSize &&
                        crosshairY > 300 - targetSize &&
                        crosshairY < 300 + targetSize
                    ) {
                    hit = true;
                        if (i === questions[currentQuestion].correct) {
                score++; // Increase score for correct answer
                
            }
                hitAnimationActive = true;
                hitAnimationX = xPos;
                hitAnimationY = 300;

                if(hit){
            currentQuestion++;

            // Check if there are more questions left
            if (currentQuestion < totalQuestions) {
                drawGame();
            } else {
                quizSound.pause();
                // Display end of game modal
                const percentageScore = (score / totalQuestions) * 100;
                document.getElementById('finalScoreText').innerText = `Your score: ${score}/${totalQuestions} (${percentageScore.toFixed(2)}%)`;
                document.getElementById('scoreModal').style.display = 'flex'; // Show modal

                // Check if the user passed or failed
                if (percentageScore >= 80) {
                    document.getElementById('finalScoreText').innerText += `\nCongratulations, you passed!`;
                    const updatedTotalScore = gameState.totalScore + score;

                    // Update the game state with the new total score
                    gameState.totalScore = updatedTotalScore;
                    showModal(updateScore);
                    // Display the total score including the post-test score
                    console.log(updatedTotalScore);
                    document.getElementById('score').innerText = `Your total score: ${updatedTotalScore}`;

                    // Save the score to the database
                    const baseUrl = window.location.origin;
                    const userId = localStorage.getItem('user_id');
                    console.log('User ID:', userId); // Get user ID from local storage

                    // First, update the user's easy_finish status
                    fetch(`${baseUrl}/update-easy-finish/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to include CSRF token
                        },
                        body: JSON.stringify({ easy_finish: 1 }) // Set easy_finish to true
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('easy_finish updated successfully:', data);

                            // After updating easy_finish, now save the score
                            return fetch(`${baseUrl}/easy-update-score/${userId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to include CSRF token
                                },
                                body: JSON.stringify({ score: updatedTotalScore })
                            });
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Score updated successfully:', data);
                        })
                        .catch(error => {
                            console.error('Error updating score or easy_finish:', error);
                        });
                    document.getElementById('postTestContainer').style.display = 'none';
                } else {
                    document.getElementById('finalScoreText').innerText += `\nYou need to score at least 80% to pass. Try again!`;
                    setTimeout(() => {
                        currentQuestion = 0; // Reset to the first question
                        score = 0; // Reset score
                        gameActive = true; // Reactivate the game
                        window.location.href = "{{ route('easy') }}"; // Restart the game
                    }, 1000);
                }
                // Stop the game
                gameActive = false;
            }
                
            }
        }
    });
});
            // Start the drawing loop
            drawGame();
            setInterval(drawGame, 100);
            document.getElementById('postTestContainer').style.display = 'block'; // Show post-test container
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
            window.location.href = "{{ route('easy') }}"; // Redirect to easy.blade.php
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

        // function attackMonster() {
        //     if (!gameState.isPlayerAttacking && !gameState.isMonsterAttacking) {
        //         gameState.isPlayerAttacking = true;
        //         gameState.attackFrame = 0;
        //         animateAttack('player');
        //     }
        // }
        const learningMaterials = {
    1: [
        "Outlines define object shapes and distinguish them from the background. This helps simplify object recognition.",
        "Using outlines helps with tasks like shape recognition and segmentation. They are used in handwriting recognition.",
        "Outlines help prepare users for advanced image analysis by improving shape recognition skills."
    ],
    2: [
        "Pixelation simplifies images by reducing detail but keeping shape and color intact.",
        "Different pixelation levels help improve object recognition skills by focusing on broader features.",
        "Practicing with pixelation aids in training machine learning models to recognize objects with varying detail."
    ],
    3: [
        "Feature extraction identifies important characteristics like edges and textures to help classify objects.",
        "Techniques like SIFT and SURF focus on relevant image details for tasks like object detection.",
        "Mastering feature extraction strengthens skills in object detection and computer vision."
    ],
    4: [
        "Color identification helps distinguish objects by their color properties, which is essential in image recognition.",
        "RGB analysis reveals color distributions and helps improve image analysis abilities.",
        "Practicing color identification is vital for fields like image editing and medical imaging."
    ],
    5: [
        "Object detection focuses on identifying and locating objects within images, marked by bounding boxes.",
        "It's used in autonomous vehicles, surveillance, and augmented reality applications.",
        "Object variations and occlusions are challenges that can be addressed with techniques like data augmentation."
    ]
};

let currentMonologueIndex = 0;
let monologueInterval;
let availableVoices = [];

// Function to display monologues one by one for a given level
function showMonologuesInSequence(level, delay = 10000) {
    endLevel();
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
    const selectedVoiceName = "Google UK English Male";
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

    // Play background music
    

    // If the level starts, play the background music
    if (currentLevel === 1) {
        draw();
        intenseFightMusic.play(); // Start playing the calm background music
        setTimeout(() => {
            flipAllCards(true); // Flip all cards face up
            setTimeout(shuffle, 1000); // Shuffle after a delay
        }, 1000);
        currentLevel++;
    } else if (currentLevel === 2) {
        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
        draw();
        isStartLevel = true;
        switchToLevel2();
        currentLevel++;
    }
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
                    clearInterval(monologueInterval); 
                    document.getElementById("learning-modal").style.display = "none";
                    skipButton.style.display = "none"; 
                    resumeTimer(); 
                    startLevel(currentLevel);
                    gameState.monsterHp = 100; 
                    startTimer();
                    updateStats(); 
                    
                    if (currentLevel === 1) {
                        draw();
                        intenseFightMusic.play(); // Start playing the calm background music
                        setTimeout(() => {
                            flipAllCards(true); // Flip all cards face up
                            setTimeout(shuffle, 1000); // Shuffle after a delay
                        }, 1000);
                        currentLevel++;
                    } else if (currentLevel === 2) {
                        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
                        draw();
                        isStartLevel = true;
                        switchToLevel2();
                        currentLevel++;
                    }
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
            ctx.fillText(damage, gameState.damageText.x, gameState.damageText.y);
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


        function handleLevelComplete() {
            if (gameState.level === 1) {
                showLevel1CompleteModal();
            } else if (gameState.level === 2) {
                showLevel2CompleteModal();
            } else if (gameState.level === 3) {
                alert("Congratulations! You've completed all levels!");
                resetGame();
            }
        }

        // Call this function to trigger the attack
        function triggerAttack() {
            gameState.isAttacking = true;
        }
        // Start the game
        initializeGame();


    </script>
</body>

</html>