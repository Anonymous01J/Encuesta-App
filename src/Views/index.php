<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas de Usabilidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Barra de navegación móvil -->
    <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-clipboard-data me-2"></i>Encuestas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Menú lateral para móviles -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title">Menú</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-clipboard-plus me-2"></i> Crear Encuesta
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-list-check me-2"></i> Todas las Encuestas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-people me-2"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart me-2"></i> Reportes
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a href="#" class="nav-link">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container mt-5 pt-3">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Encuestas Disponibles</h2>
            <button class="btn btn-sm btn-outline-primary" id="refreshBtn">
                <i class="bi bi-arrow-repeat"></i>
            </button>
        </div>

        <!-- Lista de encuestas -->
        <div class="row" id="survey-list">
            <!-- Las encuestas se cargarán dinámicamente aquí -->
        </div>
    </div>

    <!-- Footer móvil -->
    <div class="mobile-nav fixed-bottom bg-white shadow-lg">
        <div class="container">
            <div class="d-flex justify-content-around py-2">
                <a href="#" class="text-primary text-center">
                    <i class="bi bi-house-door fs-4"></i>
                    <div class="small">Inicio</div>
                </a>
                <a href="#" class="text-muted text-center btn-crear-encuesta" data-bs-toggle="modal" data-bs-target="#createSurveyModal">
                    <i class="bi bi-clipboard-plus fs-4"></i>
                    <div class="small">Crear</div>
                </a>
                <a href="#" class="text-muted text-center">
                    <i class="bi bi-list-check fs-4"></i>
                    <div class="small">Encuestas</div>
                </a>
                <a href="#" class="text-muted text-center">
                    <i class="bi bi-person fs-4"></i>
                    <div class="small">Perfil</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal para responder encuestas -->
    <div class="modal fade" id="surveyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modalContent">
                <!-- El contenido se cargará dinámicamente con JavaScript -->
            </div>
        </div>
    </div>
    <!-- Modal para crear encuesta -->
    <div class="modal fade" id="createSurveyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="createSurveyForm" action="?c=CEncuesta/insert" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Nueva Encuesta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="surveyName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="surveyName" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="surveyDesc" class="form-label">Descripción</label>
                            <textarea class="form-control" id="surveyDesc" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="surveyType" class="form-label">Siglas</label>
                            <input type="text" class="form-control" id="surveyType" name="tipo" required maxlength="5">
                        </div>
                        <hr>
                        <h6>Preguntas</h6>
                        <div id="questionsContainer"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addQuestion()">Agregar Pregunta</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Encuesta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Loader -->
    <div class="page-loader" id="pageLoader" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>
    
    <!-- Toast container -->
    <div class="toast-container" id="toastContainer">
        <!-- Toasts se añadirán dinámicamente aquí -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- En el HTML -->
    <script>
        // Función global para selección de opciones 
        function selectOption(element, questionName) {
            const container = element.closest('.response-options');
            if (container) {
                container.querySelectorAll('.response-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                element.classList.add('selected');
                
                const radio = element.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            }
        }
    </script>
</body>
</html>