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
            <button class="btn btn-sm btn-outline-primary">
                <i class="bi bi-filter"></i>
            </button>
        </div>

        <!-- Lista de encuestas -->
        <div class="row" id="survey-list">
            <!-- Encuesta SUS -->
            <div class="col-12 mb-3">
                <div class="card survey-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-success me-2">SUS</span>
                                <h5 class="card-title d-inline">Usabilidad E-commerce</h5>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-people"></i> 45
                            </div>
                        </div>
                        <p class="card-text text-muted mt-2">Encuesta estándar para medir usabilidad percibida</p>
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#surveyModal" data-survey="sus">
                                <i class="bi bi-pencil-square me-1"></i> Responder
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Encuesta NPS -->
            <div class="col-12 mb-3">
                <div class="card survey-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-primary me-2">NPS</span>
                                <h5 class="card-title d-inline">Lealtad de Clientes</h5>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-people"></i> 82
                            </div>
                        </div>
                        <p class="card-text text-muted mt-2">¿Recomendarías nuestro sitio a otros?</p>
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#surveyModal" data-survey="nps">
                                <i class="bi bi-pencil-square me-1"></i> Responder
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Encuesta CSAT -->
            <div class="col-12 mb-3">
                <div class="card survey-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-info me-2">CSAT</span>
                                <h5 class="card-title d-inline">Satisfacción Post-Compra</h5>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-people"></i> 27
                            </div>
                        </div>
                        <p class="card-text text-muted mt-2">Valora tu experiencia después de comprar</p>
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#surveyModal" data-survey="csat">
                                <i class="bi bi-pencil-square me-1"></i> Responder
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
                <a href="#" class="text-muted text-center">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>