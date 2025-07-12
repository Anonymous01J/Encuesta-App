<?php
namespace Anonymous01j\Encuesta\Models;
use Anonymous01j\Encuesta\Models\Conexion;

class Usuario extends Conexion {
    private $id;
    private $nombre;
    private $cargo;
    private $fechaRegistro;

    public function __construct($id = null, $nombre = null, $cargo=null, $fechaRegistro = null) {
        parent::__construct();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cargo = $cargo;
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getCargo() { return $this->cargo; }
    public function getFechaRegistro() { return $this->fechaRegistro; }

    public function setId($id) { $this->id = $id; return $this; }
    public function setNombre($nombre) { $this->nombre = $nombre; return $this; }
    public function setCargo($cargo) { $this->cargo = $cargo; return $this; }
    public function setFechaRegistro($fechaRegistro) { $this->fechaRegistro = $fechaRegistro; return $this; }

    public function crear($nombre,$cargo, $correo) {
        $sql = "INSERT INTO usuarios (nombre, cargo, fecha_registro) VALUES (:nombre, :cargo, NOW())";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":cargo", $cargo);
        $stmt->execute();
    }

    public function search() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update($id, $nombre, $cargo, $correo) {
        $sql = "UPDATE usuarios SET nombre = :nombre, cargo = :cargo WHERE id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":cargo", $cargo);
        $stmt->execute();
    }
}
