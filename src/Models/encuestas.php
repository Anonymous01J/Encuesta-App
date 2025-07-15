<?php
namespace Anonymous01j\Encuesta\Models;
use Anonymous01j\Encuesta\Models\Conexion;

    class Encuestas extends Conexion {
        private $id;
        private $nombre;
        private $tipo;
        private $descripcion;
        private $estado;

        public function __construct($id = null, $nombre = null, $tipo = null, $descripcion = null, $estado = null) {
            parent::__construct();
            $this->id = $id;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->descripcion = $descripcion;
            $this->estado = $estado;
        }

        public function getId() { return $this->id; }
        public function getNombre() { return $this->nombre; }
        public function getTipo() { return $this->tipo; }
        public function getDescripcion() { return $this->descripcion; }
        public function getEstado() { return $this->estado; }

        public function setId($id) { $this->id = $id; return $this; }
        public function setNombre($nombre) { $this->nombre = $nombre; return $this; }
        public function setTipo($tipo) { $this->tipo = $tipo; return $this; }
        public function setDescripcion($descripcion) { $this->descripcion = $descripcion; return $this; }
        public function setEstado($estado) { $this->estado = $estado; return $this; }

        public function insert() {
            $sql = "INSERT INTO encuestas (nombre, tipo, descripcion) VALUES (:nombre, :tipo, :descripcion)";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":tipo", $this->tipo);
            $stmt->bindParam(":descripcion", $this->descripcion);
            return $stmt->execute();
        }

        public function search() {
            $sql = "SELECT e.id, e.nombre, e.descripcion, e.tipo, 
                        COUNT(r.id) as respuestas
                    FROM encuestas e
                    LEFT JOIN preguntas p ON p.id_encuesta = e.id
                    LEFT JOIN respuestas r ON r.id_pregunta = p.id
                    WHERE e.estado = 1
                    GROUP BY e.id";
            
            $stmt = $this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        public function searchId($id) {
            $sql = "SELECT e.id, e.nombre, e.descripcion, e.tipo, 
                            COUNT(r.id) as respuestas
                    FROM encuestas e
                    LEFT JOIN preguntas p ON p.id_encuesta = e.id
                    LEFT JOIN respuestas r ON r.id_pregunta = p.id
                    WHERE e.estado = 1 AND e.id = :id
                    GROUP BY e.id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function update($id,$nombre,$tipo,$descripcion) {
            $sql = "UPDATE encuestas SET nombre = :nombre, tipo = :tipo, descripcion = :descripcion WHERE id = :id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":tipo", $this->tipo);
            $stmt->bindParam(":descripcion", $this->descripcion);
            return $stmt->execute();
        }

        public function delete($id) {
            $sql = "UPDATE encuestas set estado = 0 FROM  WHERE id = :id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $this->id);
            return $stmt->execute();
        }
        public function contResponse($encuestaId) {
            $sql = "UPDATE encuestas SET respuestas = respuestas + 1 WHERE id = :id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(':id', $encuestaId, \PDO::PARAM_INT);
            $stmt->execute();
        }
}