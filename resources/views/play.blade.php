<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Difficulty</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Roboto Mono', monospace;
            color: #00ffcc;
            text-align: center;
            background: linear-gradient(135deg, #ff0066, #ff9933, #ffff00, #33cc33, #0066ff, #9933ff);
            background-size: 400% 400%;
            animation: gradientAnimation 5s ease infinite; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .difficulty-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.7);
            max-width: 600px;
            margin: auto;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            margin-bottom: 30px;
            font-size: 3.5em;
            font-family: 'Orbitron', sans-serif;
        }

        .difficulty-button {
            width: 250px;
            margin: 15px;
            padding: 20px;
            font-size: 1.5em;
            color: #00ffcc;
            background: linear-gradient(135deg, #1a1a1a 25%, #333 100%);
            border: 2px solid #00ffcc;
            border-radius: 10px;
            cursor: pointer;
            text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .difficulty-button:hover {
            background: linear-gradient(135deg, #333 25%, #1a1a1a 100%);
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            transform: scale(1.05);
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            cursor: pointer;
            text-align: center;
            line-height: 50px;
            font-size: 1.5em;
            color: #00ffcc;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            z-index: 2;
        }

        .back-button:hover {
            background-color: #00d1b2;
            transform: scale(1.1);
        }

        /* Modal Container */
        .modal {
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
            text-align: center;
        }

        /* Modal Content */
        .modal-content {
            background-color: rgba(0, 0, 0, 0.9); 
            color: #00ffcc;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.7);
            z-index: 1001; 
        }

        .modal-button {
            background-color: #00ffcc;
            color: #000;
            border: 2px solid #00ffcc;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1.2em;
            margin-top: 10px;
            text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .modal-button:hover {
            background-color: #00d1b2;
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            transform: scale(1.05);
        }

        .close {
            color: #00ffcc;
            float: right;
            font-size: 1.5em;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: red;
        }

        /* Carousel Styles */
        .carousel {
            display: flex;
            overflow: hidden;
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .carousel-slide {
            min-width: 100%;
            transition: transform 0.5s ease;
        }

        .carousel-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .carousel-button {
            background-color: #00ffcc;
            color: #000;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .carousel-button:hover {
            background-color: #00d1b2;
        }

        /* Footer Styling */
        .footer {
            text-align: center;
            width: 100%;
            font-size: 0.8em;
            color: #00ffcc;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px 0;
            position: relative;
            z-index: 2;
            border-top: 2px solid #00ffcc;
            animation: slideInUp 1s ease-out;
        }

        .footer a {
            color: #00ffcc;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #00d1b2;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5em; /* Smaller font size for smaller screens */
            }

            .difficulty-button {
                width: 80%; /* Full width on smaller screens */
                font-size: 1.2em; /* Smaller font size for buttons */
                padding: 15px; /* Adjust padding */
            }

            .back-button {
                width: 40px; /* Smaller back button */
                height: 40px; /* Smaller back button */
                font-size: 1.2em; /* Smaller font size */
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2em; /* Even smaller font size for very small screens */
            }

            .difficulty-button {
                font-size: 1em; /* Further reduce button font size */
                padding: 10px; /* Further adjust padding */
            }

            .modal-button {
                font-size: 1em; /* Adjust modal button size */
            }
        }

        .modal {
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
            text-align: center;
        }

        /* Modal Content */
        .modal-content {
            background-color: rgba(0, 0, 0, 0.9); 
            color: #00ffcc;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.7);
            z-index: 1001; 
        }

        .modal-button {
            background-color: #00ffcc;
            color: #000;
            border: 2px solid #00ffcc;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1.2em;
            margin-top: 10px;
            text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .modal-button:hover {
            background-color: #00d1b2;
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            transform: scale(1.05);
        }

        .close {
            color: #00ffcc;
            float: right;
            font-size: 1.5em;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: red;
        }
    </style>
</head>
<body>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
<a href="{{ route('mainmenu') }}" class="back-button" title="Back">&larr;</a>
    <div class="difficulty-container">
        <h1>Select Difficulty</h1>
        <button class="difficulty-button" onclick="startGame('easy')">Easy</button>
        <button class="difficulty-button" onclick="startGame('medium')">Medium</button>
        <button class="difficulty-button" onclick="startGame('hard')">Hard</button>
    </div>
    <div id="tutorialModal" class="modal">
        <div class="modal-content">
            <span class="close" ></span>
            <h2>Tutorial</h2>
            <p>Welcome to the Image Comparison Game!</p>
            <p>Select your difficulty level to start:</p>
            <p><strong>Easy:</strong> Choose this if you're new to the game. You'll have plenty of time and chances to win!</p>
            <p><strong>Medium:</strong> A balanced challenge for players who have some experience.</p>
            <p><strong>Hard:</strong> For the experts! This level is challenging with less time and fewer attempts.</p>
            <button class="modal-button" onclick="startTutorial()">Start Tutorial!</button>
        </div>
    </div>

    <script>

function playClickSound() {
    var clickSound = document.getElementById('clickSound');
    clickSound.play();
}

// Attach the playClickSound function to all buttons and anchor tags on the page
document.querySelectorAll('button, a').forEach(function(element) {
    element.addEventListener('click', playClickSound);
});

window.onload = function() {
            const userId = localStorage.getItem('user_id');
            if (userId) {
                console.log("User ID:", userId);
                // Use the user ID for your game logic
            } else {
                console.warn("User ID not found in local storage.");
            }
        };

        function startTutorial() {
    fetch("{{ url('tutorial') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ is_tutorial: 1 }) // Send a request to update the database
    }).then(response => {
        if (response.ok) {
            window.location.href = "{{ url('tutorial') }}"; // Redirect to the tutorial page
        } else {
            alert("Error starting tutorial. Please try again.");
        }
    }).catch(error => {
        console.error("Error:", error);
    });
}

        function startGame(difficulty) {

            // localStorage.setItem('difficulty', difficulty); // Store difficulty level in localStorage
            if(difficulty === 'easy'){
                window.location.href = "{{ url('easy') }}";
            }else if(difficulty === 'medium'){
                window.location.href = "{{ url('medium') }}";
            }else if(difficulty === 'hard'){
                window.location.href = "{{ url('hard') }}";
            }
             // Update the URL for Laravel
        }
        function showTutorial() {
            document.getElementById('tutorialModal').style.display = 'flex'; // Show the tutorial modal
        }

        // Show the tutorial when the document is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
        // Check if the tutorial should be shown
        @if($tutorialShown)
            showTutorial();
        @endif
    });
    </script>
</body>
</html>
