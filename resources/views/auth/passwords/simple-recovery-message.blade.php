<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recuperar Contraseña - SIPeIP1</title>
    <style>
        body {
            background: #0b0f1a;
            color: #0ff;
            font-family: 'Orbitron', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(0, 20, 40, 0.9);
            padding: 30px;
            border-radius: 20px;
            width: 320px;
            box-shadow: 0 0 15px #00ffff88;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #00ffff;
            text-shadow:
                0 0 6px #00ffff,
                0 0 12px #00ffff;
        }
        button {
            background: #00ffff;
            color: #001f2f;
            font-weight: 700;
            border: none;
            padding: 10px 0;
            border-radius: 35px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
            width: 100%;
        }
        button:hover {
            background: #00cccc;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            color: #0ff;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Iniciando proceso de recuperación de contraseña</h2>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <button type="submit">Enviar enlace de recuperación</button>
    </form>

    <a href="{{ route('login') }}">Volver al Login</a>
</div>

</body>
</html>
