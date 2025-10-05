<?php
/**
 * SCRIPT UNIFICADO: Conexión a MySQL con PDO, consulta de datos relacionales,
 * y generación de una estructura JSON específica para API.
 * * Este script es seguro contra inyección SQL gracias al uso de PHP Data Objects (PDO).
 *
 * Configuración de la Base de Datos
 ************************************************************
 * ¡ADVERTENCIA! NUNCA uses credenciales hardcodeadas como estas en PRODUCCIÓN.
 * Usa variables de entorno o un archivo de configuración seguro.
 */
$host = 'localhost';
$db   = 'db_tarjetas_aliados';
$user = 'root';        // Usuario de desarrollo común (ajustar)
$pass = '';            // Contraseña vacía de desarrollo común (ajustar)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    // Lanza excepciones en errores (esencial para manejo de errores robusto)
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Obtiene resultados como arrays asociativos
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    // Deshabilita la emulación de declaraciones preparadas (Mejor seguridad)
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// CONEXIÓN Y MANEJO DE ERRORES
// ************************************************************
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Configura la respuesta HTTP a 500 (Error Interno del Servidor)
     http_response_code(500);
     // En producción, solo registra el error, no lo muestres
     die(json_encode(['error' => 'No se pudo establecer la conexión con el servidor de datos.']));
}

// CONSULTAS Y ESTRUCTURA DE DATOS
// ************************************************************
$data = [];

// 3.1. Consulta Fabricante (Objeto único)
try {
    $stmt = $pdo->query('SELECT logo_url FROM fabricante LIMIT 1');
    $fabricante_row = $stmt->fetch();
    
    // Mapeo al formato JSON: "fabricante_logo"
    $data['fabricante'] = [
        'fabricante_logo' => $fabricante_row ? $fabricante_row['logo_url'] : null
    ];
} catch (\PDOException $e) {
    error_log("Error al consultar fabricante: " . $e->getMessage());
    $data['fabricante'] = ['error' => 'Error de consulta de fabricante'];
}

// 3.2. Consulta Aliados (Array)
try {
    // Alias para mapear a la estructura JSON deseada
    $sql_aliados = "
        SELECT 
            id_aliado, 
            nombre AS aliado_nombre, 
            telefono AS aliado_telefono, 
            babull_url AS aliado_babull, 
            logo_url AS aliado_logo 
        FROM aliados
    ";
    $stmt = $pdo->query($sql_aliados);
    $data['aliados'] = $stmt->fetchAll();
    
} catch (\PDOException $e) {
    error_log("Error al consultar aliados: " . $e->getMessage());
    $data['aliados'] = ['error' => 'Error de consulta de aliados'];
}

// 3.3. Consulta Tarjetas (Array)
try {
    // si no estan asentadas las tarjetas los va a volver a imprimir // 1 -> 0
    $sql_tarjetas = "
        UPDATE tarjetas
        SET tarjeta_estado = 0
        WHERE tarjeta_estado = 1
    ";
    $stmt = $pdo->prepare($sql_tarjetas);
    $stmt->execute();
    // reune todas la tarjetas a imprimir // 0
    $sql_tarjetas = "
        SELECT
            monto, 
            codigo, 
            aliado_id 
        FROM tarjetas
        WHERE tarjeta_estado = 0
    ";
    $stmt = $pdo->query($sql_tarjetas);
    $data['tarjetas'] = $stmt->fetchAll();
    // marca las tarjetas como gestionadas // 0 -> 1
    $sql_tarjetas = "
        UPDATE tarjetas
        SET tarjeta_estado = 1
        WHERE tarjeta_estado = 0
    ";
    $stmt = $pdo->prepare($sql_tarjetas);
    $stmt->execute();

} catch (\PDOException $e) {
    error_log("Error al consultar tarjetas: " . $e->getMessage());
    $data['tarjetas'] = ['error' => 'Error de consulta de tarjetas'];
}

// GENERACIÓN DE RESPUESTA JSON
// ************************************************************

// 4. Establece la cabecera Content-Type
header('Content-Type: application/json');

// 5. Genera la salida JSON con formato legible
$json_output = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// 6. Imprime el resultado
echo $json_output;

// Nota: El fragmento de código JSON de ejemplo que proporcionaste al final
// se eliminó para dejar solo el código PHP ejecutable.
