<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Difficulty</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Press Start 2P', cursive;
}

body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    color: #00ffcc;
    text-align: center;
    background: radial-gradient(circle at center, #000000 20%, #111111 60%, #000000);
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1;
}

/* Container */
.difficulty-container {
    background: rgba(0, 0, 0, 0.8);
    padding: 50px;
    border-radius: 15px;
    box-shadow: 0 0 20px #00ffa3, inset 0 0 20px #00ffa3;
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
    text-shadow: 0 0 10px #00ffa3;
    margin-bottom: 30px;
    font-size: 3.5em;
}

/* Buttons */
.difficulty-button, .modal-button {
    width: 250px;
    padding: 20px;
    font-size: 1.5em;
    color: #00ffcc;
    background: transparent;
    border: 2px solid #00ffcc;
    border-radius: 10px;
    cursor: pointer;
    text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(0, 255, 163, 0.3);
}

.difficulty-button:hover, .modal-button:hover {
    background: #00ffcc;
    color: #000;
    box-shadow: 0 0 20px #00ffcc;
    transform: scale(1.05);
}

/* Back Button */
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

/* Modal */
#tutorialModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #1a1a1a;
    padding: 25px 30px;
    border-radius: 10px;
    color: #00ffa3;
    border: 2px solid #00ffa3;
    box-shadow: 0 0 15px rgba(0, 255, 163, 0.7), inset 0 0 15px rgba(0, 255, 163, 0.4);
    max-width: 500px;
    width: 100%;
    text-align: center;
}

.modal-content h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #00ffb7;
}

.modal-content p {
    font-size: 16px;
    line-height: 1.6;
    color: #d4ffd6;
    margin-bottom: 15px;
}

.modal-button {
    background-color: #00ffa3;
    color: #1a1a1a;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

.modal-button:hover {
    background-color: #00cc85;
}

.close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    color: #00ffa3;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover {
    color: #00cc85;
}


/* Footer */
footer {
    position: absolute;
    bottom: 20px;
    width: 100%;
    color: #00ffcc;
    font-size: 0.9em;
    text-shadow: 0 0 5px rgba(0, 255, 204, 0.5);
    z-index: 2;
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

        .modal{
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

        .difficulty-button:disabled {
            color: #888;
            border-color: #888;
            cursor: not-allowed;
        }

        .difficulty-button i {
            font-size: 1.2em;
        }

        .difficulty-button:hover:enabled {
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
        .tooltip {
        position: absolute;
        background-color: #333;
        color: #fff;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 14px;
        display: none;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none; /* Prevent tooltip from blocking hover events */
    }
    .tooltip.show {
        display: block;
        opacity: 1;
    }
    </style>
</head>
<body>
<audio id="bgMusic" src="{{ asset('music/background-music.mp3') }}" autoplay loop></audio>
<audio id="clickSound" src="{{ asset('audio/click-sound.mp3') }}" preload="auto"></audio>
<a href="{{ route('mainmenu') }}" class="back-button" title="Back">&larr;</a>
<div id="tooltip" class="tooltip"></div>
<div class="difficulty-container">
    <h1>Select Difficulty</h1>

    <!-- Easy Button (always enabled) -->
    <button class="difficulty-button" onclick="window.location.href='{{ url('easy') }}'">Easy</button>

    <!-- Medium Button (disabled by default, enabled after easy_finish) -->
    <button class="difficulty-button" id="mediumButton" 
    @if(!$easy_finish) onmouseover="showTooltip(event, 'Finish easy mode to unlock medium mode.')" onmouseout="hideTooltip()" disabled 
    @else onclick="window.location.href='{{ url('medium') }}'" @endif>
    @if(!$easy_finish)
        <i class="fas fa-lock"></i> Medium
    @else
        Medium
    @endif
</button>

<!-- Hard Button (disabled by default, enabled after medium_finish) -->
<button class="difficulty-button" id="hardButton" 
    @if(!$medium_finish) onmouseover="showTooltip(event, 'Finish medium mode to unlock hard mode.')" onmouseout="hideTooltip()" disabled 
    @else onclick="window.location.href='{{ url('hard') }}'" @endif>
    @if(!$medium_finish)
        <i class="fas fa-lock"></i> Hard
    @else
        Hard
    @endif
</button>

<button class="difficulty-button" id="hardButton" onclick="window.location.href='{{ url('tutorial') }}'" >Tutorial</button>
    
</div>
<div id="tutorialModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTutorialModal()">&times;</span>
        <h2>Tutorial</h2>
        <p>Welcome to the Image Comparison Game!</p>
        <p>Select your difficulty level to start:</p>
        <p><strong>Easy:</strong> Start here if you're new to the game. Completing this level will unlock Medium mode. You'll have plenty of time and chances to win!</p>
        <p><strong>Medium:</strong> This mode will be unlocked after completing Easy. A balanced challenge for players who have some experience.</p>
        <p><strong>Hard:</strong> Unlock this level by finishing Medium mode. It's designed for experts and is challenging, with less time and fewer attempts.</p>
        <button class="modal-button" onclick="startTutorial()">Start Tutorial!</button>
        <button class="modal-button" onclick="closeTutorialModal()">Skip Tutorial</button>
    </div>
</div>

    <div id="mediumNotificationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMediumNotification()">&times;</span>
        <h2>Medium Unlocked!</h2>
        <p>Congratulations! You have unlocked the Medium difficulty level.</p>
        <button class="modal-button" onclick="closeMediumNotification()">Okay</button>
    </div>
</div>

<!-- Hard Notification Modal -->
<div id="hardNotificationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeHardNotification()">&times;</span>
        <h2>Hard Unlocked!</h2>
        <p>Congratulations! You have unlocked the Hard difficulty level.</p>
        <button class="modal-button" onclick="closeHardNotification()">Okay</button>
    </div>
</div>
<script>
    let isPageFullyLoaded = false;


    function showTooltip(event, message) {
        const tooltip = document.getElementById('tooltip');
        tooltip.textContent = message;
        tooltip.style.top = `${event.clientY - 40}px`; // Position tooltip above the cursor
        tooltip.style.left = `${event.clientX}px`;
        tooltip.classList.add('show');
    }

    function hideTooltip() {
        const tooltip = document.getElementById('tooltip');
        tooltip.classList.remove('show');
    }
// Function to play background music
function playBackgroundMusic() {
    const bgMusic = document.getElementById('bgMusic');
    if (isPageFullyLoaded && bgMusic) {
        // Retrieve volume from local storage or set default value
        const savedVolume = localStorage.getItem('musicVolume');
        bgMusic.volume = savedVolume ? parseFloat(savedVolume) : 0.5; // Default volume is 0.5
        bgMusic.play().catch(function(error) {
            console.error("Music play failed:", error);
        });
    }
}

// Mark the page as fully loaded and attempt to play music
window.onload = function() {
    isPageFullyLoaded = true; // Set the boolean flag to true
    playBackgroundMusic(); // Attempt to play music

    // Existing user ID logic
    const userId = localStorage.getItem('user_id');
    if (userId) {
        console.log("User ID:", userId);
        // Use the user ID for your game logic
    } else {
        console.warn("User ID not found in local storage.");
    }

    // Check if easy_finish is 1 and show Medium notification if so
};

// Function to play the click sound
function playClickSound() {
    var clickSound = document.getElementById('clickSound');
    const savedVolume = localStorage.getItem('sfxVolume');
    clickSound.volume = savedVolume ? parseFloat(savedVolume) : 0.5;
    clickSound.play();
}

// Attach the playClickSound function to all buttons and anchor tags on the page
document.querySelectorAll('button, a').forEach(function(element) {
    element.addEventListener('click', playClickSound);
});

// Rest of your existing code
function unlockMediumNotification() {
    document.getElementById('mediumNotificationModal').style.display = 'flex'; // Show the Medium notification modal
    document.getElementById('mediumButton').disabled = false; // Enable the Medium button
    document.getElementById('mediumButton').innerHTML = 'Medium'; // Update button text
    updateMediumNotification(); // Call function to update medium_notif in the database
}

function closeMediumNotification() {
    document.getElementById('mediumNotificationModal').style.display = 'none'; // Hide the Medium notification modal
}

function unlockHardNotification() {
    document.getElementById('hardNotificationModal').style.display = 'flex'; // Show the Hard notification modal
    document.getElementById('hardButton').disabled = false; // Enable the Hard button
    document.getElementById('hardButton').innerHTML = 'Hard'; // Update button text
    updateHardNotification(); // Call function to update hard_notif in the database
}

function closeHardNotification() {
    document.getElementById('hardNotificationModal').style.display = 'none'; // Hide the Hard notification modal
}

function updateMediumNotification() {
    fetch("{{ url('update-medium-notif') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ medium_notif: 1 }) // Send a request to update medium_notif in the database
    }).then(response => {
        if (!response.ok) {
            console.error("Error updating medium_notif:", response.statusText);
        }
    }).catch(error => {
        console.error("Error:", error);
    });
}

function updateHardNotification() {
    fetch("{{ url('update-hard-notif') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ hard_notif: 1 }) // Send a request to update hard_notif in the database
    }).then(response => {
        if (!response.ok) {
            console.error("Error updating hard_notif:", response.statusText);
        }
    }).catch(error => {
        console.error("Error:", error);
    });
}

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

function completeEasyGame() {
    unlockDifficultyLevels();
}

function unlockDifficultyLevels() {
    // Enable Medium and Hard buttons after Easy game completion
    document.getElementById('mediumButton').disabled = false;
    document.getElementById('hardButton').disabled = false;

    // Update button text by removing lock icon
    document.getElementById('mediumButton').innerHTML = 'Medium';
    document.getElementById('hardButton').innerHTML = 'Hard';
}

function showTutorial() {
    document.getElementById('tutorialModal').style.display = 'flex'; // Show the tutorial modal
}

function closeTutorialModal() {
        document.getElementById('tutorialModal').style.display = 'none';
    }

// Show the tutorial when the document is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if the tutorial should be shown
    @if($tutorialShown)
        showTutorial();
    @endif

    // Check if easy_finish is 1 and medium_notif is 0
    @if($easy_finish && $medium_notif == 0)
        unlockMediumNotification();
    @endif

    // Check if medium_finish is 1 and hard_notif is 0
    @if($medium_finish && $hard_notif == 0)
        unlockHardNotification();
    @endif
});
</script>

<!-- Add FontAwesome CDN for lock icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>