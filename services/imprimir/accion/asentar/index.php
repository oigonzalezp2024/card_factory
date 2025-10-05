<?php

$host = 'localhost';
$db   = 'db_tarjetas_aliados';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC, 
    PDO::ATTR_EMULATE_PREPARES     => false,
];

$data = []; // Inicializamos la variable de respuesta

// CONEXIÓN Y MANEJO DE ERRORES
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500); // Internal Server Error
    $data = [
        'status'  => 'error',
        'message' => 'Error de conexión con la base de datos.',
        'details' => 'No se pudo establecer la conexión con el servidor de datos.'
    ];
    die(json_encode($data));
}

// EJECUCIÓN DEL UPDATE Y ESTRUCTURA DE LA RESPUESTA
try {
    $sql_tarjetas = "
        UPDATE tarjetas
        SET tarjeta_estado = 2
        WHERE tarjeta_estado = 1
    ";
    $stmt = $pdo->prepare($sql_tarjetas);
    $stmt->execute();

    // Obtener el número de filas afectadas por el UPDATE
    $rows_affected = $stmt->rowCount();

    // Generar la respuesta profesional de éxito (HTTP 200 OK implícito)
    $data = [
        'status'          => 'success',
        'message'         => 'Actualización de estado de tarjetas completada.',
        'rows_affected'   => $rows_affected
    ];

} catch (\PDOException $e) {
    http_response_code(500); // Internal Server Error
    error_log("Error de actualización: " . $e->getMessage());
    
    // Generar la respuesta profesional de error de consulta
    $data = [
        'status'  => 'error',
        'message' => 'Error al ejecutar la actualización de datos.',
        'details' => 'Revisar logs del servidor para más información.'
        // En un entorno de desarrollo, podrías añadir: 'dev_info' => $e->getMessage()
    ];
}

$json_output = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

header("location: ../../../");
exit;