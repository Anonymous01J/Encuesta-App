<?php
    namespace Anonymous01j\Encuesta\Models;
    use Anonymous01j\Encuesta\Models\Conexion;

    class Respuesta extends Conexion {
        private $id;
        private $idUsuario;
        private $idPregunta;
        private $idOpcion;
        private $valorTexto;
        private $fecha;

        public function __construct($id = null, $idUsuario = null, $idPregunta = null, $idOpcion = null, $valorTexto = null, $fecha = null) {
            parent::__construct();
            $this->id = $id;
            $this->idUsuario = $idUsuario;
            $this->idPregunta = $idPregunta;
            $this->idOpcion = $idOpcion;
            $this->valorTexto = $valorTexto;
            $this->fecha = $fecha;
        }

        public function getId() { return $this->id; }
        public function getIdUsuario() { return $this->idUsuario; }
        public function getIdPregunta() { return $this->idPregunta; }
        public function getIdOpcion() { return $this->idOpcion; }
        public function getValorTexto() { return $this->valorTexto; }
        public function getFecha() { return $this->fecha; }

        public function setId($id) { $this->id = $id; return $this; }
        public function setIdUsuario($idUsuario) { $this->idUsuario = $idUsuario; return $this; }
        public function setIdPregunta($idPregunta) { $this->idPregunta = $idPregunta; return $this; }
        public function setIdOpcion($idOpcion) { $this->idOpcion = $idOpcion; return $this; }
        public function setValorTexto($valorTexto) { $this->valorTexto = $valorTexto; return $this; }
        public function setFecha($fecha) { $this->fecha = $fecha; return $this; }

        public function insert() {
            $sql = "INSERT INTO respuestas (id_usuario, id_pregunta, id_opcion, valor_texto, fecha) VALUES (:id_usuario, :id_pregunta, :id_opcion, :valor_texto, NOW())";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id_usuario", $this->idUsuario);
            $stmt->bindParam(":id_pregunta", $this->idPregunta);
            $stmt->bindParam(":id_opcion", $this->idOpcion);
            $stmt->bindParam(":valor_texto", $this->valorTexto);
            return $stmt->execute();
        }

        public function search() {
            $sql = "SELECT * FROM respuestas";
            $stmt = $this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update($id,$idUsuario,$idPregunta,$idOpcion,$valorTexto) {
            $sql = "UPDATE respuestas SET id_usuario = :id_usuario, id_pregunta = :id_pregunta, id_opcion = :id_opcion, valor_texto = :valor_texto WHERE id = :id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $this->$id);
            $stmt->bindParam(":id_usuario", $this->$idUsuario);
            $stmt->bindParam(":id_pregunta", $this->$idPregunta);
            $stmt->bindParam(":id_opcion", $this->$idOpcion);
            $stmt->bindParam(":valor_texto", $this->$valorTexto);
            return $stmt->execute();
        }
    }