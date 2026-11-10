<?php
$host = 'mysql';
$db = 'hola_mundo';
$user = 'appuser';
$password = 'apppassword';

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conexion->exec("
        CREATE TABLE IF NOT EXISTS mensajes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mensaje VARCHAR(100) NOT NULL
        )
    ");

    $conexion->exec("
        INSERT INTO mensajes (mensaje)
        SELECT 'Hola Mundo desde PHP y MySQL'
        WHERE NOT EXISTS (SELECT 1 FROM mensajes)
    ");

    $consulta = $conexion->query("SELECT mensaje FROM mensajes LIMIT 1");
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    $mensaje = $resultado['mensaje'];

} catch (PDOException $e) {
    $mensaje = "Error al conectar con la base de datos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola Mundo</title>
</head>
<body>
    <h1>¡Hola Mundo!</h1>
    <p><?php echo htmlspecialchars($mensaje); ?></p>
</body>
</html>
