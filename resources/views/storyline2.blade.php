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
      
        .pixel-data {
          display: flex;
          justify-content: center;
          gap: 10px;
          margin-bottom: 20px;
        }
        .pixel {
          text-align: center;
        }
        .color-box {
          width: 50px;
          height: 50px;
          border: 1px solid #000;
          margin-bottom: 5px;
        }
        .input-row {
          margin: 10px 0;
        }
        input {
          width: 80px;
          padding: 5px;
          font-size: 14px;
          margin: 5px;
        }

        .feedback {
          margin-top: 20px;
          font-size: 18px;
        }
        .formula {
          font-size: 16px;
          font-style: italic;
          margin-bottom: 15px;
        }

        .color-container {
          max-width: 800px;
          margin: auto;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 8px;
          background-color: transparent;
        }


        /* General overlay styling */
        .overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
            z-index: 1000;
        }

        .overlay h2 {
            font-size: 24px;
            color: #fff;
            text-align: center;
        }

        .overlay .instruction {
            font-size: 18px;
            color: #fff;
            margin: 15px;
        }

        .overlay .matrix {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pixel-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pixel-container .pixel {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
        }

        .pixel-container .pixel span {
            display: block;
            color: #fff;
            text-align: center;
            line-height: 40px;
        }

        .overlay ul {
            font-size: 16px;
            color: #fff;
            margin-left: 20px;
        }

        /* Styling for the formula section */
        #formulaOverlay {
            margin-top: 20px;
        }

        .pixel {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container-interactions {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        #color-identification-phase,
        #color-identification {
            flex-wrap: wrap;
            flex-direction: column;
            width: 100%;
        }

        #color-identification-phase .dialogue {
            margin-top: 0;
        }

        .input-row {
            display: flex;
            justify-content: space-evenly;
        }

        .input-row .container-hex-color-input > input[type="number"] {
            height: 30px;
            border: 2px solid #ccc;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-row .container-hex-color-input > input[type="number"]:hover, 
        .input-row .container-hex-color-input > input[type="number"]:focus {
            border-color: #00cc77;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
        }

        .input-row .container-hex-color-input > input[type="number"]:focus {
            outline: none;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Dynamic Story Introduction -->
        <div id="story">
            <div class="artifact"></div>
            <div class="dialogue" id="dialogue">
                Good Work, on your first mission. Lest move one to the next one.
            </div>
            <div class="buttons">
                <button class="btn" id="startGame">Next</button>
            </div>
        </div>

        <!-- Color Identification Phase -->
        <div id="color-identification-phase" style="display: none;">
            <div class="dialogue">
                As you prepare to unlock the secrets of the artifact, you take a deep breath. Its surface holds ancient mysteries that could change history forever.
                <br><br>
                The first task is complete. You successfully enhanced the artifact’s image, revealing hidden patterns that were long obscured. The ancient secrets are slowly starting to come to light.
                <br><br>
                With this breakthrough, you've uncovered the secrets hidden within the artifact. Now, you must proceed to the next task: identifying the key color hidden within the artifact's design.
            </div>

            <div class="buttons container-interactions">
                <button class="btn" id="proceedToNext">Proceed</button>
            </div>
        </div>


       <!-- Color Identification Phase -->
<div id="color-identification" style="display: none;">
    <div class="dialogue">
        Now, we move on to the next important task: Color Identification. 
        <br><br>
        In this phase, you'll focus on identifying the key color hidden within the artifact’s design. 
        <br><br>
        Analyzing the colors of the artifact will help uncover hidden patterns that can reveal deeper insights into its meaning.
    </div>

    <!-- Display Target Image for Color Identification -->
    <div class="target-image-container">
        <h3>Target Image for Color Identification</h3>
        <img src="images/target_image.jpg" alt="Target Image" id="targetImage" class="target-image">
        <br><br>
        <p>Study the image closely to understand its colors. Your task is to identify the key color hidden within the artifact’s design.</p>
    </div>
    
    <div class="buttons container-interactions">
        <button class="btn" id="proceedToColorIdentification">Proceed with Color Identification</button>
    </div>
</div>

 <!-- Hidden "Well Done" Message -->
 <div id="color-identification-done" style="display: none;">
    <div class="dialogue">
        Well done on finding the dominant color! 
        <br><br>
        Now, let's try it in a game!
        <br><br>
    </div>
</div>

<!-- RGB Color Analysis Game -->
<div class="color-container" id="rgb-color-analysis" style="display: none;">
    <h1>RGB Color Analysis</h1>
    <p>Analyze the pixel colors and solve the task below:</p>
    <div class="pixel-data" id="pixelData"></div>
    <p id="taskText"></p>
    <p class="formula" id="formula"></p>
    <div class="input-row">
        <div class="container-hex-color-input">
          <label for="rInput">R:</label>
          <input type="number" id="rInput" min="0" max="255" placeholder="0">
        </div>
        <div class="container-hex-color-input">
          <label for="gInput">G:</label>
          <input type="number" id="gInput" min="0" max="255" placeholder="0">
        </div>
        <div class="container-hex-color-input">
          <label for="bInput">B:</label>
          <input type="number" id="bInput" min="0" max="255" placeholder="0">
        </div>
    </div>
    <div class="container-interactions">
      <button class="btn" onclick="checkAnswer()">Submit Answer</button>
    </div>
    <div class="feedback" id="feedback"></div>

    <div class="buttons container-interactions">
        <button class="btn" id="nextRoundButton" style="display: none;">Next Round</button>
    </div>

</div>


<!-- Overlay for Pixel Data Explanation -->
<div class="overlay" id="pixelDataOverlay">
    <h2>Pixel Data</h2>
    <div class="pixel-container" id="pixelDataContainer"></div>
    <p class="instruction">The Pixel Data represents the RGB values of different pixels in the image. Each pixel has three values: Red (R), Green (G), and Blue (B), which combine to create the final color seen in the image. Your task is to analyze these values and compute the average color by calculating the mean of the RGB components across all the pixels.</p>
</div>

<!-- Overlay for RGB Formula Explanation -->
<div class="overlay" id="formulaOverlay">
    <h2>RGB Average Calculation Formula</h2>
    <p class="instruction">To calculate the average color of the image, you will use the following formula:</p>
    <p><strong>Average R = ΣR / N, Average G = ΣG / N, Average B = ΣB / N</strong></p>
    <p>Where:</p>
    <ul>
        <li><strong>ΣR</strong> = Sum of all Red (R) values</li>
        <li><strong>ΣG</strong> = Sum of all Green (G) values</li>
        <li><strong>ΣB</strong> = Sum of all Blue (B) values</li>
        <li><strong>N</strong> = Total number of pixels</li>
    </ul>
    <p>This formula helps you determine the average color by considering all pixel values in the image.</p>
</div>

    </div>
    <script>


  // DOM Elements
  const pixelDataElement = document.getElementById('pixelData');
  const taskText = document.getElementById('taskText');
  const formulaText = document.getElementById('formula');
  const feedback = document.getElementById('feedback');
  const rInput = document.getElementById('rInput');
  const gInput = document.getElementById('gInput');
  const bInput = document.getElementById('bInput');
  const rgbColorAnalysis = document.getElementById('rgb-color-analysis');

  // Pixel data and correct answer
  let pixelData;
  let correctAnswer;

  // Generate random pixel data
  function generatePixelData(numPixels) {
    const pixels = [];
    for (let i = 0; i < numPixels; i++) {
      pixels.push({
        r: Math.floor(Math.random() * 256),
        g: Math.floor(Math.random() * 256),
        b: Math.floor(Math.random() * 256),
      });
    }
    return pixels;
  }

  // Display pixel data as colors and values
  function displayPixelData() {
    pixelDataElement.innerHTML = '';
    pixelData.forEach((pixel, index) => {
      const pixelDiv = document.createElement('div');
      pixelDiv.className = 'pixel';

      const colorBox = document.createElement('div');
      colorBox.className = 'color-box';
      colorBox.style.backgroundColor = `rgb(${pixel.r}, ${pixel.g}, ${pixel.b})`;

      const pixelInfo = document.createElement('p');
      pixelInfo.textContent = `(${pixel.r}, ${pixel.g}, ${pixel.b})`;

      pixelDiv.appendChild(colorBox);
      pixelDiv.appendChild(pixelInfo);
      pixelDataElement.appendChild(pixelDiv);
    });
  }

  // Calculate average RGB values
  function calculateAverageRGB() {
    let totalR = 0, totalG = 0, totalB = 0;

    pixelData.forEach(pixel => {
      totalR += pixel.r;
      totalG += pixel.g;
      totalB += pixel.b;
    });

    return {
      r: Math.round(totalR / pixelData.length),
      g: Math.round(totalG / pixelData.length),
      b: Math.round(totalB / pixelData.length),
    };
  }

  // Update formula display
  function updateFormula() {
    const formula = `
      Average R = ΣR / N, Average G = ΣG / N, Average B = ΣB / N
      where N = ${pixelData.length}
    `;
    formulaText.textContent = formula;
  }

  // Load a new task
  function loadTask() {
    feedback.textContent = '';
    rInput.value = '';
    gInput.value = '';
    bInput.value = '';

    // Generate new pixel data
    pixelData = generatePixelData(5);

    // Display pixel data
    displayPixelData();

    // Set the task and calculate the answer
    taskText.textContent = 'Task: Calculate the average RGB color.';
    correctAnswer = calculateAverageRGB();

    // Update formula display
    updateFormula();
  }

  // Check user's answer
  function checkAnswer() {
    const userAnswer = {
      r: parseInt(rInput.value),
      g: parseInt(gInput.value),
      b: parseInt(bInput.value),
    };

    const tolerance = 5; // Allow small deviation
    const isCorrect =
      Math.abs(userAnswer.r - correctAnswer.r) <= tolerance &&
      Math.abs(userAnswer.g - correctAnswer.g) <= tolerance &&
      Math.abs(userAnswer.b - correctAnswer.b) <= tolerance;

    if (isCorrect) {
      feedback.textContent = 'Correct! Well done.';
      feedback.style.color = 'green';
      document.getElementById("nextRoundButton").style.display = "block";
      setTimeout(() => {
        window.location.href = "{{ route('stage2') }}"; // Restart the game
    }, 3000);
    } else {
      feedback.textContent = `Incorrect. Correct Answer: R=${correctAnswer.r}, G=${correctAnswer.g}, B=${correctAnswer.b}`;
      feedback.style.color = 'red';
    }
  }

  // Initialize game
  function initializeColorIdentification() {
    rgbColorAnalysis.style.display = 'block';
    loadTask();
  }

  // Proceed to Color Identification Phase
  const proceedButton = document.getElementById('proceedToColorIdentification');
  proceedButton.addEventListener('click', () => {
    document.getElementById('color-identification').style.display = 'none';
    initializeColorIdentification();
  });

        document.getElementById('startGame').addEventListener('click', function() {
            document.getElementById('story').style.display = 'none';
            document.getElementById('color-identification-phase').style.display = 'flex';
            document.getElementById('color-identification-phase').style.justifyContent = 'center';
            document.getElementById('color-identification-phase').style.alignItems = 'center';
        });

        document.getElementById('proceedToNext').addEventListener('click', function() {
            document.getElementById('color-identification-phase').style.display = 'none';
            document.getElementById('color-identification').style.display = 'flex';
            document.getElementById('color-identification').style.justifyContent = 'center';
            document.getElementById('color-identification').style.alignItems = 'center';
        });

// Function to show an overlay and hide it after a certain time (in milliseconds)
function showOverlay(overlayId, delay) {
    const overlay = document.getElementById(overlayId);
    overlay.style.display = 'flex';  // Show overlay
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.style.flexDirection = 'column';

    // Hide overlay after the specified delay
    setTimeout(() => {
        overlay.style.display = 'none';  // Hide overlay
    }, delay);
}

// Function to simulate the color identification process
function startColorIdentificationProcess() {
    // Show Pixel Data Overlay and remove it after 4 seconds
    showOverlay('pixelDataOverlay', 4000);
    
    // Show RGB Formula Overlay and remove it after 4 seconds
    setTimeout(() => {
        showOverlay('formulaOverlay', 4000);
    }, 4000); // 4 seconds delay between overlays
}

// Add event listener to the "Proceed to Color Identification" button
document.getElementById('proceedToColorIdentification').addEventListener('click', function() {
    startColorIdentificationProcess();  // Start the process when the button is clicked
});

// Handle the transition when clicking "Next Round"
document.getElementById("nextRoundButton").addEventListener("click", function() {
    document.getElementById("rgb-color-analysis").style.display = "none";
    document.getElementById("color-identification-done").style.display = "block";

});
    </script>
</body>
</html>
