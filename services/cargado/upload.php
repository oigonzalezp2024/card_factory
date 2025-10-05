<?php
// =======================================================================
// === ⚠️ CONFIGURACIÓN DE BASE DE DATOS ⚠️ (¡REEMPLAZA ESTO!) ============
// =======================================================================
$servername = "localhost";
$username = "root";       
$password = "";       
$dbname = "db_tarjetas_aliados";    

// 1. Configuración de la carpeta de subida y URL
$upload_dir = '../imprimir/images/';
$base_url = './images/'; // URL pública del directorio
$table_name = 'aliados'; 

// Prepara la respuesta como JSON, antes de cualquier posible error HTML
header('Content-Type: application/json');

// Crea la carpeta si no existe (gestión de errores)
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0777, true)) {
        echo json_encode(['success' => false, 'message' => "Error al crear la carpeta de destino o permisos insuficientes."]);
        exit();
    }
}


// 2. Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión (gestión de errores)
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Error de conexión a la BD: " . $conn->connect_error]);
    exit();
}

// 3. Procesar y validar todos los campos recibidos
$required_fields = ['nombreAliado', 'telefono', 'babullUrl'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => "El campo '$field' es obligatorio."]);
        $conn->close();
        exit();
    }
}

if (!isset($_FILES['croppedImage']) || $_FILES['croppedImage']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No se recibió la imagen recortada o hubo un error de subida.']);
    $conn->close();
    exit();
}

$file = $_FILES['croppedImage'];

// 4. Generar nombre de archivo único y seguro
$original_name = basename($file['name']);
$file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
$file_base_name = pathinfo($original_name, PATHINFO_FILENAME);
    
// Crear el nombre final con timestamp
//$final_filename = $file_base_name . '_' . time() . '.' . $file_extension;
$final_filename = $file_base_name . '.' . $file_extension;
$target_file = $upload_dir . $final_filename;
    
// 5. Mover el archivo subido
if (move_uploaded_file($file['tmp_name'], $target_file)) {
        
    // Determinar la URL pública
    $logo_url = $base_url . $final_filename;
        
    // 6. Preparar datos y sanitizar
    // **¡ADVERTENCIA DE SEGURIDAD!** Usa consultas preparadas en producción.
    $nombre_escaped = $conn->real_escape_string($_POST['nombreAliado']); 
    $telefono_escaped = $conn->real_escape_string($_POST['telefono']); 
    $babull_url_escaped = $conn->real_escape_string($_POST['babullUrl']);
    $logo_url_escaped = $conn->real_escape_string($logo_url);
    
    // 7. Inserción en la base de datos (TABLA ALIADOS con todos los campos)
    $sql = "INSERT INTO $table_name (`nombre`, `telefono`, `babull_url`, `logo_url`) 
            VALUES (
                '$nombre_escaped',
                '$telefono_escaped',
                '$babull_url_escaped',
                '$logo_url_escaped'
            )";

    // Ejecutar la consulta
    $consulta = mysqli_query($conn, $sql);

    if ($consulta === TRUE) {
        // Éxito
        echo json_encode([
            'success' => true, 
            'message' => "Datos y logo de aliado insertados correctamente.",
            'url' => $logo_url
        ]);
    } else {
        // Error de BD
        echo json_encode([
            'success' => false, 
            'message' => "Error al insertar en la base de datos: " . $conn->error
        ]);
        // Revertir: eliminar la imagen si la inserción falla
        @unlink($target_file); 
    }
        
} else {
    // Error al mover el archivo
    echo json_encode(['success' => false, 'message' => 'Error al guardar la imagen en el servidor (problema de permisos).']);
}

$conn->close();
?>
