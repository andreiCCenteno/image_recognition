<?php
// "The Artifact Analyst" Game Code
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Artifact Analyst</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0c0e10;
            color: #fff;
            overflow: hidden;
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .artifact {
            width: 300px;
            height: 300px;
            background: #444;
            border-radius: 50%;
            position: relative;
            animation: glow 2s infinite alternate;
        }
        @keyframes glow {
            0% {
                box-shadow: 0 0 10px #00ff99;
            }
            100% {
                box-shadow: 0 0 30px #00ff99;
            }
        }
        .dialogue {
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
        }
        .buttons {
            margin-top: 20px;
        }
        .btn {
            background: #00ff99;
            border: none;
            padding: 10px 20px;
            color: #000;
            font-size: 16px;
            cursor: pointer;
            margin: 0 10px;
            border-radius: 5px;
        }
        .btn:hover {
            background: #00cc77;
        }
        .name-input {
            margin-bottom: 20px;
        }
        .gender-selection {
            display: flex;
            justify-content: space-evenly;
        }

          /* Styling for the CNN feature extraction game section */
        #cnn-game {
            display: none;
            padding: 20px;
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        #cnn-game h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        /* Matrix display for artifact and kernel */
        .matrix {
            display: grid;
            grid-template-columns: repeat(3, 50px);
            grid-gap: 5px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .matrix div {
            width: 50px;
            height: 50px;
            background-color: #e3e3e3;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            font-size: 18px;
        }

        .matrix div.clear {
            background-color: #fff;
        }

        .matrix div.light {
            background-color: #f3f3f3;
        }

        .matrix div.dark {
            background-color: #d2d2d2;
        }

        .matrix div.darker {
            background-color: #a2a2a2;
        }

        /* Computation steps section */
        .computation-steps {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        /* Input field for classification */
        .input-field {
            margin-bottom: 20px;
        }

        #manualResult {
            padding: 10px;
            width: 100px;
            font-size: 16px;
            margin-right: 10px;
        }

        .result {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        /* Output matrix */
        .output-matrix {
            display: grid;
            grid-template-columns: repeat(3, 50px);
            grid-gap: 5px;
            justify-content: center;
        }

        .output-matrix div {
            width: 50px;
            height: 50px;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            font-size: 18px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            display: none; /* Hidden by default */
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            z-index: 1000;
        }

        .overlay h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .matrix {
            display: grid;
            grid-template-columns: repeat(3, 50px);
            gap: 5px;
            margin: 20px 0;
        }

        .matrix div {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #555;
            border: 1px solid #fff;
        }

        .instruction {
            font-size: 16px;
            max-width: 80%;
            margin-top: 20px;
            font-style: italic;
        }

        #convolutionKernelOverlay {
            background-color: rgba(0, 0, 0, 0.7);
        }

        #artifactMatrixOverlay {
            background-color: rgba(0, 0, 0, 0.7);
        }

        #outputMatrixOverlay {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .container-interactions {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        #name-input-section, 
        #gender-selection-section {
            flex-wrap: wrap;
            line-height: 50px;
        }

        #artifact-analysis-phase,
        #image-recognition-intro,
        #cnn-feature-extraction {
            flex-wrap: wrap;
            flex-direction: column;
            width: 100%;
        }

        #cnn-game {
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: transparent;
        }

        #cnn-game .input-field {
            display: inline-flex;
        }

        #name-input-section .dialogue, 
        #gender-selection-section .dialogue,
        #cnn-game label {
            margin-top: 0;
            margin-right: 10px;
        }

        #artifact-analysis-phase .dialogue,
        #image-recognition-intro .dialogue,
        #cnn-feature-extraction .dialogue {
            margin-top: 0;
        }

        #name-input-section .name-input, 
        .input-field #manualResult {
            margin-bottom: 0;
            height: 30px;
            border: 2px solid #ccc;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        #name-input-section .name-input:hover, 
        #name-input-section .name-input:focus,
        .input-field #manualResult:hover,
        .input-field #manualResult:focus {
            border-color: #00cc77;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
        }

        #name-input-section .name-input:focus,
        .input-field #manualResult:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Dynamic Story Introduction -->
        <div id="story">
            <div class="artifact"></div>
            <div class="dialogue" id="dialogue">
                You are an archaeologist on the verge of uncovering the secrets of an ancient artifact hidden deep within the sands of time...
            </div>
            <div class="buttons">
                <button class="btn" id="enterName">Continue</button>
            </div>
        </div>

        <!-- Name Input Section -->
        <div id="name-input-section" style="display: none;">
            <div class="dialogue">What is your name, archaeologist?</div>
            <div class="container-interactions">
                <input type="text" id="playerName" class="name-input" placeholder="Enter your name">
                <button class="btn" id="nextStep">Next</button>
            </div>
        </div>

        <!-- Gender Selection Section -->
        <div id="gender-selection-section" style="display: none;">
            <div class="dialogue">Choose your character:</div>
            <div class="gender-selection container-interactions">
                <button class="btn" id="chooseMale">Male</button>
                <button class="btn" id="chooseFemale">Female</button>
            </div>
        </div>

        <!-- Story Begins: Artifact Analysis Phase -->
        <div id="artifact-analysis-phase" style="display: none;">
            <div class="dialogue">
                As you prepare to unlock the secrets of the artifact, you take a deep breath. Its surface holds ancient mysteries that could change history forever. 
                <br><br>
                The first task is to enhance the artifact’s image. Using advanced preprocessing techniques, you’ll remove noise and reveal hidden patterns that have long been forgotten. 
                <br><br>
                You begin analyzing the artifact, knowing that what you uncover will be crucial to understanding its power.
            </div>
            <div class="buttons container-interactions">
                <button class="btn" id="proceedToNext">Proceed</button>
            </div>
        </div>

        <!-- Introduction to Image Recognition -->
        <div id="image-recognition-intro" style="display: none;">
            <div class="dialogue">
                Welcome to the world of Image Recognition! To proceed further in your analysis, you must master two crucial techniques:
                <ul style="text-align: left; margin-top: 10px;">
                    <li><strong>Preprocessing:</strong> Enhancing the artifact’s images by bringing out hidden patterns and removing unwanted noise.</li>
                    <li><strong>Postprocessing:</strong> Examining the processed images to extract meaningful features and gain insights.</li>
                </ul>
                These techniques will help you decipher the artifact’s true nature and unravel its secrets.
            </div>
            <div class="buttons container-interactions">
                <button class="btn" id="proceedToNextPhase">Proceed</button>
            </div>
        </div>

        <!-- Feature Extraction using CNN -->
<div id="cnn-feature-extraction" style="display: none;">
    <div class="dialogue">
        Now, we move on to the most advanced step: Feature Extraction using Convolutional Neural Networks (CNNs). 
        <br><br>
        In this phase, you'll analyze the artifact’s image using CNNs, which help identify intricate features that are not visible to the naked eye.
        <br><br>
        CNNs are great for detecting patterns like edges, textures, and more. As you apply the model, you will extract features from the artifact that will help you understand its deeper secrets.
    </div>
    
    <!-- Display Target Image for Feature Extraction -->
    <div class="target-image-container">
        <h3>Target Image for Feature Extraction</h3>
        <img src="images/target_image.jpg" alt="Target Image" id="targetImage" class="target-image">
        <br><br>
        <p>Study the image closely to understand its features. Your task is to extract and identify the key features of this image using a CNN.</p>
    </div>
    
    <div class="buttons container-interactions">
        <button class="btn" id="proceedToFeatureExtraction">Proceed with Feature Extraction</button>
    </div>
</div>

<!-- Feature Extraction using CNN -->
<div id="cnn-feature-extraction-done" style="display: none;">
    <div class="dialogue">
        Well done on extracting the features! 
        <br><br>
        Now, lets try it to a game!
        <br><br>
    </div>
</div>


        <!-- CNN Feature Extraction Game -->
<div id="cnn-game" style="display: none;">
    <h1>Feature Extraction Game</h1>

    <div>
        <h2>Input Matrix (Artifact Image)</h2>
        <div class="matrix" id="artifactMatrix"></div>
    </div>

    <div>
        <h2>Convolution Kernel</h2>
        <div class="matrix" id="kernel"></div>
    </div>

    <div class="computation-steps" id="computationSteps"></div>

    <div class="input-field">
        <label for="manualResult">Enter Computed Value to Classify Feature:</label>
        <div class="container-interactions">
            <input type="number" id="manualResult" placeholder="Result">
            <button class="btn" onclick="classifyFeature()">Classify Feature</button>
        </div>
    </div>

    <div class="result" id="result"></div>

    <h2>Output Matrix</h2>
    <div class="matrix" id="outputMatrix"></div>

    <div class="buttons container-interactions">
        <button class="btn" id="nextRoundButton" style="display: none;" onclick="nextRound()">Next Round</button>
    </div>
</div>


<div class="overlay" id="convolutionKernelOverlay">
    <h2>Convolution Kernel</h2>
    <div class="matrix" id="kernel"></div>
    <p class="instruction">A convolution kernel is a small matrix used in image processing to extract features from an image. It works by sliding over the input image, multiplying its values with the pixel values beneath it, and producing an output that highlights important features like edges, textures, and patterns. In image recognition, kernels help the model identify key elements in an image, such as shapes and boundaries, making it easier to classify objects or detect patterns.</p>
</div>

<div class="overlay" id="artifactMatrixOverlay">
    <h2>Input Matrix (Artifact Image)</h2>
    <div class="matrix" id="artifactMatrix"></div>
    <p class="instruction">This is the input image (artifact) matrix, representing the pixel values of the original image that will undergo processing. Each pixel in the image has a value that corresponds to its intensity or color. The convolution kernel will be applied to this matrix to extract features and transform the image for further analysis, such as edge detection, pattern recognition, or texture identification.</p>
</div>

<div class="overlay" id="outputMatrixOverlay">
    <h2>Output Matrix</h2>
    <div class="matrix" id="outputMatrix"></div>
    <p class="instruction">The output matrix represents the result of applying the convolution kernel to the input matrix. Each value in the output matrix is derived by applying the kernel to a specific region of the input image, highlighting features like edges, textures, or patterns. The output matrix helps in visualizing the features extracted from the original image, which are crucial for tasks like image recognition, classification, or further processing.</p>
</div>

    </div>

    <script>
// Shape values for CNN (edge, texture, etc.)
const shapeValues = {
        'clear': 0,
        'light': 2,
        'dark': 1,
        'darker': 3
    };

    // Randomly generate shapes (features of the artifact)
    function generateRandomArtifact() {
        const shapes = ['clear', 'light', 'dark', 'darker'];
        let artifact = [];
        for (let i = 0; i < 3; i++) {
            let row = [];
            for (let j = 0; j < 3; j++) {
                const randomShape = shapes[Math.floor(Math.random() * shapes.length)];
                row.push({ shape: randomShape, value: shapeValues[randomShape] });
            }
            artifact.push(row);
        }
        return artifact;
    }

    // Render the artifact matrix (artifact image) in the HTML
    function renderArtifact(artifact) {
        const artifactMatrixDiv = document.getElementById("artifactMatrix");
        artifactMatrixDiv.innerHTML = "";
        artifact.forEach(row => {
            row.forEach(cell => {
                const cellDiv = document.createElement("div");
                const shapeDiv = document.createElement("div");
                shapeDiv.classList.add(cell.shape);
                cellDiv.appendChild(shapeDiv);
                artifactMatrixDiv.appendChild(cellDiv);
            });
        });
    }

    // Generate a random convolution kernel
    function generateRandomKernel() {
        const kernel = [];
        for (let i = 0; i < 3; i++) {
            let row = [];
            for (let j = 0; j < 3; j++) {
                const randomValue = Math.floor(Math.random() * 3) - 1; 
                row.push(randomValue);
            }
            kernel.push(row);
        }
        return kernel;
    }

    // Render the convolution kernel in the HTML
    function renderKernel(kernel) {
        const kernelDiv = document.getElementById("kernel");
        kernelDiv.innerHTML = "";
        kernel.forEach(row => {
            row.forEach(value => {
                const cellDiv = document.createElement("div");
                cellDiv.textContent = value;
                kernelDiv.appendChild(cellDiv);
            });
        });
    }

    // Compute convolution and display steps
    function computeConvolution(artifact, kernel) {
        let sum = 0;
        let computationSteps = '';
        for (let i = 0; i < 3; i++) {
            for (let j = 0; j < 3; j++) {
                const product = artifact[i][j].value * kernel[i][j];
                computationSteps += `(${artifact[i][j].value} * ${kernel[i][j]}) = ${product}<br>`;
                sum += product;
            }
        }
        return { sum, steps: computationSteps };
    }

    // Initialize output matrix as a 3x3 grid
    let outputMatrix = Array(3).fill().map(() => Array(3).fill(""));

    function renderOutputMatrix() {
        const outputMatrixDiv = document.getElementById("outputMatrix");
        outputMatrixDiv.innerHTML = "";
        outputMatrix.forEach(row => {
            row.forEach(value => {
                const cellDiv = document.createElement("div");
                cellDiv.textContent = value !== "" ? value : " ";
                outputMatrixDiv.appendChild(cellDiv);
            });
        });
    }

    let currentCellIndex = 0;

    function classifyFeature() {
        const userResult = document.getElementById("manualResult").value;
        const resultDisplay = document.getElementById("result");
        const { sum: convolutionResult } = computeConvolution(artifact, kernel);

        if (userResult === "") {
            resultDisplay.textContent = "Please enter a value to classify.";
            return;
        }

        const rowIndex = Math.floor(currentCellIndex / 3);
        const colIndex = currentCellIndex % 3;

        if (rowIndex < 3 && colIndex < 3) {
            outputMatrix[rowIndex][colIndex] = userResult;
            currentCellIndex++;
            renderOutputMatrix();
        }

        resultDisplay.textContent = parseInt(userResult) === convolutionResult
            ? `Correct! The computed value is ${convolutionResult}.`
            : `Incorrect. The computed value is ${convolutionResult}.`;

        // Check if the grid is full and show the Next Round button
        if (currentCellIndex === 9) {
            document.getElementById("nextRoundButton").style.display = "inline-block";
        }
    }

    // Function to handle the next round (reset for a new game)
    function nextRound() {
        outputMatrix = Array(3).fill().map(() => Array(3).fill(""));
        currentCellIndex = 0;
        renderOutputMatrix();
        document.getElementById("manualResult").value = "";
        document.getElementById("nextRoundButton").style.display = "none"; // Hide the button for the next round
    }

    const artifact = generateRandomArtifact();
    const kernel = generateRandomKernel();
    renderArtifact(artifact);
    renderKernel(kernel);
    renderOutputMatrix();

    // Handle the transition when clicking "Proceed with Feature Extraction"
    document.getElementById("proceedToFeatureExtraction").addEventListener("click", function() {
        document.getElementById("cnn-feature-extraction").style.display = "none";
        document.getElementById("cnn-game").style.display = "block";
    });

    // Handle the transition when clicking "Next Round"
document.getElementById("nextRoundButton").addEventListener("click", function() {
    document.getElementById("cnn-game").style.display = "none";
    document.getElementById("cnn-feature-extraction-done").style.display = "block";
    setTimeout(() => {
        window.location.href = "{{ route('stage1') }}"; // Restart the game
    }, 2000);
});

    // Handle next round button
    document.getElementById("nextRoundButton").addEventListener("click", function() {
        // Generate new random artifact and kernel for the next round
        const newArtifact = generateRandomArtifact();
        const newKernel = generateRandomKernel();
        renderArtifact(newArtifact);
        renderKernel(newKernel);
        outputMatrix = Array(3).fill().map(() => Array(3).fill(""));
        currentCellIndex = 0;
        renderOutputMatrix();
    });

        // Game Progression Logic
        let currentStage = 0;

        // Handle Enter Name Button
        document.getElementById('enterName').addEventListener('click', () => {
            document.getElementById('story').style.display = 'none';
            document.getElementById('name-input-section').style.display = 'flex';
            document.getElementById('name-input-section').style.justifyContent = 'center';
            document.getElementById('name-input-section').style.alignItems = 'center';
        });

        // Handle Next Step Button
        document.getElementById('nextStep').addEventListener('click', () => {
            const playerName = document.getElementById('playerName').value;
            if (playerName.trim() === '') {
                alert('Please enter your name.');
                return;
            }

            alert(`Welcome, ${playerName}!`);
            document.getElementById('name-input-section').style.display = 'none';
            document.getElementById('gender-selection-section').style.display = 'flex';
            document.getElementById('gender-selection-section').style.justifyContent = 'center';
            document.getElementById('gender-selection-section').style.alignItems = 'center';
        });

        // Handle Gender Selection
        document.getElementById('chooseMale').addEventListener('click', () => {
            alert('You have chosen the Male character.');
            proceedToArtifactAnalysisPhase();
        });

        document.getElementById('chooseFemale').addEventListener('click', () => {
            alert('You have chosen the Female character.');
            proceedToArtifactAnalysisPhase();
        });

        // Proceed to Artifact Analysis Phase
        function proceedToArtifactAnalysisPhase() {
            document.getElementById('gender-selection-section').style.display = 'none';
            document.getElementById('artifact-analysis-phase').style.display = 'flex';
            document.getElementById('artifact-analysis-phase').style.justifyContent = 'center';
            document.getElementById('artifact-analysis-phase').style.alignItems = 'center';
            currentStage = 1;
        }

        // Handle Proceed Button for Artifact Analysis Phase
        document.getElementById('proceedToNext').addEventListener('click', () => {
            alert('Let us begin enhancing the artifact’s image!');
            proceedToImageRecognitionIntro();
        });

        // Proceed to Image Recognition Introduction
        function proceedToImageRecognitionIntro() {
            document.getElementById('artifact-analysis-phase').style.display = 'none';
            document.getElementById('image-recognition-intro').style.display = 'flex';
            document.getElementById('image-recognition-intro').style.justifyContent = 'center';
            document.getElementById('image-recognition-intro').style.alignItems = 'center';
            currentStage = 2;
        }

        // Handle Proceed Button for Image Recognition Intro
        document.getElementById('proceedToNextPhase').addEventListener('click', () => {
            alert('You are now ready to use preprocessing and postprocessing techniques!');
            proceedToCNNFeatureExtraction();
        });

        // Proceed to Feature Extraction using CNN
        function proceedToCNNFeatureExtraction() {
            document.getElementById('image-recognition-intro').style.display = 'none';
            document.getElementById('cnn-feature-extraction').style.display = 'flex';
            document.getElementById('cnn-feature-extraction').style.justifyContent = 'center';
            document.getElementById('cnn-feature-extraction').style.alignItems = 'center';
            currentStage = 3;
        }

        // Handle Proceed Button for Feature Extraction Phase
        document.getElementById('proceedToFeatureExtraction').addEventListener('click', () => {
            alert('You are now extracting features from the artifact using CNNs! This will reveal the most hidden aspects of the artifact.');
            // Further progression logic to move to next game stages can be added here.
        });

// Function to show a specific overlay, highlight the container, and remove the overlay after a delay
function showOverlay(overlayId, removeAfter) {
    const overlays = document.querySelectorAll('.overlay');
    overlays.forEach(overlay => overlay.style.display = 'none'); // Hide all overlays
    const overlay = document.getElementById(overlayId);
    if (overlay) {
        overlay.style.display = 'flex'; // Show the selected overlay
        overlay.style.justifyContent = 'center';
        overlay.style.alignItems = 'center';

        // If it's the Output Matrix Overlay, highlight the container
        if (overlayId === 'outputMatrixOverlay') {
            const matrixContainer = document.getElementById('outputMatrix');
            matrixContainer.classList.add('highlight');  // Add highlight class to the container
            
            // Remove the highlight after 2 seconds (you can adjust this)
            setTimeout(() => {
                matrixContainer.classList.remove('highlight');
            }, 2000);  // 2 seconds delay to remove the highlight
        }

        // Remove the overlay after the specified duration (removeAfter in milliseconds)
        setTimeout(() => {
            overlay.style.display = 'none'; // Hide the overlay after the delay
        }, removeAfter); // Use the removeAfter parameter for duration
    }
}

// Function to simulate the convolution process
function startConvolutionProcess() {
    // Show the Convolution Kernel Overlay and remove it after 4 seconds
    showOverlay('convolutionKernelOverlay', 4000);
    
    // Show the Artifact Matrix Overlay and remove it after 4 seconds
    setTimeout(() => {
        showOverlay('artifactMatrixOverlay', 4000);
    }, 2000); // 2 seconds delay between overlays

    // Show the Output Matrix Overlay and remove it after 4 seconds
    setTimeout(() => {
        showOverlay('outputMatrixOverlay', 4000);
    }, 4000); // 4 seconds delay before showing the output matrix
    
}

// Function to populate a matrix with example values
function populateMatrix(matrixId, values) {
    const matrixElement = document.getElementById(matrixId);
    matrixElement.innerHTML = ''; // Clear previous content
    values.forEach(value => {
        const div = document.createElement('div');
        div.textContent = value;
        matrixElement.appendChild(div);
    });
}

// Add event listener to the "Start CNN Process" button
document.getElementById('proceedToFeatureExtraction').addEventListener('click', function() {
    startConvolutionProcess();  // Start the process when the button is clicked
});

document.getElementById('proceedToGame').addEventListener('click', function() {
    setTimeout(() => {
        window.location.href = "{{ route('stage1') }}"; // Restart the game
    }, 2000);
});

    </script>
</body>
</html>
