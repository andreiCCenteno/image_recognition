<!DOCTYPE html>
<html>

<head>
    <title>Image Processing Card Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        #gameContainer {
            width: 800px;
            margin: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
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
        }

        #gameScene {
            border: 2px solid #333;
            background: white;
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
            background: white;
            overflow: hidden;
        }

        .card-front img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .card-back {
            background: #4CAF50;
            transform: rotateY(180deg);
        }

        .card-back::after {
            content: "?";
            font-size: 48px;
            color: white;
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
            background: white;
            border-radius: 8px;
            font-weight: bold;
        }

        #message {
            text-align: center;
            font-size: 1.2em;
            margin: 10px 0;
            min-height: 30px;
            color: #333;
        }

        #guessContainer {
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        #guessInput {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #333;
        }

        #submitGuess {
            padding: 10px 20px;
            font-size: 16px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #submitGuess:hover {
            background: #45a049;
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
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
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
        }

        .modal button:hover {
            background: #45a049;
        }

        /* Add this to your existing styles */
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

                /* Level 3 specific styles */
                #level3Content {
            display: none;
            width: 100%;
            padding: 20px;
        }

        .feature-matching-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .main-image-container {
            width: 400px;
            height: 400px;
            position: relative;
            border: 2px solid #333;
            margin-right: 20px;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .feature-dropzone {
            position: absolute;
            border: 2px dashed #4CAF50;
            background: rgba(76, 175, 80, 0.1);
            cursor: pointer;
        }

        .features-panel {
            width: 200px;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .feature-item {
            width: 180px;
            height: 100px;
            margin: 10px 0;
            border: 2px solid #333;
            cursor: grab;
            position: relative;
            overflow: hidden;
        }

        .feature-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Progress indicator */
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #eee;
            border-radius: 10px;
            margin: 10px 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #4CAF50;
            width: 0%;
            transition: width 0.3s ease;
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
    background-color: rgba(255, 0, 0, 0.5); /* Semi-transparent red */
    border: 2px solid red; /* Optional border */
    pointer-events: none; /* Allow clicks to pass through */
}

    </style>
</head>

<body>
    

    <div id="gameContainer">
        <div id="stats">
            <div>Level: <span id="level">1</span></div>
            <div>Player HP: <span id="playerHp">100</span></div>
            <div>Monster HP: <span id="monsterHp">100</span></div>
        </div>

        <canvas id="gameScene" width="800" height="300"></canvas>

        <!-- Level 1 Content -->
        <div id="level1Content">
            <div id="imageDisplay">
                <img id="targetImage" src="" alt="Target image">
            </div>
            <div id="message">Find the correct outline!</div>
            <div id="cardsContainer"></div>
        </div>

        <!-- Level 2 Content -->
        <div id="level2Content" style="display: none; text-align: center;">
            <div id="blurredImageContainer">
                <img id="blurredImage" src="" alt="Blurred image">
            </div>
            <div id="guessContainer">
                <input type="text" id="guessInput" placeholder="What's in the image?">
                <button id="submitGuess">Submit Guess</button>
            </div>
        </div>
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

    <div class="modal-overlay" id="level2CompleteModal">
        <div class="modal">
            <h2>Level 2 Complete!</h2>
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 3: Feature Extraction Challenge!</p>
            <button onclick="startLevel3()">Start Level 3</button>
        </div>
    </div>

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
                <img class="main-image" id="mainImage" src="/api/placeholder/400/400" alt="Main image">
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
            <p>Excellent work! You've mastered the image recognition challenge.</p>
            <p>Get ready for Level 3: Feature Extraction Challenge!</p>
            <button onclick="startLevel4()">Start Level 4</button>
        </div>
    </div>

    <div id="level4Content" style="display: none;">
        <h2>Level 4: Color Identification</h2>
        <p>Use the sliders to select the dominant color in the image below:</p>
        
        <div>
            <img id="colorImage" src="/api/placeholder/400/400" alt="Color Image">
        </div>
    
        <div>
            <label for="redSlider">Red</label>
            <input type="range" id="redSlider" min="0" max="255" value="0">
            <span id="redValue">0</span>
            
            <label for="greenSlider">Green</label>
            <input type="range" id="greenSlider" min="0" max="255" value="0">
            <span id="greenValue">0</span>
            
            <label for="blueSlider">Blue</label>
            <input type="range" id="blueSlider" min="0" max="255" value="0">
            <span id="blueValue">0</span>
            
            <button id="submitColor">Submit Color</button>
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
        
    <div id="level5Content" style="display: none;">
        <h2>Level 5: Object Detection</h2>
        <p>Click on the placeholder image to simulate object detection (real detection zones will be added later).</p>
    
        <div class="object-detection-container" style="position: relative;">
            <img id="objectImage" src="https://via.placeholder.com/600x400" alt="Placeholder Image" style="max-width: 100%; cursor: pointer;">
            
            <!-- Large Detection Zones -->
            <div class="detection-zone" style="left: 100px; top: 150px; width: 100px; height: 100px;"></div>
            <div class="detection-zone" style="left: 300px; top: 100px; width: 100px; height: 100px;"></div>
            <div class="detection-zone" style="left: 450px; top: 250px; width: 100px; height: 100px;"></div>
    
            <!-- Small Detection Zones -->
            <div class="detection-zone" style="left: 50px; top: 200px; width: 50px; height: 50px;"></div>
            <div class="detection-zone" style="left: 200px; top: 250px; width: 50px; height: 50px;"></div>
            <div class="detection-zone" style="left: 500px; top: 300px; width: 50px; height: 50px;"></div>

        </div>
    
        <div id="detectedObjectsList"></div>
    
        <button id="submitDetection">Submit Detection</button>
    </div>
        
        <div class="modal-overlay" id="level5CompleteModal" style="display: none;">
            <div class="modal">
                <h2>Level 5 Complete!</h2>
                <p>You've completed the object detection level.</p>
                <button onclick="takeposttest()">Take Post-Test</button>
            </div>
        </div>        

        <div id="postTestContainer" style="display: none;">
            <h2>Post-Test</h2>
            <div id="questionsContainer">
                <div class="question" id="question1">
                    <p>1. What is the primary purpose of image recognition in this game?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q1" value="a"> A. To identify outlines of objects</label>
                        <label class="option"><input type="radio" name="q1" value="b"> B. To compare image colors</label>
                        <label class="option"><input type="radio" name="q1" value="c"> C. To recognize features within an image</label>
                        <label class="option"><input type="radio" name="q1" value="d"> D. To generate random images</label>
                    </div>
                </div>
    
                <div class="question" id="question2">
                    <p>2. How does the color identification challenge work?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q2" value="a"> A. By selecting the correct color from a palette</label>
                        <label class="option"><input type="radio" name="q2" value="b"> B. By guessing the color based on the image</label>
                        <label class="option"><input type="radio" name="q2" value="c"> C. By using an RGB slider to find the dominant color</label>
                        <label class="option"><input type="radio" name="q2" value="d"> D. By comparing colors with other images</label>
                    </div>
                </div>
    
                <div class="question" id="question3">
                    <p>3. What is the importance of feature extraction in image processing?</p>
                    <div class="options">
                        <label class="option"><input type="radio" name="q3" value="a"> A. It helps in reducing image resolution</label>
                        <label class="option"><input type="radio" name="q3" value="b"> B. It allows for the identification of specific patterns in images</label>
                        <label class="option"><input type="radio" name="q3" value="c"> C. It changes the colors of an image</label>
                        <label class="option"><input type="radio" name="q3" value="d"> B. It removes all details from an image</label>
                    </div>
                </div>
    
                <button id="submitTest">Submit Test</button>
            </div>
    
            <div id="results" style="display:none;">
                <h2>Results</h2>
                <p id="score"></p>
            </div>
        </div>
         
    <script>
    const gameState = {
    level: 1,
    playerHp: 100,
    monsterHp: 100,
    isAttacking: false,
    attackFrame: 0,
    shuffling: false,
    canClick: false,
    images: [
        {
            original: 'https://placehold.co/200x200',
            outlines: [
                'https://placehold.co/150x200',
                '/api/placeholder/150/200',
                '/api/placeholder/150/200'
            ]
        }
    ],
    level2Images: [
        {
            image: 'https://placehold.co/200x200',
            answer: 'cat'
        }
        // Add more level 2 images here
    ]
};

const gameScene = document.getElementById('gameScene');
const ctx = gameScene.getContext('2d');
const cardsContainer = document.getElementById('cardsContainer');
const targetImage = document.getElementById('targetImage');
const level1Content = document.getElementById('level1Content');
const level2Content = document.getElementById('level2Content');
const level4Content = document.getElementById('level4Content');
const blurredImage = document.getElementById('blurredImage');
const guessContainer = document.getElementById('guessContainer');
const guessInput = document.getElementById('guessInput');
const submitGuess = document.getElementById('submitGuess');

const cardWidth = 150;
const cardGap = 50;
const totalWidth = (cardWidth * 3) + (cardGap * 2);
const startX = (800 - totalWidth) / 2;

let cards = [];
let currentBlurLevel = 20;

function switchToLevel2() {
    level1Content.style.display = 'none';
    level2Content.style.display = 'block';
    guessContainer.style.display = 'flex';

    // Set up level 2
    const currentImage = gameState.level2Images[0];
    blurredImage.src = currentImage.image;
    blurredImage.style.filter = 'blur(0px)';

    // Start reducing blur
    setTimeout(() => {
        blurredImage.style.filter = 'blur(50px)';
    }, 10);
}

function takeposttest() {
    const modal = document.getElementById('level5CompleteModal');
    modal.style.display = 'none';
    document.getElementById('gameContainer').style.display = 'none';
    document.getElementById('postTestContainer').style.display = 'block';
       initializePostTest();
}

function startLevel5() {
    const modal = document.getElementById('level4CompleteModal');
    modal.style.display = 'none';
    gameState.level = 5;
    gameState.monsterHp = 100; 
    updateStats(); 
    initializeLevel5(); 
}

function startLevel4() {
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'none';
    gameState.level = 4;
    gameState.monsterHp = 100; 
    updateStats(); 
    initializeLevel4(); 
}


function startLevel3() {
    const modal = document.getElementById('level2CompleteModal');
    modal.style.display = 'none';
    gameState.level = 3;
    gameState.monsterHp = 100;
    updateStats();
    initializeLevel3();
}

submitGuess.addEventListener('click', () => {
    const guess = guessInput.value.toLowerCase().trim();
    const currentImage = gameState.level2Images[0];
    
    if (guess === currentImage.answer) {
        document.getElementById('message').textContent = "Correct! You identified the image!";
        gameState.monsterHp = 0; // Force monster defeat to trigger level completion
        showLevel2CompleteModal(); // Show level 2 completion modal
    } else {
        document.getElementById('message').textContent = "Wrong guess! Try again!";
        takeDamage();
    }
    
    guessInput.value = '';
});


function createCard(index, isCorrect) {
    const card = document.createElement('div');
    card.className = 'card';
    card.style.left = `${startX + (index * (cardWidth + cardGap))}px`;

    const front = document.createElement('div');
    front.className = 'card-face card-front';

    const outlineImg = document.createElement('img');
    const currentLevel = gameState.level - 1;
    outlineImg.src = isCorrect ?
        gameState.images[currentLevel].outlines[0] :
        gameState.images[currentLevel].outlines[index === 0 ? 1 : 2];
    front.appendChild(outlineImg);

    const back = document.createElement('div');
    back.className = 'card-face card-back';

    card.appendChild(front);
    card.appendChild(back);

    return { element: card, isCorrect: isCorrect };
}


function initializeGame() {
    // Hide all content first
    level1Content.style.display = 'none';
    level2Content.style.display = 'none';
    level3Content.style.display = 'none';
    level4Content.style.display = 'none';
    level5Content.style.display = 'none';

    // Show appropriate level content
    if (gameState.level === 1) {
        level1Content.style.display = 'block';
        initializeLevel1();
    } else if (gameState.level === 2) {
        level2Content.style.display = 'block';
        switchToLevel2();
    } else if (gameState.level === 3) {
        level3Content.style.display = 'block';
        initializeLevel3();
    } else if (gameState.level === 4) {
        level4Content.style.display = 'block';
        initializeLevel4();
    } else if (gameState.level == 5) {
        level5Content.style.display = 'block';
        initializeLevel5();
    }
}

function initializeLevel1() {
    cardsContainer.innerHTML = '';
    cards = [];
    targetImage.src = gameState.images[0].original;
    level1Content.style.display = 'block';

    const correctPosition = Math.floor(Math.random() * 3);

    for (let i = 0; i < 9; i++) {
        const cardData = createCard(i, i === correctPosition);
        cards.push(cardData);
        cardData.element.addEventListener('click', function () {
            handleCardClick(cardData);
        });
        cardsContainer.appendChild(cardData.element);
    }
}

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
    switchToLevel2();
}

function showLevel1CompleteModal() {
    const modal = document.getElementById('levelCompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel2CompleteModal() {
    const modal = document.getElementById('level2CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel3CompleteModal() {
    const modal = document.getElementById('level3CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel4CompleteModal() {
    const modal = document.getElementById('level4CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function showLevel5CompleteModal() {
    const modal = document.getElementById('level5CompleteModal');
    modal.style.display = 'flex';
    createConfetti();
}

function flipAllCards(faceDown = true) {
    cards.forEach(card => {
        if (faceDown) {
            card.element.classList.add('flipped');
        } else {
            card.element.classList.remove('flipped');
        }
    });
}

function shuffle() {
    if (gameState.shuffling) return;

    gameState.shuffling = true;
    gameState.canClick = false;
    document.getElementById('message').textContent = "Watch the cards shuffle...";

    let shuffles = 0;
    const maxShuffles = 15;

    const shuffleInterval = setInterval(() => {
        const pos1 = Math.floor(Math.random() * 9);
        const pos2 = Math.floor(Math.random() * 9);

        if (pos1 !== pos2) {
            // Update visual positions
            const left1 = cards[pos1].element.style.left;
            const left2 = cards[pos2].element.style.left;

            cards[pos1].element.style.left = left2;
            cards[pos2].element.style.left = left1;

            // Swap cards in array
            [cards[pos1], cards[pos2]] = [cards[pos2], cards[pos1]];
        }

        shuffles++;
        if (shuffles >= maxShuffles) {
            clearInterval(shuffleInterval);
            gameState.shuffling = false;
            gameState.canClick = true;
            document.getElementById('message').textContent = "Select the card with the correct Outline!";
        }
    }, 1000);
}

function handleCardClick(cardData) {
    if (!gameState.canClick || gameState.shuffling) return;

    gameState.canClick = false;
    flipAllCards(false);

    if (cardData.isCorrect) {
        document.getElementById('message').textContent = "Correct! You found the Outline";
        cardData.element.classList.add('victory');

        setTimeout(() => {
            attackMonster();
        }, 1500);

        setTimeout(() => {
            cardData.element.classList.remove('victory');
            if (gameState.monsterHp > 0 && gameState.playerHp > 0) {
                nextRound();
            }
        }, 2500);
    } else {
        document.getElementById('message').textContent = "Wrong card! Try again!";
        cardData.element.classList.add('wrong');

        const correctCard = cards.find(card => card.isCorrect);
        setTimeout(() => {
            correctCard.element.classList.add('correct-reveal');
        }, 500);

        setTimeout(() => {
            takeDamage();
        }, 1000);

        setTimeout(() => {
            cardData.element.classList.remove('wrong');
            correctCard.element.classList.remove('correct-reveal');
            flipAllCards(true);
            shuffle();
            gameState.canClick = true;
        }, 3000);
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
        updateLevel3Progress();
        
        if (gameState.level3.matchedFeatures.size === gameState.level3.features.length) {
            // Level complete
            setTimeout(() => {
                showLevel3CompleteModal();
                gameState.level++;
                attackMonster();
            }, 500);
        }
    } else {
        // Wrong match
        document.getElementById('message').textContent = "Wrong match! Try again.";
        takeDamage();
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

function initializeLevel3() {
    const level3Content = document.getElementById('level3Content');
    level1Content.style.display = 'none';
    level2Content.style.display = 'none';
    level3Content.style.display = 'block';

    const mainImage = document.getElementById('mainImage');
    mainImage.src = gameState.level3.mainImage;

    // Create dropzones
    const mainImageContainer = document.querySelector('.main-image-container');
    gameState.level3.features.forEach(feature => {
        const dropzone = createDropzone(feature);
        mainImageContainer.appendChild(dropzone);
    });

    // Create draggable features
    const featuresList = document.getElementById('featuresList');
    featuresList.innerHTML = '';
    gameState.level3.features.forEach(feature => {
        const featureElement = createFeatureElement(feature);
        featuresList.appendChild(featureElement);
    });

    updateLevel3Progress();
}

function createDropzone(feature) {
    const dropzone = document.createElement('div');
    dropzone.className = 'feature-dropzone';
    dropzone.dataset.featureId = feature.id;
    dropzone.style.width = feature.correctZone.width + 'px';
    dropzone.style.height = feature.correctZone.height + 'px';
    dropzone.style.left = feature.correctZone.x + 'px';
    dropzone.style.top = feature.correctZone.y + 'px';

    dropzone.addEventListener('dragover', handleDragOver);
    dropzone.addEventListener('drop', handleDrop);
    dropzone.addEventListener('dragenter', handleDragEnter);
    dropzone.addEventListener('dragleave', handleDragLeave);

    return dropzone;
}

function createFeatureElement(feature) {
    const featureElement = document.createElement('div');
    featureElement.className = 'feature-item';
    featureElement.draggable = true;
    featureElement.dataset.featureId = feature.id;

    const featureImage = document.createElement('img');
    featureImage.src = feature.image;
    featureImage.alt = `${feature.type} feature`;
    featureElement.appendChild(featureImage);

    featureElement.addEventListener('dragstart', handleDragStart);
    featureElement.addEventListener('dragend', handleDragEnd);

    return featureElement;
}


function nextRound() {
    initializeGame();
    setTimeout(() => {
        flipAllCards(true);
        setTimeout(shuffle, 1000);
    }, 1000);
}

function updateLevel3Progress() {
    const progress = (gameState.level3.matchedFeatures.size / gameState.level3.features.length) * 100;
    document.querySelector('.progress-fill').style.width = `${progress}%`;
}

function initializeLevel4() {
    const level4Content = document.getElementById('level4Content');
    level1Content.style.display = 'none';
    level2Content.style.display = 'none';
    level3Content.style.display = 'none';
    level4Content.style.display = 'block';

    const submitColorButton = document.getElementById('submitColor');
    
    submitColorButton.addEventListener('click', () => {
        const red = parseInt(document.getElementById('redSlider').value);
        const green = parseInt(document.getElementById('greenSlider').value);
        const blue = parseInt(document.getElementById('blueSlider').value);

        const selectedRGB = { r: red, g: green, b: blue };

        const expectedColor = { r: 0, g: 0, b: 0 }; 
        

        if (selectedRGB.r === expectedColor.r && 
            selectedRGB.g === expectedColor.g && 
            selectedRGB.b === expectedColor.b) {
            showLevel4CompleteModal();
            gameState.level++;
            attackMonster();
        } else {
            document.getElementById('message').textContent = "Incorrect color, try again!";
            takeDamage();
        }
    });
}

function initializeLevel5() {
    level1Content.style.display = 'none';
    level2Content.style.display = 'none';
    level3Content.style.display = 'none';
    level4Content.style.display = 'none';
    level5Content.style.display = 'block';

    const objectImage = document.getElementById('objectImage');
    const detectedObjectsList = document.getElementById('detectedObjectsList');

    const detectionZones = [
        { xStart: 100, xEnd: 200, yStart: 150, yEnd: 250 }, // Large Zone 1
        { xStart: 300, xEnd: 400, yStart: 100, yEnd: 200 }, // Large Zone 2
        { xStart: 450, xEnd: 550, yStart: 250, yEnd: 350 }, // Large Zone 3
        { xStart: 50, xEnd: 100, yStart: 200, yEnd: 250 },   // Small Zone 1
        { xStart: 200, xEnd: 250, yStart: 250, yEnd: 300 },  // Small Zone 2
        { xStart: 500, xEnd: 550, yStart: 300, yEnd: 350 }    // Small Zone 3
        // Add more zones as needed
    ];

    // Event listener for image click
    objectImage.addEventListener('click', function(event) {
        const rect = objectImage.getBoundingClientRect();
        const x = event.clientX - rect.left; 
        const y = event.clientY - rect.top;  

        const detected = detectionZones.some(zone => 
            x >= zone.xStart && x <= zone.xEnd &&
            y >= zone.yStart && y <= zone.yEnd
        );

        if (detected) {
            detectedObjectsList.innerHTML = '<p>Object Detected!</p>';
            showLevel5CompleteModal();
        } else {
            detectedObjectsList.innerHTML = '<p>No object detected, try again!</p>';
        }
    });
}

    function initializePostTest() {
        level1Content.style.display = 'none';
        level2Content.style.display = 'none';
        level3Content.style.display = 'none';
        level4Content.style.display = 'none';
        level5Content.style.display = 'none';
    }


    function submitPostTest() {

        const answer1 = document.querySelector('input[name="q1"]:checked');
        const answer2 = document.querySelector('input[name="q2"]:checked');
        const answer3 = document.querySelector('input[name="q3"]:checked');
    
        let score = 0;
    
        if (answer1 && answer1.value === 'c') { // Correct answer for question 1
            score++;
        }
        if (answer2 && answer2.value === 'c') { // Correct answer for question 2
            score++;
        }
        if (answer3 && answer3.value === 'b') { // Correct answer for question 3
            score++;
        }
    

        document.getElementById('score').innerText = `Your score: ${score} out of 3`;
        document.getElementById('results').style.display = 'block';

        document.getElementById('postTestContainer').style.display = 'none';
    }
    
    document.getElementById('submitTest').addEventListener('click', submitPostTest);

function attackMonster() {
    gameState.isAttacking = true;
    gameState.attackFrame = 0;
    gameState.monsterHp = Math.max(0, gameState.monsterHp - 100);

    if (gameState.monsterHp <= 0) {
        if (gameState.level === 1) {
            showLevel1CompleteModal();
        } else if (gameState.level === 2) {
            showLevel2CompleteModal();
        } else if (gameState.level === 3) {
            showLevel3CompleteModal
        }else if (gameState.level === 5) {
            showLevel4CompleteModal();
        }else if (gameState.level === 6) {
            showLevel5CompleteModal();
            alert("Congratulations! You've completed all levels!");
            resetGame();
        }
    }
    updateStats();
}

function takeDamage() {
    gameState.playerHp = Math.max(0, gameState.playerHp - 100);
    updateStats();

    if (gameState.playerHp <= 0) {
        setTimeout(() => {
            alert("Game Over! Try again!");
            resetGame();
        }, 500);
    }
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

function draw() {
    ctx.clearRect(0, 0, gameScene.width, gameScene.height);

    // Draw player
    ctx.fillStyle = '#4CAF50';
    ctx.fillRect(100, 150, 60, 80);

    // Draw monster
    ctx.fillStyle = '#F44336';
    ctx.fillRect(600, 150, 80, 100);

    if (gameState.isAttacking) {
        ctx.beginPath();
        ctx.moveTo(160, 190);
        ctx.lineTo(600, 200);
        ctx.strokeStyle = '#FFD700';
        ctx.lineWidth = 3;
        ctx.stroke();

        gameState.attackFrame++;
        if (gameState.attackFrame > 10) {
            gameState.isAttacking = false;
        }
    }

    requestAnimationFrame(draw);
}


// Start the game
initializeGame();
draw();
setTimeout(() => {
    flipAllCards(true);
    setTimeout(shuffle, 1000);
}, 1000); 
    </script>
</body>

</html>