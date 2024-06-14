<?php
session_start();

header("Content-Type: application/json");
include 'connection.php';

$pdo = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cod_alumno']) && isset($_POST['contrasena'])) {
        $cod_alumno = $_POST['cod_alumno'];
        $contrasena = $_POST['contrasena'];

        $sql = "SELECT * FROM user WHERE cod_alumno = :cod_alumno AND contrasena = :contrasena";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_alumno', $cod_alumno);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['cod_alumno'] = $user['cod_alumno'];
            $nombre = $user['nombre'];
            $sede = $user['sede'];
            $modalidad = $user['modalidad'];
            $puntaje = $user['puntaje'];
            $monedas = $user['monedas'];
            $data = array(
                'cod_alumno' => $cod_alumno,
                'nombre' => $nombre,
                'sede' => $sede,
                'modalidad' => $modalidad,
                'puntaje' => $puntaje,
                'monedas' => $monedas
            );

            header("HTTP/1.1 200 OK");
            echo json_encode($data);
        } else {
            header("HTTP/1.1 400 Credenciales incorrectas");
            echo json_encode(['error' => 'Credenciales incorrectas']);
        }
    } else {
        header("HTTP/1.1 400 Solicitud incorrecta");
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
    }
} else {
    header("HTTP/1.1 405 Método no permitido");
    echo json_encode(['error' => 'Método no permitido']);
}
?>
