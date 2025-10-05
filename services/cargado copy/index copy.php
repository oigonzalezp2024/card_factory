<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Recorte y Subida</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        #contenedor-recorte {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #imagen-a-recortar {
            display: block; /* Necesario para Cropper.js */
            max-width: 100%;
            height: auto;
        }
        input[type="file"], input[type="text"], button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        #mensaje-estado {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div id="contenedor-recorte">
        <h2>Cargar y Recortar Imagen ($295 \times 119 \text{ px}$)</h2>
        
        <label for="input-archivo">1. Selecciona la Imagen:</label>
        <input type="file" id="input-archivo" accept="image/*">
        
        <label for="nombre-destino" style="margin-top: 15px; display: block;">2. Define el nombre del archivo:</label>
        <input type="text" id="nombre-destino" placeholder="ej: foto_perfil_miniatura">

        <div style="margin-top: 15px; max-height: 400px; overflow: auto; border: 1px solid #ddd;">
            <img id="imagen-a-recortar" src="" alt="Imagen a recortar">
        </div>

        <button id="boton-subir" style="margin-top: 15px; display: none;">3. Subir Recorte ($295 \times 119 \text{ px}$)</button>
        
        <p id="mensaje-estado"></p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="script.js"></script>

</body>
</html>