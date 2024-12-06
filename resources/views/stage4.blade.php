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
        </div>

        <!-- Level 2 Content -->
        <div id="level2Content" style="display: none; text-align: center;">
        </div>
        <div id="level3Content">
        </div>

        <div id="level4Content" style="display: none;">

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

    <div id="celebration"></div>


    <div id="celebration"></div>

    </div>
    
        <div class="modal-overlay" id="level5CompleteModal" style="display: none;">
            <div class="modal">
                <h2>Level 5 Complete!</h2>
                <p>You've completed the object detection level.</p>
                <button onclick="takeposttest()">Take Post-Test</button>
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




function takeposttest() {
            quizOn = true;
            const modal = document.getElementById('level5CompleteModal');
            modal.style.display = 'none';
            document.getElementById('gameContainer').style.display = 'none';
            setTimeout(() => {
                        window.location.href = "{{ route('postprocessingquiz') }}"; // Restart the game
                    }, 1000);
        }

function startLevel5() {
    const modal = document.getElementById('level4CompleteModal');
    modal.style.display = 'none';
    gameState.level = 5;
    showMonologuesInSequence(5);; 
    updateStats(); 
    initializeLevel5(); 
}


function initializeGame() {

    gameState.level =5;
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

function showLevel5CompleteModal() {
    levelComplete.play();
    const modal = document.getElementById('level5CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
    currentLevel++;
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
            showLevel5CompleteModal();
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
    "Player: Wow, that’s all I need to learn? Perfect!",
    "Player: Alright, let’s do this. Time to take you down, monster!",
    "Monster: Hah! Do you think learning a few tricks will be enough to defeat me?",
    "Player: Tricks? This is knowledge, and it’s going to beat you!",
    "Monster: Foolish human! Knowledge alone won’t save you. Let’s see if you have the skill to back it up.",
    "Player: Just watch me. I’m ready for whatever you throw at me!",
    "Monster: Very well! Prepare yourself for a challenge unlike any you’ve faced before!",
    "Player: Bring it on. I’m not afraid of you!",
    "Monster: We’ll see about that... Let the battle begin!"
],
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