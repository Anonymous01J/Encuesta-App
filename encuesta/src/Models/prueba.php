<?php
    namespace Anonymous01j\Encuesta\Models;
    use Anonymous01j\Encuesta\Models\Conexion;
    
    class Preguntas extends Conexion {
        private $id;
        private $id_encuesta;
        private $texto;
        private $tipoRespuesta;
        private $orden;

        public function __construct($id = null, $id_encuesta = null, $texto = null, $tipoRespuesta = null, $orden = null) {
            parent::__construct();
            $this->id = $id;
            $this->id_encuesta = $id_encuesta;
            $this->texto = $texto;
            $this->tipoRespuesta = $tipoRespuesta;
            $this->orden = $orden;
        }

        public function getId() { return $this->id; }
        public function getIdEncuesta() { return $this->id_encuesta; }
        public function getTexto() { return $this->texto; }
        public function getTipoRespuesta() { return $this->tipoRespuesta; }
        public function getOrden() { return $this->orden; }

        public function setId($id) { $this->id = $id; return $this; }
        public function setIdEncuesta($id_encuesta) { $this->id_encuesta = $id_encuesta; return $this; }
        public function setTexto($texto) { $this->texto = $texto; return $this; }
        public function setTipoRespuesta($tipoRespuesta) { $this->tipoRespuesta = $tipoRespuesta; return $this; }
        public function setOrden($orden) { $this->orden = $orden; return $this; }

        public function insert() {
            $sql = "INSERT INTO preguntas (id_encuesta, texto, tipo_respuesta, orden) VALUES (:id_encuesta, :texto, :tipo_respuesta, :orden)";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id_encuesta", $this->id_encuesta);
            $stmt->bindParam(":texto", $this->texto);
            $stmt->bindParam(":tipo_respuesta", $this->tipoRespuesta);
            $stmt->bindParam(":orden", $this->orden);
            return $stmt->execute();
        }

        public function search() {
            $sql = "SELECT * FROM preguntas";
            $stmt = $this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update($id,$id_encuesta,$texto,$tipoRespuesta,$orden) {
            $sql = "UPDATE preguntas SET id_encuesta = :id_encuesta, texto = :texto, tipo_respuesta = :tipo_respuesta, orden = :orden WHERE id = :id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $this->$id);
            $stmt->bindParam(":id_encuesta", $this->$id_encuesta);
            $stmt->bindParam(":texto", $this->$texto);
            $stmt->bindParam(":tipo_respuesta", $this->$tipoRespuesta);
            $stmt->bindParam(":orden", $this->$orden);
            return $stmt->execute();
        }
        public function surveyQuestions($id){
            $sql = "SELECT id,texto FROM `preguntas` WHERE id_encuesta = :id ORDER BY orden";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $this->$id);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);    
        }
    }