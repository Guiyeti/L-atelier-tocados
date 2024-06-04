<?php
include 'config.php';

// Consultar productos y actualizar rutas de imágenes si es necesario
$sql = "SELECT id_producto, imagen FROM producto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_producto = $row['id_producto'];
        $imagen = $row['imagen'];
        
        // Verificar si la ruta no tiene el prefijo 'imagenes/'
        if (strpos($imagen, 'imagenes/') === false) {
            $nueva_imagen = 'imagenes/' . $imagen;
            $update_sql = "UPDATE producto SET imagen = ? WHERE id_producto = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("si", $nueva_imagen, $id_producto);
            $stmt->execute();
            $stmt->close();
        }
    }
}

echo "Actualización de rutas completada.";
?>
