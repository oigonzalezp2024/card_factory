<?php
// generar_pdf.php - Consume los datos de la API JSON (tu script de base de datos)

// ----------------------------------------------------------------------------------
// 1. INCLUSIÓN DE LIBRERÍAS Y CONFIGURACIÓN DE LA API
// ----------------------------------------------------------------------------------

require('fpdf/fpdf.php');
require_once "../../config.php";

// 2. OBTENCIÓN DE DATOS MEDIANTE API (HTTP REQUEST)
// ************************************************************

// Opción simple: file_get_contents (Requiere allow_url_fopen = On)
$json_data = @file_get_contents($API_URL);

// Manejo de error de petición
if ($json_data === false) {
    // Si la API falla, detenemos la ejecución y mostramos un error.
    die("Error fatal: No se pudo conectar ni obtener datos de la API en: " . $API_URL);
}

// Decodificación del JSON
$data = json_decode($json_data, true);

// Manejo de error de decodificación o datos no válidos
if ($data === null) {
    die("Error fatal: El JSON recibido de la API no es válido. Mensaje: " . json_last_error_msg());
}

// Manejo de errores de la API (si la API devolvió un código de error JSON)
if (isset($data['error'])) {
    die("Error de datos reportado por la API: " . $data['error']);
}

// Asignación de variables desde el array de datos
$tarjetas = $data['tarjetas'];
$aliados = $data['aliados'];
$logo_fabricante_ruta = $data['fabricante']['fabricante_logo'];

// ----------------------------------------------------------------------------------
// 3. FUNCIONES DE UTILIDAD
// ----------------------------------------------------------------------------------

/**
 * Función de utilidad para buscar datos del aliado dentro del array cargado.
 */
function obtenerDatosAliado($id, $aliados_array)
{
    foreach ($aliados_array as $aliado) {
        if ($aliado['id_aliado'] === $id) {
            return $aliado;
        }
    }
    return false;
}

/**
 * Ajusta la posición Y del PDF.
 */
function setPositionYNextRow(
    $pdf,
    $columna,
    $max_tarjetas_por_fila,
    $y,
    $alto_tarjeta
) {
    if ($columna == $max_tarjetas_por_fila - 1) {
        $pdf->SetY($y + $alto_tarjeta);
    }
}

// ----------------------------------------------------------------------------------
// 4. CLASE EXTENDIDA DE FPDF (Código de Barras)
// ----------------------------------------------------------------------------------
class PDF extends FPDF
{
    function BarCode39($x, $y, $code, $w, $h)
    {
        $code_formatted = '*' . $code . '*';
        $this->SetFont('LibreBarcode39Text-Regular', '', 18);
        $this->SetFontSize($h * 1.5);
        $this->Text($x + ($w - $this->GetStringWidth($code_formatted)) / 2, $y + $h * 0.9, $code_formatted);
    }
}

// ----------------------------------------------------------------------------------
// 5. INICIALIZACIÓN Y CONFIGURACIÓN DEL PDF
// ----------------------------------------------------------------------------------

$pdf = new PDF();
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 0);

// **********************************************************************************
// CAMBIO CLAVE 1: Definir la página a 320mm (Ancho) x 480mm (Alto) (32x48 cm Vertical)
$pdf->AddPage('P', array(320, 480));
// **********************************************************************************

$pdf->AddFont('LibreBarcode39Text-Regular', '', 'LibreBarcode39Text-Regular.php');

// 6. DEFINICIÓN DE DIMENSIONES Y COLORES

$max_tarjetas_por_fila = 5; 
// **********************************************************************************
// CAMBIO CLAVE 2: Actualizar las dimensiones totales del PDF al nuevo tamaño
$ANCHO_TOTAL_PDF = 320; // 320 mm (32 cm)
$ALTURA_HOJA_DISPONIBLE = 480; // 480 mm (48 cm)
// **********************************************************************************

$ancho_tarjeta = 55; 
$alto_tarjeta = 90; 
$contador_tarjetas = 0;

$COLOR_BLANCO = array(255, 255, 255);
$COLOR_NEGRO = array(0, 0, 0);
$COLOR_DORADO = array(184, 134, 11);
$COLOR_GRIS_FONDO = array(240, 240, 240);

$TEXTO_CONDICIONES = utf8_decode("Ver condiciones y restricciones");
$TEXTO_CONDICIONES_ = utf8_decode("en babull.com.co");

$ancho_total_tarjetas = $ancho_tarjeta * $max_tarjetas_por_fila;
// Calcular el margen para centrar 5 tarjetas de 55mm en 320mm de ancho
$margen_izquierda_total = ($ANCHO_TOTAL_PDF - $ancho_total_tarjetas) / 2;

// ----------------------------------------------------------------------------------
// 7. BUCLE PARA GENERAR LAS TARJETAS
// ----------------------------------------------------------------------------------

if (!empty($tarjetas)) {
    foreach ($tarjetas as $tarjeta) {
        // Obtenemos los datos del aliado del array $aliados que se cargó del JSON
        $datos_aliado = obtenerDatosAliado($tarjeta['aliado_id'], $aliados);

        if (!$datos_aliado) {
            error_log("Aliado ID: " . $tarjeta['aliado_id'] . " no encontrado, saltando tarjeta.");
            continue;
        }

        // Cálculo de Posición 
        $columna = $contador_tarjetas % $max_tarjetas_por_fila;
        $x = $margen_izquierda_total + ($columna * $ancho_tarjeta);
        
        if ($columna == 0) {
            if ($pdf->GetY() + $alto_tarjeta > $ALTURA_HOJA_DISPONIBLE) {
                // **********************************************************************************
                // Asegurar que la nueva página use el tamaño personalizado (320x480)
                $pdf->AddPage('P', array(320, 480)); 
                // **********************************************************************************
                $pdf->SetY(0);
            }
            $y = $pdf->GetY();
        }
        
        $pdf->SetXY($x, $y);
        
        // FORMATO DE MONEDA
        $monto_mil = (float)$tarjeta['monto'] * 1000;
        $monto_formato = '$' . number_format($monto_mil, 0, ',', '.');
        
        // Dibuja el fondo y borde
        $pdf->SetFillColor($COLOR_GRIS_FONDO[0], $COLOR_GRIS_FONDO[1], $COLOR_GRIS_FONDO[2]);
        $pdf->Rect($x, $y, $ancho_tarjeta, $alto_tarjeta, 'F');
        $pdf->SetDrawColor(180, 180, 180);
        $pdf->Rect($x, $y, $ancho_tarjeta, $alto_tarjeta, 'D');

        // --- SECCIÓN SUPERIOR CON LOGO DE ALIADO (25mm) ---
        $ALTURA_LOGO_SUPERIOR = 25; 
        $ruta_logo = $datos_aliado['aliado_logo'];
        $pdf->SetY($y);
        
        if (file_exists($ruta_logo)) {
            $pdf->Image($ruta_logo, $x, $y, $ancho_tarjeta, $ALTURA_LOGO_SUPERIOR);
        } else {
            $pdf->SetFillColor(80, 40, 20);
            $pdf->Rect($x, $y, $ancho_tarjeta, $ALTURA_LOGO_SUPERIOR, 'F');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor($COLOR_BLANCO[0], $COLOR_BLANCO[1], $COLOR_BLANCO[2]);
            $pdf->SetXY($x, $y + 10);
            $pdf->Cell($ancho_tarjeta, 4, utf8_decode("LOGO ALIADO (25mm)"), 0, 1, 'C');
            $pdf->SetTextColor(0);
        }
        
        // --- FRANJA OSCURA 1 (Teléfono - 5mm) ---
        $y_info = $y + $ALTURA_LOGO_SUPERIOR;
        $pdf->SetFillColor($COLOR_NEGRO[0], $COLOR_NEGRO[1], $COLOR_NEGRO[2]);
        $pdf->Rect($x, $y_info, $ancho_tarjeta, 5, 'F');
        $pdf->SetXY($x, $y_info + 0.5);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor($COLOR_BLANCO[0], $COLOR_BLANCO[1], $COLOR_BLANCO[2]);
        $pdf->Cell($ancho_tarjeta, 4, "Cel.: " . $datos_aliado['aliado_telefono'], 0, 1, 'C');
        $pdf->SetTextColor(0);

        // --- SECCIÓN CENTRAL (REGALO, Monto, URL y LOGO FABRICANTE) ---
        $y_regalo = $y_info + 8;
        
        $pdf->SetXY($x, $y_regalo);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor($COLOR_DORADO[0], $COLOR_DORADO[1], $COLOR_DORADO[2]);
        $pdf->Cell($ancho_tarjeta, 3, 'REGALO', 0, 1, 'C');
        
        $pdf->SetXY($x, $y_regalo + 6);
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->SetTextColor(0);
        $pdf->Cell($ancho_tarjeta, 5, $monto_formato, 0, 1, 'C');
        
        $pdf->SetXY($x, $y_regalo + 13);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($ancho_tarjeta, 3, $datos_aliado['aliado_babull'], 0, 1, 'C');
        
        $TAM_LOGO_FABRICANTE = 13;
        $x_logo_fab = $x + ($ancho_tarjeta / 2) - ($TAM_LOGO_FABRICANTE / 2);
        $y_logo_fab = $y_regalo + 18;
        
        if (file_exists($logo_fabricante_ruta)) {
            $pdf->Image($logo_fabricante_ruta, $x_logo_fab, $y_logo_fab, $TAM_LOGO_FABRICANTE, $TAM_LOGO_FABRICANTE);
        } else {
            $pdf->SetFillColor(50, 50, 200);
            $pdf->Rect($x_logo_fab, $y_logo_fab, $TAM_LOGO_FABRICANTE, $TAM_LOGO_FABRICANTE, 'F');
        }

        // --- CÓDIGO DE BARRAS ---
        $ALTURA_BARCODE_Y = $y + $alto_tarjeta - 33;
        $alto_para_barcode = 16;
        $ancho_tarjeta_margin = 2;
        $ancho_para_barcode_dibujo = $ancho_tarjeta - ($ancho_tarjeta_margin * 2);
        $x_barcode_inicio = $x + $ancho_tarjeta_margin;
        
        $pdf->BarCode39($x_barcode_inicio, $ALTURA_BARCODE_Y, $tarjeta['codigo'], $ancho_para_barcode_dibujo, $alto_para_barcode);

        // --- FRANJA INFERIOR (Condiciones - 5mm) ---
        $y_bottom = $y + $alto_tarjeta - 18;
        $pdf->SetFillColor($COLOR_GRIS_FONDO[0], $COLOR_GRIS_FONDO[1], $COLOR_GRIS_FONDO[2]);
        //$pdf->SetFillColor(122, 122, 122);
        $pdf->Rect($x+2, $y_bottom, $ancho_tarjeta-5, 4, 'F');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($COLOR_NEGRO[0], $COLOR_NEGRO[1], $COLOR_NEGRO[2]);

        $pdf->BarCode39($x_barcode_inicio, $ALTURA_BARCODE_Y+4.9, $tarjeta['codigo'], $ancho_para_barcode_dibujo, $alto_para_barcode);

        // --- FRANJA INFERIOR (Condiciones - 5mm) ---
        $y_bottom = $y + $alto_tarjeta - 8;
        $pdf->SetFillColor($COLOR_BLANCO[0], $COLOR_BLANCO[1], $COLOR_BLANCO[2]);
        $pdf->Rect($x, $y_bottom, $ancho_tarjeta, 8, 'F');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($COLOR_NEGRO[0], $COLOR_NEGRO[1], $COLOR_NEGRO[2]);
        
        $pdf->SetXY($x, $y_bottom + 2);
        $pdf->Cell($ancho_tarjeta, 2, $TEXTO_CONDICIONES, 0, 0, 'C');
        
        $pdf->SetXY($x, $y_bottom + 4.5);
        $pdf->Cell($ancho_tarjeta, 2, $TEXTO_CONDICIONES_, 0, 0, 'C');
        $pdf->SetTextColor(0);
        
        // Ajustar la posición Y para la siguiente fila
        setPositionYNextRow(
            $pdf,
            $columna,
            $max_tarjetas_por_fila,
            $y,
            $alto_tarjeta
        );
        $contador_tarjetas++;
    }
}

// 8. SALIDA DEL DOCUMENTO
$pdf->Output('D', 'Tarjetas_55mm_90mm_32x48cm_API_JSON.pdf');