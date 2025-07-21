<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Restablecer Contraseña - SIPeIP1</title>
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

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            padding: 10px;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
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
        }

        button:hover {
            background: #00cccc;
        }

        .message {
            margin-bottom: 15px;
            color: #0f0;
            font-weight: 600;
        }

        .error {
            color: #ff4444;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Restablecer Contraseña</h2>

    @if (session('status'))
        <div class="message">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->token }}">

        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email', $request->email) }}"
            placeholder="Correo electrónico"
            required
            autofocus
        >

        <input
            id="password"
            type="password"
            name="password"
            placeholder="Nueva contraseña"
            required
        >

        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="Confirmar contraseña"
            required
        >

        <button type="submit">Restablecer contraseña</button>
    </form>
</div>

</body>
</html>
