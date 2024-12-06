<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Random Quiz</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f4f4f4;
    }
    h1 {
      text-align: center;
    }
    .question {
      background-color: #ffffff;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .question h3 {
      margin: 0;
      font-size: 1.2em;
    }
    .answers label {
      display: block;
      padding: 5px 0;
    }
    button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      font-size: 1.1em;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
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
  </style>
</head>
<body>
  <h1>Pre-processing and Image Analysis Quiz</h1>
  <div id="postTestWrapper">
        <div id="postTestContainer" style="display: none;">
            <h2>Pre-Test Assessment</h2>
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
  <script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

            const shootSound = new Audio("{{ asset('audio/shootSound.mp3') }}");
            const quizSound = new Audio("{{ asset('music/quizBackgroundMusic.mp3') }}");

        const questions = [
    {
        question: "1. What is the main goal of image segmentation?\n\nA. To reduce image resolution\nB. To separate different regions based on pixel properties\nC. To enhance edges\nD. To perform color adjustment",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "2. Which of the following is a key challenge in object detection?\n\nA. Identifying edges\nB. Distinguishing between different classes\nC. Correctly classifying each pixel\nD. Reducing image noise",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "3. How does the Sobel filter detect edges in an image?\n\nA. By calculating pixel gradients in horizontal and vertical directions\nB. By smoothing the image\nC. By enhancing color intensity\nD. By sharpening the image",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "4. What is the advantage of using an adaptive filter over a global filter?\n\nA. It uses local properties of the image\nB. It applies the same filter to the entire image\nC. It improves the overall brightness\nD. It enhances edge detection globally",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "5. What does precision in a classification task measure?\n\nA. The number of false positives\nB. The ability to correctly identify relevant instances\nC. The accuracy of image segmentation\nD. The overall quality of the dataset",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "6. Which of the following methods can be used to perform image thresholding?\n\nA. Gaussian Filter\nB. Otsu’s Method\nC. Median Filter\nD. Sobel Filter",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "7. What is a common use of the K-means clustering algorithm in image processing?\n\nA. Image classification\nB. Edge detection\nC. Color quantization\nD. Image denoising",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "8. How is the true positive rate (TPR) calculated?\n\nA. TP / (TP + FN)\nB. TP / (TP + FP)\nC. TN / (TN + FP)\nD. FN / (TP + TN)",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "9. What is the role of image filters in preprocessing?\n\nA. To classify images into categories\nB. To enhance specific image features or reduce noise\nC. To segment images into regions\nD. To detect the objects within the image",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "10. What does a high false positive rate indicate in a model?\n\nA. The model is underfitting\nB. The model is overfitting\nC. The model is very accurate\nD. The model incorrectly classifies negatives as positives",
        answers: ["A", "B", "C", "D"],
        correct: 3
    },
    {
        question: "11. Which of the following is commonly used to handle missing data in image processing?\n\nA. Median filter\nB. K-means clustering\nC. Gaussian filter\nD. Data augmentation",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "12. What does the Laplacian filter do in image processing?\n\nA. Enhances edges\nB. Reduces noise\nC. Performs thresholding\nD. Segments the image into regions",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "13. What is a key disadvantage of using global thresholding?\n\nA. It works well with images that have varying lighting conditions\nB. It applies the same threshold across the entire image\nC. It requires less computation\nD. It enhances contrast",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "14. Which method is most effective for noise removal in images?\n\nA. Gaussian Filter\nB. Sobel Filter\nC. Median Filter\nD. Laplacian Filter",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "15. What is the purpose of the softmax function in classification?\n\nA. To calculate probabilities for each class\nB. To perform segmentation\nC. To apply filters to the image\nD. To perform edge detection",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "16. How does the non-maximum suppression algorithm work in object detection?\n\nA. By removing overlapping bounding boxes\nB. By increasing the image contrast\nC. By detecting edges\nD. By applying adaptive filters",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "17. What is the advantage of using median filters over Gaussian filters in certain applications?\n\nA. Median filters preserve edges better than Gaussian filters\nB. Median filters blur edges more effectively\nC. Gaussian filters reduce image size\nD. Median filters enhance the image resolution",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "18. What is a common use case for edge detection in image processing?\n\nA. Image compression\nB. Object recognition\nC. Noise removal\nD. Image segmentation",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "19. What does a higher recall score indicate?\n\nA. The model is more sensitive to false positives\nB. The model is able to detect more relevant items\nC. The model is more precise\nD. The model performs better in segmentation tasks",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "20. Which filter is commonly used to sharpen images?\n\nA. Gaussian Filter\nB. Sobel Filter\nC. Laplacian Filter\nD. Median Filter",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "21. What is one common application of Otsu's thresholding method?\n\nA. Image smoothing\nB. Image segmentation based on pixel intensity\nC. Edge detection\nD. Noise reduction",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "22. What does a convolutional neural network (CNN) do?\n\nA. Detects edges in an image\nB. Classifies images based on learned features\nC. Enhances color contrast in an image\nD. Segments an image into regions",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "23. How does an image pyramid help in multi-scale object detection?\n\nA. By enhancing image contrast at different scales\nB. By applying different filters at multiple scales\nC. By reducing image resolution to detect larger objects\nD. By reducing image size for faster processing",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "24. What is the purpose of image dilation in morphological operations?\n\nA. To shrink objects in an image\nB. To enhance object boundaries\nC. To segment regions\nD. To blur edges",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "25. What is the purpose of erosion in morphological image processing?\n\nA. To enhance object boundaries\nB. To shrink objects or boundaries in an image\nC. To segment regions\nD. To reduce noise",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "26. Which of the following is a key challenge in optical character recognition (OCR)?\n\nA. Image thresholding\nB. Detecting edge boundaries\nC. Recognizing text in noisy or distorted images\nD. Image segmentation",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "27. Which method is used for removing background noise in images?\n\nA. Median Filtering\nB. Sobel Filter\nC. Gaussian Filter\nD. Thresholding",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "28. Which of the following is an application of feature extraction?\n\nA. Image smoothing\nB. Detecting specific patterns or shapes in an image\nC. Object removal\nD. Image compression",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "29. What is the Hough Transform used for in image processing?\n\nA. Edge detection\nB. Circle and line detection\nC. Noise reduction\nD. Object recognition",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "30. What does the confusion matrix help evaluate in classification tasks?\n\nA. Image segmentation accuracy\nB. Object detection precision\nC. True positives, false positives, and overall performance\nD. Edge detection quality",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "31. What is a key feature of binary thresholding?\n\nA. It converts an image into two distinct classes\nB. It reduces the image size\nC. It applies edge detection\nD. It smooths the image",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "32. How does a Gaussian blur affect an image?\n\nA. It sharpens edges\nB. It reduces image resolution\nC. It reduces noise by smoothing the image\nD. It highlights features in the image",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "33. What is one benefit of deep learning over traditional image processing methods?\n\nA. Requires less data\nB. Automatically learns features from the data\nC. Works without any pre-trained models\nD. Is faster and more efficient",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "34. Which of the following is not an image enhancement technique?\n\nA. Contrast adjustment\nB. Noise removal\nC. Feature extraction\nD. Image segmentation",
        answers: ["A", "B", "C", "D"],
        correct: 3
    },
    {
        question: "35. What does the concept of 'overfitting' refer to in machine learning?\n\nA. The model performs well on new, unseen data\nB. The model becomes too complex and performs poorly on new data\nC. The model learns features from images automatically\nD. The model generalizes well to different datasets",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "36. What is the purpose of batch normalization in deep learning?\n\nA. To enhance image resolution\nB. To normalize image data for better training performance\nC. To remove noise from images\nD. To apply filters to images",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "37. How does the watershed algorithm perform image segmentation?\n\nA. By detecting edges in the image\nB. By partitioning an image into distinct regions based on intensity gradients\nC. By applying a filter to reduce noise\nD. By classifying each pixel",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "38. What is the purpose of the region-growing technique in image segmentation?\n\nA. To find edges in the image\nB. To merge similar pixels into regions\nC. To reduce image resolution\nD. To remove background noise",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "39. What does the term 'image histogram' refer to?\n\nA. The average pixel value of an image\nB. A graph showing the distribution of pixel intensities\nC. The color balance of an image\nD. The segmentation of an image into regions",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "40. What is a common application of principal component analysis (PCA) in image processing?\n\nA. Image classification\nB. Noise removal\nC. Dimensionality reduction\nD. Image enhancement",
        answers: ["A", "B", "C", "D"],
        correct: 2
    },
    {
        question: "41. What is the purpose of the Fourier Transform in image processing?\n\nA. To enhance image quality\nB. To transform the image into the frequency domain\nC. To classify images\nD. To segment the image",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "42. What does the term 'convolution' refer to in convolutional neural networks (CNNs)?\n\nA. A mathematical operation used to filter images\nB. A way to normalize images\nC. A method for image segmentation\nD. A way to reduce image resolution",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "43. What is the purpose of the histogram of oriented gradients (HOG) in object detection?\n\nA. To extract features related to object shapes\nB. To reduce image noise\nC. To enhance contrast\nD. To segment the image",
        answers: ["A", "B", "C", "D"],
        correct: 0
    },
    {
        question: "44. What does a high F1-score indicate?\n\nA. The model has high precision but low recall\nB. The model balances precision and recall effectively\nC. The model is good at detecting false positives\nD. The model overfits the data",
        answers: ["A", "B", "C", "D"],
        correct: 1
    },
    {
        question: "45. What is the purpose of using the dilation operation in morphological image processing?\n\nA. To shrink objects in an image\nB. To enhance edges or boundaries of objects\nC. To segment regions\nD. To reduce noise",
        answers: ["A", "B", "C", "D"],
        correct: 1
    }
];


const shuffleArray = (array) => {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]]; // Swap elements
    }
    return array;
};

// Function to get only 15 shuffled questions from the total 45
const getShuffledQuestions = (questions) => {
    // Take the first 45 questions (if needed)
    const selectedQuestions = questions.slice(0, 45);

    // Shuffle the first 15 questions
    const shuffled = shuffleArray(selectedQuestions.slice(0, 15));

    // Return only the shuffled 15 questions
    return shuffled;
};

// Get shuffled questions
const shuffledQuestions = getShuffledQuestions(questions);

// Output result
console.log(shuffledQuestions);

    let currentQuestion = 0;
    let score = 0;
    const totalQuestions = 15;
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

                if (hit) {
    currentQuestion++;

    // Check if there are more questions left
    if (currentQuestion < totalQuestions) {
        drawGame();
    } else {
        quizSound.pause();
        
        // Calculate the score percentage
        const percentageScore = (score / totalQuestions) * 100;

        // Define base URL and retrieve user ID from local storage
        const baseUrl = window.location.origin;
        const userId = localStorage.getItem('user_id');
        console.log('User ID:', userId);

        // Fetch previous performance from backend to ensure accuracy
        

                // Check if the user passed or failed
                if (percentageScore >= 80) {
                let previousPostTestPerformance = data.post_test_performance || 0;
                    document.getElementById('finalScoreText').innerText += `\nCongratulations, you passed!\nYour total score: ${updatedTotalScore}/${totalQuestions}, (${percentageScore.toFixed(2)}%)`;
                    document.getElementById('scoreModal').style.display = 'flex'; // Show modal
                    const updatedTotalScore = score;
                    setTimeout(() => {
                        gameActive = true; // Reactivate the game
                        window.location.href = "{{ route('storylinestage1') }}"; // Restart the game
                    }, 3000);
                    
                    // Update the game state with the new total score
                    gameState.totalScore = updatedTotalScore;
                    showModal(updatedTotalScore);

                } else {
                    const updatedTotalScore = score;
                    document.getElementById('finalScoreText').innerText += `\nYou need to score at least 80% to pass. Try again! \nYour total score: ${updatedTotalScore}/${totalQuestions}, (${percentageScore.toFixed(2)}%)`;
                    document.getElementById('scoreModal').style.display = 'flex'; // Show modal
                    setTimeout(() => {
                        window.location.href = "{{ route('storylinestage1') }}"; // Restart the game
                    }, 3000);
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
        
  </script>
</body>
</html>
