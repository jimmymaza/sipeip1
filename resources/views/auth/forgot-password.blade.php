<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recuperar Contraseña | SIPeIP1</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0b0f1a;
            color: #00ffff;
            font-family: 'Orbitron', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #112;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"] {
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            background-color: #1e2a38;
            color: #0ff;
        }

        button {
            background-color: #00ffff;
            color: #000;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #00cccc;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #00ffff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .status, .error {
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .status {
            color: #00ff88;
        }

        .error {
            color: #ff0066;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperar Contraseña</h2>

        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required autofocus>
            <button type="submit">Enviar enlace de recuperación</button>
        </form>

        <a class="back-link" href="{{ route('login') }}">← Volver al Login</a>
    </div>
</body>
</html>
