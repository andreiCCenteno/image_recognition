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

        .feedback {
            margin-top: 20px;
            font-size: 18px;
        }
        .formula {
            font-size: 16px;
            font-style: italic;
            margin-bottom: 15px;
        }

        #filtering-gameContainer {
            flex-direction: column;
            justify-content: center;
            padding: 20px;
            margin-top: 30px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: transparent;
        }

        .container-interactions {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        #Post-Process,
        #post-analysis,
        #thresholding {
            flex-wrap: wrap;
            flex-direction: column;
            width: 100%;
        }

        #inputs-container {
            display: flex;
            flex-direction: column;
            line-height: 50px;
            width: 100%;
        }

        #inputs-container .confidence-input-container > input[type="number"] {
            height: 30px;
            border: 2px solid #ccc;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        #inputs-container .confidence-input-container > input[type="number"]:hover, 
        #inputs-container .confidence-input-container > input[type="number"]:focus {
            border-color: #00cc77;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
        }

        #inputs-container .confidence-input-container > input[type="number"]:focus {
            outline: none;
        }

        .confidence-input-container {
            display: inline-flex;
            width: auto;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Dynamic Story Introduction -->
        <div id="story">
            <div class="artifact"></div>
            <div class="dialogue" id="dialogue">
                Good Work, on your second mission! Now lets move on to your final mission.
            </div>
            <div class="buttons">
                <button class="btn" id="startGame" onclick="startGame()">Next</button>
            </div>
        </div>

        <div id="Post-Process" style="display: none;">
            <div class="dialogue">
                As you prepare to unlock the secrets of the artifact, you take a deep breath. Its surface holds ancient mysteries that could change history forever.
                <br><br>
                The Second task is complete. You successfully enhanced the artifact’s image, revealing hidden colors that were long obscured. The ancient secrets are slowly starting to come to light.
                <br><br>
                With this breakthrough, you've uncovered the secrets hidden within the artifact. Now, you must proceed to the next task: identifying the image that is blurred.
            </div>

            <div class="buttons container-interactions">
                <button class="btn" id="proceedToNext" onclick="proceedToNext()">Proceed</button>
            </div>
        </div>

        <div id="post-analysis" style="display: none;">
            <div class="dialogue">
                Now, we move on to the last important task: Post Analysis. 
                <br><br>
                In this phase, you'll focus on identifying the image hidden within the artifact’s imperfection/blurred. 
                <br><br>
                Analyzing the artifact will help uncover hidden patterns that can reveal deeper insights into its meaning.
            </div>
            
            <div class="buttons container-interactions">
                <button class="btn" id="proceedToPost-Analysis" onclick="proceedToPostAnalysis()">Proceed with Post-Analysis</button>
            </div>
        </div>

        <div id="thresholding" style="display: none;">
            <div class="dialogue">
                The first step is Thresholding and Filtering. 
                <br><br>
                In this phase, you'll focus on refining the artifact by separating significant features from the background using thresholding techniques. 
                <br><br>
                Analyzing the artifact through this process will help uncover hidden patterns and enhance its clarity, providing deeper insights into its structure and meaning.
            </div>
            <div class="buttons container-interactions">
                <button class="btn" id="proceedToThresholding" onclick="proceedToThresholding()">Proceed</button>
            </div>
        </div>

        <div id="well-done" style="display: none;">
    <div class="dialogue">
        Excellent work! You've successfully completed all the tasks and unlocked the mysteries of the artifact. Your sharp analysis and problem-solving skills have led to an invaluable discovery. 
        <br><br>
        This achievement is a testament to your dedication and expertise. You are now ready to face even greater challenges ahead.
    </div>
</div>

    <div id="filtering-gameContainer" style="display: none;">
        <h1>Filtering and Thresholding</h1>
        <p>Use the softmax formula to calculate the confidence score for each target image.</p>
        
        <div class="formula">
            <p><strong>Softmax Formula:</strong></p>
            <p>
                <code>
                    Confidence Score = <sup>e<sup>𝑧<sub>i</sub></sup></sup> / ∑<sub>j</sub> e<sup>𝑧<sub>j</sub></sup>
                </code>
            </p>
            <p>Where:</p>
            <ul>
                <li><strong>𝑧<sub>i</sub></strong>: Logit (raw score) for the predicted class.</li>
                <li><strong>∑<sub>j</sub> e<sup>𝑧<sub>j</sub></sup></strong>: Sum of exponentials of all logits for all classes.</li>
            </ul>
        </div>

        <div class="image-container">
            <h3>Target Image:</h3>
            <img src="images/cat.jpg" alt="Target Image" id="target-image">
            
            <h3>Logits for this Image:</h3>
            <div id="logits-container"></div>

            <div id="inputs-container"></div>

            <div class="container-interactions" style="margin-top: 20px;">
                <button class="btn" onclick="checkAnswers()">Submit</button>
            </div>
            <div class="feedback" id="feedback"></div>
        </div>
        <div class="container-interactions" style="margin-top: 20px;">
            <button class="btn" id="nextButton" onclick="proceedToNextStep()" style="display: none;">Next</button>
        </div>
    </div>

    
    </div>

    <script>
        // List of available categories
        const categories = ["Cat", "Dog", "Bird", "Elephant", "Lion", "Tiger", "Horse", "Rabbit", "Fish"];

        // Function to generate random logits
        function generateRandomLogits() {
            const min = -2; // Minimum logit value
            const max = 3;  // Maximum logit value
            return Math.random() * (max - min) + min;
        }

        // Function to select 3 random categories and generate logits
        function getRandomCategoriesAndLogits() {
            const selectedCategories = [];
            const selectedLogits = {};

            while (selectedCategories.length < 3) {
                const randomIndex = Math.floor(Math.random() * categories.length);
                const category = categories[randomIndex];
                if (!selectedCategories.includes(category)) {
                    selectedCategories.push(category);
                    selectedLogits[category] = generateRandomLogits();
                }
            }

            return { selectedCategories, selectedLogits };
        }

        // Get random categories and logits
        const { selectedCategories, selectedLogits } = getRandomCategoriesAndLogits();

        // Display the selected categories and logits
        const logitsContainer = document.getElementById("logits-container");
        selectedCategories.forEach(category => {
            const logitText = document.createElement("p");
            logitText.innerHTML = `<strong>${category}:</strong> Logit = <span id="${category}-logit">${selectedLogits[category].toFixed(2)}</span>`;
            logitsContainer.appendChild(logitText);
        });

        // Create input fields dynamically for each category
        const inputsContainer = document.getElementById("inputs-container");
        selectedCategories.forEach(category => {
            const divContainer = document.createElement('div');
            divContainer.className = 'confidence-input-container';

            const inputLabel = document.createElement("label");
            inputLabel.setAttribute("for", `${category}-score`);
            inputLabel.innerHTML = `Confidence Score for ${category}:`;

            const input = document.createElement("input");
            input.type = "number";
            input.id = `${category}-score`;
            input.placeholder = `Enter score for ${category}`;

            divContainer.append(inputLabel, input);
            inputsContainer.appendChild(divContainer);
        });

        // Softmax formula implementation
        function softmax(logits) {
            const expLogits = Object.values(logits).map(logit => Math.exp(logit));
            const sumExpLogits = expLogits.reduce((sum, value) => sum + value, 0);
            const probabilities = expLogits.map(expLogit => expLogit / sumExpLogits);
            return probabilities;
        }

        // Function to check answers and provide feedback
        function checkAnswers() {
            const inputs = selectedCategories.map(category => {
                const inputValue = parseFloat(document.getElementById(`${category}-score`).value);
                return { category, inputValue };
            });

            const probabilities = softmax(selectedLogits);

            let correct = true;
            inputs.forEach(({ category, inputValue }) => {
                const expectedProbability = probabilities[selectedCategories.indexOf(category)];
                const difference = Math.abs(inputValue - expectedProbability);
                if (difference > 0.1) { // Threshold for checking if the answer is close enough
                    correct = false;
                }
            });

            const feedbackElement = document.getElementById("feedback");
            if (correct) {
                feedbackElement.innerHTML = "Correct! You've calculated the probabilities correctly.";
                nextButton.style.display = 'block'; 
            } else {
                feedbackElement.innerHTML = "Incorrect. Please try again!";
            }
        }

        // Functions for progressing through the steps
        function startGame() {
            document.getElementById('story').style.display = 'none';
            document.getElementById('Post-Process').style.display = 'flex';
        }

        function proceedToNext() {
            document.getElementById('Post-Process').style.display = 'none';
            document.getElementById('post-analysis').style.display = 'flex';
        }

        function proceedToPostAnalysis() {
            document.getElementById('post-analysis').style.display = 'none';
            document.getElementById('thresholding').style.display = 'flex';
        }

        function proceedToThresholding() {
        console.log("Proceeding to Thresholding..."); // Debugging message

        // Hide the current section
        const thresholdingSection = document.getElementById('thresholding');
        if (thresholdingSection) {
            thresholdingSection.style.display = 'none';
        } else {
            console.error("Element with ID 'thresholding' not found!");
        }

        // Show the filtering game container
        const filteringGameContainer = document.getElementById('filtering-gameContainer');
        if (filteringGameContainer) {
            filteringGameContainer.style.display = 'flex';
            console.log("Filtering Game Container is now visible.");
        } else {
            console.error("Element with ID 'filtering-gameContainer' not found!");
        }
    }

    function proceedToNextStep() {
    setTimeout(() => {
        window.location.href = "{{ route('stage3') }}"; // Restart the game
    }, 3000);
    document.getElementById('filtering-gameContainer').style.display = 'none'; // Hide the current section
    document.getElementById('well-done').style.display = 'block';
}
    
    </script>
</body>
</html>
