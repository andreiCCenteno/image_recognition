<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Press Start 2P', cursive;
}

body {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    position: relative;
    background-color: #000;
}

/* Background Styles */
.game-background {
    position: absolute;
    inset: 0;
    background: #000;
    overflow: hidden;
}

/* Menu Container */
.menu-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Menu Buttons */
.menu-button {
    padding: 15px 30px;
    border: 2px solid #00ffa3;
    background: transparent;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-transform: uppercase;
    color: #00ffa3;
    text-decoration: none;
    text-shadow: 0 0 5px #00ffa3;
    box-shadow: 0 0 10px rgba(0, 255, 163, 0.3);
}

.menu-button:hover {
    background: #00ffa3;
    color: #000;
    box-shadow: 0 0 20px #00ffa3;
}

/* Bottom line effect */
.bottom-line {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 2px;
    background: #00ffa3;
    box-shadow: 0 0 20px #00ffa3;
}

/* Footer */
.footer {
    position: absolute;
    bottom: 20px;
    width: 100%;
    padding: 10px;
    color: #00ffa3;
    text-align: center;
    font-size: 12px;
    text-shadow: 0 0 5px #00ffa3;
}

/* Audio Controls */
#audio-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
}

.audio-btn {
    background: transparent;
    border: 2px solid #00ffa3;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    color: #00ffa3;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(0, 255, 163, 0.3);
}

.audio-btn:hover {
    background: #00ffa3;
    color: #000;
    box-shadow: 0 0 20px #00ffa3;
}

.audio-btn.disabled {
    border-color: #ff0000;
    color: #ff0000;
    box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
}

.audio-btn.disabled::after {
    content: '';
    position: absolute;
    width: 70%;
    height: 2px;
    background-color: #ff0000;
    transform: rotate(45deg);
    box-shadow: 0 0 5px #ff0000;
}

/* Modal Styles */
.modal {
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
    background: #111; /* Darker background for contrast */
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    color: #00ffa3;
    border: 2px solid #00ffa3;
    box-shadow: 0 0 20px #00ffa3, inset 0 0 20px #00ffa3;
}

.modal-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.modal-btn {
    padding: 10px 30px;
    border: 2px solid #00ffa3;
    background: transparent;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'Press Start 2P', cursive;
    font-size: 12px;
    color: #00ffa3;
    transition: all 0.3s ease;
}

.modal-btn:hover {
    background: #00ffa3;
    color: #000;
    box-shadow: 0 0 20px #00ffa3;
}

/* Dashboard Container */
.dashboard-container {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 400px;
    background: rgba(0, 0, 0, 0.8);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 20px #00ffa3, inset 0 0 20px #00ffa3;
}

h1, h2, h3 {
    color: #00ffa3;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 0 10px #00ffa3;
}

.statistics {
    background-color: rgba(255, 255, 255, 0.1); /* Slight transparency for better aesthetics */
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column; /* Arrange children in a column */
    gap: 10px; /* Space between items */
}

.stat-item {
    display: flex; /* Use flexbox for inner layout */
    justify-content: space-between; /* Space between label and value */
    padding: 10px;
    border: 1px solid rgba(0, 255, 163, 0.5); /* Light border for clarity */
    border-radius: 3px;
    transition: background 0.3s;
}

.stat-item:hover {
    background: rgba(0, 255, 163, 0.1); /* Highlight on hover */
}

.stat-label {
    font-weight: bold; /* Make labels stand out */
    color: #00ffa3; /* Neon teal for labels */
}

.stat-value {
    color: #00ffa3; /* Neon teal for values */
}

/* Responsive Design */
@media (max-width: 768px) {
    .menu-container {
        width: 90%;
        padding: 20px;
    }

    .menu-button {
        font-size: 14px;
        padding: 12px 20px;
    }

    .dashboard-container {
        width: 90%; /* Make dashboard responsive */
        padding: 20px;
    }
}

.back-button:hover {
        background-color: #00d1b2;
        transform: scale(1.1);
    }

    .back-button:focus {
        outline: 2px solid #00ffcc;
        outline-offset: 4px;
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


</style>
</head>
<body>
<a href="{{ route('mainmenu') }}" class="back-button" title="Back">&larr;</a>
    <div class="dashboard-container">
        <h1>Your Game Dashboard</h1>
        <div class="statistics">
            <h2>Statistics</h2>
            <div class="stat-item">
                <span class="stat-label">Total Wins:</span>
                <span class="stat-value">{{ $totalWins }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Success Rate:</span>
                <span class="stat-value">{{ $successRate }}%</span>
            </div>
            <h3>Score</h3>
            <ul class="stat-item">
                <li class="stat-value">{{ $score }}</li>
            </ul>
            <h3>Post-Test Performance</h3>
            <div class="stat-item">
                <span class="stat-label">Easy:</span>
                <span class="stat-value">{{ $easyPostTestPerformance }}%</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Medium:</span>
                <span class="stat-value">{{ $mediumPostTestPerformance }}%</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Hard:</span>
                <span class="stat-value">{{ $hardPostTestPerformance }}%</span>
            </div>
            <h3>Your Ranking</h3>
            <div class="stat-item">
                <span class="stat-label">Rank:</span>
                <span class="stat-value">{{ $ranking }}</span>
            </div>
        </div>
    </div>
</body>

</html>
