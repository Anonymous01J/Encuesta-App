<?php
    namespace Anonymous01j\Encuesta\Controller;
    use Anonymous01j\Encuesta\Models\Encuestas;
    use Anonymous01j\Encuesta\Models\Preguntas;
    use Anonymous01j\Encuesta\Models\OpcionRespuestas;
    use Anonymous01j\Encuesta\Models\Respuestas;
    class CModal {
        
        private $productos;
        private $categorias;

        public function view() {
            // $idEncuesta = $_POST['idEncuesta'];
            $idEncuesta = 1;
        
            $encuesta = new Encuestas();
            $pregunta = new Preguntas();
            $opcionRespuesta = new OpcionRespuestas();
        
            $encuestas = $encuesta->searchEncuesta($idEncuesta);
            $preguntas = $pregunta->preguntaEncuesta($idEncuesta);
            $opcionesRespuesta = $opcionRespuesta->respuestasEncuesta($idEncuesta);
        
            // Arma la estructura que necesita el frontend
            $response = [
                'encuesta' => $encuestas,
                'preguntas' => $preguntas,
                'opciones' => $opcionesRespuesta
            ];
        
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
         
        public function insert() {
            $idUsuario = $_POST['idUsuario'];
            $idPregunta = $_POST['idPregunta'];
            $idOpcion = isset($_POST['idOpcion'])?$_POST['idOpcion']:null;
            $valorTexto = isset($_POST['valorTexto'])?$_POST['valorTexto']:null;
            $respuesta = new Respuestas;
            $respuesta->insert();
            
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
        public function encuestas() {

            $encuesta = new Encuestas();
            $encuestas = $encuesta->search();
            var_dump($encuestas);
        }
        
    }
?>