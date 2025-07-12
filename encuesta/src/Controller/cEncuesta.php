<?php
    namespace Anonymous01j\Encuesta\Controllers;
    use Anonymous01j\Encuesta\Models\Encuesta;
    
    class CEncuesta {
        public function index() {
            $encuesta = new Encuesta();
            $encuestas = $encuesta->search();
            require_once __DIR__ . "/../View/encuestas/index.php";
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
    
        public function update() {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $descripcion = $_POST['descripcion'];
            
            $encuesta = new Encuesta();
            $encuesta->setId($id);
            $encuesta->setNombre($nombre);
            $encuesta->setTipo($tipo);
            $encuesta->setDescripcion($descripcion);
            $encuesta->update($id, $nombre, $tipo, $descripcion);
            
            header("Location: index.php?c=CEncuesta&a=index");
        }
    
        public function delete() {
            $id = $_POST['id'];
            $encuesta = new Encuesta();
            $encuesta->delete($id);
            header("Location: index.php?c=CEncuesta&a=index");
        }
    }