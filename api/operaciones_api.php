<?php
include_once '../config/config.php';
include_once '../funciones/operaciones.php';
include_once '../utils/error.php';

// Configuración de cabeceras
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Activar el reporte de errores (solo para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Verificar si la solicitud es POST
if ($method === 'POST') {
    // Leer y decodificar los datos JSON
    $json = file_get_contents("php://input");
    error_log("JSON recibido: " . $json); // Mostrar el JSON recibido en el log

    $data = json_decode($json, true);

    // Verificar si la decodificación fue exitosa
    if ($data === null) {
        responderError("Error en el formato del JSON.", 400);
    }

    // Validar que se recibieron los parámetros necesarios
    if (!isset($data['action']) || !isset($data['valor1']) || !isset($data['valor2'])) {
        responderError("Faltan parámetros.", 400);
    }

    $operacion = $data['action'];
    $a = floatval($data['valor1']);
    $b = floatval($data['valor2']);

    // Verificar que los valores sean numéricos
    if (!is_numeric($a) || !is_numeric($b)) {
        responderError("Los valores deben ser numéricos.", 400);
    }

    // Mostrar qué operación se recibió
    error_log("Operación recibida: " . $operacion);

    // Realizar la operación matemática
    switch ($operacion) {
        case 'suma':
            $resultado = suma($a, $b);
            break;
        case 'resta':
            $resultado = resta($a, $b);
            break;
        case 'multiplicacion':
            $resultado = multiplicacion($a, $b);
            break;
        case 'division':
            if ($b == 0) {
                responderError("No se puede dividir por cero.", 400);
            }
            $resultado = division($a, $b);
            break;
        default:
            responderError("Operación no válida.", 400);
    }

    // Devolver el resultado en JSON
    echo json_encode(["resultado" => $resultado]);
} else {
    responderError("Método no permitido. Usa POST.", 405);
}

