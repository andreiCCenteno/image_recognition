<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preprocessing Stages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Overall body styling */
        body {
            background: radial-gradient(circle, #000000, #1a1a1a);
            color: #00ffcc;
            font-family: 'Orbitron', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Container for the stage */
        .stage-container {
            text-align: center;
            background: rgba(0, 0, 0, 0.8);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 0 20px #00ffa3, inset 0 0 20px #00ffa3;
            max-width: 600px;
            margin: auto;
            z-index: 2;
        }

        /* Heading styling */
        h1 {
            color: #00ffcc;
            text-shadow: 0 0 15px #00ffa3;
            font-size: 3em;
            margin-bottom: 20px;
        }

        /* Button styling */
        .btn-stage {
            margin: 15px;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #00ffcc;
            background: transparent;
            border: 2px solid #00ffcc;
            border-radius: 15px;
            text-shadow: 0 0 5px rgba(0, 255, 204, 0.7);
            box-shadow: 0 0 10px rgba(0, 255, 163, 0.3);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        /* Button hover effect */
        .btn-stage:hover {
            background: #00ffcc;
            color: #000;
            box-shadow: 0 0 20px #00ffcc, inset 0 0 10px #00ffcc;
            transform: scale(1.05);
        }

        /* Adding dynamic glow effect to buttons */
        .btn-stage::before {
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

        .btn-stage:hover::before {
            left: 100%;
        }

        /* Paragraph styling */
        p {
            margin-bottom: 20px;
            font-size: 1.3em;
            color: #00ffcc;
            text-shadow: 0 0 10px #00ffa3;
        }
    </style>
</head>
<body>
    <div class="container stage-container">
        <h1>Preprocessing Stages</h1>
        <p>Select a stage to proceed:</p>
        <div>
            <a href="{{ route('stage1') }}" class="btn btn-stage">Stage 1</a>
            <a href="{{ route('stage2') }}" class="btn btn-stage">Stage 2</a>
            <a href="{{ route('stage3') }}" class="btn btn-stage">Stage 3</a>
            <a href="{{ route('preprocessingquiz') }}" class="btn btn-stage">Quiz</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
