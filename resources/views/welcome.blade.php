<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Sistema de Inventario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            margin: 50px;
        }

        h1 {
            color: #3498db;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .enter-btn {
            padding: 10px 20px;
            background-color: #2ecc71;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <img src="{{ asset('admin/dist/img/welcome.jpg') }}" alt="Imagen de Bienvenida" width="480">
    <h1>Bienvenido al Sistema de Inventario</h1>
    <p>Administra fácilmente el inventario de tu negocio.</p>
    <a href="{{ route('products.index') }}" class="enter-btn">Entrar al Sistema</a>
</body>
</html>