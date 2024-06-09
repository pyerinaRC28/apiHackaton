<?php
session_start();

header("Content-Type: application/json");
include '../connection.php';

$pdo = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cod_alumno'])) {
        $sql = $pdo->prepare("SELECT * FROM pedido WHERE alumno=:cod_alumno");
        $sql->bindValue(':cod_alumno', $_GET['cod_alumno'], PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID de alumno faltante']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['alumno']) && isset($data['merch']) && isset($data['f_ingreso']) && isset($data['estado'])) {
        $sql = $pdo->prepare("INSERT INTO pedido (alumno, merch, f_ingreso, estado) VALUES (:alumno, :merch, :f_ingreso, :estado)");
        $sql->bindValue(':alumno', $data['alumno'], PDO::PARAM_STR);
        $sql->bindValue(':merch', $data['merch'], PDO::PARAM_INT);
        $sql->bindValue(':f_ingreso', $data['f_ingreso'], PDO::PARAM_STR);
        $sql->bindValue(':estado', $data['estado'], PDO::PARAM_STR);
        if ($sql->execute()) {
            echo json_encode(['message' => 'Pedido creado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el pedido']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos incompletos para crear el pedido']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
