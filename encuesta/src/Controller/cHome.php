<?php
    namespace Anonymous01j\Encuesta\Controller;
    use Anonymous01j\Encuesta\Models\Encuesta;
    use Anonymous01j\Encuesta\Models\Preguntas;
    class CHome {
        
        private $productos;
        private $categorias;

        public function view() {
            // $this->productos = new Productos();
            // $productos = $this->productos->search();
            // $this->categorias = new CategoriasProductos();
            // $categorias = $this->categorias->search();
            include_once __DIR__ . '/../Views/index.php';
        }  
        public function insert() {
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $descripcion = $_POST['descripcion'];
            
            $encuesta = new Encuesta();
            $encuesta->setNombre($nombre);
            $encuesta->setTipo($tipo);
            $encuesta->setDescripcion($descripcion);
            $encuesta->insert();
            
            header("Location: index.php?c=CEncuesta&a=index");
        }
        public function preguntasEncuesta() {
            // $idEncuesta = $_POST['idEncuesta'];
            $idEncuesta = 1;
            $pregunta = new Preguntas();
            $pregunta->setIdEncuesta($idEncuesta);
            $preguntas = $pregunta->surveyQuestions($idEncuesta);
            var_dump($preguntas);
            
        }
        
    }
?>