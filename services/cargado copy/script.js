document.addEventListener('DOMContentLoaded', () => {
    const inputArchivo = document.getElementById('input-archivo');
    const nombreDestinoInput = document.getElementById('nombre-destino');
    const imagenRecortar = document.getElementById('imagen-a-recortar');
    const botonSubir = document.getElementById('boton-subir');
    const mensajeEstado = document.getElementById('mensaje-estado');
    let cropper;

    // Cuando se selecciona un archivo (Paso 1: Cargar la imagen)
    inputArchivo.addEventListener('change', (e) => {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();

            reader.onload = (event) => {
                // Destruir el cropper anterior si existe
                if (cropper) {
                    cropper.destroy();
                }

                // Mostrar la imagen
                imagenRecortar.src = event.target.result;
                botonSubir.style.display = 'block';

                // Inicializar Cropper.js con el aspecto fijo (295:119)
                cropper = new Cropper(imagenRecortar, {
                    // Relación de aspecto: 295 / 119 ≈ 2.479
                    aspectRatio: 295 / 119, 
                    viewMode: 1, // Restringe la caja del cropper
                    autoCropArea: 1, // Intenta usar la imagen completa al inicio
                });
                mensajeEstado.textContent = 'Imagen lista. Arrastra el recuadro para seleccionar el área.';
            };

            reader.readAsDataURL(file);
        }
    });

    // Cuando se hace clic en Subir (Paso 2: Recortar y Enviar por AJAX)
    botonSubir.addEventListener('click', () => {
        if (!cropper) {
            mensajeEstado.textContent = 'Por favor, selecciona una imagen primero.';
            return;
        }

        // Obtener y validar el nombre de archivo del input
        const nombreDestino = nombreDestinoInput.value.trim();
        if (nombreDestino === '') {
            mensajeEstado.textContent = '❌ Por favor, ingresa un nombre para el archivo de destino.';
            return;
        }

        // 1. Obtener el recorte como un Canvas con las dimensiones finales de 295x119 px
        const canvas = cropper.getCroppedCanvas({
            width: 295,  // Ancho final deseado
            height: 119, // Altura final deseada
            imageSmoothingQuality: 'high',
        });

        // Convertir el Canvas a un objeto Blob (archivo binario) para el envío
        canvas.toBlob((blob) => {
            // 2. Crear un objeto FormData para enviar datos
            const formData = new FormData();
            
            // Adjuntar la imagen recortada. El nombre del archivo en $_FILES será 'croppedImage'
            formData.append('croppedImage', blob, 'recorte.jpg'); 
            
            // Adjuntar el nombre deseado por el usuario (el PHP lo recibe en $_POST['fileName'])
            formData.append('fileName', nombreDestino); 

            // 3. Enviar el archivo recortado al servidor con AJAX (Fetch API)
            mensajeEstado.textContent = '⏳ Subiendo...';
            
            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mensajeEstado.textContent = `✅ ¡Recorte subido con éxito! Ruta: ${data.filePath}`;
                } else {
                    mensajeEstado.textContent = `❌ Error al subir: ${data.message}`;
                }
            })
            .catch(error => {
                mensajeEstado.textContent = '❌ Error de conexión o servidor.';
                console.error('Error:', error);
            });
        }, 'image/jpeg', 0.9); // Tipo de archivo y calidad
    });
});
