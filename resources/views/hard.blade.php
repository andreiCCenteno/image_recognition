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
        background-color: rgba(0, 0, 0, 0.05); /* Light overlay for effect */
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
        <img id="objectImage" src="{{ asset('images/hard/hard.jpg') }}" style="max-width: 2000%; height: auto; cursor: pointer;">
    
            <!-- Large Detection Zones -->
            <div id="farthestpost" class="detection-zone" style="left: 510px; top: 180px; width: 20px; height: 200px;"></div>
            <div id="middlepost" class="detection-zone" style="left: 140px; top: 200px; width: 20px; height: 200px;"></div>
            <div id="manwithphone" class="detection-zone" style="left: 260px; top: 360px; width: 40px; height: 100px;"></div>
            <div id="ladyintheblackholdingplastic" class="detection-zone" style="left: 70px; top: 350px; width: 40px; height: 120px;"></div>
            <div id="manpink" class="detection-zone" style="left: 310px; top: 370px; width: 40px; height: 100px;"></div>
            <div id="mangreen" class="detection-zone" style="left: 745px; top: 370px; width: 40px; height: 80px;"></div>
            <div id="ladyblackandwhitejeans" class="detection-zone" style="left: 450px; top: 370px; width: 40px; height: 100px;"></div>
            <div id="ladygreenwithredbabg" class="detection-zone" style="left: 390px; top: 350px; width: 40px; height: 100px;"></div>
            <div id="closepost" class="detection-zone" style="left: 900px; top: 10px; width: 25px; height: 420px;"></div>
            <div id="train" class="detection-zone" style="left: 435px; top: 320px; width: 30px; height: 30px;"></div>
            <div id="firehydrant" class="detection-zone" style="left: 735px; top: 470px; width: 60px; height: 110px;"></div>
            <div id="trashcan" class="detection-zone" style="left: 680px; top: 430px; width: 60px; height: 120px;"></div>
            <div id="poster" class="detection-zone" style="left: 560px; top: 0px; width: 70px; height: 140px;"></div>
            <div id="u-turnsign" class="detection-zone" style="left: 680px; top: 130px; width: 70px; height: 70px;"></div>
            <div id="trafficlight" class="detection-zone" style="left: 830px; top: 200px; width: 70px; height: 70px;"></div>
            <div id="blackcar" class="detection-zone" style="left: 0px; top: 370px; width: 150px; height: 70px;"></div>
            
        </div>
    </div>
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
        window.location.href = "{{ url('hard') }}"; // Reset the game state (you'll need to implement this)
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
        original: 'images/medium/bicycle.webp',
        outlines: [
            'images/medium/bicycle_outline.webp',
            'images/medium/house_outline.jpg',
            'images/medium/coffeemug_outline.webp'
        ]
    },

    {
        original: 'images/medium/coffeemug.webp',
        outlines: [
            'images/medium/coffeemug_outline.webp',
            'images/medium/house_outline.jpg',
            'images/medium/bicycle_outline.webp'
        ]
    },

    {
        original: 'images/medium/house.webp',
        outlines: [
            'images/medium/house_outline.jpg',
            'images/medium/coffeemug_outline.webp',
            'images/medium/laptop_outline.jpg'
        ]
    },

    {
        original: 'images/medium/laptop.jpg',
        outlines: [
            'images/medium/laptop_outline.jpg',
            'images/medium/coffeemug_outline.webp',
            'images/medium/house_outline.jpg'
        ]
    }
],

level2Images: [
    {
        image: 'images/medium/laptop.jpg',
        answer: 'laptop'
    },
    
    {
        image: 'images/medium/house.webp',
        answer: 'house'
    },

    {
        image: 'images/medium/coffeemug.webp',
        answer: 'coffee mug'
    },

    {
        image: 'images/medium/bicycle.webp',
        answer: 'bicycle'
    },

    {
        image: 'images/medium/cat.jpg',
        answer: 'cat'
    }
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
const startX = (590 - totalWidth) / 2;

let cards = [];
let currentBlurLevel = 20;

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
    timeLeft = timerDuration; // Reset time left to initial duration
    document.getElementById('countdownTimer').textContent = timeLeft;

    timerId = setInterval(() => {
        if (isPaused) { // Check if the timer is not paused
            timeLeft--;
            document.getElementById('countdownTimer').textContent = timeLeft;

            if (timeLeft <= 0) {
                alert("Time's up!"); // Notify player when time runs out
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

// Example of starting a new level (update accordingly in your game logic)
// startNewLevel(1); // Call this when a new level starts



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
    showLearningMaterial(5); 
    updateStats(); 
    initializeLevel5(); 
}

function startLevel4() {
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'none';
    gameState.level = 4;
    showLearningMaterial(4);
    updateStats(); 
    initializeLevel4(); 
}


function startLevel3() {
    const modal = document.getElementById('level2CompleteModal');
    modal.style.display = 'none';
    gameState.level = 3;
    showLearningMaterial(3);
    updateStats();
    initializeLevel3();
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
    showLearningMaterial(2);
    switchToLevel2();
    currentLevel++;
    console.log(currentLevel);
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
    const maxShuffles = 15;

    const shuffleInterval = setInterval(() => {
        const pos1 = Math.floor(Math.random() * 9);
        const pos2 = Math.floor(Math.random() * 9);

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
    }, 300);
}

function initializeLevel1() {
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

    for (let i = 0; i < 9; i++) {
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
        updateScore(15); // Award 10 points for correct guess

        setTimeout(() => {
            attackMonster();
        }, 1500);

        setTimeout(() => {
            cardData.element.classList.remove('victory');
            if (gameState.monsterHp >= 100 && gameState.playerHp > 0) {
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

function switchToLevel2() {
    // endLevel(); // Ensure to clear the timer from Level 1 before switching

    level1Content.style.display = 'none';
    level2Content.style.display = 'block';
    guessContainer.style.display = 'flex';

    // Randomly select an image from the level2Images array
    const randomImageIndex = Math.floor(Math.random() * gameState.level2Images.length);
    const selectedImage = gameState.level2Images[randomImageIndex];

    // Set up level 2 with the randomly selected image
    blurredImage.src = selectedImage.image;
    blurredImage.style.filter = 'blur(50px)';

    // Start reducing blur after a brief delay

    if (isStartLevel) {
    setTimeout(() => {
        blurredImage.style.filter = 'blur(0px)'; // Remove blur effect completely
    }, 150); // Reduce the timeout duration for faster removal
    
    // Start the timer for Level 2
    startNewLevel(2);

    // Store the selected image in the game state to use it later during the guess check
    gameState.currentLevel2Image = selectedImage;
    } 
    blurredImage.addEventListener('transitionend', () => {
        endLevel();
        pauseTimer();
        alert("Game Over!");
        // Add any additional logic here, such as navigating to another screen or resetting the game
    }, { once: true });
}

// Event listener for submitting a guess
submitGuess.addEventListener('click', () => {
    const guess = guessInput.value.toLowerCase().trim();
    const currentImage = gameState.currentLevel2Image;
    
    if (guess === currentImage.answer) {
        document.getElementById('message').textContent = "Correct! You identified the image!";
        currentLevel++;
        level2Content.style.display = 'none';
        gameState.level++;
        attackMonster(); // Force monster defeat to trigger level completion
        
        // Update score for correct answer
        updateScore(15); // Award 20 points for correct guess
        // showLevel2CompleteModal(); // Show level 2 completion modal
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
        updateScore(15); // Example: 10 points for a correct match
        
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
            updateScore(15); // Example: 20 points for correct color match
            
            showLevel4CompleteModal(); // Show completion modal
            gameState.level++; // Progress to the next level
            attackMonster(); // Move to the next stage or action
        } else {
            document.getElementById('message').textContent = `Incorrect color! Try again!`;
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
    { id: 'farthestpost', name: 'Farthest Post' },
    { id: 'middlepost', name: 'Middle Post' },
    { id: 'manwithphone', name: 'Man with Phone' },
    { id: 'ladyintheblackholdingplastic', name: 'Lady in Black Holding Plastic' },
    { id: 'manpink', name: 'Man in Pink' },
    { id: 'mangreen', name: 'Man in Green' },
    { id: 'ladyblackandwhitejeans', name: 'Lady with Black and White Jeans' },
    { id: 'ladygreenwithredbabg', name: 'Lady in Green with Red Bag' },
    { id: 'closepost', name: 'Close Post' },
    { id: 'train', name: 'Train' },
    { id: 'firehydrant', name: 'Fire Hydrant' },
    { id: 'trashcan', name: 'Trash Can' },
    { id: 'poster', name: 'Poster' },
    { id: 'u-turnsign', name: 'U-turn Sign' },
    { id: 'trafficlight', name: 'Traffic Light' },
    { id: 'blackcar', name: 'Black Car' }
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
            updateScore(20); // Example: Award 20 points for detecting the object

            showLevel5CompleteModal(); // Trigger the completion modal for Level 5
            gameState.level++; // Move to the next level
        } else {
            takeDamage(); // Handle incorrect clicks
        }
    });
}



function initializePostTest() {

pauseTimer();
const totalScore = gameState.totalScore || 0;
level1Content.style.display = 'none';
level2Content.style.display = 'none';
level3Content.style.display = 'none';
level4Content.style.display = 'none';
level5Content.style.display = 'none';

const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');

const questions = [
    {
    question: "What is outline classification in image recognition?",
    answers: [
        "Identifying edges",
        "Color detection",
        "Pixel classification",
        "Object tracking"
    ],
    correct: 0,
    topic: "Outline"
},
{
    question: "What does pixelation in images do?",
    answers: [
        "Increases clarity",
        "Reduces detail",
        "Enhances color",
        "Adds noise"
    ],
    correct: 1,
    topic: "Pixelation"
},
{
    question: "Which method is commonly used for object detection?",
    answers: [
        "Convolutional Neural Networks",
        "Decision Trees",
        "Linear Regression",
        "K-Means Clustering"
    ],
    correct: 0,
    topic: "ObjectDetection"
},
{
    question: "What is color identification in image processing?",
    answers: [
        "Identifying shapes",
        "Determining the predominant color",
        "Detecting edges",
        "Segmenting images"
    ],
    correct: 1,
    topic: "ColorIdentification"
},
{
    question: "What is feature extraction in image recognition?",
    answers: [
        "Simplifying the image",
        "Identifying key attributes",
        "Enhancing colors",
        "Reducing noise"
    ],
    correct: 1,
    topic: "FeatureExtraction"
},
{
    question: "What is the primary goal of image segmentation?",
    answers: [
        "To isolate regions of interest",
        "To increase image size",
        "To enhance brightness",
        "To compress images"
    ],
    correct: 0,
    topic: "Pixelation"
},
{
    question: "Which algorithm is used for outline classification?",
    answers: [
        "Hough Transform",
        "K-Means Clustering",
        "Principal Component Analysis",
        "Support Vector Machine"
    ],
    correct: 0,
    topic: "Outline"
},
{
    question: "What is a common technique used in object detection?",
    answers: [
        "Histogram Equalization",
        "Sliding Window",
        "Color Thresholding",
        "Image Blurring"
    ],
    correct: 1,
    topic: "Object Detection"
},
{
    question: "In color identification, which color model is often used?",
    answers: [
        "CMYK",
        "HSV",
        "XYZ",
        "LAB"
    ],
    correct: 1,
    topic: "Color Identification"
},
{
    question: "Which method is essential for feature extraction?",
    answers: [
        "Normalization",
        "Data Augmentation",
        "Dimensionality Reduction",
        "Color Correction"
    ],
    correct: 2,
    topic: "FeatureExtraction"
},
{
    question: "What is a common technique for identifying edges in images?",
    answers: [
        "Gaussian Blur",
        "Sobel Filter",
        "Mean Shift",
        "Median Filter"
    ],
    correct: 1,
    topic: "Outline"
},
{
    question: "What does image segmentation help with?",
    answers: [
        "Improving image resolution",
        "Separating distinct objects",
        "Enhancing colors",
        "Changing brightness"
    ],
    correct: 1,
    topic: "Pixelation"
},
{
    question: "What is the purpose of object detection?",
    answers: [
        "Finding edges",
        "Recognizing patterns",
        "Locating objects within an image",
        "Changing colors"
    ],
    correct: 2,
    topic: "ObjectDetection"
},
{
    question: "Which algorithm is used for color detection?",
    answers: [
        "K-Means Clustering",
        "Random Forest",
        "Decision Tree",
        "PCA"
    ],
    correct: 0,
    topic: "ColorIdentification"
},
{
    question: "What is an important aspect of feature extraction?",
    answers: [
        "Image size",
        "Color depth",
        "Shape representation",
        "Resolution"
    ],
    correct: 2,
    topic: "FeatureExtraction"
},
{
    question: "What is the process of simplifying an image while preserving important information?",
    answers: [
        "Compression",
        "Segmentation",
        "Normalization",
        "Smoothing"
    ],
    correct: 0,
    topic: "Pixelation"
},
{
    question: "What do we analyze in outline classification?",
    answers: [
        "Shapes and edges",
        "Colors",
        "Brightness",
        "Textures"
    ],
    correct: 0,
    topic: "Outline"
},
{
    question: "What technique is used to detect multiple objects in an image?",
    answers: [
        "YOLO",
        "Convolutional Filtering",
        "Edge Detection",
        "Histogram Equalization"
    ],
    correct: 0,
    topic: "ObjectDetection"
},
{
    question: "What is the significance of the HSV color model?",
    answers: [
        "It separates color information from intensity",
        "It's faster than RGB",
        "It's easier to visualize",
        "It's more accurate"
    ],
    correct: 0,
    topic: "ColorIdentification"
},
{
    question: "Which of the following is a method for image feature extraction?",
    answers: [
        "Scale-Invariant Feature Transform",
        "Color Balancing",
        "Image Denoising",
        "Color Correction"
    ],
    correct: 0,
    topic: "FeatureExtraction"
}
];

let currentQuestion = 0;
let score = 0; // Variable to keep track of the score
let totalQuestions = questions.length; // Total number of questions
let gameActive = true; // Variable to track if the game is ongoing

const targetSize = 100; // Size of the asteroid shape
const targets = [
    { x: 100, y: 300, dx: 2, dy: 2, shape: 'A' }, // Position and shape for answer A
    { x: 300, y: 300, dx: -2, dy: 2, shape: 'B' }, // Position and shape for answer B
    { x: 500, y: 300, dx: 2, dy: -2, shape: 'C' }, // Position and shape for answer C
    { x: 700, y: 300, dx: -2, dy: -2, shape: 'D' }  // Position and shape for answer D
];

let crosshairX = 50, crosshairY = 50;

// Function to draw the game
function drawGame() {
    if (!gameActive) return; // Stop drawing if the game is inactive

    // Check if currentQuestion is within the valid range
    if (currentQuestion < totalQuestions) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw question
        document.getElementById('questionText').innerText = questions[currentQuestion].question;

        // Draw and update moving targets
        questions[currentQuestion].answers.forEach((answer, i) => {
            // Move targets
            targets[i].x += targets[i].dx;
            targets[i].y += targets[i].dy;

            // Reverse direction if hitting canvas edges
            if (targets[i].x + targetSize > canvas.width || targets[i].x < 0) {
                targets[i].dx = -targets[i].dx;
            }
            if (targets[i].y + targetSize > canvas.height || targets[i].y < 0) {
                targets[i].dy = -targets[i].dy;
            }

            // Draw target (as an asteroid shape)
            drawAsteroid(targets[i].x, targets[i].y, targets[i].shape);
            ctx.fillStyle = "white"; // Set text color to white
            ctx.fillText(answer, targets[i].x - 50, targets[i].y + 10); // Adjusted text position for larger asteroids
        });

        // Draw crosshair
        drawCrosshair(crosshairX, crosshairY);
    }
}

// Function to draw different asteroid shapes based on the shape identifier
function drawAsteroid(x, y, shape) {
    const gradient = ctx.createRadialGradient(x + 30, y + 30, 10, x + 30, y + 30, 80);
    gradient.addColorStop(0, 'gray');
    gradient.addColorStop(1, 'darkslategray');

    ctx.fillStyle = gradient; // Use gradient as fill color
    ctx.beginPath();

    switch (shape) {
        case 'A':
            ctx.moveTo(x, y);
            ctx.bezierCurveTo(x + 30, y - 40, x + 90, y - 40, x + 80, y);
            ctx.bezierCurveTo(x + 110, y + 30, x + 60, y + 60, x, y + 40);
            ctx.bezierCurveTo(x - 30, y + 10, x - 40, y - 30, x, y);
            break;
        case 'B':
            ctx.moveTo(x, y);
            ctx.bezierCurveTo(x + 20, y - 60, x + 90, y - 30, x + 70, y + 30);
            ctx.bezierCurveTo(x + 50, y + 60, x + 30, y + 40, x, y + 20);
            ctx.bezierCurveTo(x - 40, y - 10, x - 20, y - 50, x, y);
            break;
        case 'C':
            ctx.moveTo(x, y);
            ctx.bezierCurveTo(x + 20, y - 20, x + 80, y - 60, x + 50, y);
            ctx.bezierCurveTo(x + 90, y + 10, x + 40, y + 50, x, y + 20);
            ctx.bezierCurveTo(x - 30, y + 10, x - 20, y - 30, x, y);
            break;
        case 'D':
            ctx.moveTo(x, y);
            ctx.bezierCurveTo(x + 10, y - 30, x + 70, y - 20, x + 50, y);
            ctx.bezierCurveTo(x + 80, y + 10, x + 30, y + 30, x, y + 10);
            ctx.bezierCurveTo(x - 20, y + 20, x - 30, y - 20, x, y);
            break;
    }

    ctx.closePath();
    ctx.fill();
}

// Function to draw crosshair
function drawCrosshair(x, y) {
    ctx.strokeStyle = "white"; // Set crosshair color to white
    ctx.beginPath();
    ctx.moveTo(x - 10, y);
    ctx.lineTo(x + 10, y);
    ctx.moveTo(x, y - 10);
    ctx.lineTo(x, y + 10);
    ctx.stroke();
}

// Mouse move event to update crosshair position
canvas.addEventListener('mousemove', function (event) {
    const rect = canvas.getBoundingClientRect();
    crosshairX = event.clientX - rect.left;
    crosshairY = event.clientY - rect.top;
});

// Click event to handle answer selection
canvas.addEventListener('click', function () {
    const targetIndex = targets.findIndex(target =>
        crosshairX > target.x && crosshairX < target.x + targetSize &&
        crosshairY > target.y && crosshairY < target.y + targetSize
    );

    if (targetIndex !== -1 && gameActive) {
        // Update score for correct answer
        if (targetIndex === questions[currentQuestion].correct) {
            score++; // Increase score for correct answer
        }
        currentQuestion++;

        // Check if there are more questions left
        if (currentQuestion < totalQuestions) {
            drawGame();
        } else {
            // Display end of game modal

            const percentageScore = (score / totalQuestions) * 100;
            document.getElementById('finalScoreText').innerText = `Your score: ${score}/${totalQuestions} (${percentageScore.toFixed(2)}%)`;
            document.getElementById('scoreModal').style.display = 'flex'; // Show modal

            // Check if the user passed or failed
            if (percentageScore >= 80) {
                document.getElementById('finalScoreText').innerText += `\nCongratulations, you passed!`;
                const updatedTotalScore = totalScore + score;

                // Update the game state with the new total score
                gameState.totalScore = updatedTotalScore;

                // Display the total score including the post-test score
                console.log(updatedTotalScore);
                showModal(updatedTotalScore);
                document.getElementById('score').innerText = `Your total score: ${updatedTotalScore}`;


                // Save the score to the database
                const baseUrl = window.location.origin;
                const userId = localStorage.getItem('user_id');
                console.log('User ID:', userId); // Get user ID from local storage

                // First, update the user's hard_finish status
                fetch(`${baseUrl}/update-hard-finish/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to include CSRF token
                    },
                    body: JSON.stringify({ hard_finish: 1 }) // Set hard_finish to true
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('hard_finish updated successfully:', data);

                        // After updating hard_finish, now save the score
                        return fetch(`${baseUrl}/hard-update-score/${userId}`, {
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
                        console.error('Error updating score or hard_finish:', error);
                    });
                document.getElementById('postTestContainer').style.display = 'none';
            } else {
                document.getElementById('finalScoreText').innerText += `\nYou need to score at least 80% to pass. Try again!`;
            }

            // Stop the game
            gameActive = false; // Set the game to inactive

                setTimeout(() => {
                currentQuestion = 0; // Reset to the first question
                score = 0; // Reset score
                gameActive = true; // Reactivate the game
                window.location.href = "{{ route('hard') }}"; // Restart the game
            }, 1000);
        }
    }
});

// Initial game draw and interval setup
drawGame(); // Initial game draw
setInterval(drawGame, 100); // Continuously update the game
// Continuously update the game

}


function attackMonster() {
    pauseTimer();
    gameState.isAttacking = true;
    gameState.attackFrame = 0;
    gameState.monsterHp = Math.max(0, gameState.monsterHp - 10);

    if (gameState.monsterHp < 0) {
        if (gameState.level === 1) {
            showLevel1CompleteModal();
        } else if (gameState.level === 2) {
            showLevel2CompleteModal();
        } else if (gameState.level === 3) {
            showLevel3CompleteModal();
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
    gameState.playerHp = Math.max(0, gameState.playerHp - 50);
    updateStats();

    if (gameState.playerHp <= 0) {
        setTimeout(() => {
            alert("Game Over! Try again!");
            resetGame();
        }, 500);
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
    if(currentLevel === 1){
        startTimer();
        draw();
        setTimeout(() => {
            flipAllCards(true);
            setTimeout(shuffle, 1000);
        }, 1000);
    }else if(currentLevel === 2){
        isStartLevel = true;
        switchToLevel2();
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
    // ctx.clearRect(0, 0, gameScene.width, gameScene.height);
    ctx.drawImage(backgroundImage, 0, 0, gameScene.width, gameScene.height);

    // Draw player
    ctx.drawImage(playerImage, 100, 150, 120, 120); // Adjust width and height as needed

    // Draw monster image
    ctx.drawImage(currentMonsterImage, 550, 120, 170, 170);

    if (gameState.isAttacking) {
        // Draw attack animation
        drawAttackEffect();
        
        gameState.attackFrame++;
        if (gameState.attackFrame > 10) {
            gameState.isAttacking = false;
            gameState.attackFrame = 0; // Reset attack frame
        }
    }

    requestAnimationFrame(draw);
}

function drawAttackEffect() {
    // Calculate the attack's position based on the frame count
    const attackX = 100 + (gameState.attackFrame * 5); // Adjust movement speed
    const attackYStart = 190;
    const attackYEnd = 200;

    ctx.beginPath();
    ctx.moveTo(attackX, attackYStart);
    ctx.lineTo(600, attackYEnd);

    // Add a glowing effect during the attack
    ctx.strokeStyle = 'rgba(255, 215, 0, 0.8)'; // Gold color with transparency
    ctx.lineWidth = 6 + Math.sin(gameState.attackFrame / 10) * 2; // Pulse effect for the line width
    ctx.shadowColor = 'rgba(255, 215, 0, 0.6)'; // Gold glow
    ctx.shadowBlur = 15; // Blur effect for the glow
    ctx.stroke();
    ctx.closePath();

    // Reset shadow properties for future draws
    ctx.shadowColor = 'transparent'; // Remove glow effect
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