<?php
    namespace Anonymous01j\Encuesta\Controller;
    use Anonymous01j\Encuesta\Models\Encuestas;
    use Anonymous01j\Encuesta\Models\Preguntas;
    use Anonymous01j\Encuesta\Models\OpcionRespuestas;
    use Anonymous01j\Encuesta\Models\Respuestas;
    use Anonymous01j\Encuesta\Models\Usuarios;
    class CHome {
        public function view() {
            // Obtener encuestas activas
            $encuestaModel = new Encuestas();
            $encuestas = $encuestaModel->search();
    
            require_once __DIR__ . '/../Views/index.php';
        }
        
        public function getEncuestas() {
            $encuesta = new Encuestas();
            $data = $encuesta->search();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        
        public function getEncuesta()
        {
            // 1. Validar el parámetro id
            $idEncuesta = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            if ($idEncuesta <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Parámetro id inválido']);
                exit;
            }

            // 2. Instanciar modelos
            $encuestaModel   = new Encuestas();
            $preguntaModel   = new Preguntas();
            $opcionModel     = new OpcionRespuestas();

            // 3. Buscar la encuesta
            $encuestaData = $encuestaModel->searchId($idEncuesta);
            if (!$encuestaData) {
                http_response_code(404);
                echo json_encode(['error' => 'Encuesta no encontrada']);
                exit;
            }

            // 4. Traer preguntas y sus opciones
            $preguntas = $preguntaModel->searchIdEncuesta($idEncuesta);
            if (!is_array($preguntas)) {
                $preguntas = [];
            }
            foreach ($preguntas as &$p) {
                if ($p['tipo_respuesta'] !== 'texto_libre') {
                    $p['opciones'] = $opcionModel->searchIdPregunta($p['id']);
                }
            }

            // 5. Responder
            header('Content-Type: application/json');
            echo json_encode([
                'encuesta'  => $encuestaData,
                'preguntas' => $preguntas
            ]);
            exit;
        }

        public function saveRespuesta() {
            // Obtener datos enviados por AJAX
            $data = json_decode(file_get_contents('php://input'), true);
            $usuarioId = 1; // ID del usuario (de sesión en sistema real)
            
            $respuestaModel = new Respuestas();
            
            try {
                foreach ($data['respuestas'] as $respuesta) {
                    $respuestaModel->setIdUsuario($usuarioId);
                    $respuestaModel->setIdPregunta($respuesta['pregunta_id']);
                    
                    if (isset($respuesta['opcion_id'])) {
                        $respuestaModel->setIdOpcion($respuesta['opcion_id']);
                    }
                    
                    if (isset($respuesta['texto'])) {
                        $respuestaModel->setValorTexto($respuesta['texto']);
                    }
                    
                    $respuestaModel->insert();
                }
                
                // Actualizar contador de respuestas
                $encuestaModel = new Encuestas();
                $encuestaModel->contResponse($this->getEncuestaIdFromPregunta($respuesta['pregunta_id']));
                
                echo json_encode(['success' => true, 'message' => 'Respuestas guardadas correctamente']);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }
?>