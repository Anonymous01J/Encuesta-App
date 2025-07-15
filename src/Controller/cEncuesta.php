<?php
    namespace Anonymous01j\Encuesta\Controllers;
    use Anonymous01j\Encuesta\Models\Encuestas;
    use Anonymous01j\Encuesta\Models\Preguntas;
    use Anonymous01j\Encuesta\Models\OpcionRespuestas;
    class CEncuesta {
        public function index() {
            $encuesta = new Encuestas();
            $encuestas = $encuesta->search();
            require_once __DIR__ . "/../View/encuestas/index.php";
        }
        public function insert() {
            header('Content-Type: application/json');

            // Solo aceptar peticiones AJAX con JSON
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Petición inválida']);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data || !isset($data['nombre'], $data['tipo'], $data['descripcion'], $data['preguntas'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                exit;
            }

            try {
                // 1. Guardar encuesta
                $encuesta = new Encuestas();
                $encuesta->setNombre($data['nombre']);
                $encuesta->setTipo($data['tipo']);
                $encuesta->setDescripcion($data['descripcion']);
                $encuesta->setEstado(1); // Activa por defecto
                $encuestaId = $encuesta->insert(); // Debe retornar el ID insertado

                // 2. Guardar preguntas y opciones
                $orden = 1;
                foreach ($data['preguntas'] as $pregunta) {
                    $preguntaModel = new Preguntas();
                    $preguntaModel->setIdEncuesta($encuestaId);
                    $preguntaModel->setTexto($pregunta['texto']);
                    $preguntaModel->setTipoRespuesta($pregunta['tipo_respuesta']);
                    $preguntaModel->setOrden($orden); // Orden autoincrementable
                    $preguntaId = $preguntaModel->insert(); // Debe retornar el ID insertado

                    // Si la pregunta tiene opciones, guardarlas
                    if (!empty($pregunta['opciones']) && is_array($pregunta['opciones'])) {
                        foreach ($pregunta['opciones'] as $opcion) {
                            $opcionModel = new OpcionRespuestas();
                            $opcionModel->setIdPregunta($preguntaId);
                            $opcionModel->setValor($opcion);
                            $opcionModel->setPeso(0); // Puedes ajustar el peso si lo necesitas
                            $opcionModel->insert();
                        }
                    }
                    $orden++;
                }

                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }
        public function update() {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $descripcion = $_POST['descripcion'];
            
            $encuesta = new Encuestas();
            $encuesta->setId($id);
            $encuesta->setNombre($nombre);
            $encuesta->setTipo($tipo);
            $encuesta->setDescripcion($descripcion);
            $encuesta->update($id, $nombre, $tipo, $descripcion);
            
            header("Location: index.php?c=CEncuesta&a=index");
        }
    
        public function delete() {
            $id = $_POST['id'];
            $encuesta = new Encuestas();
            $encuesta->delete($id);
            header("Location: index.php?c=CEncuesta&a=index");
        }
    }