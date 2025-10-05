<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Recorte y Subida de Aliado</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    
    <style>
        /* Estilos generales del cuerpo y fuente (sin cambios) */
        body {
            font-family: 'Consolas', 'Courier New', monospace;
            margin: 20px;
            background-color: #000000;
            color: #c7f3ff;
        }
        
        h2 {
            color: #00ffff;
            text-shadow: 0 0 10px #00ffff;
            text-transform: uppercase;
            letter-spacing: 3px;
            border-bottom: 2px solid #00ffff;
            padding-bottom: 5px;
            margin-top: 0;
        }

        #contenedor-recorte {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #0c1a2c;
            border-radius: 4px;
            border: 1px solid #00ffff;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.5); 
        }
        
        label {
            color: #00ffff;
            text-shadow: 0 0 5px #00ffff;
            text-transform: uppercase;
            margin-top: 15px; 
            display: block;
        }

        div[style*="max-height: 400px"] {
            margin-top: 15px; 
            max-height: 400px; 
            overflow: auto;
            border: 1px solid #00ffff !important; 
            box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.3);
            background-color: #000000;
        }
        
        #imagen-a-recortar {
            display: block;
            max-width: 100%;
            height: auto;
        }

        input[type="file"], input[type="text"], button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
            border-radius: 2px;
            background-color: #1a2c3d;
            border: 1px solid #00ffff;
            color: #fff;
            font-family: 'Consolas', monospace;
            box-shadow: inset 0 0 5px rgba(0, 255, 255, 0.3);
            outline: none;
        }
        
        input[type="text"]:focus,
        input[type="file"]:focus {
            border-color: #00e0e0;
            box-shadow: inset 0 0 8px rgba(0, 255, 255, 0.5);
        }

        button {
            background-color: #00ffff !important;
            color: #0c1a2c !important;
            border: none;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.7);
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            margin-top: 15px; 
        }
        
        button:hover {
            background-color: #00e0e0 !important;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.9);
        }

        #mensaje-estado {
            margin-top: 15px;
            font-weight: bold;
            color: #c7f3ff;
            text-shadow: 0 0 5px #c7f3ff;
        }

        .cropper-modal {
             background-color: rgba(0, 0, 0, 0.9); 
        }
    </style>
</head>
<body>

    <div id="contenedor-recorte">
        <h2>Cargar y Recortar Logo de Aliado ($295 \times 119 \text{ px}$)</h2>
        
        <label for="nombre-destino">1. Nombre del Aliado:</label>
        <input type="text" id="nombre-destino" placeholder="ej: Google Colombia">

        <label for="telefono-input">2. Teléfono:</label>
        <input type="text" id="telefono-input" placeholder="ej: +57 1 2345678">

        <label for="babull-url-input">3. Babull URL:</label>
        <input type="text" id="babull-url-input" placeholder="ej: https://babull.com/aliado-x">
        
        <label for="input-archivo">4. Selecciona el Logo:</label>
        <input type="file" id="input-archivo" accept="image/*">

        <div style="max-height: 400px; overflow: auto;">
            <img id="imagen-a-recortar" src="" alt="Imagen a recortar">
        </div>

        <button id="boton-subir" style="display: none;">5. Subir Recorte y Datos ($295 \times 119 \text{ px}$)</button>
        
        <p id="mensaje-estado">Completa los datos y selecciona una imagen para empezar.</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="script.js"></script>

</body>
</html>