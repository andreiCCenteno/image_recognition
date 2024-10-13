<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tutorial</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(135deg, #ff0066, #ff9933, #ffff00, #33cc33, #0066ff, #9933ff);
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite;
            margin: 0;
            padding: 20px;
            color: #00ffcc;
            text-align: center;
        }
        @keyframes gradientAnimation {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }
        .game-container {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            width: 80%;
        }
        .pixel-container {
            margin: 20px auto;
            width: 150px;
            height: 150px;
            background-color: #fff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        canvas {
            border: 2px solid white;
            max-width: 100%;
            height: auto;
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
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
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
            background-image: url('hand-pointer.png'); /* Replace with your hand pointer image URL */
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

        /* Headers */
        h1 {
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
        }
        h2 {
            margin-bottom: 15px;
        }
        /* Game Container */
        .game-container {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            width: 80%;
        }
        /* Image and Canvas */
        .image-container, .pixel-container {
            margin: 20px auto;
            width: 150px;
            height: 150px;
            background-color: #fff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        canvas {
            border: 2px solid white;
            max-width: 100%;
            height: auto;
        }
        .pixel-container::before, .shell::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 15px;
            border: 2px solid rgba(0, 255, 204, 0.5);
            filter: blur(5px);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .pixel-container:hover::before, .shell:hover::before {
            opacity: 1;
        }
        /* Controls */
        .controls {
            margin: 20px 0;
        }
        #guessInput {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
            border: 2px solid #fff;
            background-color: #333;
            color: #fff;
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
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
            text-align: center;
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
        /* Shell Stage */
        .shell {
            width: 100px;
            height: 100px;
            margin: 0 10px;
            cursor: pointer;
            border: 2px solid #333;
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            transition: transform 0.2s;
        }
        .shell:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
        }
        .shell img {
            width: 100%;
            height: 100%;
            transition: transform 0.2s;
        }
        #result, #colorResult {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
        }
        #timer {
            font-size: 20px;
            margin-top: 10px;
        }
        /* Glowing Effect for Shells */
        .shell::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 15px;
            border: 2px solid rgba(0, 255, 204, 0.5);
            filter: blur(5px);
            opacity: 0;
            transition: opacity 0.2s;
            z-index: -1;
        }
        .shell:hover::before {
            opacity: 1;
        }
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.7); /* Black w/ opacity */
            padding-top: 60px; /* Location of the box */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 10px;
            text-align: center;
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
        /* Next Round Button Styles */
        #nextRoundButton {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #33cc33;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: none; /* Initially hidden */
            transition: background-color 0.2s;
        }
        #nextRoundButton:hover {
            background-color: #28a745;
        }
        /* Color Identification Stage Styles */
        #colorStage {
            display: none; /* Initially hidden */
            text-align: center;
        }
        .color-target {
            width: 100px;
            height: 100px;
            border: 2px solid #333;
            margin: 20px auto;
        }
        .color-choice {
            margin: 10px;
            display: inline-block;
            width: 50px;
            height: 50px;
            cursor: pointer;
            border: 1px solid #333;
            border-radius: 5px;
        }
        .slider-container {
            margin: 10px 0;
        }

        .slider {
            width: 100%;
        }
        /* Button styles for the check button */
        #checkButton {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #0066ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        #checkButton:hover {
            background-color: #0056b3;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
            text-align: center;
            color: #333;
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
        /* Button styles */
        #startGameButton {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #33cc33;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        #startGameButton:hover {
            background-color: #28a745;
        }
        /* Finish Modal */
#finishModal {
    display: none; /* Initially hidden */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.7); /* Black w/ opacity */
    padding-top: 60px;
}
#finishModal .modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    border-radius: 10px;
    text-align: center;
}
#finishModal .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
#finishModal .close:hover, #finishModal .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
#finishModal #playGameButton {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 16px;
    background-color: #33cc33;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
}
#finishModal #playGameButton:hover {
    background-color: #28a745;
}
#tutorialText {
    white-space: normal; /* Allow wrapping */
    word-wrap: break-word; /* Break words if they are too long */
    overflow-wrap: break-word; /* Additional support for breaking long words */
    max-width: 90%; /* Prevents overflowing the container */
    margin: 10px; /* Add some margin for aesthetics */
    font-size: 18px; /* Adjust font size as needed */
}
    </style>
</head>
<body>
    <!-- Dark Overlay for Tutorial -->
    <div class="overlay" id="tutorialOverlay">
        <div class="highlight-area" id="highlightArea"></div>
        <div class="hand-pointer" id="handPointer"></div> <!-- Hand pointer element -->
        <div class="instruction-box">
            <p id="tutorialText">This is a tutorial message...</p>
            <button id="nextTutorialButton">Next</button>
        </div>
    </div>
    <div id="tutorialModal" class="modal">
        <div class="modal-content">
            <span class="close" id="modalClose">&times;</span>
            <h2>Welcome to the Image Recognition Learning Game!</h2>
            <p>In this game, you'll be guided through several stages to improve your image recognition skills:</p>
            <ul>
                <li><strong>Stage 1 (Pixelator Puzzle)</strong>: Try to identify the image as it becomes increasingly pixelated.</li>
                <li><strong>Stage 2 (Outline Selection)</strong>: Choose the correct outline for the image in a shell-game format.</li>
                <li><strong>Stage 3 (Color Calibration)</strong>: Adjust the colors to match the target image as closely as possible.</li>
            </ul>
            <p>Each stage will test your ability to recognize and understand images, helping you improve your visual learning skills!</p>
            <button id="startGameButton">Start Game</button>
        </div>
    </div>
    <h1>Image Recognition Learning</h1>
    <div class="game-container">
        <!-- Pixelator Puzzle Stage -->
        <div id="pixelStage" class="pixel-container">
            <canvas id="pixelCanvas"></canvas>
        </div>
    </div>
    <div id="pixelatorGuess" class="controls hidden">
        <input type="text" id="guessInput" placeholder="Enter your guess" />
        <button id="submitGuess">Submit Guess</button>
    </div>
    <!-- Shell Game Stage -->
    <div id="shellStage" class="game-stage" style="display: none;">
        <div class="game-container">
            <div class="shell" data-id="0">
                <img src="question.jpg" alt="?" class="shell-image">
            </div>
            <div class="shell" data-id="1">
                <img src="question.jpg" alt="?" class="shell-image">
            </div>
            <div class="shell" data-id="2">
                <img src="question.jpg" alt="?" class="shell-image">
            </div>
        </div>
        <div id="result"></div>
        <div id="timer">Time left: <span id="time">10</span> seconds</div>
    </div>
    <div id="colorStage" style="display: none;">
        <div>
            <strong>Target Color:</strong>
            <div class="color-target" id="targetColorDisplay" style="border: 1px solid black;"></div>
        </div>
        <div>
            <strong>Your Color:</strong>
            <div class="color-target" id="colorTarget"></div>
        </div>
        <div id="colorResult"></div>
        <div class="slider-container">
            <label>Red: <input type="range" min="0" max="255" id="redSlider" class="slider" /></label>
            <p>Value: <span id="redValue">0</span></p>
        </div>
        <div class="slider-container">
            <label>Green: <input type="range" min="0" max="255" id="greenSlider" class="slider" /></label>
            <p>Value: <span id="greenValue">0</span></p>
        </div>
        <div class="slider-container">
            <label>Blue: <input type="range" min="0" max="255" id="blueSlider" class="slider" /></label>
            <p>Value: <span id="blueValue">0</span></p>
        </div>

        <div id="finishModal" class="modal">
            <div class="modal-content">
                <h2>Tutorial Complete!</h2>
                <p>You've completed the tutorial and are now ready to play the game.</p>
                <button id="playGameButton" onclick="exitTutorial()">Go to Play Page</button>
            </div>
        </div>
        <script>
            function exitTutorial() {
    window.location.href = "{{ route('play') }}"; // Replace 'play' with your actual route name
}

document.addEventListener('DOMContentLoaded', function () {
        const tutorialSteps = [
        // Pixelator Puzzle Stage
        {
            element: document.getElementById('pixelStage'),
            message: "Welcome  to the Pixelator Puzzle! The image resolution will decrease over time, and you need to guess what the object is."
        },
        {
            element: document.getElementById('guessInput'),
            message: "Use this input box to type your guess based on the pixelated image."
        },
        {
            element: document.getElementById('submitGuess'),
            message: "Once you’ve made your guess, click this button to submit it."
        },
        // Transition to Shell Game
        {
            element: document.getElementById('shellStage'),
            message: "Now we move to the Shell Game stage! Here, the outlines will shuffle, and you have to find the correct outline."
        },
        {
            element: document.querySelector('.shell[data-id="0"]'),
            message: "These are the shell outlines. They will shuffle, and you need to select the one with the correct shape."
        },
        {
            element: document.querySelector('.shell[data-id="1"]'),
            message: "Try to keep track of the correct outline as the shells shuffle. You can click on one of these shells to make your choice."
        },
        {
            element: document.getElementById('timer'),
            message: "Watch the timer! You only have a limited amount of time to make your selection."
        },
        // Transition to Color Matching Stage
        {
            element: document.getElementById('colorStage'),
            message: "Next up is the Color Matching Stage! Here, you'll adjust the sliders to match the target color."
        },
        {
            element: document.getElementById('redSlider'),
            message: "Use this slider to adjust the red value. Try to match the target color."
        },
        {
            element: document.getElementById('greenSlider'),
            message: "This slider controls the green value. Use it to tweak the color further."
        },
        {
            element: document.getElementById('blueSlider'),
            message: "And finally, use this slider to adjust the blue value to get closer to the target color."
        },
        {
            element: document.getElementById('colorResult'),
            message: "Your result will be shown here. Try to match the color as closely as possible!"
        }
    ];


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

    const type = () => {
        if (index < message.length) {
            tutorialText.textContent += message.charAt(index); // Use textContent to avoid issues
            index++;
            setTimeout(type, typingSpeed); // Call type again after a delay
        }
    };

    type();// Start typing effect
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
            // Additional logic to start the game goes here
            nextTutorialButton.addEventListener('click', () => {
                if (currentStep < tutorialSteps.length - 1) {
                    currentStep++;

                    // Check if transitioning between stages
                    if (currentStep === 3) {
                        // Hide Pixelator Puzzle, Show Shell Game
                        document.getElementById('pixelatorGuess').style.display = 'none';
                        document.getElementById('shellStage').style.display = 'block';
                    } else if (currentStep === 7) {
                        // Hide Shell Game, Show Color Matching Stage
                        document.getElementById('shellStage').style.display = 'none';
                        document.getElementById('pixelStage').style.display = 'none';
                        document.getElementById('colorStage').style.display = 'block';
                    }

                    showTutorialStep();
                } else {
                    const finishModal = document.getElementById('finishModal');

                    finishModal.style.display = 'flex';
                    tutorialOverlay.style.display = 'none';
                    handPointer.style.display = 'none';
                }
            });
            // Initialize the first tutorial step
            showTutorialStep();
        };
    };
});

        </script>  
</body>
</html>
