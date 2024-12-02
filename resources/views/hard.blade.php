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

/* Styling for the guess container */
#guessContainer {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 20px; /* Increased gap for better spacing */
    flex-wrap: wrap;
    margin-top: 55px; /* Space between image and choices */
    padding: 10px; /* Added padding for better alignment */
}

/* Styling for the choice buttons */
.choice-button {
    padding: 15px 30px; /* Increased padding for larger buttons */
    font-size: 18px; /* Slightly larger font for better readability */
    background: linear-gradient(145deg, #4CAF50, #45a049);
    color: white;
    border: none;
    border-radius: 8px; /* Increased border-radius for smoother curves */
    cursor: pointer;
    transition: background 0.3s, transform 0.2s, box-shadow 0.2s;
    width: 150px; /* Increased width for better alignment */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
    text-transform: uppercase; /* Uppercase text for buttons for emphasis */
    font-weight: bold; /* Bold text for a stronger presence */
}

/* Hover effect */
.choice-button:hover {
    background: linear-gradient(145deg, #45a049, #4CAF50);
    transform: translateY(-5px); /* Slightly stronger hover effect */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* More pronounced shadow on hover */
}

/* Focused button for accessibility */
.choice-button:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.5); /* Green outline for focus */
}

/* Correct choice animation */
.correct-choice {
    animation: correctAnimation 0.5s ease forwards;
    box-shadow: 0 6px 12px rgba(40, 167, 69, 0.4); /* Green shadow for correct */
}

/* Wrong choice animation */
.wrong-choice {
    animation: wrongAnimation 0.5s ease forwards;
    box-shadow: 0 6px 12px rgba(244, 67, 54, 0.4); /* Red shadow for wrong */
}

/* Correct answer animation (green) */
@keyframes correctAnimation {
    0% {
        background: linear-gradient(145deg, #4CAF50, #45a049);
        transform: scale(1);
    }
    50% {
        background: linear-gradient(145deg, #28a745, #218838);
        transform: scale(1.1);
    }
    100% {
        background: linear-gradient(145deg, #4CAF50, #45a049);
        transform: scale(1);
    }
}

/* Wrong answer animation (red) */
@keyframes wrongAnimation {
    0% {
        background: linear-gradient(145deg, #f44336, #e53935);
        transform: scale(1);
    }
    50% {
        background: linear-gradient(145deg, #d32f2f, #c62828);
        transform: scale(1.1);
    }
    100% {
        background: linear-gradient(145deg, #f44336, #e53935);
        transform: scale(1);
    }
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

.feature-item img {
    width: 80px;  /* Set the desired width */
    height: 80px; /* Set the desired height */
    object-fit: cover; /* Ensures the image fits well within the specified dimensions */
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

.feature-item:hover img {
    transform: scale(1.1); /* Slight zoom effect on the image */
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
    font-size: 15px;
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
/* Certificate Modal Overlay */
.certificate-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center; 
    z-index: 1000;
}

/* Certificate Container */
.certificate {
    background: #fff;
    width: 90%;
    max-width: 700px;
    padding: 2rem;
    border: 10px solid #D4AF37;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    text-align: center;
    font-family: 'Georgia', serif;
    position: relative;
    background-image: linear-gradient(145deg, #ffffff 50%, #f3f3f3);
}

/* Inner Border */
.certificate::before {
    content: '';
    position: absolute;
    top: 15px;
    left: 15px;
    width: calc(100% - 30px);
    height: calc(100% - 30px);
    border: 2px solid #D4AF37;
    border-radius: 12px;
}

/* Certificate Text */
.certificate h1 {
    font-size: 2.5rem;
    color: #4A90E2;
    font-weight: bold;
    margin-bottom: 0.8rem;
    text-transform: uppercase;
}

.certificate p {
    font-size: 1.2rem;
    color: #333;
    margin: 0.5rem 0;
}

.certificate h2 {
    font-size: 1.8rem;
    color: #4A90E2;
    font-weight: bold;
    margin: 0.5rem 0;
}

/* Date Styling */
.certificate #date {
    font-weight: bold;
}

/* Buttons Styling */
.certificate-modal button {
    margin-top: 1rem;
    padding: 0.8rem 1.5rem;
    font-size: 1rem;
    background-color: #4A90E2;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.certificate-modal button:hover {
    background-color: #357ABD;
}

/* Spacing for Buttons */
.certificate-modal button + button {
    margin-left: 1rem;
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
<audio id="intenseFightMusic" src="{{ asset('audio/intense-fight-music.mp3') }}" loop preload="auto"></audio>
<audio id="playerAttackSound" src="{{ asset('audio/player-attack.mp3') }}" preload="auto"></audio>
    <audio id="monsterAttackSound" src="{{ asset('audio/monster-attack.mp3') }}" preload="auto"></audio>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
<div id="learning-modal">
    <div class="modal-background">
        <img src="{{ asset('images/characters/player.png') }}" alt="Player" class="modal-image" />
    </div>
    <div class="modal-content">
        <p id="learning-text"></p>
        <button id="skip-monologue-btn">Skip Monologue</buttoni>
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
            <div>Time Left: <span id="countdownTimer">30</span> seconds</div> 
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

        <div id="level5Content" style="display: block;">
                <h2>Level 5: Object Detection</h2>
                <div id="targetZoneMessage" style="margin-bottom: 10px;"></div>
                <div class="object-detection-container" style="position: relative;">
                <img id="objectImage" src="{{ asset('images/hard/hard.jpg') }}" style="max-width: 1000%; height: auto; cursor: pointer;">
            
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


    <div id="celebration"></div>

    <div class="modal-overlay" id="level3CompleteModal">
        <div class="modal">
            <h2>Level 3 Complete!</h2>
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 4: Feature Extraction Challenge!</p>
            <button onclick="startLevel4()">Start Level 4</button>
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
            <canvas id="gameCanvas" width="1000" height="625"></canvas>
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
        <button onclick="displayCertificate()">Show Certificate</button>
        <button onclick="closeModal()">Close</button>
        <button onclick="playAgain()">Play Again</button>
    </div>
</div>

<div id="certificateModal" class="certificate-modal" style="display: none;">
    <div class="certificate">
        <h1>Certificate of Achievement</h1>
        <p>This certificate is awarded to:</p>
        <h2 id="userName">John Doe</h2>
        <p>For Easy Mode achieving a score of</p>
        <h2 id="easyPostTest">80%</h2>
        <p>For Medium Mode achieving a score of</p>
        <h2 id="mediumPostTest">80%</h2>
        <p>For Hard Mode achieving a score of</p>
        <h2 id="hardPostTest">80%</h2>
        <p>Date: <span id="date"></span></p>
    </div>
    <div class="certificate-modal-buttons">
        <button onclick="downloadCertificate()">Download Certificate</button>
        <button onclick="closeCertificate()">Close Certificate</button>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
let quizOn = false;
function showGameOverModal() {
    gameOver.play();
    pauseTimer();
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
        if(quizOn === false){
            pauseTimer();
        }
        
    });

    // Close settings modal
    window.closeSettingsModal = function() {
        $('#settingsModal').hide();
    }

    // Resume button functionality
    $('#resumeButton').click(function() {
        closeSettingsModal(); // Close the modal
        // Additional logic to resume the game can go here
        if(quizOn === false){
            resumeTimer();
        }
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
            monsterY: 100,
            playerHurt: false,
            monsterHurt: false

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
let intenseFightMusic = document.getElementById("intenseFightMusic");
intenseFightMusic.volume = 0.2;

const wrongAnswer = new Audio("{{ asset('audio/wrong-answer.mp3') }}");
const correctAnswer = new Audio("{{ asset('audio/correct-answer.mp3') }}");
const levelComplete = new Audio("{{ asset('audio/level-complete.mp3') }}");
const gameOver = new Audio("{{ asset('audio/game-over.mp3') }}");

const cardWidth = 150;
const cardGap = 50;
const totalWidth = (cardWidth * 3) + (cardGap * 2);
const startX = (590 - totalWidth) / 2;

let cards = [];
let currentBlurLevel = 20;

 // Set duration for the timer (in seconds)
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
    const timerDuration = 30;
    timeLeft = timerDuration; // Reset time left to initial duration
    clearInterval(timerId);
    document.getElementById('countdownTimer').textContent = timeLeft;

    timerId = setInterval(() => {
        if (isPaused) { // Check if the timer is not paused
            timeLeft--;
            document.getElementById('countdownTimer').textContent = timeLeft;

            if (timeLeft <= 0) {
                showGameOverModal();// Notify player when time runs out
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
    startTimer(); // Start the timer for the new level
}

// Example of starting a new level (update accordingly in your game logic)
// startNewLevel(1); // Call this when a new level starts



function takeposttest() {
            quizOn = true;
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
    showMonologuesInSequence(5);; 
    updateStats(); 
    initializeLevel5(); 
}

function startLevel4() {
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'none';
    gameState.level = 4;
    showMonologuesInSequence(4);;
    updateStats(); 
    initializeLevel4(); 
}


function startLevel3() {
    const modal = document.getElementById('level2CompleteModal');
    modal.style.display = 'none';
    gameState.level = 3;
    showMonologuesInSequence(3);;
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
        initializeLevel1(9);
    } else if (gameState.level === 2) {
        level2Content.style.display = 'block';
        switchToLevel2();
        gameState.monsterHp = 100;
    } else if (gameState.level === 3) {
        level3Content.style.display = 'block';
        initializeLevel3();
        gameState.monsterHp = 100;
    } else if (gameState.level === 4) {
        level4Content.style.display = 'block';
        initializeLevel4();
        gameState.monsterHp = 100;
    } else if (gameState.level == 5) {
        level5Content.style.display = 'block';
        initializeLevel5();
        gameState.monsterHp = 100;
    }
    console.log(gameState.level);
            console.log(currentLevel);

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
function skipLevel() {
    pauseTimer();
    window.speechSynthesis.cancel(); 
    clearInterval(monologueInterval); 
    document.getElementById("learning-modal").style.display = "none"; // Hide modal
    document.getElementById("start-level-btn").style.display = "none"; // Hide the start button for next time
    startLevel(currentLevel); // Start the level
    gameState.monsterHp = 100; // Reset monster's health
    updateStats(); // Update game stats
    if (gameState.level === 1) {
                showLevel1CompleteModal();
                updateScore(10); 
            } else if (gameState.level === 2) {
                showLevel2CompleteModal();
                level2Content.style.display = 'block';
                isStartLevel = false;
                switchToLevel2();
                updateScore(10); 
                gameState.level++;
                const modal = document.getElementById('levelCompleteModal');
                modal.style.display = 'none';
                currentLevel++;
            } else if (gameState.level === 3) {
                showLevel3CompleteModal();
                level3Content.style.display = 'block';
                initializeLevel3();
                updateScore(10); 
                gameState.level++;
                const modal = document.getElementById('level2CompleteModal');
                modal.style.display = 'none';
            }else if (gameState.level === 4) {
                showLevel4CompleteModal();
                level4Content.style.display = 'block';
                initializeLevel4();
                updateScore(10); 
                gameState.level++;
                const modal = document.getElementById('level3CompleteModal');
                modal.style.display = 'none';
            }else if (gameState.level === 5) {
                showLevel5CompleteModal();
                level5Content.style.display = 'block';
                initializeLevel5();
                updateScore(10); 
                gameState.level++;
                const modal = document.getElementById('level4CompleteModal');
                modal.style.display = 'none';
            }else  {
                takeposttest();
                const modal = document.getElementById('level5CompleteModal');
                modal.style.display = 'none';
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
    switchToLevel2();
    console.log(currentLevel);
}

function showLevel1CompleteModal() {
    levelComplete.play();
    const modal = document.getElementById('levelCompleteModal');
    modal.style.display = 'flex';
    createConfetti();
    currentLevel++;
    gameState.level++;
}

function showLevel2CompleteModal() {
    levelComplete.play();
    const modal = document.getElementById('level2CompleteModal');
    console.log(gameState.level);
    level2Content.style.display = 'none';
    modal.style.display = 'flex';
    createConfetti();
    currentLevel++;
}

function showLevel3CompleteModal() {
    levelComplete.play();
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
    currentLevel++;
}

function showLevel4CompleteModal() {
    levelComplete.play();
    const modal = document.getElementById('level4CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
    currentLevel++;
}

function showLevel5CompleteModal() {
    levelComplete.play();
    const modal = document.getElementById('level5CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
    currentLevel++;
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

function initializeLevel1(cardNumber) {
    cardsContainer.innerHTML = '';
    cards = [];

    // Ensure you have enough unique images to display
    if (gameState.images.length < cardNumber) {
        console.error('Not enough unique images available!');
        return;
    }

    // Shuffle images and select unique ones
    const shuffledImages = gameState.images.sort(() => 0.5 - Math.random()).slice(0, cardNumber);

    // Set the target image and outlines
    const correctImageIndex = Math.floor(Math.random() * cardNumber);
    const selectedImage = shuffledImages[correctImageIndex];

    // Set the target image to the randomly selected one
    targetImage.src = selectedImage.original;

    level1Content.style.display = 'block';

    // Create an array of outlines for this image
    const outlines = [...selectedImage.outlines]; // Copy the outlines array

    // Randomize the correct position for the correct outline
    const correctPosition = Math.floor(Math.random() * cardNumber);

    // Create the cards
    for (let i = 0; i < cardNumber; i++) {
        let outlineSrc;

        if (i === correctPosition) {
            // Assign the correct outline for the correct card
            outlineSrc = outlines[0]; // First outline is always the correct one
        } else {
            // Shuffle the outlines to select an incorrect one
            // We should pick a random incorrect outline that isn't the correct one
            let incorrectOutlineIndex;
            do {
                incorrectOutlineIndex = Math.floor(Math.random() * outlines.length);
            } while (incorrectOutlineIndex === 0); // Ensure it isn't the correct outline

            outlineSrc = outlines[incorrectOutlineIndex]; // Pick incorrect outline
        }

        const cardData = createCard(i, i === correctPosition, outlineSrc);
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
                correctAnswer.play();
                document.getElementById('message').textContent = "Correct! You found the Outline";
                cardData.element.classList.add('victory');

                // Update score for correct answer

                updateScore(10); // Award 10 points for correct guess

                setTimeout(() => {
                    attackMonster(50);
                }, 500);

                setTimeout(() => {
                    cardData.element.classList.remove('victory');
                    if (gameState.monsterHp > 0 && gameState.playerHp > 0) {
                        nextRound();
                    }
                }, 2500);
            } else {
                wrongAnswer.play();
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
        function nextRound() {
            initializeGame();
            setTimeout(() => {
                flipAllCards(true);
                setTimeout(shuffle, 1000);
            }, 1000);
        }
        function switchToLevel2() {
    // Ensure that the timer and level 1 state are cleared
    level1Content.style.display = 'none'; // Hide Level 1 content
    level2Content.style.display = 'block'; // Show Level 2 content
    guessContainer.style.display = 'flex'; // Display guess container for level 2
    
    // Randomly select an image from the level2Images array
    const randomImageIndex = Math.floor(Math.random() * gameState.level2Images.length);
    const selectedImage = gameState.level2Images[randomImageIndex];
    gameState.currentLevel2Image = selectedImage; // Store selected image in game state

    // Set up level 2 with the randomly selected image
    blurredImage.src = selectedImage.image;

    // Reset the blur to 100px at the start to ensure consistent animation
    blurredImage.style.transition = 'none';
    blurredImage.style.filter = 'blur(100px)';

    // Delay the blur reduction to create the animation effect
    setTimeout(() => {
        if (isStartLevel) {
            blurredImage.style.transition = 'filter 6s ease';
            blurredImage.style.filter = 'blur(0px)';
        }
    }, 10);

    // Start the timer for Level 2
    startNewLevel(2);

    // Create multiple-choice options
    createMultipleChoiceOptions(selectedImage.answer);

    // Event listener for when the blur animation ends
    blurredImage.addEventListener('transitionend', () => {
        endLevel();
        pauseTimer();
        showGameOverModal();
    }, { once: true });
}

// Function to generate multiple-choice options with relevant answers
function createMultipleChoiceOptions(correctAnswer) {
    // Clear existing guess container contents
    guessContainer.innerHTML = '';

    // Filter to find incorrect answers from level2Images that are not the correct answer
    const incorrectAnswers = gameState.level2Images
        .map(item => item.answer)
        .filter(answer => answer !== correctAnswer);

    // Randomly select three incorrect answers
    const randomIncorrectAnswers = incorrectAnswers
        .sort(() => 0.5 - Math.random())
        .slice(0, 3); // Pick only three incorrect options

    // Combine the correct answer with the incorrect answers
    const options = [correctAnswer, ...randomIncorrectAnswers];
    
    // Shuffle options array to randomize button placement
    const shuffledOptions = options.sort(() => Math.random() - 0.5);

    // Create a button for each option
    shuffledOptions.forEach((optionText) => {
        const optionButton = document.createElement('button');
        optionButton.className = 'choice-button';
        optionButton.textContent = optionText;
        
        // Event listener for handling guesses
        optionButton.addEventListener('click', () => handleGuess(optionText, correctAnswer));

        // Append each button to the guessContainer
        guessContainer.appendChild(optionButton);
    });

    // Display the guess container with the multiple-choice options
    guessContainer.style.display = 'flex';
}

// Handle guess selection
function handleGuess(selectedOption, correctAnswerText) {
    const currentImage = gameState.currentLevel2Image;

    // Find the button based on the selectedOption text
    const selectedButton = [...document.querySelectorAll('.choice-button')].find(button => button.textContent === selectedOption);

    if (selectedOption === correctAnswerText) {
        // Add correct animation class
        selectedButton.classList.add('correct-choice');
        correctAnswer.play(); // Play correct answer sound
        document.getElementById('message').textContent = "Correct! You identified the image!";
        level2Content.style.display = 'none';
        attackMonster(50);

        // Force monster defeat to trigger level completion
        if (gameState.monsterHp === 0) {
            isStartLevel = false;
        }

        // Update score for correct answer
        updateScore(10);
    } else {
        // Add wrong animation class
        selectedButton.classList.add('wrong-choice');
        wrongAnswer.play(); // Play wrong answer sound
        document.getElementById('message').textContent = "Wrong guess! Try again!";
        monsterAttack();
        takeDamage(); // Handle player damage on wrong guess
    }

    // Remove the class after animation ends (reset for next guess)
    selectedButton.addEventListener('animationend', () => {
        selectedButton.classList.remove('correct-choice', 'wrong-choice');
    });

    // Continue or restart Level 2 based on game state
    if (gameState.monsterHp > 0) {
        switchToLevel2();
    }
}


        const containerWidth = 400; // Assuming the width of the container
const containerHeight = 400; // Assuming the height of the container
const zoneWidth = 80; // Width of each correct zone
const zoneHeight = 80; // Height of each correct zone

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
    level2Content.style.display = 'none';

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
    startNewLevel(3); // This function handles starting the countdown timer for the level
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

                if (gameState.monsterHp <= 0) {
                    showLevel3CompleteModal();
                    gameState.level++;
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
            correctAnswer.play();
            // Update score if needed
            updateScore(15); // Example: 20 points for correct color match
            
            showLevel4CompleteModal(); // Show completion modal
            gameState.level++; // Progress to the next level
            attackMonster(100); // Move to the next stage or action
        } else {
            wrongAnswer.play();
            document.getElementById('message').textContent = `Incorrect color! Try again!`;
            takeDamage(); // Handle incorrect color guess
            monsterAttack();
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
        { id: 'farthestpost', name: 'Farthest Lamp Post' },
        { id: 'middlepost', name: 'Middle Lamp Post' },
        { id: 'manwithphone', name: 'Man with Phone' },
        { id: 'ladyintheblackholdingplastic', name: 'Lady in Black Holding Plastic' },
        { id: 'manpink', name: 'Old Woman in Pink' },
        { id: 'mangreen', name: 'Man in Green' },
        { id: 'ladyblackandwhitejeans', name: 'Lady with Black and White Jeans' },
        { id: 'ladygreenwithredbabg', name: 'Lady in Green with Red Bag' },
        { id: 'closepost', name: 'Closest Lamp Post' },
        { id: 'train', name: 'Train' },
        { id: 'firehydrant', name: 'Fire Hydrant' },
        { id: 'trashcan', name: 'Trash Can' },
        { id: 'poster', name: 'Poster' },
        { id: 'u-turnsign', name: 'Do not turn Sign' },
        { id: 'trafficlight', name: 'Traffic Light' },
        { id: 'blackcar', name: 'Black Car' }
    ];

    // Randomly shuffle and select 8 distinct targets
    const shuffledZones = [...detectionZones].sort(() => Math.random() - 0.5);
    const selectedTargets = shuffledZones.slice(0, 8);

    // Show the first target's name in the message
    let currentTargetIndex = 0;
    targetZoneMessage.innerText = `Click on the: ${selectedTargets[currentTargetIndex].name}`;

    // Event listener for image click
    objectImage.addEventListener('click', function(event) {
        const rect = objectImage.getBoundingClientRect();
        const x = event.clientX - rect.left; 
        const y = event.clientY - rect.top;  

        // Get the target zone for the current target
        const targetZone = document.getElementById(selectedTargets[currentTargetIndex].id);
        const targetRect = targetZone.getBoundingClientRect();

        // Check if the clicked area is within the target zone
        const detected = (x >= targetRect.left - rect.left && x <= targetRect.right - rect.left) &&
                         (y >= targetRect.top - rect.top && y <= targetRect.bottom - rect.top);

        if (detected) {
            // Update score for successful detection
            updateScore(5); // Example: Award 20 points for detecting the object
            attackMonster(25);
            correctAnswer.play();
            // Move to the next target
            currentTargetIndex++;

            if (currentTargetIndex < selectedTargets.length) {
                // Update the message to show the next target
                targetZoneMessage.innerText = `Click on the: ${selectedTargets[currentTargetIndex].name}`;
            } 
            else {
                gameState.level = 6; // Move to the next level
            }
        } else {
            takeDamage(); // Handle incorrect clicks
            monsterAttack();
            wrongAnswer.play();
        }
    });
}



function initializePostTest() {
    const quizSound = new Audio("{{ asset('music/quizBackgroundMusic.mp3') }}");
            quizSound.loop = true; // Enable looping
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
        question: "1. What is outline classification in image recognition?\n\n\nA. Identifying edges\nB. Color detection\nC. Pixel classification\nD. Object tracking",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "Outline"
    },
    {
        question: "2. What does pixelation in images do?\n\n\nA. Increases clarity\nB. Reduces detail\nC. Enhances color\nD. Adds noise",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "Pixelation"
    },
    {
        question: "3. Which method is commonly used for object detection?\n\n\nA. Convolutional Neural Networks\nB. Decision Trees\nC. Linear Regression\nD. K-Means Clustering",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "ObjectDetection"
    },
    {
        question: "4. What is color identification in image processing?\n\n\nA. Identifying shapes\nB. Determining the predominant color\nC. Detecting edges\nD. Segmenting images",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "ColorIdentification"
    },
    {
        question: "5. What is feature extraction in image recognition?\n\n\nA. Simplifying the image\nB. Identifying key attributes\nC. Enhancing colors\nD. Reducing noise",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "FeatureExtraction"
    },
    {
        question: "6. What is the primary goal of image segmentation?\n\n\nA. To isolate regions of interest\nB. To increase image size\nC. To enhance brightness\nD. To compress images",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "Pixelation"
    },
    {
        question: "7. Which algorithm is used for outline classification?\n\n\nA. Hough Transform\nB. K-Means Clustering\nC. Principal Component Analysis\nD. Support Vector Machine",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "Outline"
    },
    {
        question: "8. What is a common technique used in object detection?\n\n\nA. Histogram Equalization\nB. Sliding Window\nC. Color Thresholding\nD. Image Blurring",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "Object Detection"
    },
    {
        question: "9. In color identification, which color model is often used?\n\n\nA. CMYK\nB. HSV\nC. XYZ\nD. LAB",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "Color Identification"
    },
    {
        question: "10. Which method is essential for feature extraction?\n\n\nA. Normalization\nB. Data Augmentation\nC. Dimensionality Reduction\nD. Color Correction",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 2,
        topic: "FeatureExtraction"
    },
    {
        question: "11. What is a common technique for identifying edges in images?\n\n\nA. Gaussian Blur\nB. Sobel Filter\nC. Mean Shift\nD. Median Filter",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "Outline"
    },
    {
        question: "12. What does image segmentation help with?\n\n\nA. Improving image resolution\nB. Separating distinct objects\nC. Enhancing colors\nD. Changing brightness",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 1,
        topic: "Pixelation"
    },
    {
        question: "13. What is the purpose of object detection?\n\n\nA. Finding edges\nB. Recognizing patterns\nC. Locating objects within an image\nD. Changing colors",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 2,
        topic: "ObjectDetection"
    },
    {
        question: "14. Which algorithm is used for color detection?\n\n\nA. K-Means Clustering\nB. Random Forest\nC. Decision Tree\nD. PCA",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "ColorIdentification"
    },
    {
        question: "15. What is an important aspect of feature extraction?\n\n\nA. Image size\nB. Color depth\nC. Shape representation\nD. Resolution",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 2,
        topic: "FeatureExtraction"
    },
    {
        question: "16. What is the process of simplifying an image while preserving important information?\n\n\nA. Compression\nB. Segmentation\nC. Normalization\nD. Smoothing",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "Pixelation"
    },
    {
        question: "17. What do we analyze in outline classification?\n\n\nA. Shapes and edges\nB. Colors\nC. Brightness\nD. Textures",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "Outline"
    },
    {
        question: "18. What technique is used to detect multiple objects in an image?\n\n\nA. YOLO\nB. Convolutional Filtering\nC. Edge Detection\nD. Histogram Equalization",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "ObjectDetection"
    },
    {
        question: "19. What is the significance of the HSV color model?\n\n\nA. It separates color information from intensity\nB. It's faster than RGB\nC. It's easier to visualize\nD. It's more accurate",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "ColorIdentification"
    },
    {
        question: "20. Which of the following is a method for image feature extraction?\n\n\nA. Scale-Invariant Feature Transform\nB. Color Balancing\nC. Image Denoising\nD. Color Correction",
        answers: [
            "A.",
            "B.",
            "C.",
            "D."
        ],
        correct: 0,
        topic: "FeatureExtraction"
    }
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
    let isReloading = false; // State to track if the gun is reloading

function drawRevolver() {
const gunX = canvas.width / 2; // Center position of the gun on the canvas
const gunY = canvas.height - 0; // Slightly above the bottom for a first-person effect

ctx.save();
ctx.translate(gunX, gunY);

// Scale factor to make the revolver bigger
const scaleFactor = 1.5;

// Draw the revolver grip with a wood texture effect
ctx.fillStyle = "#663300";
ctx.beginPath();
ctx.moveTo(-20 * scaleFactor, 0);
ctx.lineTo(20 * scaleFactor, 0);
ctx.lineTo(15 * scaleFactor, -40 * scaleFactor);
ctx.lineTo(-15 * scaleFactor, -40 * scaleFactor);
ctx.closePath();
ctx.fill();

// Add some lines to simulate wood grain texture
ctx.strokeStyle = "#331900";
ctx.lineWidth = 1 * scaleFactor;
ctx.beginPath();
ctx.moveTo(-18 * scaleFactor, -10 * scaleFactor);
ctx.lineTo(-10 * scaleFactor, -35 * scaleFactor);
ctx.moveTo(10 * scaleFactor, -5 * scaleFactor);
ctx.lineTo(15 * scaleFactor, -35 * scaleFactor);
ctx.stroke();

// Draw the revolver body with more details
ctx.fillStyle = "#555";
ctx.fillRect(-15 * scaleFactor, -40 * scaleFactor, 30 * scaleFactor, -60 * scaleFactor);

// Draw the cylinder (revolver style) with rotation effect
ctx.save();
ctx.fillStyle = isReloading ? "#666" : "#777";
ctx.translate(0, -70 * scaleFactor);
ctx.rotate(isReloading ? Math.PI / 8 : 0); // Slight rotation during reload
ctx.beginPath();
ctx.arc(0, 0, 15 * scaleFactor, 0, Math.PI * 2);
ctx.fill();

// Add cylinder chambers (holes for bullets)
ctx.fillStyle = "#333";
for (let i = 0; i < 6; i++) {
    ctx.beginPath();
    ctx.arc(
        10 * scaleFactor * Math.cos(i * Math.PI / 3), 
        10 * scaleFactor * Math.sin(i * Math.PI / 3), 
        3 * scaleFactor, 
        0, 
        Math.PI * 2
    );
    ctx.fill();
}
ctx.restore();

// Draw the barrel with additional details
ctx.fillStyle = "#444";
ctx.fillRect(-5 * scaleFactor, -100 * scaleFactor, 10 * scaleFactor, -40 * scaleFactor); // Main barrel shape

// Draw barrel details (e.g., grooves or lines)
ctx.strokeStyle = "#333";
ctx.lineWidth = 1 * scaleFactor;
ctx.beginPath();
ctx.moveTo(-3 * scaleFactor, -140 * scaleFactor);
ctx.lineTo(-3 * scaleFactor, -100 * scaleFactor);
ctx.moveTo(3 * scaleFactor, -140 * scaleFactor);
ctx.lineTo(3 * scaleFactor, -100 * scaleFactor);
ctx.stroke();

// Optional: Add a sight at the end of the barrel
ctx.fillStyle = "#222";
ctx.fillRect(-2 * scaleFactor, -140 * scaleFactor, 4 * scaleFactor, 5 * scaleFactor);

ctx.restore();
}

// Function to simulate firing and reloading
function fireGun() {
if (!isReloading) {
    isReloading = true;

    // Gunfire effect
    

    // Start reloading animation with recoil effect
    setTimeout(() => {
        isReloading = false;
        drawGame();
    }, 300); // 300 ms reloading delay for animation effect
}
}

// Function to create a muzzle flash effect with details
function drawMuzzleFlash() {
const flashX = canvas.width / 2;
const flashY = canvas.height - 200; // Flash should appear near the end of the barrel

ctx.save();
ctx.translate(flashX, flashY);

// Create outer flash (larger and less opaque)
ctx.fillStyle = "rgba(255, 165, 0, 0.5)";
ctx.beginPath();
ctx.arc(0, 0, 60, 0, Math.PI * 2); // Increased size for larger gun
ctx.fill();

// Create inner flash (smaller and brighter)
ctx.fillStyle = "rgba(255, 200, 50, 0.8)";
ctx.beginPath();
ctx.arc(0, 0, 40, 0, Math.PI * 2);
ctx.fill();

// Create core flash (smallest and most intense)
ctx.fillStyle = "rgba(255, 255, 255, 0.9)";
ctx.beginPath();
ctx.arc(0, 0, 20, 0, Math.PI * 2);
ctx.fill();

ctx.restore();

// Remove the flash after a short time
setTimeout(drawGame, 100);
}


// Update the drawGame function to include drawing the gun
function drawGame() {
if (!gameActive) return;

// Clear the canvas
ctx.clearRect(0, 0, canvas.width, canvas.height);

// Draw the background first
drawBackground();

// Check if there are more questions to display
if (currentQuestion < totalQuestions) {
    // Display the current question text
    document.getElementById('questionText').innerText = questions[currentQuestion].question;

    // Draw targets for each answer
    questions[currentQuestion].answers.forEach((answer, i) => {
        const xPos = 100 + (i * 200);
        drawTarget(xPos, 300, answer);
    });

    // Draw the crosshair
    drawCrosshair(crosshairX, crosshairY);

    // Draw the gun that follows the crosshair
    drawRevolver();

    // Draw hit animation if active
    if (hitAnimationActive) {
        drawHitAnimation(hitAnimationX, hitAnimationY);
        fireGun();
        drawMuzzleFlash();
        hitAnimationFrame++;

        // Reset hit animation after a few frames
        if (hitAnimationFrame > 5) {
            hitAnimationActive = false;
            hitAnimationFrame = 0;
        }
    }
}
}


function drawBackground() {
const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

// Sky Gradient
const skyGradient = ctx.createLinearGradient(0, 0, 0, canvas.height / 2);
skyGradient.addColorStop(0, "#87CEEB"); // Light blue
skyGradient.addColorStop(1, "#4682B4"); // Steel blue
ctx.fillStyle = skyGradient;
ctx.fillRect(0, 0, canvas.width, canvas.height / 2);

// Draw Clouds
for (let i = 0; i < 5; i++) {
    const cloudX = Math.random() * canvas.width;
    const cloudY = Math.random() * (canvas.height / 3);
    drawCloud(ctx, cloudX, cloudY);
}

// Ground Gradient
const groundGradient = ctx.createLinearGradient(0, canvas.height / 2, 0, canvas.height);
groundGradient.addColorStop(0, "#8B4513"); // Brown at horizon
groundGradient.addColorStop(1, "#5C4033"); // Darker brown near bottom
ctx.fillStyle = groundGradient;
ctx.fillRect(0, canvas.height / 2, canvas.width, canvas.height / 2);

// Horizon Line
ctx.strokeStyle = "#654321"; // Darker brown for horizon
ctx.lineWidth = 2;
ctx.beginPath();
ctx.moveTo(0, canvas.height / 2);
ctx.lineTo(canvas.width, canvas.height / 2);
ctx.stroke();

// Distant Trees on Horizon
for (let i = 0; i < 10; i++) {
    const treeX = Math.random() * canvas.width;
    const treeY = canvas.height / 2 - Math.random() * 10;
    drawTree(ctx, treeX, treeY, 0.4); // Smaller trees for distance effect
}

// Grass Patches in Foreground
for (let i = 0; i < 15; i++) {
    const grassX = Math.random() * canvas.width;
    const grassY = canvas.height / 2 + Math.random() * (canvas.height / 2);
    drawGrass(ctx, grassX, grassY);
}

// Stones and Ground Details
for (let i = 0; i < 10; i++) {
    const stoneX = Math.random() * canvas.width;
    const stoneY = canvas.height / 2 + Math.random() * (canvas.height / 2);
    drawStone(ctx, stoneX, stoneY);
}

// Targets on the Ground
for (let i = 0; i < 3; i++) {
    const targetX = (canvas.width / 4) * (i + 1);
    const targetY = canvas.height / 2 + 100;
    drawTarget(ctx, targetX, targetY);
}
}

// Function to draw clouds
function drawCloud(ctx, x, y) {
ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
ctx.beginPath();
ctx.arc(x, y, 20, Math.PI * 0.5, Math.PI * 1.5);
ctx.arc(x + 30, y - 10, 25, Math.PI * 1, Math.PI * 1.85);
ctx.arc(x + 60, y, 20, Math.PI * 1.5, Math.PI * 0.5);
ctx.closePath();
ctx.fill();
}

// Function to draw trees on the horizon
function drawTree(ctx, x, y, scale = 1) {
ctx.fillStyle = "#2E8B57"; // Green for tree leaves
ctx.beginPath();
ctx.moveTo(x, y);
ctx.lineTo(x - 10 * scale, y + 20 * scale);
ctx.lineTo(x + 10 * scale, y + 20 * scale);
ctx.closePath();
ctx.fill();

ctx.fillStyle = "#8B4513"; // Brown for trunk
ctx.fillRect(x - 2 * scale, y + 20 * scale, 4 * scale, 10 * scale);
}

// Function to draw grass patches
function drawGrass(ctx, x, y) {
ctx.fillStyle = "#228B22"; // Green color for grass
for (let i = 0; i < 5; i++) {
    const bladeX = x + Math.random() * 10 - 5;
    const bladeY = y - Math.random() * 15;
    ctx.beginPath();
    ctx.moveTo(bladeX, y);
    ctx.lineTo(bladeX - 2, bladeY);
    ctx.lineTo(bladeX + 2, bladeY);
    ctx.fill();
    ctx.closePath();
}
}

// Function to draw small stones
function drawStone(ctx, x, y) {
ctx.fillStyle = "#A9A9A9"; // Gray color for stone
ctx.beginPath();
ctx.ellipse(x, y, Math.random() * 5 + 2, Math.random() * 3 + 1, Math.PI / 4, 0, Math.PI * 2);
ctx.fill();
ctx.closePath();
}

// Function to draw targets with answers inside
function drawTarget(x, y, answer) {
const ringSizes = [80, 70, 60, 50, 40, 30, 20]; // Radii for each ring from outer to inner
const ringColors = ["white", "black", "blue", "black", "red", "red", "yellow"]; // Colors for each ring

// Adjust x position to move targets further right
const adjustedX = x + 100; // Move the target right by 100 pixels

// Draw each ring
for (let i = 0; i < ringSizes.length; i++) {
    ctx.fillStyle = ringColors[i]; // Set the fill color for the current ring
    ctx.beginPath();
    ctx.arc(adjustedX, y, ringSizes[i], 0, Math.PI * 2); // Draw the ring as a circle
    ctx.fill();
    ctx.closePath();
}

// Text settings
const textColor = "black"; // Text color
const textBackgroundColor = "rgba(255, 255, 255, 0.8)"; // Background color for the text
const fontSize = "20px"; // Font size for better readability
const textPadding = 5; // Padding for the text background

// Calculate text background dimensions
const textWidth = ctx.measureText(answer).width;
const textBackgroundWidth = textWidth + textPadding * 2; // Width of text background
const textBackgroundHeight = parseInt(fontSize, 10) + textPadding; // Height of text background

// Draw the answer label inside the target
ctx.fillStyle = textColor; // Text color
ctx.font = `bold ${fontSize} Arial`; // Font style with increased size
ctx.textAlign = "center"; // Center text alignment
ctx.textBaseline = "middle"; // Align text vertically in the middle
ctx.fillText(answer, adjustedX, y);
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
const maxBurstRadius = 70; // Increase the max burst radius for a bigger effect
const burstRadius = 20 + hitAnimationFrame * 4; // Increase initial burst radius and speed of expansion
const burstOpacity = 1 - hitAnimationFrame / 8; // Make burst opacity fade out slower

// Radial gradient for the burst effect
const gradient = ctx.createRadialGradient(x, y, 0, x, y, burstRadius);
gradient.addColorStop(0, `rgba(255, 165, 0, ${burstOpacity})`); // Brighter Orange
gradient.addColorStop(0.5, `rgba(255, 100, 0, ${burstOpacity * 0.9})`); // More intense Orange-red
gradient.addColorStop(1, `rgba(255, 50, 0, 0)`); // Edge - Transparent

// Draw expanding burst with gradient
ctx.fillStyle = gradient;
ctx.beginPath();
ctx.arc(x, y, Math.min(burstRadius, maxBurstRadius), 0, Math.PI * 2);
ctx.fill();
ctx.closePath();

// Draw "hole" in the target
const holeRadius = hitAnimationFrame * 3; // Increase hole radius expansion
ctx.fillStyle = "rgba(0, 0, 0, 0.8)"; // Darker "hole" color for contrast
ctx.beginPath();
ctx.arc(x, y, holeRadius, 0, Math.PI * 2);
ctx.fill();
ctx.closePath();

// Shockwave ring effect
const shockwaveRadius = hitAnimationFrame * 5; // Larger shockwave
ctx.strokeStyle = `rgba(255, 255, 255, ${burstOpacity * 0.8})`; // White with stronger opacity
ctx.lineWidth = 3; // Thicker line for the shockwave
ctx.beginPath();
ctx.arc(x, y, shockwaveRadius, 0, Math.PI * 2);
ctx.stroke();
ctx.closePath();

// Enhanced particle debris effect
for (let i = 0; i < 18; i++) { // Increase particle count
    const angle = Math.random() * Math.PI * 2;
    const distance = burstRadius + Math.random() * 20;
    const particleX = x + Math.cos(angle) * distance;
    const particleY = y + Math.sin(angle) * distance;
    const particleSize = 3 + Math.random() * 3; // Larger particles
    const particleOpacity = burstOpacity * (0.7 + Math.random() * 0.5); // Higher opacity range

    ctx.fillStyle = `rgba(169, 169, 169, ${particleOpacity})`; // Gray debris
    ctx.beginPath();
    ctx.arc(particleX, particleY, particleSize, 0, Math.PI * 2);
    ctx.fill();
    ctx.closePath();
}

// More noticeable smoke particles
for (let i = 0; i < 10; i++) { // Increase smoke particle count
    const smokeAngle = Math.random() * Math.PI * 2;
    const smokeDistance = 25 + Math.random() * 15;
    const smokeX = x + Math.cos(smokeAngle) * smokeDistance;
    const smokeY = y - Math.sin(smokeAngle) * (smokeDistance + hitAnimationFrame); // Moves upwards
    const smokeSize = 5 + Math.random() * 4; // Larger smoke particles
    const smokeOpacity = burstOpacity * 0.4; // Increase smoke opacity slightly

    ctx.fillStyle = `rgba(105, 105, 105, ${smokeOpacity})`; // Dark gray smoke
    ctx.beginPath();
    ctx.arc(smokeX, smokeY, smokeSize, 0, Math.PI * 2);
    ctx.fill();
    ctx.closePath();
}

// Update animation frame count
hitAnimationFrame++;

// Reset animation once completed
if (hitAnimationFrame > 20) { // Longer duration for extended visibility
    hitAnimationActive = false;
    hitAnimationFrame = 0;
}
}

        canvas.addEventListener('mousemove', function (event) {
            const rect = canvas.getBoundingClientRect();
            crosshairX = event.clientX - rect.left;
            crosshairY = event.clientY - rect.top;
            drawGame();
        });
        
        // Click event to handle answer selection
        canvas.addEventListener('click', function () {
            fireGun();
        shootSound.play();
            const targetSize = 80; // Size of the target shape

             let hit = false;

            // Check if a target was clicked
            questions[currentQuestion].answers.forEach((answer, i) => {
                const adjustedXPos = 100 + (i * 200) + 100; // Match x position from drawTarget
                const adjustedYPos = 300; // Match y position from drawTarget// Calculate X position for the target

                if (
                    crosshairX > adjustedXPos - targetSize &&
                    crosshairX < adjustedXPos + targetSize &&
                    crosshairY > adjustedYPos - targetSize &&
                    crosshairY < adjustedYPos + targetSize
                ) {
                hit = true;
                    if (i === questions[currentQuestion].correct) {
            score++; // Increase score for correct answer
            
        }
        hitAnimationActive = true;
        hitAnimationX = adjustedXPos; // Use adjusted X position to align with target
        hitAnimationY = adjustedYPos;

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

                


// Function to download the certificate as an image

                // Check if the user passed or failed
                 // Define base URL and retrieve user ID from local storage
        const baseUrl = window.location.origin;
        const userId = localStorage.getItem('user_id');
        console.log('User ID:', userId);

        // Fetch previous performance from backend to ensure accuracy
        

                // Check if the user passed or failed
                if (percentageScore >= 80) {
                    fetch(`${baseUrl}/get-hard-current-performance/${userId}`)
            .then(response => response.json())
            .then(data => {
                let previousPostTestPerformance = data.post_test_performance || 0;
                console.log('Previous Performance:', previousPostTestPerformance);
                    document.getElementById('finalScoreText').innerText += `\nCongratulations, you passed!`;
                    const updatedTotalScore = gameState.totalScore + score;
                    
                    // Update the game state with the new total score
                    gameState.totalScore = updatedTotalScore;
                    showModal(updatedTotalScore);
                    

                    // Display the total score including the post-test score
                    console.log('Updated Total Score:', updatedTotalScore);
                    document.getElementById('score').innerText = `Your total score: ${updatedTotalScore}`;

                    // Update hard_finish status and save stats to the database
                    fetch(`${baseUrl}/update-hard-finish/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ hard_finish: 1 })
                    })
                    .then(response => response.json())
                    .then(() => {
                        // Save the score and additional stats
                        return fetch(`${baseUrl}/hard-update-score/${userId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                score: updatedTotalScore,
                                increment_total_games_played: true,
                                total_wins: percentageScore >= 80 ? 1 : 0,
                                success_rate: percentageScore >= 80 ? 1 : 0,
                                hard_post_test_performance: Math.max(percentageScore, previousPostTestPerformance)
                            })
                        });
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Score and additional stats updated successfully:', data);
                        displayCertificate();
                    })
                    .catch(error => {
                        console.error('Error updating score or hard_finish:', error);
                    });
                })
            .catch(error => {
                console.error('Error fetching current performance:', error);
            });
            document.getElementById('postTestContainer').style.display = 'none';
                } else {
                    document.getElementById('finalScoreText').innerText += `\nYou need to score at least 80% to pass. Try again!`;
                    // Restart the game after 1 second if user failed
                    fetch(`${baseUrl}/hard-update-score/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            increment_total_games_played: true, // Only increment total games played
                            // Include other fields conditionally based on your logic
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();  // Parse JSON only if the response is ok
                    })
                    .then(data => {
                        console.log('Game stats updated successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error updating total games played:', error);
                    });
                    setTimeout(() => {
                        currentQuestion = 0; // Reset to the first question
                        score = 0; // Reset score
                        gameActive = true; // Reactivate the game
                        window.location.href = "{{ route('hard') }}"; // Restart the game
                    }, 1000);
                }
                gameActive = false;
            }
            }
        }
    });
});
            drawGame();
            setInterval(drawGame, 100);
            document.getElementById('postTestContainer').style.display = 'block'; // Show post-test container
        }
        function displayCertificate() {
    // Fetch user data from the backend
    fetch('/certificate-data') // Replace with your correct route
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('userName').innerText = data.name;
            document.getElementById('easyPostTest').innerText = `${data.easyPostTest}%`;
            document.getElementById('mediumPostTest').innerText = `${data.mediumPostTest}%`;
            document.getElementById('hardPostTest').innerText = `${data.hardPostTest}%`;
            document.getElementById('date').innerText = data.date;

            // Display the certificate modal
            document.getElementById('certificateModal').style.display = 'flex';
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("Failed to load certificate data. Please try again.");
        });
}

function sendCertificateByEmail() {
    // Capture the certificate as an image
    html2canvas(document.querySelector('.certificate')).then(canvas => {
        const imageData = canvas.toDataURL("image/png");

        fetch(`/send-certificate-email`, { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                certificateImage: imageData
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.message === 'Certificate emailed successfully') {
                alert("Certificate emailed successfully!");
            } else {
                alert("Failed to email certificate.");
            }
        })
        .catch(error => {
            console.error("Error emailing certificate:", error);
            alert("Error occurred while emailing certificate.");
        });
    });
}

function closeCertificate() {
    document.getElementById('certificateModal').style.display = 'none';
}

function downloadCertificate() {
    const certificate = document.querySelector('.certificate');
    console.log(html2canvas); 
    // Capture the certificate as an image
    html2canvas(certificate).then(canvas => {
        const link = document.createElement('a');
        link.download = 'certificate.png';
        link.href = canvas.toDataURL();
        link.click();
    }).catch(error => {
        console.error("Error generating the certificate image:", error);
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
            window.location.href = "{{ route('hard') }}"; // Redirect to hard.blade.php
        }


function attackMonster(damage) {
    gameState.isAttacking = true;
    gameState.attackFrame = 0;
    gameState.monsterHp = Math.max(0, gameState.monsterHp - damage);

    if (gameState.monsterHp === 0) {
        pauseTimer();
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

    if (!gameState.isPlayerAttacking && !gameState.isMonsterAttacking) {
                gameState.isPlayerAttacking = true;
                gameState.attackFrame = 0;
                animateAttack('player');
            }
    updateStats();
}

function takeDamage() {
    gameState.playerHp = Math.max(0, gameState.playerHp - 50);
    updateStats();

    if (gameState.playerHp <= 0) {
        setTimeout(() => {
            showGameOverModal();
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

        const learningMaterials = {
    1: [
        "Classification is an artificial neural networks to identify objects in the image and assign them one of the predefined groups or classifications.",
        "They analyze the features of an image and assign it to one of the predefined categories based on the patterns they have learned during analyze.",
        "Outline is the one of the featured of classification, this process called edge detection or shape recognition.",
        "The outlines can help the model recognize specific shapes associated with different classes. For example, the outline of a cat may differ significantly from that of a dog, allowing the model to classify them accurately.",
        "In this level you need to find the correct outline of the target image on the card below, one of the card is the right answer so choose wisely, otherwise you will get ATTACKED!"
    ],
    2: [
        "For the first step of image recognition is Image Acquisition",
        "This is the first step in the image recognition process, and it involves capturing or obtaining images for analysis.",
        "This step is crucial because the quality and characteristics of the acquired images can significantly influence the performance of subsequent processing and recognition tasks.",
        "Proper image acquisition sets the stage for effective preprocessing, feature extraction, and ultimately, accurate recognition.",
        "With the line of Image Acquistion is the Proprocessing",
        "This is also crucial step in the image recognition pipeline that involves preparing the acquired images for analysis. The goal of preprocessing is to enhance the quality of the images and make them suitable for feature extraction and classification. ",
        "On this level, you need to know the image before it becomes clearer it called Normalization",
        "Normalization is an essential preprocessing step in image recognition and machine learning that involves scaling pixel values to a specific range. This process helps improve the performance and convergence of machine learning models."
    ],
    3: [
        "Feature extraction identifies important characteristics like edges and textures to help classify objects.",
        "This process is also a crucial step in the image recognition process that involves identifying and isolating important characteristics or patterns from an image.",
        "These features are then used to represent the image in a way that makes it easier for machine learning models to classify or recognize objects within the image.",
        "There are different types of method in extracting feature:",
        "Edge Detection: Techniques like the Sobel operator, Canny edge detector, or Laplacian filter identify edges in an image, which are important for recognizing shapes and boundaries.",
        "Texture Features: Methods such as Local Binary Patterns (LBP) or Gabor filters extract texture information from images, which can be useful for distinguishing between different materials or surfaces.",
        "Color Extraction: The process used in image processing and computer vision to identify and isolate specific colors or color distributions within an image",
        "On this level you need to find the right edge, texture, and color of a specific image."
    ],
    4: [
        "Color identification helps distinguish objects by their color properties, which is essential in image recognition.",
        "It involves detecting and recognizing specific colors within an image, which can be crucial for various applications in computer vision and image analysis.",
        "Color identification fits into the broader context of image processing",
        "Feature Extraction: Color is an important feature that can be used to distinguish between different objects or regions in an image. By identifying colors, systems can extract relevant information that aids in further analysis or classification.",
        "Segmentation: Color identification is often used in image segmentation, where an image is divided into meaningful regions based on color similarity. This can help isolate objects of interest from the background or other elements in the image.",
        "Object Detection: In many applications, such as robotics or autonomous vehicles, color identification is used to detect and track objects based on their color. For example, a system might identify red traffic lights or green road signs.",
        "On this level we apply the technique of Color Space Conversion: Images are often converted from the RGB color space to other color spaces (e.g., HSV, LAB) that may be more suitable for color identification.",
        "You need to find the right color on the target image!" 
    ],
    5: [
        "Now with all of the steps that you have take, we can move on the final level which is the object detection",
        "It is a computer vision task that involves identifying and locating objects within an image or video. It not only classifies objects but also provides their positions in the form of bounding boxes. ",
        "Object detection is widely used in various applications, including autonomous vehicles, surveillance, robotics, and image retrieval.",
        "With the help of the previous steps it will apply to this object detection.",
        "Image Acquisition: Process of capturing or obtaining images that will be analyzed for object detection.",
        "Preprocessing: Involves preparing the acquired images for analysis by enhancing their quality and making them suitable for feature extraction and object detection.",
        "Classification: Determining the category or class of the detected objects.",
        "Feature extraction: Identifying and isolating important characteristics or patterns from the preprocessed images that will be used for object detection.",
        "Now you on this level you need to find a specific target!"
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

    // Play background music
    

    // If the level starts, play the background music
    if (currentLevel === 1) {
        draw();
        setTimeout(() => {
            flipAllCards(true); // Flip all cards face up
            setTimeout(shuffle, 1000); // Shuffle after a delay
        }, 1000);
    } else if (currentLevel === 2) {
        draw();
        switchToLevel2();
        isStartLevel = true;
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

window.speechSynthesis.cancel(); 
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
} else if (currentLevel === 2) {
    currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
    draw();
    isStartLevel = true;
    switchToLevel2();
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
            'images/characters/monster1.png', // Replace with correct paths
            'images/characters/monster2.png',
            'images/characters/monster3.png'
        ];

        const backgroundImage = new Image();
        backgroundImage.src = 'images/background3.jpg';

        let currentMonsterImage = new Image();
        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];

        class LavaPlume {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.size = Math.random() * 6 + 4;
        this.speedY = Math.random() * 2 + 2;
        this.speedX = (Math.random() - 0.5) * 2;
        this.gravity = 0.1;
        this.opacity = 1;
    }

    update() {
        this.y -= this.speedY;
        this.x += this.speedX;
        this.speedY -= this.gravity;
        this.opacity -= 0.02;

        if (this.opacity <= 0) {
            this.x = Math.random() * gameScene.width;
            this.y = gameScene.height - 20;
            this.speedY = Math.random() * 2 + 2;
            this.opacity = 1;
        }
    }

    draw(ctx) {
        const gradient = ctx.createRadialGradient(this.x, this.y, this.size / 2, this.x, this.y, this.size);
        gradient.addColorStop(0, `rgba(255, 69, 0, ${this.opacity})`);
        gradient.addColorStop(1, `rgba(139, 0, 0, ${this.opacity * 0.6})`);
        
        ctx.fillStyle = gradient;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

class SmokeParticle {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.size = Math.random() * 10 + 10; // Larger smoke particles
        this.speedY = Math.random() * 1 + 0.5; // Slower rising speed for smoke
        this.opacity = Math.random() * 0.5 + 0.3; // Semi-transparent smoke
    }

    update() {
        this.y -= this.speedY; // Move particle upward
        this.opacity -= 0.005; // Gradual fade out

        // Reset particle when fully faded
        if (this.opacity <= 0) {
            this.x = Math.random() * gameScene.width;
            this.y = gameScene.height - 20;
            this.opacity = Math.random() * 0.5 + 0.3;
        }
    }

    draw(ctx) {
        ctx.fillStyle = `rgba(105, 105, 105, ${this.opacity})`; // Gray color for smoke
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

// Arrays to hold particles
let lavaPlumes = [];
let smokeParticles = [];

// Initialize lava and smoke particles
function initParticles() {
    for (let i = 0; i < 80; i++) {
        let x = Math.random() * gameScene.width;
        let y = gameScene.height - 20;
        lavaPlumes.push(new LavaPlume(x, y));
        smokeParticles.push(new SmokeParticle(x, y));
    }
}

// Draw particles for lava and smoke
function drawParticles(ctx) {
    lavaPlumes.forEach(lavaPlume => {
        lavaPlume.update();
        lavaPlume.draw(ctx);
    });
    smokeParticles.forEach(smokeParticle => {
        smokeParticle.update();
        smokeParticle.draw(ctx);
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
    ctx.ellipse(gameState.monsterX + 80, gameState.monsterY + 160, 20, 7, 0, 0, 2 * Math.PI); // Smaller ellipse shadow
    ctx.fill();

    // Draw monster with breathing effect
    const monsterWidth = 170 * breathingScale;
    const monsterHeight = 170 * breathingScale;
    ctx.drawImage(
        currentMonsterImage,
        gameState.monsterX - (monsterWidth - 170) / 2,
        gameState.monsterY - (monsterHeight - 170) / 2,
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
        ctx.fillRect(gameState.monsterX, gameState.monsterY, 170, 170);
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
            ctx.fillText("50", gameState.damageText.x, gameState.damageText.y);
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