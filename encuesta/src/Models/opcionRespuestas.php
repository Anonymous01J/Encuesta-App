<?php
    namespace Anonymous01j\Encuesta\Models;
    use Anonymous01j\Encuesta\Models\Conexion;

    class OpcionRespuesta extends Conexion {
        private $id;
        private $idPregunta;
        private $valor;
        private $peso;

        public function __construct($id = null, $idPregunta = null, $valor = null, $peso = null) {
            parent::__construct();
            $this->id = $id;
            $this->IdPregunta = $idPregunta;
            $this->valor = $valor;
            $this->peso = $peso;
        }

        public function getId() { return $this->id; }
        public function getIdPregunta() { return $this->IdPregunta; }
        public function getValor() { return $this->valor; }
        public function getPeso() { return $this->peso; }

        public function setId($id) { $this->id = $id; return $this; }
        public function setIdPregunta($idPregunta) { $this->IdPregunta = $idPregunta; return $this; }
        public function setValor($valor) { $this->valor = $valor; return $this; }
        public function setPeso($peso) { $this->peso = $peso; return $this; }

        public function insert() {
            $sql = "INSERT INTO opciones_respuesta (id_pregunta, valor, peso) VALUES (:id_pregunta, :valor, :peso)";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id_pregunta", $this->IdPregunta);
            $stmt->bindParam(":valor", $this->valor);
            $stmt->bindParam(":peso", $this->peso);
            return $stmt->execute();
        }

        public function search() {
            $sql = "SELECT * FROM opciones_respuesta";
            $stmt = $this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update($id,$idPregunta,$valor,$peso) {
            $sql = "UPDATE opciones_respuesta SET id_pregunta = :id_pregunta, valor = :valor, peso = :peso WHERE id = :id";
            $stmt = $this->prepare($sql);
            $stmt->bindParam(":id", $this->$id);
            $stmt->bindParam(":id_pregunta", $this->$idPregunta);
            $stmt->bindParam(":valor", $this->$valor);
            $stmt->bindParam(":peso", $this->$peso);
            return $stmt->execute();
        }
    }