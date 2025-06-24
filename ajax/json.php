<?php
header('Content-Type: application/json');

// Conexión segura
include("../config/db.php");
$con = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión"]);
    exit;
}

// Sanitizar entrada
$search = trim($_GET['q'] ?? '');
$search = "%{$search}%";

// Preparar consulta segura
$stmt = mysqli_prepare($con, "SELECT id, nombre, email, telefono, direccion FROM proveedores WHERE nombre LIKE ? LIMIT 40");
mysqli_stmt_bind_param($stmt, "s", $search);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['id'],
        'text' => $row['nombre'],
        'email' => $row['email'],
        'telefono' => $row['telefono'],
        'direccion' => $row['direccion']
    ];
}

echo json_encode($data);
?>
