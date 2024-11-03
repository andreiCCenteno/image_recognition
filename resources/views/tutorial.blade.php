<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tutorial</title>
    <script src="https://cdn.jsdelivr.net/npm/fireworks-js/dist/fireworks.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap">
    <style>

h1 {
    margin-bottom: 20px;
    text-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
}

h2 {
    margin-bottom: 15px;
}

/* Dark Overlay */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.466);
    z-index: 100;
    display: none; /* Initially hidden */
}

/* Highlight Area */
.highlight-area {
    position: absolute;
    z-index: 101;
    background-color: rgba(255, 255, 255, 0.4);
    opacity: 0.5;
    border: 2px solid yellow;
    box-shadow: 0 0 10px yellow;
    transition: all 0.3s ease;
}

/* Instruction Box */
.instruction-box {
    position: absolute;
    z-index: 102;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff; /* White text for contrast */
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 800px; /* Fixed width */
    height: 150px; /* Fixed height */
    box-shadow: 0 0 15px rgba(0, 255, 0, 0.5); /* Optional: glow effect */
    font-size: 22px; /* Increased font size for better visibility */
    line-height: 1.5; /* Increased line height for better readability */
    overflow-y: auto; /* Adds scroll if text exceeds the box height */
}
#skipButton, #nextTutorialButton, #backTutorialButton {
    font-size: 20px; /* Adjusted size for button text */
}

#skipButton {
    position: absolute; /* Positioning relative to the instruction box */
    top: 10px; /* Distance from the top */
    right: 10px; /* Distance from the right */
    background: none; /* No background */
    border: none; /* No border */
    color: #39FF14; /* Neon green color */
    font-size: 16px; /* Adjust font size as needed */
    text-decoration: underline; /* Underline text */
    cursor: pointer; 
    padding: 5px 10px; /* Add padding for better touch area */
    margin: 0; /* Ensure no margin to avoid layout issues */
    z-index: 103; /* Ensure it is above other elements */
}

.instruction-box button {
    margin-top: 10px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    background-color: #00ffcc;
    color: #333;
    border-radius: 5px;
}

.hand-pointer {
    position: absolute;
    z-index: 102;
    width: 80px;
    height: 80px;
    background-image: url('{{ asset('images/hand-pointer.png') }}'); /* Replace with your hand pointer image URL */
    background-size: contain;
    background-repeat: no-repeat;
    display: none; /* Initially hidden */
}

.hand-pointer.show {
    display: block;
    opacity: 1;
}

@keyframes handBounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Add bounce effect */
.hand-pointer.bounce {
    animation: handBounce 1s ease-in-out infinite;
}

#handPointer {
    transition: transform 0.5s ease; /* Adjust the duration and easing as needed */
    position: absolute; /* Ensure it can be positioned anywhere */
    pointer-events: none; /* Prevent pointer events on the hand */
    z-index: 1000; /* Ensure it's on top */
}

/* Controls */
.controls {
    margin: 20px 0;
}

#backTutorialButton {
    position: absolute;
    bottom: 10px;
    left: 10px;
}

#nextTutorialButton {
    position: absolute;
    bottom: 10px;
    right: 10px;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    background-color: #00ffcc;
    color: #333;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #009999;
}

/* Game Info */
#message {
    font-size: 18px;
    margin-top: 10px;
}

#timer, #score {
    font-size: 20px;
    margin-top: 10px;
    font-weight: bold;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7);
    padding-top: 60px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover, .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

#tutorialModal{
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.7); 
}

/* Finish Modal */
#finishModal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    background-color: rgba(34, 34, 34, 0.9); /* Grey background with some opacity */
    padding: 30px; /* Increased padding for better readability */
    border: 3px solid #00ff00; /* Neon green for retro effect */
    width: 85%; /* Increased width for larger view */
    max-width: 800px; /* Maximum width to maintain responsiveness */
    border-radius: 8px;
    box-shadow: 0px 0px 20px rgba(0, 255, 0, 0.5); /* Enhanced glow */
    font-family: 'Courier New', monospace; /* Retro computer font */
    color: #00ff00; /* Retro computer text color */
    text-align: left;
    font-size: 18px; 
    top: 50%; /* Move it down to the middle of the viewport */
    left: 50%; /* Move it to the middle of the viewport */
    transform: translate(-50%, -50%); /* Center the modal */
}

/* Modal content */ .tutorial-modal-content{
    background-color: #111; /* Darker background for retro look */
    margin: 8% auto; /* 8% from the top for better positioning */
    padding: 30px; /* Increased padding for better readability */
    border: 3px solid #00ff00; /* Neon green for retro effect */
    width: 85%; /* Increased width for larger view */
    max-width: 800px; /* Maximum width to maintain responsiveness */
    border-radius: 8px;
    box-shadow: 0px 0px 20px rgba(0, 255, 0, 0.5); /* Enhanced glow */
    font-family: 'Courier New', monospace; /* Retro computer font */
    color: #00ff00; /* Retro computer text color */
    text-align: left;
    font-size: 18px; /* Larger font size for readability */
}

/* Buttons for Play Again and Save and Quit */
.play-again-button,
.save-quit-button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #ff9933;
    color: #333;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    transition: background-color 0.2s;
}

.play-again-button:hover,
.save-quit-button:hover {
    background-color: #e68a00;
}

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
    width: 800px;
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
        background-color: rgba(0, 0, 0, 0.05); /* Light overlay for effect */
    }

    #postTestContainer {
        max-height: 80vh;
        width: 80%;
        overflow-y: auto;
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .test-form-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .question {
        background: #ffffff;
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

#nextTutorialButton {
    margin-left: 160px;
    display: flex;
    justify-content: center;  /* Centers the button horizontally */
    align-items: center;      /* Centers the button vertically */
    height: auto;         /* Optional: Adds some padding to the button */
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

        #skipTutorialButton {
    position: absolute; /* Allows positioning relative to the nearest positioned ancestor */
    top: 10px; /* Adjust as needed */
    left: 10px; /* Adjust as needed */
    padding: 10px 15px; /* Add some padding */
    background-color: rgba(255, 0, 0, 0.8); /* Red background with some transparency */
    color: white; /* White text color */
    border: none; /* Remove default border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Change cursor to pointer */
    z-index: 1000; /* Ensure it appears above other elements */
}

#skipTutorialButton:hover {
    background-color: rgba(255, 0, 0, 1); /* Darker red on hover */
}
.fireworks-canvas {
            position: fixed;
            bottom: 0; /* Position at the bottom */
            pointer-events: none; /* Prevents canvas from blocking clicks */
            z-index: 999; /* Ensure it is below the modal */
            height: 50%; /* Make sure the canvas covers half the height of the screen */
        }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
</head>
<body>
<audio id="tutorialBackgroundSound" autoplay loop>
        <source src="{{ asset('music/tutorialBackgroundSound.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>

<button id="skipTutorialButton">Skip Tutorial</button>
<div class="settings-modal-overlay" id="settingsModal" style="display: none;">
        <div class="settings-modal">
            <h2>Settings</h2>
            <button id="resumeButton">Resume Tutorial</button>
            <button id="quitGameButton">Quit Tutorial</button>
            <span class="close" onclick="closeSettingsModal()"></span>
        </div>
    </div>
    <button id="settingsIcon" class="btn btn-light">
        <i class="bi bi-gear"></i>
    </button>
    
    <!-- Dark Overlay for Tutorial -->
            <div class="overlay" id="tutorialOverlay">
            <div class="highlight-area" id="highlightArea"></div>
            <div class="hand-pointer" id="handPointer"></div>
            <div class="instruction-box">
                <button id="skipButton" style="display: none;">Skip</button>
                <p id="tutorialText">This is a tutorial message...</p>
                <button id="nextTutorialButton" style="display: none;">Next</button>
                <button id="backTutorialButton" style="display: none;">Back</button>
            </div>
        </div>

    <div id="tutorialModal" class="tutorialModal">
    <div class="tutorial-modal-content">
        <span class="close" id="modalClose">&times;</span>
        <h2>Welcome to the Image Recognition Learning Game!</h2>
        <p>In this game, you'll be guided through several stages to improve your image recognition skills:</p>
        <ul>
            <li><strong>Stage 1 (Pixelator Puzzle)</strong>: Try to identify the image as it becomes increasingly pixelated.</li>
            <li><strong>Stage 2 (Outline Selection)</strong>: Choose the correct outline for the image in a shell-game format.</li>
            <li><strong>Stage 3 (Object Calibration)</strong>: Adjust the Object to match the target image as closely as possible.</li>
            <li><strong>Stage 4 (Dominant Color Detection)</strong>: Identify the dominant color in the image using sliders.</li>
            <li><strong>Stage 5 (Object Detection Simulation)</strong>: Click on the placeholder image to simulate object detection.</li>
        </ul>
        <p>Each stage will test your ability to recognize and understand images, helping you improve your visual learning skills!</p>
        <button id="startGameButton">Start Game</button>
    </div>
</div>

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
            <button onclick="startLevel3()">Start Level 3</button>
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
            <div class="main-image-container" id="main-image-container">
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
    
    <div class="modal-overlay" id="level4CompleteModal">
        <div class="modal">
            <h2>Level 4 Complete!</h2>
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 5: Feature Extraction Challenge!</p>
            <button onclick="startLevel5()">Start Level 5</button>
        </div>
    </div>
        
    <div id="level5Content" style="display: none;">
        <h2>Level 5: Object Detection</h2>
        <p>Click on the placeholder image to simulate object detection (real detection zones will be added later).</p>
    
        <div class="object-detection-container" style="position: relative;">
            <img id="objectImage" src="https://via.placeholder.com/600x400" alt="Placeholder Image" style="max-width: 100%; cursor: pointer;">
            
            <!-- Large Detection Zones -->
            <div class="detection-zone" style="left: 100px; top: 150px; width: 100px; height: 100px;"></div>
            <div class="detection-zone" style="left: 300px; top: 100px; width: 100px; height: 100px;"></div>
            <div class="detection-zone" style="left: 450px; top: 250px; width: 100px; height: 100px;"></div>
    
            <!-- Small Detection Zones -->
            <div class="detection-zone" style="left: 50px; top: 200px; width: 50px; height: 50px;"></div>
            <div class="detection-zone" style="left: 200px; top: 250px; width: 50px; height: 50px;"></div>
            <div class="detection-zone" style="left: 500px; top: 300px; width: 50px; height: 50px;"></div>

        </div>
    
        <div id="detectedObjectsList"></div>
    </div>
        
        <div class="modal-overlay" id="level5CompleteModal" style="display: none;">
            <div class="modal">
                <h2>Level 5 Complete!</h2>
                <p>You've completed the object detection level.</p>
                <button onclick="takeposttest()">Take Post-Test</button>
            </div>
        </div>        

        <div id="finishModal" class="tutorial-modal">
            <div class="modal-content">
                <h2>Tutorial Complete!</h2>
                <p>You've completed the tutorial and are now ready to play the game.</p>
                <button id="playGameButton" onclick="exitTutorial()">Go to Play Page</button>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>

window.onload = function() {
            const audio = document.getElementById("tutorialBackgroundSound");
            audio.play();
        };
         let fireworks;

         function startFireworks() {
    // Create left canvas for fireworks
    const leftCanvas = document.createElement('canvas');
    leftCanvas.className = 'fireworks-canvas'; // Set the class name
    leftCanvas.style.left = '0'; // Position on the left
    leftCanvas.style.width = '50vw'; // Set width to 20% of viewport
    leftCanvas.style.height = '40%'; // Cover bottom half of the screen
    leftCanvas.style.marginRight = '5vw'; // Add some space to the right
    document.body.appendChild(leftCanvas);

    // Create right canvas for fireworks
    const rightCanvas = document.createElement('canvas');
    rightCanvas.className = 'fireworks-canvas'; // Set the class name
    rightCanvas.style.right = '0'; // Position on the right
    rightCanvas.style.width = '50vw'; // Set width to 20% of viewport
    rightCanvas.style.height = '40%'; // Cover bottom half of the screen
    rightCanvas.style.marginLeft = '5vw'; // Add some space to the left
    document.body.appendChild(rightCanvas);

    // Start fireworks on the left canvas
    const fireworksLeft = new Fireworks(leftCanvas, {
        opacity: 0.5,
        trace: 3,
        particles: 100,
    });
    fireworksLeft.start();

    // Start fireworks on the right canvas
    const fireworksRight = new Fireworks(rightCanvas, {
        opacity: 0.5,
        trace: 3,
        particles: 100,
    });
    fireworksRight.start();
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

            function exitTutorial() {
    window.location.href = "{{ route('play') }}";
}

document.addEventListener('DOMContentLoaded', function () {
    const tutorialSteps = [
    {
        element: document.getElementById('gameContainer'),
        message: "This is the main game container, which holds all game elements like stats, images, and controls."
    },
    {
        element: document.getElementById('stats'),
        message: "Here are the stats displayed during the game: Level, Player HP, Monster HP, Time Left, and Score."
    },
    {
        element: document.getElementById('level1Content'),
        message: "This section displays the content for Level 1, where you will find the target image and a message prompting you to find the correct outline."
    },
    {
        element: document.getElementById('targetImage'),
        message: "This image is your target to identify in Level 1. Pay attention to its details!"
    },
    {
        element: document.getElementById('message'),
        message: "The message above indicates what you need to do in this level. In Level 1, you need to find the correct outline!"
    },
    {
        element: document.getElementById('cardsContainer'),
        message: "This container will hold the outline cards that you can choose from to match with the target image."
    },
    {
        element: document.getElementById('level2Content'),
        message: "This section appears in Level 2, where you will see a blurred image and input field for your guess."
    },
    {
        element: document.getElementById('blurredImage'),
        message: "In Level 2, you'll try to identify the image from this blurred version."
    },
    {
        element: document.getElementById('guessInput'),
        message: "Use this input box to type in your guess for the blurred image."
    },
    {
        element: document.getElementById('submitGuess'),
        message: "Click this button to submit your guess after typing it in the input box."
    },
    {
        element: document.getElementById('level3Content'),
        message: "In Level 3, you'll match visual features to their correct locations in the main image."
    },
    {
        element: document.getElementById('main-image-container'),
        message: "This is the main image where you will match visual features. Make sure to analyze it carefully!"
    },
    {
        element: document.getElementById('featuresList'),
        message: "This list will display the visual features you need to match to the main image."
    },
    {
        element: document.getElementById('level4Content'),
        message: "In Level 4, you'll identify the dominant color in the image using sliders."
    },
    {
        element: document.getElementById('colorImage'),
        message: "This image is the one you'll use to determine the dominant color."
    },
    {
        element: document.getElementById('redSlider'),
        message: "Use this slider to select the amount of red in the dominant color."
    },
    {
        element: document.getElementById('greenSlider'),
        message: "Use this slider to select the amount of green in the dominant color."
    },
    {
        element: document.getElementById('blueSlider'),
        message: "Use this slider to select the amount of blue in the dominant color."
    },
    {
        element: document.getElementById('submitColor'),
        message: "Click this button to submit your selected color after adjusting the sliders."
    },
    {
        element: document.getElementById('level5Content'),//20
        message: "In Level 5, you'll click on the placeholder image to simulate object detection."
    },
    {
        element: document.getElementById('objectImage'),
        message: "This is the placeholder image where you'll perform object detection."
    },
];

const skipTutorialButton = document.getElementById('skipTutorialButton');
const skipButton = document.getElementById('skipButton');

    let currentStep = 0;
    const tutorialOverlay = document.getElementById('tutorialOverlay');
    const highlightArea = document.getElementById('highlightArea');
    const tutorialText = document.getElementById('tutorialText');
    const nextTutorialButton = document.getElementById('nextTutorialButton');
    const readyButton = document.getElementById('readyButton');
    
    // Function to show tutorial step
    const showTutorialStep = () => {
        const step = tutorialSteps[currentStep];
    const element = step.element;
    const rect = element.getBoundingClientRect(); // Get element position and size

    console.log("Displaying message:", step.message); // Debugging line
    tutorialText.innerText = step.message;

        // Set highlight area to match the element's position and size
        highlightArea.style.width = `${rect.width}px`;
        highlightArea.style.height = `${rect.height}px`;
        highlightArea.style.top = `${rect.top + window.scrollY}px`; // Adjust for any scroll
        highlightArea.style.left = `${rect.left + window.scrollX}px`;

        handPointer.style.top = `${rect.top + window.scrollY + rect.height / 3}px`;
        handPointer.style.left = `${rect.left + window.scrollX - 80}px`; // Adjust for hand size
        handPointer.style.display = 'block'; // Show the hand pointer
        setTimeout(() => {
            handPointer.classList.add('bounce');
        }, 1000);

        // Start the typing effect for the tutorial message
        typeMessage(step.message);
        
        // Display the overlay
        tutorialOverlay.style.display = 'block';
        
    };

    const typeMessage = (message) => {
    tutorialText.textContent = ""; // Clear previous text
    let index = 0;
    const typingSpeed = 50; // Typing speed in milliseconds
    let typingTimeout; // Store the typing timeout ID

    skipButton.style.display = "block"; // Show skip button

    // Typing function
    const type = () => {
        if (index < message.length) {
            tutorialText.textContent += message.charAt(index);
            index++;
            typingTimeout = setTimeout(type, typingSpeed); // Store timeout ID
        } else {
            // Hide skip button when typing completes
            skipButton.style.display = "none";
            nextTutorialButton.style.display = "block";
            backTutorialButton.style.display = currentStep > 0 ? 'block' : 'none';
        }
    };

    // Function to skip typing and display the full message immediately
    const skipTyping = () => {
        clearTimeout(typingTimeout); // Stop the ongoing typing effect
        tutorialText.textContent = message; // Show full message immediately
        skipButton.style.display = "none"; // Hide skip button
        nextTutorialButton.style.display = "block"; // Show next button
        backTutorialButton.style.display = currentStep > 0 ? 'block' : 'none';
    };

    // Attach the skip function to the "Skip" button click event
    skipButton.onclick = skipTyping;

    // Start typing effect
    type();
};

    window.onload = function() {
        const modal = document.getElementById("tutorialModal");
        const closeModal = document.getElementById("modalClose");
        const startButton = document.getElementById("startGameButton");

        // Show the modal
        modal.style.display = "block";

        // Close the modal when the 'x' is clicked
        closeModal.onclick = function() {
            modal.style.display = "none";
        };
        
        // Start the game when the 'Start Game' button is clicked
        startButton.onclick = function() {
            modal.style.display = "none";

            backTutorialButton.addEventListener('click', () => {
    if (currentStep > 0) {
        currentStep--;

        if(currentStep === 5){
                        setTimeout(() => {
                            flipAllCards(true);
                            setTimeout(shuffle, 1000);
                        }, 1000);
                    }
        // Hide specific content if moving back between stages
        if (currentStep === 5) {
            document.getElementById('level2Content').style.display = 'none';
            document.getElementById('level1Content').style.display = 'block';
        } else if (currentStep === 9) {
            document.getElementById('level3Content').style.display = 'none';
            document.getElementById('level2Content').style.display = 'block';
        } else if (currentStep === 12) {
            document.getElementById('level4Content').style.display = 'none';
            document.getElementById('level3Content').style.display = 'block';
        } else if (currentStep === 18) {
            document.getElementById('level5Content').style.display = 'none';
            document.getElementById('level4Content').style.display = 'block';
        }

        showTutorialStep();
        nextTutorialButton.style.display = "none";
        backTutorialButton.style.display = 'none';
    }
});
            // Additional logic to start the game goes here
            nextTutorialButton.addEventListener('click', () => {
                if (currentStep < tutorialSteps.length - 1) {
                    currentStep++;
                    
                    if(currentStep === 5){
                        setTimeout(() => {
                            flipAllCards(true);
                            setTimeout(shuffle, 1000);
                        }, 1000);
                    }
                    // Check if transitioning between stages
                    if (currentStep === 6) {
                        // Hide Pixelator Puzzle, Show Shell Game
                        document.getElementById('level1Content').style.display = 'none';
                        document.getElementById('level2Content').style.display = 'block';
                        startLevel2();
                    } else if (currentStep === 10) {
                        // Hide Shell Game, Show Color Matching Stage
                        document.getElementById('level1Content').style.display = 'none';
                        document.getElementById('level2Content').style.display = 'none';
                        document.getElementById('level3Content').style.display = 'block';
                        startLevel3();
                    } else if (currentStep === 13) {
                        // Hide Color Matching Stage, Show Object Detection Stage
                        document.getElementById('level1Content').style.display = 'none';
                        document.getElementById('level2Content').style.display = 'none';
                        document.getElementById('level3Content').style.display = 'none';
                        document.getElementById('level4Content').style.display = 'block';
                        startLevel4();
                    }else if (currentStep === 19) {
                        // Hide Color Matching Stage, Show Object Detection Stage
                        document.getElementById('level1Content').style.display = 'none';
                        document.getElementById('level2Content').style.display = 'none';
                        document.getElementById('level3Content').style.display = 'none';
                        document.getElementById('level4Content').style.display = 'none';
                        document.getElementById('level5Content').style.display = 'block';
                        startLevel5();
                    }

                    showTutorialStep();
                    nextTutorialButton.style.display = "none";
                    backTutorialButton.style.display = 'none';
                } else {
                    const finishModal = document.getElementById('finishModal');
                    skipTutorialButton.style.display = 'none';
                    // Start fireworks and confetti before showing the modal
                    startFireworks(); // Initiate fireworks

                    finishModal.style.display = 'flex'; // Show the finish modal
                    tutorialOverlay.style.display = 'none'; // Hide the tutorial overlay
                    handPointer.style.display = 'none'; // Hide the hand pointer
                }
            });
            // Initialize the first tutorial step
            showTutorialStep();
        };

        skipTutorialButton.onclick = function() {
        const finishModal = document.getElementById('finishModal');
        const entryModal = document.getElementById('tutorialModal');
        // Show the finish modal directly

        startFireworks(); // Initiate fireworks
        entryModal.style.display = 'none';
        finishModal.style.display = 'flex';
        tutorialOverlay.style.display = 'none';
        handPointer.style.display = 'none';
        skipTutorialButton.style.display = 'none';

        document.getElementById('level1Content').style.display = 'none';
        document.getElementById('level2Content').style.display = 'none';
        document.getElementById('level3Content').style.display = 'none';
        document.getElementById('level4Content').style.display = 'none';
        document.getElementById('level5Content').style.display = 'block';
        startLevel5();
    };
    };
});

const gameState = {
    level: 1,
    playerHp: 100,
    monsterHp: 100,
    isAttacking: false,
    attackFrame: 0,
    shuffling: false,
    canClick: false,
    images: [
        {
            original: 'https://placehold.co/200x200',
            outlines: [
                'https://placehold.co/150x200',
                'https://placehold.co/150x200',
                'https://placehold.co/150x200'
            ]
        }
    ],
    level2Images: [
        {
            image: 'https://placehold.co/200x200',
            answer: 'cat'
        }
        // Add more level 2 images here
    ]
};

const gameScene = document.getElementById('gameScene');
const ctx = gameScene.getContext('2d');
const cardsContainer = document.getElementById('cardsContainer');
const targetImage = document.getElementById('targetImage');
const level1Content = document.getElementById('level1Content');
const level2Content = document.getElementById('level2Content');
const level4Content = document.getElementById('level4Content');
const blurredImage = document.getElementById('blurredImage');
const guessContainer = document.getElementById('guessContainer');
const guessInput = document.getElementById('guessInput');
const submitGuess = document.getElementById('submitGuess');

const cardWidth = 150;
const cardGap = 50;
const totalWidth = (cardWidth * 3) + (cardGap * 2);
const startX = (800 - totalWidth) / 2;

let cards = [];
let currentBlurLevel = 20;

let score = 0; // Initialize score

function updateScore(points) {
    gameState.totalScore = (gameState.totalScore || 0) + points;
    document.getElementById('scoreDisplay').textContent = `Score: ${gameState.totalScore}`;
}


// Call startTimer when the player starts a new level
function startNewLevel(level) {
    document.getElementById('level').textContent = level; // Start the timer for the new level
}

// Example of starting a new level (update accordingly in your game logic)
 // Call this when a new level starts



function takeposttest() {
    const modal = document.getElementById('level5CompleteModal');
    modal.style.display = 'none';
    document.getElementById('gameContainer').style.display = 'none';
    document.getElementById('postTestContainer').style.display = 'block';
       initializePostTest();
}

function startLevel5() {
    const modal = document.getElementById('level4CompleteModal');
    modal.style.display = 'none';
    gameState.level = 5;
    gameState.monsterHp = 100;
    updateStats(); 
    initializeLevel5(); 
}

function startLevel4() {
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'none';
    gameState.level = 4;
    gameState.monsterHp = 100;
    updateStats(); 
    initializeLevel4(); 
}


function startLevel3() {
    const modal = document.getElementById('level2CompleteModal');
    modal.style.display = 'none';
    gameState.level = 3;
    gameState.monsterHp = 100;
    updateStats();
    initializeLevel3();
}


function createCard(index, isCorrect) {
    const card = document.createElement('div');
    card.className = 'card';
    card.style.left = `${startX + (index * (cardWidth + cardGap))}px`;

    const front = document.createElement('div');
    front.className = 'card-face card-front';

    const outlineImg = document.createElement('img');
    const currentLevel = gameState.level - 1;
    outlineImg.src = isCorrect ?
        gameState.images[currentLevel].outlines[0] :
        gameState.images[currentLevel].outlines[index === 0 ? 1 : 2];
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
    } else if (gameState.level == 5) {
        level5Content.style.display = 'block';
        initializeLevel5();
    }
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
    switchToLevel2();
}

function showLevel1CompleteModal() {
    const modal = document.getElementById('levelCompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel2CompleteModal() {
    const modal = document.getElementById('level2CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel3CompleteModal() {
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel4CompleteModal() {
    const modal = document.getElementById('level4CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel5CompleteModal() {
    const modal = document.getElementById('level5CompleteModal');
    modal.style.display = 'flex';
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
    const maxShuffles = 5;

    const shuffleInterval = setInterval(() => {
        const pos1 = Math.floor(Math.random() * 3);
        const pos2 = Math.floor(Math.random() * 3);

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
    }, 1000);
}

function initializeLevel1() {
    cardsContainer.innerHTML = '';
    cards = [];
    targetImage.src = gameState.images[0].original;
    level1Content.style.display = 'block';

    const correctPosition = Math.floor(Math.random() * 3);

    for (let i = 0; i < 3; i++) {
        const cardData = createCard(i, i === correctPosition);
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
            attackMonster();
        }, 1500);

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

function switchToLevel2() { // Ensure to clear the timer from Level 1 before switching

    level1Content.style.display = 'none';
    level2Content.style.display = 'block';
    guessContainer.style.display = 'flex';

    // Set up level 2
    const currentImage = gameState.level2Images[0];
    blurredImage.src = currentImage.image;
    blurredImage.style.filter = 'blur(0px)';

    // Start reducing blur
    setTimeout(() => {
        blurredImage.style.filter = 'blur(50px)'; // Apply blur effect
    }, 10);

    startNewLevel(2); // Start the timer for Level 2
}

// Event listener for submitting a guess
submitGuess.addEventListener('click', () => {
    const guess = guessInput.value.toLowerCase().trim();
    const currentImage = gameState.level2Images[0];
    
    if (guess === currentImage.answer) {
        document.getElementById('message').textContent = "Correct! You identified the image!";
        gameState.monsterHp = 0; // Force monster defeat to trigger level completion
        
        // Update score for correct answer
        updateScore(20); // Award 20 points for correct guess
        showLevel2CompleteModal(); // Show level 2 completion modal
    } else {
        document.getElementById('message').textContent = "Wrong guess! Try again!";
        takeDamage(); // Handle player damage on wrong guess
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
        updateScore(5); // Example: 10 points for a correct match
        
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
    startNewLevel(4); // Reset and start the countdown timer for Level 4

    const submitColorButton = document.getElementById('submitColor');
    
    // Add the event listener inside the function
    submitColorButton.addEventListener('click', () => {
        const red = parseInt(document.getElementById('redSlider').value);
        const green = parseInt(document.getElementById('greenSlider').value);
        const blue = parseInt(document.getElementById('blueSlider').value);

        const selectedRGB = { r: red, g: green, b: blue };

        // Define the expected color for this level (black in this case)
        const expectedColor = { r: 0, g: 0, b: 0 }; 
        
        if (selectedRGB.r === expectedColor.r && 
            selectedRGB.g === expectedColor.g && 
            selectedRGB.b === expectedColor.b) {
            
            document.getElementById('message').textContent = "Correct! You've matched the color!";
            
            // Update score if needed
            updateScore(20); // Example: 20 points for correct color match
            
            showLevel4CompleteModal(); // Show completion modal
            gameState.level++; // Progress to the next level
            attackMonster(); // Move to the next stage or action
        } else {
            document.getElementById('message').textContent = "Incorrect color, try again!";
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

    const objectImage = document.getElementById('objectImage');
    const detectedObjectsList = document.getElementById('detectedObjectsList');

    const detectionZones = [
        { xStart: 100, xEnd: 200, yStart: 150, yEnd: 250 }, // Large Zone 1
        { xStart: 300, xEnd: 400, yStart: 100, yEnd: 200 }, // Large Zone 2
        { xStart: 450, xEnd: 550, yStart: 250, yEnd: 350 }, // Large Zone 3
        { xStart: 50, xEnd: 100, yStart: 200, yEnd: 250 },   // Small Zone 1
        { xStart: 200, xEnd: 250, yStart: 250, yEnd: 300 },  // Small Zone 2
        { xStart: 500, xEnd: 550, yStart: 300, yEnd: 350 }    // Small Zone 3
        // Add more zones as needed
    ];

    // Event listener for image click
    objectImage.addEventListener('click', function(event) {
        const rect = objectImage.getBoundingClientRect();
        const x = event.clientX - rect.left; 
        const y = event.clientY - rect.top;  

        const detected = detectionZones.some(zone => 
            x >= zone.xStart && x <= zone.xEnd &&
            y >= zone.yStart && y <= zone.yEnd
        );

        if (detected) {
            detectedObjectsList.innerHTML = '<p>Object Detected!</p>';
            showLevel5CompleteModal();
        } else {
            detectedObjectsList.innerHTML = '<p>No object detected, try again!</p>';
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
    const detectedObjectsList = document.getElementById('detectedObjectsList');

    const detectionZones = [
        { xStart: 100, xEnd: 200, yStart: 150, yEnd: 250 }, // Large Zone 1
        { xStart: 300, xEnd: 400, yStart: 100, yEnd: 200 }, // Large Zone 2
        { xStart: 450, xEnd: 550, yStart: 250, yEnd: 350 }, // Large Zone 3
        { xStart: 50, xEnd: 100, yStart: 200, yEnd: 250 },   // Small Zone 1
        { xStart: 200, xEnd: 250, yStart: 250, yEnd: 300 },  // Small Zone 2
        { xStart: 500, xEnd: 550, yStart: 300, yEnd: 350 }    // Small Zone 3
    ];

    // Event listener for image click
    objectImage.addEventListener('click', function(event) {
        const rect = objectImage.getBoundingClientRect();
        const x = event.clientX - rect.left; 
        const y = event.clientY - rect.top;  

        const detected = detectionZones.some(zone => 
            x >= zone.xStart && x <= zone.xEnd &&
            y >= zone.yStart && y <= zone.yEnd
        );

        if (detected) {
            detectedObjectsList.innerHTML = '<p>Object Detected!</p>';
            
            // Update score for successful detection
            updateScore(20); // Example: Award 30 points for detecting the object

            showLevel5CompleteModal(); // Trigger the completion modal for Level 5
            gameState.level++; // Move to the next level
        } else {
            detectedObjectsList.innerHTML = '<p>No object detected, try again!</p>';
        }
    });
}

function attackMonster() {
    gameState.isAttacking = true;
    gameState.attackFrame = 0;
    gameState.monsterHp = Math.max(0, gameState.monsterHp - 100);

    if (gameState.monsterHp <= 0) {
        if (gameState.level === 1) {
            showLevel1CompleteModal();
        } else if (gameState.level === 2) {
            showLevel2CompleteModal();
        } else if (gameState.level === 3) {
            showLevel3CompleteModal
        }else if (gameState.level === 5) {
            showLevel4CompleteModal();
        }else if (gameState.level === 6) {
            showLevel5CompleteModal();
            alert("Congratulations! You've completed all levels!");
            resetGame();
        }
    }
    updateStats();
}

function takeDamage() {
    gameState.playerHp = Math.max(0, gameState.playerHp - 100);
    updateStats();

    if (gameState.playerHp <= 0) {
        setTimeout(() => {
            alert("Game Over! Try again!");
            resetGame();
        }, 500);
    }
}


function updateStats() {
    document.getElementById('level').textContent = gameState.level;
    document.getElementById('playerHp').textContent = gameState.playerHp;
    document.getElementById('monsterHp').textContent = gameState.monsterHp;
}

function draw() {
    ctx.clearRect(0, 0, gameScene.width, gameScene.height);

    // Draw player
    ctx.fillStyle = '#4CAF50';
    ctx.fillRect(100, 150, 60, 80);

    // Draw monster
    ctx.fillStyle = '#F44336';
    ctx.fillRect(600, 150, 80, 100);

    if (gameState.isAttacking) {
        ctx.beginPath();
        ctx.moveTo(160, 190);
        ctx.lineTo(600, 200);
        ctx.strokeStyle = '#FFD700';
        ctx.lineWidth = 3;
        ctx.stroke();

        gameState.attackFrame++;
        if (gameState.attackFrame > 10) {
            gameState.isAttacking = false;
        }
    }

    requestAnimationFrame(draw);
}

// Start the game
initializeGame();
draw();
        </script>  
</body>
</html>
