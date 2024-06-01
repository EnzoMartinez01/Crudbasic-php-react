<?php

class UserModel{
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $lastname;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Crear Usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, lastname=:lastname, email=:email";
        $stmt = $this->conn->prepare($query);

        //Limpiar Datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));

        //Enlazar Datos
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Leer Usuarios
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //Leer un Solo Usuario
    public function readSingle() {
        $query = "SELECT * FROM " . $this-table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->name = $row['name'];
            $this->lastname = $row['lastname'];
            $this->email = $row['email'];
        }
    }

    // Actualizar Usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, lastname=:lastname, email=:email WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        //Limpiar Datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Enlazar Datos
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Eliminar Usuario
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
    
        // Limpiar datos
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Enlazar id del registro a eliminar
        $stmt->bindParam(1, $this->id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>