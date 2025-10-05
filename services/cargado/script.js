document.addEventListener('DOMContentLoaded', () => {
    const inputArchivo = document.getElementById('input-archivo');
    const imagenRecortar = document.getElementById('imagen-a-recortar');
    const botonSubir = document.getElementById('boton-subir');
    const nombreDestinoInput = document.getElementById('nombre-destino');
    // Nuevos inputs
    const telefonoInput = document.getElementById('telefono-input');
    const babullUrlInput = document.getElementById('babull-url-input');
    
    const mensajeEstado = document.getElementById('mensaje-estado');
    let cropper;

    // Función para mostrar mensajes de estado con color ciberpunk
    const mostrarMensaje = (message, isSuccess = false) => {
        mensajeEstado.textContent = message;
        if (isSuccess) {
            mensajeEstado.style.color = '#00ffff';
            mensajeEstado.style.textShadow = '0 0 8px #00ffff';
        } else if (message.toLowerCase().includes('error')) {
            mensajeEstado.style.color = '#ff0000';
            mensajeEstado.style.textShadow = '0 0 8px #ff0000';
        } else {
            mensajeEstado.style.color = '#c7f3ff';
            mensajeEstado.style.textShadow = '0 0 5px #c7f3ff';
        }
    };

    // Ocultar la imagen al inicio
    imagenRecortar.style.display = 'none';

    // 1. Manejar la selección del archivo
    inputArchivo.addEventListener('change', (e) => {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagenRecortar.src = e.target.result;
                imagenRecortar.style.display = 'block';
                botonSubir.style.display = 'none';
                mostrarMensaje('Ajusta el área de recorte...');

                if (cropper) {
                    cropper.destroy();
                }

                // Inicializar Cropper con la relación de aspecto deseada
                cropper = new Cropper(imagenRecortar, {
                    aspectRatio: 295 / 119,
                    viewMode: 1, 
                    autoCropArea: 0.9,
                    responsive: true,
                    background: false,
                    ready() {
                        botonSubir.style.display = 'block';
                        mostrarMensaje('Imagen lista para subir. Verifica los demás campos.');
                    },
                });
            };
            reader.readAsDataURL(files[0]);
        } else {
             mostrarMensaje('Selección de archivo cancelada.', false);
        }
    });

    // 2. Manejar el botón de subir
    botonSubir.addEventListener('click', () => {
        // Obtener y validar todos los campos de texto
        const nombreAliado = nombreDestinoInput.value.trim();
        const telefono = telefonoInput.value.trim();
        const babullUrl = babullUrlInput.value.trim();

        if (nombreAliado === '') {
            mostrarMensaje('Error: El nombre del aliado es obligatorio.', false);
            nombreDestinoInput.focus();
            return;
        }
        if (telefono === '') {
            mostrarMensaje('Error: El teléfono es obligatorio.', false);
            telefonoInput.focus();
            return;
        }
        if (babullUrl === '') {
            mostrarMensaje('Error: La Babull URL es obligatoria.', false);
            babullUrlInput.focus();
            return;
        }
        
        if (!cropper) {
            mostrarMensaje('Error: Debes seleccionar y recortar una imagen.', false);
            return;
        }

        // Obtener el canvas con la imagen recortada
        const canvas = cropper.getCroppedCanvas({
            width: 295, 
            height: 119, 
        });

        // Convertir el canvas a Blob (formato de archivo)
        canvas.toBlob((blob) => {
            const formData = new FormData();
            
            // 1. Datos del archivo y sus metadatos
            const cleanName = nombreAliado.toLowerCase().replace(/\s/g, '_').replace(/[^a-z0-9_]/g, '');
            formData.append('croppedImage', blob, cleanName + '.png');
            
            // 2. Datos de los nuevos campos de texto para la BD
            formData.append('nombreAliado', nombreAliado);
            formData.append('telefono', telefono);
            formData.append('babullUrl', babullUrl);
            
            mostrarMensaje('Subiendo datos e imagen... por favor espera.');
            botonSubir.disabled = true;

            // Enviar la imagen recortada al servidor (upload.php)
            fetch('upload.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                botonSubir.disabled = false;
                if (data.success) {
                    mostrarMensaje(`¡Subida exitosa! Redirigiendo...`, true);
                    
                    setTimeout(() => {
                        window.location.href = "../../";
                    }, 2000); 
                    
                } else {
                    mostrarMensaje(`Error en la subida: ${data.message}`, false);
                    console.error('Error del servidor:', data.message);
                }
            })
            .catch(error => {
                botonSubir.disabled = false;
                mostrarMensaje(`Error de red o servidor: ${error.message}`, false); 
                console.error('Error de red:', error);
            });
        }, 'image/png');
    });
});
