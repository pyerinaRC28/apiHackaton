<?php
session_start();

header("Content-Type: application/json");
include '../connection.php';

$pdo = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cod_alumno'])) {
        $cod_alumno = $_GET['cod_alumno'];

        $sql = "SELECT * FROM user WHERE cod_alumno = :cod_alumno";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_alumno', $cod_alumno);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            header("HTTP/1.1 200 OK");
            echo json_encode($user);
        } else {
            header("HTTP/1.1 404 No encontrado");
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    } else {
        header("HTTP/1.1 400 Solicitud incorrecta");
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = json_decode(file_get_contents("php://input"), true);
    if (isset($input['cod_alumno']) && isset($input['puntaje']) && isset($input['monedas'])) {
        $cod_alumno = $input['cod_alumno'];
        $puntaje = $input['puntaje'];
        $monedas = $input['monedas'];

        $sql = "UPDATE user SET puntaje = :puntaje, monedas = :monedas WHERE cod_alumno = :cod_alumno";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cod_alumno', $cod_alumno);
        $stmt->bindParam(':puntaje', $puntaje);
        $stmt->bindParam(':monedas', $monedas);
        $result = $stmt->execute();

        if ($result) {
            header("HTTP/1.1 200 OK");
            echo json_encode(['message' => 'Usuario actualizado exitosamente']);
        } else {
            header("HTTP/1.1 500 Error interno del servidor");
            echo json_encode(['error' => 'Error al actualizar usuario']);
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