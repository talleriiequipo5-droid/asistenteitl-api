<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// ============================================
// CONEXIÓN A LA BASE DE DATOS
// ============================================
$servername = "sql209.infinityfree.com";
$username   = "if0_40263650";
$password   = "t7JbLtWPpTHFCt";
$dbname     = "if0_40263650_bd_ingreso";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

// ============================================
// VERIFICAR MÉTODO HTTP
// ============================================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método no permitido. Use POST."]);
    exit;
}

// ============================================
// LEER Y DECODIFICAR EL JSON
// ============================================
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['nombre'], $data['correo'], $data['curp'], $data['carrera'])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos o inválidos"]);
    exit;
}

// ============================================
// SANITIZAR VARIABLES
// ============================================
$nombre        = $conn->real_escape_string($data['nombre']);
$correo        = $conn->real_escape_string($data['correo']);
$curp          = $conn->real_escape_string($data['curp']);
$carrera       = $conn->real_escape_string($data['carrera']);
$documento_url = isset($data['documento_url']) ? $conn->real_escape_string($data['documento_url']) : null;

// ============================================
// INSERTAR EN LA BASE DE DATOS
// ============================================
$sql = "INSERT INTO aspirantes (nombre, correo, curp, carrera, documento_url)
        VALUES ('$nombre', '$correo', '$curp', '$carrera', " . ($documento_url ? "'$documento_url'" : "NULL") . ")";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        "status" => "ok",
        "message" => "Registro exitoso",
        "data" => [
            "id" => $conn->insert_id,
            "nombre" => $nombre,
            "correo" => $correo,
            "curp" => $curp,
            "carrera" => $carrera
        ]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al guardar: " . $conn->error
    ]);
}

$conn->close();
?>
