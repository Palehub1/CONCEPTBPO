<?php

class Productos
{
    private $conn;
    private $table_name = 'productos';

    public $id;
    public $nombre;
    public $descripcion;
    public $rentabilidad;
    public $riesgo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    ////CREATE
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion, rentabilidad, riesgo) VALUES (:nombre, :descripcion, :rentabilidad, :riesgo)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->rentabilidad = htmlspecialchars(strip_tags($this->rentabilidad));
        $this->riesgo = htmlspecialchars(strip_tags($this->riesgo));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':rentabilidad', $this->rentabilidad);
        $stmt->bindParam(':riesgo', $this->riesgo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /////READ
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    ///READone
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nombre = $row['nombre'];
            $this->descripcion = $row['descripcion'];
            $this->rentabilidad = $row['rentabilidad'];
            $this->riesgo = $row['riesgo'];
        }
        if ($stmt->execute()) {
        }
        return $row !== false;
    }

    ////UPDATE
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
            SET nombre = :nombre, descripcion = :descripcion, rentabilidad = :rentabilidad, riesgo = :riesgo WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->rentabilidad = htmlspecialchars(strip_tags($this->rentabilidad));
        $this->riesgo = htmlspecialchars(strip_tags($this->riesgo));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':rentabilidad', $this->rentabilidad);
        $stmt->bindParam(':riesgo', $this->riesgo);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //obterner po ID
    public function getById($id)
    {
        $query = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /////DELETE
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
