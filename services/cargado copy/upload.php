<?php
// Configura la respuesta como JSON
header('Content-Type: application/json');

// --- Configuración ---
$uploadDir = 'uploads/'; // Directorio donde se guardarán las imágenes

// 1. Crear la carpeta de uploads si no existe
if (!is_dir($uploadDir)) {
    // Intenta crear la carpeta con permisos de escritura
    if (!mkdir($uploadDir, 0777, true)) { 
        echo json_encode(['success' => false, 'message' => 'Error: No se pudo crear el directorio de subida.']);
        exit;
    }
}

// 2. Validar el nombre de archivo proporcionado por el usuario
$nombreDeseado = isset($_POST['fileName']) ? trim($_POST['fileName']) : null;
$extension = 'jpg'; 

if (empty($nombreDeseado)) {
    echo json_encode(['success' => false, 'message' => 'El nombre del archivo de destino es requerido.']);
    exit;
}

// 3. Sanitizar el nombre del archivo para seguridad (IMPORTANTE)
// Se reemplazan caracteres no alfanuméricos, guiones o guiones bajos por un guión
$nombreSanitizado = preg_replace('/[^a-zA-Z0-9_-]/', '-', $nombreDeseado);

// Si después de sanitizar queda vacío, usa un nombre genérico único
if (empty($nombreSanitizado)) {
    $nombreSanitizado = 'img';
}

// 4. Generar el nombre de archivo final, añadiendo un timestamp para evitar sobreescritura
$fileName = $nombreSanitizado . '_' . time() . '.' . $extension; 
$filePath = $uploadDir . $fileName;


// 5. Procesar la carga del archivo (el recorte ya procesado por JS)
if (isset($_FILES['croppedImage'])) {
    $file = $_FILES['croppedImage'];

    // Verificar si hay errores de subida
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Error en la carga del archivo. Código: ' . $file['error']]);
        exit;
    }

    // Mover el archivo temporal al destino final con el nombre sanitizado
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Éxito
        echo json_encode([
            'success' => true, 
            'message' => 'Archivo recortado y subido correctamente.',
            'filePath' => $filePath,
            'fileName' => $fileName
        ]);
    } else {
        // Error al mover
        echo json_encode(['success' => false, 'message' => 'Error al mover el archivo a la carpeta de destino. Verifica los permisos de la carpeta "uploads/".']);
    }
} else {
    // Archivo no encontrado
    echo json_encode(['success' => false, 'message' => 'No se recibió el archivo de imagen recortado.']);
}
