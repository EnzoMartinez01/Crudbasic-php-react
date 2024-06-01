<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require 'usercontroller.php';

$request_method = $_SERVER["REQUEST_METHOD"];

$controller = new UserController();

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $user = $controller->getUser($id);
            if ($user) {
                echo json_encode($user);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Usuario no encontrado."));
            }
        } else {
            $users = $controller->getUsers();
            echo json_encode($users);
        }
        break;
    
    case  'POST':
        $data = json_decode(file_get_contents("php://input"));
        if ($controller->createUser($data)){
            http_response_code(201);
            echo json_encode(array("message" => "Usuario Creado."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se pudo Crear al usuario."));
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if($controller->updateUser($data)) {
            http_response_code(200);
            echo json_encode(array("message" => "Datos Modificados."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "No se pudó modificar al usuario."));
        }
        break;

    case 'DELETE':
        // Obtener el ID de la URL
        if (preg_match('/\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
            $id = intval($matches[1]);
            if ($controller->deleteUser($id)) {
                http_response_code(200);
                echo json_encode(array("message" => "Usuario eliminado."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "No se pudo eliminar al usuario."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No se proporcionó el ID del usuario."));
        }
        break;
    
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método no permitido."));
        break;
}