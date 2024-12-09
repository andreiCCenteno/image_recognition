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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

    </head>

    <body>
        <!-- Add these audio elements to your HTML -->
        <audio id="playerAttackSound" src="{{ asset('audio/player-attack.mp3') }}" preload="auto"></audio>
        <audio id="monsterAttackSound" src="{{ asset('audio/monster-attack.mp3') }}" preload="auto"></audio>
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
                <img id="modal-character-image" src="{{ asset('images/characters/player.png') }}" alt="Player" class="modal-image" />
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
            <img id="targetImage" src="" alt="Target image" style="display:none;">
        </div>
        <canvas id="tracingCanvas"></canvas>
        <div id="message">Trace the outline of the image!</div>
        <button id="submitTrace">Submit Trace</button>
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
                    <img class="main-image" id="mainImage" alt="Main image">
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
                <p>Excellent work! You've manage to defeat the Enemy</p>
                <p>You can now proceed to next Chapter!</p>
                <button onclick="takeposttest()">PROCEED</button>
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
                <div id="easyTree" class="detection-zone" style="left: 32px; top: 90px; width: 35px; height: 200px;">
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
            <button onclick="closeModal()">Close</button>
            <button onclick="playAgain()">Play Again</button>
        </div>
        </div>
        


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>

let playerGender = '{{ auth()->user()->gender }}';  // Assuming gender is stored in the database
 // This can be dynamically set based on the user's choice

// Update the modal character image based on the player's gender
const modalCharacterImage = document.getElementById('modal-character-image');

if (playerGender === 'male') {
    modalCharacterImage.src = "{{ asset('images/characters/playerMale.png') }}";  // Male image
    modalCharacterImage.alt = "Player Male";
} else if (playerGender === 'female') {
    modalCharacterImage.src = "{{ asset('images/characters/playerFemale.png') }}";  // Female image
    modalCharacterImage.alt = "Player Female";
}

            let quizOn = false;
            function showGameOverModal() {
                const modal = document.getElementById('gameOverModal');
                pauseTimer();
                modal.style.display = 'flex'; // Show modal with flexbox for centering
                gameOver.play();
                // Set up button event listeners
                document.getElementById('playAgainButton').addEventListener('click', function () {
                    window.location.href = "{{ url('stage1') }}"; // Reset the game state (you'll need to implement this)
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
                    if(quizOn === false){
                        pauseTimer();
                    }
                });

                // Close settings modal
                window.closeSettingsModal = function () {
                    $('#settingsModal').hide();
                }

                // Resume button functionality
                $('#resumeButton').click(function () {
                    closeSettingsModal(); // Close the modal
                    // Additional logic to resume the game can go here
                    if(quizOn === false){
                        resumeTimer();
                    }
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
            let intenseFightMusic = document.getElementById("intenseFightMusic");
            intenseFightMusic.volume = 0.2;

            const wrongAnswer = new Audio("{{ asset('audio/wrong-answer.mp3') }}");
            const correctAnswer = new Audio("{{ asset('audio/correct-answer.mp3') }}");
            const levelComplete = new Audio("{{ asset('audio/level-complete.mp3') }}");
            const gameOver = new Audio("{{ asset('audio/game-over.mp3') }}");

            const timeInterval = 1000;

            // Set duration for the timer (in seconds)
            let timerId;
            let timeLeft; // Variable to hold the remaining time
            let isPaused = false; // Flag to track if the timer is paused
            let score = 0; // Initialize score
            let currentLevel = 1;
            let isStartLevel = false;
            let damage = 25;

            function updateScore(points) {
                gameState.totalScore = (gameState.totalScore || 0) + points;
                document.getElementById('scoreDisplay').textContent = `Score: ${gameState.totalScore}`;
            }

            let elapsedSeconds = 0;
        const timerElement = document.getElementById('countdownTimer');
        function startTimer(){
            setInterval(() => {
            elapsedSeconds++;
            timerElement.textContent = elapsedSeconds;
        }, 1000);
        }
    
        function updateScore(points) {
            gameState.totalScore = (gameState.totalScore || 0) + points;
            document.getElementById('scoreDisplay').textContent = `Score: ${gameState.totalScore}`;
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
        function startNewLevel() {
            startTimer(); // Start the timer for the new level
        }


            // Example of starting a new level (update accordingly in your game logic)
            // startNewLevel(1); // Call this when a new level starts



            function takeposttest() {
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
                window.location.href = "{{ route('storylinestage2') }}"; // Restart the game
            }

            function startLevel3() {
                const modal = document.getElementById('level2CompleteModal');
                modal.style.display = 'none';
                // gameState.level = 3;
                showLearningMaterial(3);
                updateStats();
                initializeGame();
            }





            function initializeGame() {
                // Hide all content first
                level1Content.style.display = 'none';
                level3Content.style.display = 'none';

                // Show appropriate level content
                if (gameState.level === 1) {
                    // level1Content.style.display = 'block';
                    initializeLevel1();
                } else if (gameState.level === 2) {
                    // level2Content.style.display = 'block';
                    initializeLevel3();
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
        window.speechSynthesis.cancel();
    clearInterval(monologueInterval);
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
            showLevel1CompleteModal();
            updateScore(10);
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
            isStartLevel = false;
            initializeLevel3();
            gameState.level++;
            showLevel2CompleteModal();
            updateScore(10);
            const modal = document.getElementById('levelCompleteModal');
                modal.style.display = 'none';

        }
        }else if(gameState.level === 3){
            const modal = document.getElementById('level2CompleteModal');
                modal.style.display = 'none';
            takeposttest();
            intenseFightMusic.pause();
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
                levelComplete.play();
                pauseTimer();
                const modal = document.getElementById('levelCompleteModal');
                modal.style.display = 'flex';
                createConfetti();
                console.log(gameState.level);
                gameState.level++;
                currentLevel++;
            }

            function showLevel3CompleteModal() {
                pauseTimer();
                const modal = document.getElementById('level3CompleteModal');
                modal.style.display = 'flex';
                gameState.level++;
                console.log(gameState.level);
                createConfetti();
            }

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


            let attackCount = 0;
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

    const featureSets = [
        {
            mainImage: 'images/tree.jpg',
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
            mainImage: 'images/oregano.jpg',
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
            mainImage: 'images/window.jpg',
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
            mainImage: 'images/brick.jpg',
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

    // Shuffle features for random order
    const shuffledFeatures = shuffleArray([...currentFeatureSet.features]); // Use a copy to avoid mutating the original array

    gameState.level3.features = shuffledFeatures; // Set the shuffled features
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

    // Generate a new set of features (this includes randomizing the order)
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
                    { id: 'easyTree', name: 'easy Tree' },
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
            question: "1. Why are outlines essential in image recognition?\n\n\nA. Define shape\nB. Add color\nC. Highlight details\nD. Remove textures",
            answers: ["A.", "B.", "C.", "D."],
            correct: 0
        },
        {
            question: "2. What is pixelation in image recognition?\n\n\nA. Enhancing details\nB. Transforming to blocks\nC. Increasing size\nD. Improving color",
            answers: ["A.", "B.", "C.", "D."],
            correct: 1
        },
        {
            question: "3. What role do outlines play in feature extraction?\n\n\nA. They obscure details\nB. They help identify shapes\nC. They add complexity\nD. They reduce processing time",
            answers: ["A.", "B.", "C.", "D."],
            correct: 1
        },
        {
            question: "4. Which of the following best describes pixelation?\n\n\nA. A smoothing technique\nB. A method to reduce noise\nC. A way to create block-like images\nD. A technique for enhancing edges",
            answers: ["A.", "B.", "C.", "D."],
            correct: 2
        },
        {
            question: "5. Why is it important to recognize outlines in image processing?\n\n\nA. To remove background noise\nB. To improve image resolution\nC. To extract essential features\nD. To enhance color saturation",
            answers: ["A.", "B.", "C.", "D."],
            correct: 2
        },
        {
            question: "6. How does pixelation affect image quality?\n\n\nA. It improves sharpness\nB. It makes images clearer\nC. It reduces detail\nD. It has no effect",
            answers: ["A.", "B.", "C.", "D."],
            correct: 2
        },
        {
            question: "7. Which method is commonly used for detecting outlines?\n\n\nA. Histogram equalization\nB. Edge detection algorithms\nC. Noise reduction\nD. Image segmentation",
            answers: ["A.", "B.", "C.", "D."],
            correct: 1
        },
        {
            question: "8. What happens to pixelated images when you zoom in?\n\n\nA. They become clearer\nB. They show blocks of color\nC. They lose detail\nD. They remain unchanged",
            answers: ["A.", "B.", "C.", "D."],
            correct: 1
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
    setInterval(drawGame, 50000);

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
        const clouds = [];

    // Create more clouds
    for (let i = 0; i < 10; i++) {
        const cloud = {
            x: Math.random() * canvas.width,  // Random initial X position
            y: Math.random() * (canvas.height / 5),  // Random initial Y position within the upper part of the canvas
            speed: 0.02 + Math.random() * 0.03  // Slower cloud speed (further reduced for a smoother effect)
        };
        clouds.push(cloud);
    }

    // In your draw function:
    for (let i = 0; i < clouds.length; i++) {
            const cloud = clouds[i];
            cloud.x += cloud.speed;  // Move the cloud horizontally based on its speed

            // Reset cloud position when it moves off-screen
            if (cloud.x > canvas.width) {
                cloud.x = -100;  // Move it off-screen to the left
                cloud.y = Math.random() * (canvas.height / 3);  // Reset its Y position randomly within the top third of the canvas
            }

            // Draw the cloud at its new position
            drawCloud(ctx, cloud.x, cloud.y);
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
        ctx.fillStyle = "rgba(255, 255, 255, 0.8)";  // White cloud color with transparency
        ctx.beginPath();
        ctx.arc(x, y, 25, Math.PI * 0.5, Math.PI * 1.5);  // Left side of the cloud
        ctx.arc(x + 30, y - 10, 30, Math.PI * 1, Math.PI * 1.85);  // Middle part of the cloud
        ctx.arc(x + 60, y, 25, Math.PI * 1.5, Math.PI * 0.5);  // Right side of the cloud
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
                    requestAnimationFrame(animate);
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
                hitAnimationY = adjustedYPos

                    if (hit) {
                        canvas.addEventListener('click', fireGun);
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
        // Log the percentageScore and ensure it's being calculated correctly
        console.log('Passing score detected:', percentageScore);

        fetch(`${baseUrl}/get-current-performance/${userId}`)
            .then(response => response.json())
            .then(data => {
                let previousPostTestPerformance = data.post_test_performance || 0;
                console.log('Previous Performance:', previousPostTestPerformance);

                // Updated logging for the performance score
                console.log('Current easy_post_test_performance:', percentageScore);

                document.getElementById('finalScoreText').innerText += `\nCongratulations, you passed!`;
                const updatedTotalScore = gameState.totalScore + score;

                // Update the game state with the new total score
                gameState.totalScore = updatedTotalScore;
                showModal(updatedTotalScore);

                // Display the total score including the post-test score
                console.log('Updated Total Score:', updatedTotalScore);
                document.getElementById('score').innerText = `Your total score: ${updatedTotalScore}`;

                // Update easy_finish status and save stats to the database
                fetch(`${baseUrl}/update-easy-finish/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ easy_finish: 1 })
                })
                .then(response => response.json())
                .then(() => {
                    // Save the score and additional stats
                    return fetch(`${baseUrl}/easy-update-score/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            score: updatedTotalScore,
                            increment_total_games_played: true,
                            total_wins: 1,  // Always sending 1 when passed
                            success_rate: 1, // Assuming you also want to count this as a success
                            easy_post_test_performance: percentageScore // Ensure you are sending the correct value
                        })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Score and additional stats updated successfully:', data);
                })
                .catch(error => {
                    console.error('Error updating score or easy_finish:', error);
                });
            })
            .catch(error => {
                console.error('Error fetching current performance:', error);
            });

        document.getElementById('postTestContainer').style.display = 'none';
    } else {
        // Handle failure case as before
        document.getElementById('finalScoreText').innerText += `\nYou need to score at least 80% to pass. Try again!`;
        // Restart the game after 1 second if the user failed
        fetch(`${baseUrl}/easy-update-score/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                increment_total_games_played: true, // Only increment total games played
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
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
            window.location.href = "{{ route('stage1') }}"; // Restart the game
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
                window.location.href = "{{ route('stage1') }}"; // Redirect to easy.blade.php
            }

            function attackMonster(damage) {
                gameState.isAttacking = true;
                gameState.attackFrame = 0;
                gameState.monsterHp = Math.max(0, gameState.monsterHp - damage);

                if (gameState.monsterHp === 0) {
                    if (gameState.level === 1) {
                        showLevel1CompleteModal();
                    } else if (gameState.level === 2) {
                        showLevel3CompleteModal();
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
            "Now you on this level you need to find a specific tagert!"
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
        } else if (currentLevel === 2) {
            currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
            draw();
            initializeLevel3();
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
    } else if (currentLevel === 2) {
        currentMonsterImage.src = monsterImages[Math.floor(Math.random() * monsterImages.length)];
        draw();
        initializeLevel3();
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


        let playerImage = new Image();

// Initialize the player image based on the gender
fetch('/get-game-state') // Example API to fetch user state, assuming it returns the gender
    .then(response => response.json())
    .then(data => {
        if (data.playerGender === 'male') {
            playerImage.src = 'images/characters/playerMale.png';
        } else if (data.playerGender === 'female') {
            playerImage.src = 'images/characters/playerFemale.png';
        } else {
            playerImage.src = 'images/characters/defaultPlayer.png'; // Fallback image
        }
    })
    .catch(error => console.error('Error fetching game state:', error));

// Event listener to ensure player image is loaded before drawing
playerImage.onload = function() {
    console.log("Player image loaded successfully.");
};

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

    // Ensure the player image is fully loaded before drawing it
    if (playerImage.complete) {
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
    } else {
        console.error("Player image is not loaded yet.");
    }

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
            // Call this function to trigger the attack
            function triggerAttack() {
                gameState.isAttacking = true;
            }
            // Start the game
            initializeGame();


        </script>
    </body>

    </html>
