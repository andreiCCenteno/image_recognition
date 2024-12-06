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
.stage-button, .modal-button {
    width: 400px;
    padding: 20px;
    font-size: 1.3em;
    color: #00fff0; /* Updated text color for better visibility */
    background: linear-gradient(145deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3));
    border: 2px solid #00ffcc;
    border-radius: 15px;
    cursor: pointer;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.3); /* Stronger text shadow */
    transition: all 0.4s ease;
    box-shadow: 
        0 0 20px rgba(0, 255, 163, 0.1), /* Outer glow */
        inset 0 0 10px rgba(0, 255, 204, 0.1); /* Inner glow */
    margin: 15px 0; /* Adds spacing between buttons */
    position: relative;
    overflow: hidden;
}

.stage-button::before, .modal-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 300%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
    transition: all 0.6s ease;
    transform: skewX(-45deg);
}

.stage-button:hover::before, .modal-button:hover::before {
    left: 100%;
}

.stage-button:hover, .modal-button:hover {
    background: linear-gradient(145deg, rgba(0, 255, 204, 0.3), rgba(0, 0, 0, 0.7));
    color: #000;
    box-shadow: 
        0 0 30px #00ffcc, 
        inset 0 0 15px #00ffcc;
    transform: scale(1.1);
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


        .stage-button:disabled {
            color: #888;
            border-color: #888;
            cursor: not-allowed;
        }

        .stage-button i {
            font-size: 1.2em;
        }

        .stage-button:hover:enabled {
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
    <h1>Select Stage</h1>

    <!-- Pre-Processing Button (always enabled) -->
    <button class="stage-button" onclick="window.location.href='{{ url('preprocessing') }}'">Pre-Processing</button>

    <!-- Post-Processing Button (disabled by default, enabled after pre-processing is complete) -->
    <button class="stage-button" id="postProcessingButton" 
    @if(!$preprocessing_complete) 
        onmouseover="showTooltip(event, 'Complete pre-processing to unlock post-processing.')" 
        onmouseout="hideTooltip()" disabled 
    @else 
        onclick="window.location.href='{{ url('postprocessing') }}'" 
    @endif>
    @if(!$preprocessing_complete)
        <i class="fas fa-lock"></i> Post-Processing
    @else
        Post-Processing
    @endif
    </button>

    <button class="stage-button" id="tutorialButton" onclick="window.location.href='{{ url('tutorial') }}'">Tutorial</button>
</div>

<div id="tutorialModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTutorialModal()">&times;</span>
        <h2>Tutorial</h2>
        <p>Welcome to the Image Processing Game!</p>
        <p>Select your stage to start:</p>
        <p><strong>Pre-Processing:</strong> Begin here to learn the basics of preparing images for analysis. Completing this stage unlocks Post-Processing.</p>
        <p><strong>Post-Processing:</strong> Learn advanced techniques to enhance or analyze images. This stage will be unlocked after completing Pre-Processing.</p>
        <button class="modal-button" onclick="startTutorial()">Start Tutorial!</button>
        <button class="modal-button" onclick="closeTutorialModal()">Skip Tutorial</button>
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
            const savedVolume = localStorage.getItem('musicVolume');
            bgMusic.volume = savedVolume ? parseFloat(savedVolume) : 0.5;
            bgMusic.play().catch(function(error) {
                console.error("Music play failed:", error);
            });
        }
    }

    // Mark the page as fully loaded and attempt to play music
    window.onload = function() {
        isPageFullyLoaded = true;
        playBackgroundMusic();
    };

    // Attach the playClickSound function to all buttons and anchor tags on the page
    document.querySelectorAll('button, a').forEach(function(element) {
        element.addEventListener('click', playClickSound);
    });

    // Function to show the tutorial modal
    function showTutorial() {
        document.getElementById('tutorialModal').style.display = 'flex';
    }

    // Function to close the tutorial modal
    function closeTutorialModal() {
        document.getElementById('tutorialModal').style.display = 'none';
    }

    // Show the tutorial when the document is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        @if($tutorialShown)
            showTutorial();
        @endif

        @if($preprocessing_complete && $postprocessing_notif == 0)
            unlockPostProcessingNotification();
        @endif
    });

    function unlockPostProcessingNotification() {
        document.getElementById('postProcessingButton').disabled = false;
        document.getElementById('postProcessingButton').innerHTML = 'Post-Processing';
    }
</script>
</body>


<!-- Add FontAwesome CDN for lock icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>