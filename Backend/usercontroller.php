<?php
require 'database.php';
require 'usermodel.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new UserModel($this->db);
    }

    //Obtener todos los usuarios
    public function getUsers() {
        $stmt = $this->user->read();
        $users_arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
                "id" => $id,
                "name" => $name,
                "lastname" => $lastname,
                "email" => $email
            );
            array_push($users_arr, $user_item);
        }
        return $users_arr;
    }

    //Obtener un solo usuario
    public function getUser($id) {
        $this->user->id = $id;
        $this->user->readSingle();
        if ($this->user->name != null) {
            return array(
                "id" => $this->user->id,
                "name" => $this->user->name,
                "lastname" => $this->user->lastname,
                "email" => $this->user->email
            );
        }
        return null;
    }

    //Crear un Usuario
    public function createUser($data){
        $this->user->name = $data->name;
        $this->user->lastname = $data->lastname;
        $this->user->email = $data->email;
        
        if ($this->user->create()) {
            return true;
        }
        return false;
    }

    //Actualizar un Usuario
    public function updateUser($data) {
        $this->user->id = $data->id;
        $this->user->name = $data->name;
        $this->user->lastname = $data->lastname;
        $this->user->email = $data->email;
        
        if ($this->user->update()) {
            return true;
        }
        return false;
    }

    //Eliminar Usuario
    public function deleteUser($id) {
        $this->user->id = $id;
        if ($this->user->delete()) {
            return true;
        } else {
            return false;
        }
    }
}