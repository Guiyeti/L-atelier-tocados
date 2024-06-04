<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latelier1";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener la consulta de búsqueda
$query = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$sql = "SELECT id_producto, nombre, imagen, precio FROM producto WHERE LOWER(nombre) LIKE '%" . $conn->real_escape_string($query) . "%'";
$result = $conn->query($sql);

$productos = array();
if ($result->num_rows > 0) {
    // Salida de cada fila
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
} 

// Devolver los resultados en formato JSON
echo json_encode($productos);

// Cerrar la conexión
$conn->close();
?>
