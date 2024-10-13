<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
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

        h1 {
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.7);
            margin-bottom: 20px;
            font-size: 3.5em;
            font-family: 'Orbitron', sans-serif;
        }

        .leaderboard {
            background: rgba(0, 0, 0, 0.8);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.7);
            max-width: 600px;
            margin: auto;
            z-index: 2;
        }

        .leaderboard ul {
            list-style: none;
            padding: 0;
        }

        .leaderboard li {
            margin: 10px 0;
            color: #fff;
            font-size: 1.2em;
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

        .back-button:focus {
            outline: 2px solid #00ffcc;
            outline-offset: 4px;
        }
    </style>
</head>
<body>
<a href="{{ route('mainmenu') }}" class="back-button" title="Back">&larr;</a>
    <div class="leaderboard">
        <h1>Leaderboard</h1>
        <ul>
@if (!empty($users) && is_array($users))
    @foreach ($users as $user)
        <li>
            @if ($user['username'] == $current_user)
                <strong>{{ htmlspecialchars($user['username']) }} (You)</strong> - {{ htmlspecialchars($user['score']) }} points
            @else
                {{ htmlspecialchars($user['username']) }} - {{ htmlspecialchars($user['score']) }} points
            @endif
        </li>
    @endforeach
@else
    <li>No scores available yet.</li>
@endif
</ul>


    </div>
</body>
</html>
