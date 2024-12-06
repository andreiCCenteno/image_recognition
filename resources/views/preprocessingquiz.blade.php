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
            <h2>Quiz Game</h2>
            <p id="questionText"></p>
            <canvas id="gameCanvas" width="1000" height="625"></canvas>
        </div>
    </div>
  <script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

            const shootSound = new Audio("{{ asset('audio/shootSound.mp3') }}");

            const questions = [
    {
        question: "1. What is the primary purpose of feature extraction in image recognition?\n\n\nA. To increase image resolution\nB. To identify and isolate specific characteristics of an image\nC. To convert images into different formats\nD. To change the color of an image",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "2. What does feature extraction enable users to focus on in an image?\n\n\nA. Color properties\nB. Background elements\nC. Key aspects like edges and textures\nD. File formats",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "3. Which application is enhanced by mastering feature extraction?\n\n\nA. Web development\nB. Object detection and computer vision\nC. Image compression\nD. Sound recognition",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "4. Which technique helps users understand color distributions in images?\n\n\nA. Edge detection\nB. Color histograms\nC. Image scaling\nD. Pixelation",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "5. Why is color identification important in various fields?\n\n\nA. It improves image quality.\nB. It enhances visual perception and classification of objects.\nC. It reduces image file size.\nD. It increases image brightness.",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "6. What is a common method used in color identification to analyze color properties?\n\n\nA. Pixelation\nB. RGB analysis\nC. Grayscale conversion\nD. Image segmentation",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "7. Engaging in color identification exercises helps foster a deeper appreciation of what?\n\n\nA. Color theory\nB. Graphic design\nC. Sound engineering\nD. Data analysis",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "8. How does feature extraction improve object recognition capabilities?\n\n\nA. By simplifying images\nB. By identifying irrelevant data\nC. By focusing on significant features like edges and textures\nD. By converting images to black and white",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "9. What is the primary role of edge detection in image recognition?\n\n\nA. To remove noise\nB. To identify boundaries within images\nC. To increase image resolution\nD. To change the color properties of an image",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "10. What is the importance of grayscale conversion in image processing?\n\n\nA. To enhance colors\nB. To simplify the image by removing color information\nC. To sharpen edges\nD. To increase the image size",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "11. Which technology helps in analyzing the frequency of colors in images?\n\n\nA. RGB analysis\nB. Edge detection\nC. Grayscale conversion\nD. Histogram equalization",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "12. What role does noise reduction play in image recognition?\n\n\nA. It helps to simplify complex data\nB. It enhances details in images\nC. It improves the accuracy of color identification\nD. It helps to identify edges",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "13. What is the main goal of convolution in image processing?\n\n\nA. To reduce image size\nB. To apply filters for feature extraction\nC. To sharpen image resolution\nD. To adjust the contrast of the image",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "14. What does pooling do in the context of convolutional neural networks (CNN)?\n\n\nA. Increases the image resolution\nB. Reduces the size of the feature maps\nC. Enhances color analysis\nD. Converts images into grayscale",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "15. What is the main function of the softmax layer in neural networks?\n\n\nA. To convert the network’s outputs into probabilities\nB. To reduce the image size\nC. To identify the color of an image\nD. To detect edges",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "16. What technique can help in recognizing patterns in images?\n\n\nA. Color histograms\nB. Grayscale conversion\nC. Edge detection\nD. Convolution filters",
        answers: ["A.", "B.", "C.", "D."],
        correct: 3
    },
    {
        question: "17. Which method is used for noise reduction in image processing?\n\n\nA. Median filtering\nB. Gaussian filtering\nC. Thresholding\nD. Edge detection",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "18. What is the role of the Sobel filter in image processing?\n\n\nA. To apply color adjustments\nB. To perform edge detection\nC. To reduce noise\nD. To enhance image brightness",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "19. In what type of task is feature extraction commonly used?\n\n\nA. Sorting colors\nB. Object recognition\nC. Image compression\nD. Image resizing",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "20. What does histogram equalization help to improve in image processing?\n\n\nA. The brightness of an image\nB. The contrast of an image\nC. The resolution of an image\nD. The color distribution of an image",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "21. What does RGB stand for?\n\n\nA. Red, Green, Blue\nB. Red, Grey, Black\nC. Red, Gradient, Blue\nD. Red, Green, Black",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "22. Which model is used for representing colors in digital images?\n\n\nA. CMYK\nB. RGB\nC. HSL\nD. HSV",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "23. How does pixelation affect the clarity of an image?\n\n\nA. It sharpens the image\nB. It increases the resolution\nC. It reduces the resolution\nD. It adjusts the contrast",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "24. What is a typical use case for CNNs in image processing?\n\n\nA. Color enhancement\nB. Image classification\nC. Image resizing\nD. Text recognition",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "25. What does the median filter help to reduce in an image?\n\n\nA. Gaussian noise\nB. Salt-and-pepper noise\nC. Random noise\nD. White noise",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "26. What is the main purpose of convolutional layers in CNNs?\n\n\nA. To adjust image brightness\nB. To apply filters and extract features\nC. To resize the image\nD. To add noise to the image",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "27. What is the effect of increasing the RGB value of red?\n\n\nA. Decreases brightness\nB. Increases brightness\nC. Changes contrast\nD. Increases image resolution",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "28. In image recognition, what is a ‘feature’?\n\n\nA. A color component of an image\nB. A distinct and identifiable pattern or object in an image\nC. A pixel's brightness level\nD. A noise pattern",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "29. Which algorithm is commonly used in feature extraction for object recognition?\n\n\nA. K-means clustering\nB. SIFT (Scale Invariant Feature Transform)\nC. Gaussian blur\nD. Histogram equalization",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "30. How do convolution layers enhance image recognition?\n\n\nA. By applying random filters\nB. By extracting and emphasizing relevant features\nC. By converting images to grayscale\nD. By increasing image size",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "31. What is the purpose of using the color histogram in image processing?\n\n\nA. To classify images\nB. To adjust the resolution\nC. To analyze the distribution of colors\nD. To detect edges",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "32. How does image segmentation contribute to object recognition?\n\n\nA. By dividing the image into meaningful regions\nB. By increasing image resolution\nC. By removing color information\nD. By adjusting brightness",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "33. What does applying the Sobel operator to an image help to detect?\n\n\nA. Noise\nB. Edges\nC. Color changes\nD. Image contrast",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "34. Which method is commonly used for image compression?\n\n\nA. PCA (Principal Component Analysis)\nB. JPEG compression\nC. Median filtering\nD. Histogram equalization",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "35. What is the main challenge in image recognition?\n\n\nA. Extracting features\nB. Reducing noise\nC. Identifying patterns in images\nD. Enhancing color quality",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "36. How can pixelation be reversed in an image?\n\n\nA. By increasing the resolution\nB. By using color enhancement algorithms\nC. By smoothing the image\nD. Pixelation cannot be reversed",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "37. What is the function of the Hough transform in image analysis?\n\n\nA. To detect edges\nB. To identify circular shapes\nC. To perform noise reduction\nD. To adjust image color",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "38. Which of the following is crucial for accurate object recognition?\n\n\nA. Image resolution\nB. Image contrast\nC. Feature extraction\nD. Image file size",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "39. What effect does the RGB color model have on image recognition?\n\n\nA. It increases brightness\nB. It enhances image quality\nC. It simplifies color matching\nD. It reduces image size",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "40. What is the key advantage of using neural networks in image recognition?\n\n\nA. It automates feature extraction\nB. It enhances image resolution\nC. It reduces image size\nD. It enhances color vibrancy",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "41. What does image recognition involve?\n\n\nA. Identifying the contents of an image\nB. Enhancing image brightness\nC. Compressing an image\nD. Applying color adjustments",
        answers: ["A.", "B.", "C.", "D."],
        correct: 0
    },
    {
        question: "42. What role does contrast play in object recognition?\n\n\nA. It simplifies the image\nB. It enhances the visibility of features\nC. It changes image size\nD. It reduces image noise",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "43. How can you improve color identification accuracy in images?\n\n\nA. By increasing the image resolution\nB. By improving image contrast\nC. By performing noise reduction\nD. By enhancing image brightness",
        answers: ["A.", "B.", "C.", "D."],
        correct: 1
    },
    {
        question: "44. What is one of the primary uses of color histograms in image processing?\n\n\nA. To detect edges\nB. To detect patterns\nC. To analyze the color distribution\nD. To reduce noise",
        answers: ["A.", "B.", "C.", "D."],
        correct: 2
    },
    {
        question: "45. Which tool would you use to detect the most prevalent color in an image?\n\n\nA. Edge detection\nB. Histogram analysis\nC. Pixelation\nD. Contrast enhancement",
        answers: ["A.", "B.", "C.", "D."],
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
        document.getElementById('finalScoreText').innerText = `Your score: ${score}/${totalQuestions} (${percentageScore.toFixed(2)}%)`;
        document.getElementById('scoreModal').style.display = 'flex'; // Show modal

        // Define base URL and retrieve user ID from local storage
        const baseUrl = window.location.origin;
        const userId = localStorage.getItem('user_id');
        console.log('User ID:', userId);

        // Fetch previous performance from backend to ensure accuracy
        

                // Check if the user passed or failed
                if (percentageScore >= 80) {
                    fetch(`${baseUrl}/get-medium-current-performance/${userId}`)
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

                    // Update medium_finish status and save stats to the database
                    fetch(`${baseUrl}/update-medium-finish/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ medium_finish: 1 })
                    })
                    .then(response => response.json())
                    .then(() => {
                        // Save the score and additional stats
                        return fetch(`${baseUrl}/medium-update-score/${userId}`, {
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
                                medium_post_test_performance: Math.max(percentageScore, previousPostTestPerformance)
                            })
                        });
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Score and additional stats updated successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error updating score or medium_finish:', error);
                    });
                })
            .catch(error => {
                console.error('Error fetching current performance:', error);
            });
            document.getElementById('postTestContainer').style.display = 'none';
                } else {
                    document.getElementById('finalScoreText').innerText += `\nYou need to score at least 80% to pass. Try again!`;
                    // Restart the game after 1 second if user failed
                    fetch(`${baseUrl}/medium-update-score/${userId}`, {
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
        
  </script>
</body>
</html>
