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
    display: flex; /* Default for visibility */
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
    </style>
</head>
<body>
    <div class="container">
        <!-- Dynamic Story Introduction -->
        <div id="story">
            <div class="artifact"></div>
            <div class="dialogue" id="dialogue">
                Good Work, final mission! Now its time to implement all of your learning in real-life.
            </div>
            <div class="buttons">
                <button class="btn" id="startGame" onclick="startGame()">Next</button>
            </div>
        </div>

        <div id="Post-Process" style="display: none;">
            <div class="dialogue">
                As you prepare to find all the object?
                <br><br>
                This is your final task to complete. You successfully finish all the mission to know how image recognition works.
                <br><br>
                Now, you must proceed to the next task: find the object.
            </div>

            <div class="buttons">
                <button class="btn" id="proceedToNext" onclick="proceedToNext()">Proceed</button>
            </div>
        </div>

        <div id="post-analysis" style="display: none;">
            <div class="dialogue">
                Now, we move on to the last mission, Object Detection!
                <br><br>
                In this phase, all the learning you have learned you'll focus on identifying the object hidden within the world. 
                <br><br>
            </div>
            
            <div class="buttons">
                <button class="btn" id="proceedToPost-Analysis" onclick="proceedToPostAnalysis()">Proceed to Object Detection</button>
            </div>
        </div>
        
    </div>

    <script>

        // Functions for progressing through the steps
        function startGame() {
            document.getElementById('story').style.display = 'none';
            document.getElementById('Post-Process').style.display = 'block';
        }

        function proceedToNext() {
            document.getElementById('Post-Process').style.display = 'none';
            document.getElementById('post-analysis').style.display = 'block';
        }

        function proceedToPostAnalysis() {
            window.location.href = "{{ route('stage4') }}"; // Restart the game
            document.getElementById('post-analysis').style.display = 'none';
            document.getElementById('thresholding').style.display = 'block';
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
    
    document.getElementById('filtering-gameContainer').style.display = 'none'; // Hide the current section
    document.getElementById('well-done').style.display = 'block';
    }
    
    </script>
</body>
</html>
