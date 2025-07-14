<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recuperar Contraseña - SIPeIP1</title>
    <style>
        body {
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .modal {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            width: 300px;
            text-align: center;
        }

        button {
            margin-top: 15px;
            padding: 8px 15px;
            border: none;
            background: #0077ff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #005fcc;
        }
    </style>
</head>
<body>
    <div class="modal">
        <p>Iniciando proceso de recuperación de contraseña</p>
        <button onclick="window.location.href='/login'">Cerrar</button>
        <!-- O usa esta línea en vez de la anterior:
        <button onclick="window.location.href='{{ url('login') }}'">Cerrar</button>
        -->
    </div>
</body>
</html>
