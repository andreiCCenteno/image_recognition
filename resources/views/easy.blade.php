<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Image Processing Card Game</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');
        body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    font-family: 'Roboto Mono', monospace; /* Retained your font */
    color: #00ffcc; /* Bright, neon-like text color */
    text-align: center;
    background: linear-gradient(135deg, #141e30, #243b55, #4b79a1, #00c853, #ff007f, #ff4081);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite; /* Dynamic background animation */
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    box-shadow: inset 0 0 30px rgba(255, 255, 255, 0.1); /* Subtle depth effect */
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
h1, h2, h3, p {
    text-shadow: 0 0 20px rgba(0, 255, 204, 0.6), 0 0 30px rgba(0, 255, 204, 0.6); /* Neon glow */
}

#gameContainer {
    width: 1800px;
    margin: 20px auto; /* Centered horizontally */
    display: flex;
    flex-direction: column;
    gap: 20px;
    background: rgba(255, 255, 255, 0.1); /* Light translucent background */
    border-radius: 15px; /* Rounded corners */
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
    background: rgba(255, 255, 255, 0.2); /* Semi-transparent background */
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
    background: rgba(255, 255, 255, 0.1); /* Light translucent */
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
    background: linear-gradient(145deg, #4CAF50, #45a049); /* Gradient button */
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

                /* Level 3 specific styles */
                #level3Content {
    display: none;
    max-width: 100%; /* Ensures it doesn't exceed the screen width */
    width: 90%; /* Keeps it at a responsive size within the screen */
    margin: 0 auto; /* Centers the content */
    padding: 20px;
    background: rgba(0, 0, 0, 0.8); /* Adds a semi-transparent background */
    border-radius: 10px; /* Adds rounded corners */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5); /* Creates a shadow for depth */
    color: white;
    word-wrap: break-word; /* Prevents content from overflowing */
}

/* Media queries for responsive design */
@media (max-width: 1024px) {
    #level3Content {
        width: 95%; /* Slightly reduces the width for smaller screens */
        padding: 15px;
    }
}

@media (max-width: 768px) {
    #level3Content {
        width: 100%; /* Takes up more space on smaller screens */
        padding: 10px;
        margin: 10px; /* Adds a margin for better layout */
    }
}

@media (max-width: 480px) {
    #level3Content {
        width: 100%;
        padding: 8px;
        margin: 5px; /* Adds a smaller margin for better fit on small devices */
        font-size: 14px; /* Reduces text size for smaller screens */
    }
}

        .feature-matching-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    flex-wrap: wrap; /* Allows wrapping on smaller screens */
}

.main-image-container {
    width: 100%; /* Makes it responsive, can adjust for larger screens */
    max-width: 400px; /* Limits the size */
    height: auto; /* Maintains aspect ratio */
    position: relative;
    border: 2px solid #333;
    margin-right: 20px;
    margin-bottom: 20px; /* Space between images on smaller screens */
}

/* Ensures responsiveness on smaller screens */
@media (max-width: 768px) {
    .main-image-container {
        width: 100%; /* Full width on smaller devices */
        max-width: none; /* Remove the fixed width for better flexibility */
        height: auto;
    }

    .feature-matching-container {
        flex-direction: column; /* Stacks images vertically */
        align-items: center; /* Centers the content */
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
            width: 200px;
            padding: 10px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .feature-item {
            width: 180px;
            height: 100px;
            margin: 10px 0;
            border: 2px solid #333;
            cursor: grab;
            position: relative;
            overflow: hidden;
        }

        .feature-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Progress indicator */
        .progress-bar {
    width: 100%;
    height: 25px; /* Slightly increased height for better visibility */
    background: linear-gradient(145deg, #222, #555); /* Gradient background for a sleek look */
    border-radius: 15px; /* Increased roundness for a smoother feel */
    margin: 15px 0; /* Increased margin for better spacing */
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Adds shadow for depth */
    border: 1px solid #4CAF50; /* Neon-like border effect */
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00ff7f, #32cd32, #228b22); /* Neon green gradient */
    width: 0%;
    transition: width 0.3s ease, background 0.6s ease; /* Smooth transition for both width and color */
    box-shadow: 0px 4px 15px rgba(0, 255, 127, 0.8); /* Glowing effect */
    border-radius: 15px; /* Matches the outer container’s roundness */
}

/* Optional animation for progress fill to pulse */
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

/* Apply the pulse effect when the progress bar is filling */
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
    display: none; /* Initially hidden */
    position: fixed; /* Fixed position */
    z-index: 1; /* Ensure modal is on top */
    left: 0; /* Align to the left */
    top: 0; /* Align to the top */
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scrolling if necessary */
    background: linear-gradient(135deg, rgba(10, 10, 10, 0.9), rgba(30, 30, 30, 0.9)); /* Dark gradient for a futuristic look */
    backdrop-filter: blur(15px); /* Blur effect for background */
    animation: fadeIn 0.5s; /* Fade-in animation */
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
    background: rgba(20, 20, 20, 0.95); /* Darker, semi-transparent background without white */
    padding: 30px; /* Increased padding for better spacing */
    border: none; /* Remove default border */
    width: 90%; /* Slightly less than full width */
    position: fixed; /* Fixed position */
    left: 50%; /* Center horizontally */
    transform: translateX(-50%); /* Adjust for centering */
    bottom: 5%; /* Align to the bottom with some margin */
    border-radius: 15px; /* Rounded corners for a modern look */
    box-shadow: 0 8px 30px rgba(0, 255, 204, 0.5); /* Subtle glowing shadow for depth */
    color: #00ffcc; /* Futuristic text color */
    display: flex; /* Flexbox for alignment */
    flex-direction: column; /* Column layout */
    align-items: center; /* Center items */
    font-size: 1.2em; /* Font size */
    text-align: justify; /* Justified text alignment */
    overflow-wrap: break-word; /* Prevent overflow */
    word-wrap: break-word; /* For compatibility */
}



        .character {
            width: 100px; /* Adjust character size */
            margin-right: 20px; /* Space between character and text */
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
            display: none; /* Initially hide game area */
        }

        #colorContainer {
    display: flex;              /* Enables flexbox layout */
    justify-content: center;    /* Centers content horizontally */
    align-items: center;        /* Centers content vertically */
    height: 300px;             /* Set the height of the container */
}

#colorImage, #selectedColorImage {
    width: 300px;              /* Width of the color display */
    height: 300px;             /* Height of the color display */
    background-color: rgb(0, 0, 0); /* Default background color */
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
    z-index: 1000; /* Ensure the modal is above other content */
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
    background-color: #0f3460; /* Button color */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #1a1a2e; /* Change color on hover */
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
    width: 100%;
    padding: 20px;
    text-align: center;
    color: #fff;
}

/* Color Container */
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
    background-color: rgb(0, 0, 0); /* Default black */
    border: 2px solid #4CAF50; /* Neon green border */
    margin-right: 20px;
    box-shadow: 0 0 15px rgba(0, 255, 127, 0.7); /* Glowing effect */
}

#selectedColorImage {
    width: 200px;
    height: 200px;
    border: 2px solid #4CAF50;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.6); /* Subtle glow */
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
/* Level 5 Content Styling */
#level5Content {
    text-align: center;
    padding: 20px;
    color: #fff;
}

#targetZoneMessage {
    font-size: 18px;
    color: #ff9800;
}

/* Object Detection Container */
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

/* Detection Zones */
.detection-zone {
    position: absolute;
    cursor: pointer;
    transition: background-color 0.3s, border-color 0.3s;
}

.detection-zone:hover {
    background-color: rgba(255, 255, 255, 0.5);
    border-color: #FFC300;
}


/* Detected Objects List */
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

/* General Test Container Styling */
#postTestWrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.05); /* Light overlay for effect */ /* Light overlay for effect */
    }

    #postTestContainer {
        max-height: 80vh;
        width: 80%;
        overflow-y: auto;
        padding: 20px;
        background: rgba(20, 20, 20, 0.85);
        border-radius: 10px;
        box-shadow: 0 4px 30px rgba(0, 255, 204, 0.5);
    }

    .test-form-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .question {
        background: rgba(20, 20, 20, 0.85);
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .question p {
        font-size: 18px;
        margin-bottom: 10px;
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
            font-size: 2rem; /* Make the icon bigger */
            z-index: 1000; /* Ensure it stays on top of other elements */
            padding: 10px;
        }

        /* Optional hover effect */
        #settingsIcon:hover {
            transform: scale(1.1);
        }
        .gameover-modal {
            display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.8); /* Dark background with more opacity */
    justify-content: center; /* Center modal content */
    align-items: center; /* Center modal content */
}

.gameover-modal-content {
    background: linear-gradient(135deg, rgba(0, 0, 50, 0.8), rgba(0, 0, 100, 0.6)); /* Futuristic gradient */
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5); /* Light border with transparency */
    border-radius: 15px; /* Rounded corners */
    width: 300px; /* Could be more or less, depending on screen size */
    text-align: center; /* Center text */
    box-shadow: 0 0 30px rgba(255, 255, 255, 0.5); /* Center text */
}

.modal-background {
    position: absolute; /* Allows positioning relative to modal */
    top: 0; /* Align to the top of the modal */
    left: 0; /* Align to the left of the modal */
    right: 0; /* Stretch to the right */
    bottom: 0; /* Stretch to the bottom */
    z-index: -1; /* Send the background image behind the modal content */
}

.modal-image {
    width: 70%; /* Set the width to 70% of the modal */
    height: auto; /* Maintain aspect ratio */
    /* opacity: 0.1; Make the image semi-transparent         */
    position: absolute; 
    transform: translateY(-50%) scaleX(-1); /* Center and flip */
    position: absolute; /* Position it absolutely within the modal background */
    top: 70%; /* Adjusted to lower the image */
    right: 0%;/* Align to the right */
}
    </style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

</head>

<body>

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
        <img id="objectImage" src="{{ asset('images/easy/scenery.avif') }}" style="max-width: 100%; cursor: pointer;">
    
            <!-- Large Detection Zones -->
            <div id="mediumTree" class="detection-zone" style="left: 32px; top: 90px; width: 35px; height: 200px;"></div>
            <div id="smallTree" class="detection-zone" style="left: 110px; top: 150px; width: 300px; height: 100px;"></div>
            <div id="largestTree" class="detection-zone" style="left: 520px; top: 20px; width: 100px; height: 350px;"></div>
    
            <!-- Small Detection Zones -->
            <div id="bench" class="detection-zone" style="left: 20px; top: 250px; width: 95px; height: 30px;"></div>
            <div id="sun" class="detection-zone" style="left: 415px; top: 12px; width: 50px; height: 50px;"></div>
            
        </div>
    </div>

    <div id="detectedObjectsList"></div>    
    
    </div>
        
        <div class="modal-overlay" id="level5CompleteModal" style="display: none;">
            <div class="modal">
                <h2>Level 5 Complete!</h2>
                <p>You've completed the object detection level.</p>
                <button onclick="startLevel6()">Start Level 6</button>
            </div>
        </div>        

        <div id="postTestWrapper">
        <div id="postTestContainer" style="display: none;">
            <h2>Post-Test</h2>
<div id="questionsContainer">
    <div class="question" id="question1">
        <p>1. Why are outlines essential in image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q1" value="a"> A. They help distinguish objects from the background by defining their shape</label>
            <label class="option"><input type="radio" name="q1" value="b"> B. They add color to images for better recognition</label>
            <label class="option"><input type="radio" name="q1" value="c"> C. They highlight intricate details of objects</label>
            <label class="option"><input type="radio" name="q1" value="d"> D. They remove textures from the objects</label>
        </div>
    </div>

    <div class="question" id="question2">
        <p>2. What role do edge detection algorithms play in outline recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q2" value="a"> A. They enhance image resolution</label>
            <label class="option"><input type="radio" name="q2" value="b"> B. They detect and highlight the outlines of objects in images</label>
            <label class="option"><input type="radio" name="q2" value="c"> C. They convert images into abstract shapes</label>
            <label class="option"><input type="radio" name="q2" value="d"> D. They remove color from the image</label>
        </div>
    </div>

    <div class="question" id="question3">
        <p>3. What is pixelation in image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q3" value="a"> A. The process of enhancing details of an image</label>
            <label class="option"><input type="radio" name="q3" value="b"> B. Transforming an image into grid-like blocks, obscuring finer details</label>
            <label class="option"><input type="radio" name="q3" value="c"> C. Increasing the size of the objects in the image</label>
            <label class="option"><input type="radio" name="q3" value="d"> D. Improving color accuracy in an image</label>
        </div>
    </div>

    <div class="question" id="question4">
        <p>4. Why is pixelation important in image recognition learning?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q4" value="a"> A. It allows learners to focus on overall shapes without being distracted by details</label>
            <label class="option"><input type="radio" name="q4" value="b"> B. It enhances the color accuracy of images</label>
            <label class="option"><input type="radio" name="q4" value="c"> C. It increases the resolution of the image</label>
            <label class="option"><input type="radio" name="q4" value="d"> D. It highlights the textures of the objects</label>
        </div>
    </div>

    <div class="question" id="question5">
        <p>5. How can adjusting pixelation levels help in image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q5" value="a"> A. By revealing hidden details gradually</label>
            <label class="option"><input type="radio" name="q5" value="b"> B. By reducing the complexity of shapes</label>
            <label class="option"><input type="radio" name="q5" value="c"> C. By changing the colors of the objects</label>
            <label class="option"><input type="radio" name="q5" value="d"> D. By increasing the number of objects in the image</label>
        </div>
    </div>

    <div class="question" id="question6">
        <p>6. What is feature extraction in image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q6" value="a"> A. Identifying specific characteristics of an image, such as edges and textures</label>
            <label class="option"><input type="radio" name="q6" value="b"> B. Adding color to objects in the image</label>
            <label class="option"><input type="radio" name="q6" value="c"> C. Changing the shapes of the objects</label>
            <label class="option"><input type="radio" name="q6" value="d"> D. Decreasing the resolution of the image</label>
        </div>
    </div>

    <div class="question" id="question7">
        <p>7. Why is feature extraction important in object detection?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q7" value="a"> A. It allows for precise identification of objects by focusing on key characteristics</label>
            <label class="option"><input type="radio" name="q7" value="b"> B. It enhances the overall shape of the objects</label>
            <label class="option"><input type="radio" name="q7" value="c"> C. It increases the brightness of the image</label>
            <label class="option"><input type="radio" name="q7" value="d"> D. It modifies the contrast of the image</label>
        </div>
    </div>

    <div class="question" id="question8">
        <p>8. Which algorithms are commonly used in feature extraction for image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q8" value="a"> A. Edge detection and SIFT</label>
            <label class="option"><input type="radio" name="q8" value="b"> B. Color correction and brightness control</label>
            <label class="option"><input type="radio" name="q8" value="c"> C. Pixelation and resolution enhancement</label>
            <label class="option"><input type="radio" name="q8" value="d"> D. Noise reduction and sharpening</label>
        </div>
    </div>

    <div class="question" id="question9">
        <p>9. How does color identification contribute to image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q9" value="a"> A. By helping to differentiate objects based on their color properties</label>
            <label class="option"><input type="radio" name="q9" value="b"> B. By blurring the objects to make recognition harder</label>
            <label class="option"><input type="radio" name="q9" value="c"> C. By enhancing the texture of the objects</label>
            <label class="option"><input type="radio" name="q9" value="d"> D. By focusing only on the shapes of the objects</label>
        </div>
    </div>

    <div class="question" id="question10">
        <p>10. What techniques are used in color identification for image analysis?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q10" value="a"> A. Color histograms and RGB analysis</label>
            <label class="option"><input type="radio" name="q10" value="b"> B. Brightness control and pixelation</label>
            <label class="option"><input type="radio" name="q10" value="c"> C. Contrast adjustment and shadow detection</label>
            <label class="option"><input type="radio" name="q10" value="d"> D. Noise reduction and sharpening</label>
        </div>
    </div>

    <div class="question" id="question11">
        <p>11. What is the primary challenge of object detection?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q11" value="a"> A. Locating and classifying objects in varying conditions</label>
            <label class="option"><input type="radio" name="q11" value="b"> B. Reducing the size of the images</label>
            <label class="option"><input type="radio" name="q11" value="c"> C. Changing the brightness of the objects</label>
            <label class="option"><input type="radio" name="q11" value="d"> D. Extracting key features such as color and texture</label>
        </div>
    </div>

    <div class="question" id="question12">
        <p>12. In object detection, what is typically used to represent the location of an object?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q12" value="a"> A. A bounding box</label>
            <label class="option"><input type="radio" name="q12" value="b"> B. A shadow</label>
            <label class="option"><input type="radio" name="q12" value="c"> C. A pixel grid</label>
            <label class="option"><input type="radio" name="q12" value="d"> D. A histogram</label>
        </div>
    </div>

    <div class="question" id="question13">
        <p>13. How does brightness and contrast adjustment impact image recognition?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q13" value="a"> A. It enhances visibility and helps distinguish between objects</label>
            <label class="option"><input type="radio" name="q13" value="b"> B. It reduces noise and blurs the objects</label>
            <label class="option"><input type="radio" name="q13" value="c"> C. It changes the shape of the objects</label>
            <label class="option"><input type="radio" name="q13" value="d"> D. It removes color from the image</label>
        </div>
    </div>

    <div class="question" id="question14">
        <p>14. Which of the following is NOT commonly used in image recognition techniques?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q14" value="a"> A. Shape analysis</label>
            <label class="option"><input type="radio" name="q14" value="b"> B. Noise addition</label>
            <label class="option"><input type="radio" name="q14" value="c"> C. Edge detection</label>
            <label class="option"><input type="radio" name="q14" value="d"> D. Feature extraction</label>
        </div>
    </div>

    <div class="question" id="question15">
        <p>15. What is the main advantage of using RGB sliders in color identification?</p>
        <div class="options">
            <label class="option"><input type="radio" name="q15" value="a"> A. It allows for precise color matching by adjusting Red, Green, and Blue levels</label>
            <label class="option"><input type="radio" name="q15" value="b"> B. It reduces the resolution of the image</label>
            <label class="option"><input type="radio" name="q15" value="c"> C. It enhances the size of objects</label>
            <label class="option"><input type="radio" name="q15" value="d"> D. It changes the overall shape of objects</label>
        </div>
    </div>
</div>
    
                <button id="submitTest">Submit Test</button>
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
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

function showGameOverModal() {
    const modal = document.getElementById('gameOverModal');
    modal.style.display = 'flex'; // Show modal with flexbox for centering

    // Set up button event listeners
    document.getElementById('playAgainButton').addEventListener('click', function() {
        window.location.href = "{{ url('easy') }}"; // Reset the game state (you'll need to implement this)
        modal.style.display = 'none'; // Hide modal
    });

    document.getElementById('exitGameButton').addEventListener('click', function() {
        window.close(); // Close the game window
        // Or you can redirect to a specific URL
        window.location.href = "{{ url('play') }}"; // Redirect to the main page
    });
}
        $(document).ready(function() {
    // Show settings modal when settings icon is clicked
    $('#settingsIcon').click(function() {
        $('#settingsModal').show();
    });

    // Close settings modal
    window.closeSettingsModal = function() {
        $('#settingsModal').hide();
    }

    // Resume button functionality
    $('#resumeButton').click(function() {
        closeSettingsModal(); // Close the modal
        // Additional logic to resume the game can go here
    });

    // Quit game button functionality
    $('#quitGameButton').click(function() {
        window.location.href = "{{ url('play') }}";
    });
});

        function playClickSound() {
    var clickSound = document.getElementById('clickSound');
    clickSound.play();
}
document.querySelectorAll('button, a').forEach(function(element) {
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
                'images/easy/vase_outline.jpg'
            ]
        },

        {
            original: 'images/easy/triangle.webp',
            outlines: [
                'images/easy/triangle_outline.jpg',
                'images/easy/ball_outline.jpg',
                'images/easy/vase_outline.jpg'
            ]
        },

        {
            original: 'images/easy/box.jpg',
            outlines: [
                'images/easy/box_outline.jpg',
                'images/easy/ball_outline.jpg',
                'images/easy/vase_outline.jpg'
            ]
        },

        {
            original: 'images/easy/vase.jpg',
            outlines: [
                'images/easy/vase_outline.jpg',
                'images/easy/apple_outline.jpg',
                'images/easy/triangle_outline.jpg'
            ]
        },
        {
            original: 'images/easy/balloon.jpg',
            outlines: [
                'images/easy/balloon_outline.jpg',
                'images/easy/ball_outline.jpg',
                'images/easy/apple_outline.jpg'
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
            monsterX: 600,
            monsterY: 150,
            playerHurt: false,
            monsterHurt: false

};

const gameScene = document.getElementById('gameScene');
const ctx = gameScene.getContext('2d');
const cardsContainer = document.getElementById('cardsContainer');
const targetImage = document.getElementById('targetImage');
let level1Content = document.getElementById('level1Content');
let level2Content = document.getElementById('level2Content');
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


    console.log(gameState.level);
    console.log(currentLevel);
}


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
    showLearningMaterial(2);
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
    const randomImageIndex = Math.floor(Math.random() * gameState.images.length);
    const selectedImage = gameState.images[randomImageIndex];

    // Set the target image to the randomly selected one
    targetImage.src = selectedImage.original;

    level1Content.style.display = 'block';

    // Randomize the correct position for the correct outline
    const correctPosition = Math.floor(Math.random() * 3);

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
            if(cardNumber === 3){
                startX = (1150 - totalWidth) / 2;
                attackMonster(damage);
                cardNumber += 3;
                shuffleCount += 5;
                shuffleTime -= 300;
            }
            else if(cardNumber === 6){
                startX = (590 - totalWidth) / 2;
                attackMonster(damage);
                cardNumber += 3;
                shuffleCount += 5;
                shuffleTime -= 150;
            }else if(cardNumber === 9){
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
    if(isStartLevel){
        if(attackCount === 0){
            blurredImage.style.transition = 'filter 13s ease'; // Ensure smooth transition
            
            attackCount++;
        }else{
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
    if(gameState.monsterHp > 0){
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
    objectImage.addEventListener('click', function(event) {
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

    pauseTimer();
// Hide all levels content
level1Content.style.display = 'none';
level2Content.style.display = 'none';
level3Content.style.display = 'none';
level4Content.style.display = 'none';
level5Content.style.display = 'none';

// Show the post-test content
postTestContainer.style.display = 'block';

// Display the accumulated total score from all levels

// Add event listener to the submit button
}

function submitPostTest() {
    pauseTimer();
    const totalScore = gameState.totalScore || 0;

    // Get the answers from the post-test
    const answer1 = document.querySelector('input[name="q1"]:checked');
    const answer2 = document.querySelector('input[name="q2"]:checked');
    const answer3 = document.querySelector('input[name="q3"]:checked');
    const answer4 = document.querySelector('input[name="q4"]:checked');
    const answer5 = document.querySelector('input[name="q5"]:checked');
    const answer6 = document.querySelector('input[name="q6"]:checked');
    const answer7 = document.querySelector('input[name="q7"]:checked');
    const answer8 = document.querySelector('input[name="q8"]:checked');
    const answer9 = document.querySelector('input[name="q9"]:checked');
    const answer10 = document.querySelector('input[name="q10"]:checked');
    const answer11 = document.querySelector('input[name="q11"]:checked');
    const answer12 = document.querySelector('input[name="q12"]:checked');
    const answer13 = document.querySelector('input[name="q13"]:checked');
    const answer14 = document.querySelector('input[name="q14"]:checked');
    const answer15 = document.querySelector('input[name="q15"]:checked');

    // Calculate the post-test score
    let postTestScore = 0;

    // Correct answers
    const correctAnswers = {
        q1: 'c', q2: 'c', q3: 'b', q4: 'b', q5: 'a',
        q6: 'd', q7: 'c', q8: 'a', q9: 'd', q10: 'c',
        q11: 'a', q12: 'a', q13: 'a', q14: 'b', q15: 'a'
    };

    // Score calculation based on user selection
    for (let i = 1; i <= 15; i++) {
        const answer = document.querySelector(`input[name="q${i}"]:checked`);
        if (answer && answer.value === correctAnswers[`q${i}`]) {
            postTestScore++;
        }
    }

    // Update the total score by adding the post-test score
    const updatedTotalScore = totalScore + postTestScore;

    // Update the game state with the new total score
    gameState.totalScore = updatedTotalScore;

    // Display the total score including the post-test score
    showModal(updatedTotalScore);
    document.getElementById('score').innerText = `Your total score: ${updatedTotalScore}`;
    console.log(updatedTotalScore);

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



// Hide the post-test container
document.getElementById('postTestContainer').style.display = 'none';
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


    document.getElementById('submitTest').addEventListener('click', submitPostTest);

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

        function attackMonster() {
            if (!gameState.isPlayerAttacking && !gameState.isMonsterAttacking) {
                gameState.isPlayerAttacking = true;
                gameState.attackFrame = 0;
                animateAttack('player');
            }
        }


const learningMaterials = {
    1: "Outlines are essential in image recognition, defining object shapes and distinguishing them from the background. They simplify object recognition, aiding tasks like shape recognition and segmentation. Used in fields like handwriting recognition and medical imaging, outline exercises improve shape recognition skills and prepare users for advanced image analysis.",
    
    2: "Pixelation simplifies images into square blocks, reducing detail but keeping shape and color. It's useful for privacy, digital art, and image recognition by helping users focus on broader features. Though challenging, practicing with different pixelation levels improves object recognition skills. Applications include security and training machine learning models to recognize objects with varying detail.",
    
    3: "Feature extraction is a key step in image recognition, identifying important characteristics like edges, corners, and textures to help classify objects. Techniques like SIFT and SURF aid in this process, focusing on relevant image details. Mastering feature extraction is crucial for tasks like object detection and computer vision, and interactive practice can strengthen these skills.",
    
    4: "Color identification is crucial in image recognition, helping users distinguish objects by their color properties. Techniques like color histograms and RGB analysis reveal color distributions within images. This skill is essential in fields like image editing, product categorization, and medical imaging. Practicing color identification enhances visual perception and strengthens image analysis abilities.",

    5: "Object detection is key in image recognition, focusing on identifying and locating objects within images, often marked by bounding boxes. It's used in areas like autonomous vehicles, surveillance, and augmented reality. Challenges include object variations, occlusions, lighting changes, and detecting small or cluttered objects. Techniques like data augmentation, transfer learning, and multi-scale detection help improve accuracy."
};
 // Set the current level

function showLearningMaterial(level) {
    endLevel();
    const learningText = learningMaterials[level];
    document.getElementById("learning-text").innerText = learningText;
    document.getElementById("learning-modal").style.display = "block";
}

// Close modal function
document.querySelector(".close").onclick = function() {
    document.getElementById("learning-modal").style.display = "none";
};

document.getElementById("start-level-btn").onclick = function() {
    resumeTimer();
    document.getElementById("learning-modal").style.display = "none";
    startLevel(currentLevel); // Call your existing level start function here
    gameState.monsterHp = 100;
    startTimer();
    updateStats();
    if(currentLevel === 1){
        // initializeLevel1();
        draw();
        setTimeout(() => {
            flipAllCards(true);
            setTimeout(shuffle, 1000);
        }, 1000);
        currentLevel++;
    }else if(currentLevel === 2){
        isStartLevel = true;
        switchToLevel2();
        currentLevel--;
    }
};

function startLevel(level) {
    // Logic to start the level goes here
    console.log("Starting level:", level);
    // Example: Load level-specific content or set up the game for the current level
}

// Example of how to call the showLearningMaterial function
showLearningMaterial(currentLevel);

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
    'images/characters/monster1.png', // Replace with correct paths
    'images/characters/monster2.png',
    'images/characters/monster3.png'
];

const backgroundImage = new Image();
backgroundImage.src = 'images/background.jpg';

let currentMonsterImage = new Image();
currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];

function draw() {
            // Clear the game scene
ctx.clearRect(0, 0, gameScene.width, gameScene.height);

// Draw background image
ctx.drawImage(backgroundImage, 0, 0, gameScene.width, gameScene.height);

// Draw player
const playerColor = gameState.playerHurt ? '#FF9999' : '#4CAF50';
ctx.fillStyle = playerColor; // Set fill color based on state

// Draw player image
ctx.drawImage(playerImage, gameState.playerX, gameState.playerY, 120, 120); // Adjust width and height as needed

// Draw monster
const monsterColor = gameState.monsterHurt ? '#FF0000' : '#F44336';
ctx.fillStyle = monsterColor; // Set fill color based on state

// Draw monster image
ctx.drawImage(currentMonsterImage, gameState.monsterX, gameState.monsterY, 170, 170); // Adjust width and height as needed

            if (gameState.isPlayerAttacking || gameState.isMonsterAttacking) {
                // Draw attack line
                ctx.beginPath();
                ctx.moveTo(gameState.playerX + 60, gameState.playerY + 40);
                ctx.lineTo(gameState.monsterX, gameState.monsterY + 50);
                ctx.strokeStyle = '#FFD700';
                ctx.lineWidth = 3;
                ctx.stroke();
            }

            requestAnimationFrame(draw);
        }

function animateAttack(attacker) {
            const attackDuration = 30; // Number of frames for the attack animation
            const moveDistance = 400; // Distance to move
            const frameRate = 60; // Assuming 60 FPS

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
                    // Hit the target
                    if (attacker === 'player') {
                        gameState.monsterHurt = true;
                        gameState.monsterHp = Math.max(0, gameState.monsterHp - 25);
                    } else {
                        gameState.playerHurt = true;
                        gameState.playerHp = Math.max(0, gameState.playerHp - 15);
                    }
                    updateStats();
                } else if (gameState.attackFrame <= attackDuration) {
                    // Move back to original position
                    if (attacker === 'player') {
                        gameState.playerX -= moveDistance / (attackDuration / 2);
                    } else {
                        gameState.monsterX += moveDistance / (attackDuration / 2);
                    }
                } else {
                    // Animation complete
                    if (attacker === 'player') {
                        gameState.isPlayerAttacking = false;
                        gameState.monsterHurt = false;
                        gameState.playerX = 100; // Reset to initial position
                    } else {
                        gameState.isMonsterAttacking = false;
                        gameState.playerHurt = false;
                        gameState.monsterX = 600; // Reset to initial position
                    }

                    if (gameState.monsterHp <= 0) {
                        handleLevelComplete();
                    } else if (gameState.playerHp <= 0) {
                        handleGameOver();
                    }
                    return;
                }

                // Continue the animation
                requestAnimationFrame(animate);
            }

            animate();
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