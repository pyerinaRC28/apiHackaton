<?php
session_start();

header("Content-Type: application/json");
include '../connection.php';

$pdo = new Conexion();

function respond($status, $data)
{
    header("HTTP/1.1 " . $status);
    echo json_encode($data);
    exit;
}

set_error_handler(function ($severity, $message, $file, $line) {
    error_log("Error PHP: $message en $file en la línea $line", 0);
    respond(500, ['error' => "Error PHP: $message en $file en la línea $line"]);
});

set_exception_handler(function ($exception) {
    error_log("Excepción: " . $exception->getMessage(), 0);
    respond(500, ['error' => $exception->getMessage()]);
});

error_log("Método de solicitud: " . $_SERVER['REQUEST_METHOD'], 0);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Manejando solicitud GET", 0);
    if (isset($_GET['cod_prod'])) {
        error_log("cod_prod: " . $_GET['cod_prod'], 0);
        $sql = $pdo->prepare("SELECT * FROM store WHERE cod_prod=:cod_prod");
        $sql->bindValue(':cod_prod', $_GET['cod_prod'], PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            error_log("Producto encontrado: " . json_encode($result), 0);
            respond(200, $result);
        } else {
            error_log("Producto no encontrado", 0);
            respond(404, ['error' => 'Producto no encontrado']);
        }
    } else {
        error_log("Obteniendo todos los productos", 0);
        $sql = $pdo->prepare("SELECT * FROM store");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        error_log("Productos encontrados: " . json_encode($result), 0);
        respond(200, $result);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    error_log("Manejando solicitud PUT", 0);
    if (isset($_GET['cod_prod'])) {
        error_log("cod_prod: " . $_GET['cod_prod'], 0);
        // Obtener los datos enviados en la solicitud
        $input = file_get_contents("php://input");
        error_log("Datos de entrada: " . $input, 0);
        $data = json_decode($input, true);
        error_log("Datos decodificados: " . json_encode($data), 0);

        if (isset($data['stock'])) {
            error_log("Actualizando stock a: " . $data['stock'], 0);
            $sql = $pdo->prepare("UPDATE store SET stock=:stock WHERE cod_prod=:cod_prod");
            $sql->bindValue(':stock', $data['stock'], PDO::PARAM_INT);
            $sql->bindValue(':cod_prod', $_GET['cod_prod'], PDO::PARAM_INT);
            if ($sql->execute()) {
                error_log("Stock actualizado correctamente", 0);
                respond(200, ['message' => 'Stock actualizado correctamente']);
            } else {
                error_log("Error al actualizar el stock", 0);
                respond(500, ['error' => 'Error al actualizar el stock']);
            }
        } else {
            error_log("Falta el parámetro de stock", 0);
            respond(400, ['error' => 'Parámetro de stock faltante']);
        }
    } else {
        error_log("Falta el ID del producto", 0);
        respond(400, ['error' => 'ID de producto faltante']);
    }
} else {
    error_log("Método no permitido", 0);
    respond(405, ['error' => 'Método no permitido']);
}
?>
