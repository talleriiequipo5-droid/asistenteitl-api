<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

$servername = "sql209.infinityfree.com";  
$username = "if0_40263650";
$password = "t7JbltWPpTHFCt"; 
$dbname = "if0_40263650_bd_ingreso";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    exit;
}

$nombre = $conn->real_escape_string($data['nombre']);
$correo = $conn->real_escape_string($data['correo']);
$curp = $conn->real_escape_string($data['curp']);
$carrera = $conn->real_escape_string($data['carrera']);
$documento_url = isset($data['documento_url']) ? $conn->real_escape_string($data['documento_url']) : null;

$sql = "INSERT INTO aspirantes (nombre, correo, curp, carrera, documento_url)
        VALUES ('$nombre', '$correo', '$curp', '$carrera', '$documento_url')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "ok", "message" => "Registro exitoso"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
