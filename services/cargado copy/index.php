<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Recorte y Subida</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    
    <style>
        /* Estilos generales del cuerpo y fuente */
        body {
            font-family: 'Consolas', 'Courier New', monospace; /* Fuente del tema */
            margin: 20px;
            background-color: #000000; /* Fondo oscuro del tema */
            color: #c7f3ff; /* Color de texto base del tema */
        }
        
        /* Contenedor principal del formulario */
        #contenedor-recorte {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #0c1a2c; /* Fondo de contenedores del tema */
            border-radius: 4px; /* Un poco más sutil */
            border: 1px solid #00ffff; /* Borde cian */
            /* Sombra cian */
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.5); 
        }
        
        /* Ajuste para el h2 dentro del contenedor */
        #contenedor-recorte h2 {
             /* Se utilizan los estilos definidos para h2 en el CSS base */
            margin-top: 0; /* Para evitar doble margen */
        }

        /* Etiqueta del formulario */
        label {
            color: #00ffff; /* Color de contraste para etiquetas */
            text-shadow: 0 0 5px #00ffff;
            text-transform: uppercase;
        }

        #imagen-a-recortar {
            display: block;
            max-width: 100%;
            height: auto;
        }

        /* Estilos para el input de archivo, input de texto y botón */
        input[type="file"], input[type="text"], button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
            border-radius: 2px; /* Redondeo acorde a .btn */
            /* Estilos de campo de texto del tema (.form-control) */
            background-color: #1a2c3d;
            border: 1px solid #00ffff;
            color: #fff;
            font-family: 'Consolas', monospace;
            box-shadow: inset 0 0 5px rgba(0, 255, 255, 0.3);
            outline: none;
        }
        
        /* Estilo para el campo de texto enfocado */
        input[type="text"]:focus,
        input[type="file"]:focus {
            border-color: #00e0e0;
            box-shadow: inset 0 0 8px rgba(0, 255, 255, 0.5);
        }

        /* Estilo base del botón */
        button {
            /* Estilos de botón del tema (.btn-primary) */
            background-color: #00ffff !important;
            color: #0c1a2c !important;
            border: none;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.7);
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            text-transform: uppercase; /* Para que combine con h2 */
            letter-spacing: 1px;
        }
        
        /* Estilo hover del botón */
        button:hover {
            background-color: #00e0e0 !important;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.9);
        }

        /* Contenedor de la imagen a recortar */
        div[style*="max-height: 400px"] {
             /* Cambia el borde al estilo del tema */
            border: 1px solid #00ffff !important; 
            box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.3);
            background-color: #000000;
        }

        /* Mensaje de estado */
        #mensaje-estado {
            margin-top: 15px;
            font-weight: bold;
            color: #ff00ff; /* Un color de retroalimentación distintivo, magenta */
            text-shadow: 0 0 8px #ff00ff;
        }

        /* Estilos de Cropper.js para visibilidad en fondo oscuro */
        /* Hace la capa de fondo de Cropper más oscura/visible */
        .cropper-modal {
             background-color: rgba(0, 0, 0, 0.9); 
        }

    </style>
</head>
<body>

    <div id="contenedor-recorte">
        <h2>Cargar y Recortar Imagen</h2>
        
        <label for="input-archivo">1. Selecciona la Imagen:</label>
        <input type="file" id="input-archivo" accept="image/*">
        
        <label for="nombre-destino" style="margin-top: 15px; display: block;">2. Define el nombre del archivo:</label>
        <input type="text" id="nombre-destino" placeholder="ej: foto_perfil_miniatura">

        <div style="margin-top: 15px; max-height: 400px; overflow: auto;">
            <img id="imagen-a-recortar" src="" alt="Imagen a recortar">
        </div>

        <button id="boton-subir" style="margin-top: 15px; display: none;">3. Subir Recorte</button>
        
        <p id="mensaje-estado"></p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="script.js"></script>

</body>
</html>