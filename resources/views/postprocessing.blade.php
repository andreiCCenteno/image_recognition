<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postprocessing Stages</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #28313b, #485461);
            color: #ffffff;
            font-family: 'Orbitron', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .stage-container {
            text-align: center;
        }
        .btn-stage {
            margin: 15px;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffffff;
            background: #1e3c72;
            border: 2px solid #ffffff;
            transition: all 0.3s ease;
        }
        .btn-stage:hover {
            background: #ef476f;
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container stage-container">
        <h1>Postprocessing Stages</h1>
        <p>Select a stage to proceed:</p>
        <div>
            <a href="{{ route('poststage1') }}" class="btn btn-stage">Stage 1</a>
            <a href="{{ route('poststage2') }}" class="btn btn-stage">Stage 2</a>
            <a href="{{ route('poststage3') }}" class="btn btn-stage">Stage 3</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
