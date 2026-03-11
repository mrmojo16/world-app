<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Population Viewer</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos personalizados (solo para ajustes finos) -->
    <style>
        .scale-high { background-color: #198754; color: white; }
        .scale-medium { background-color: #ffc107; color: black; }
        .scale-low { background-color: #dc3545; color: white; }
        .scale { font-weight: bold; text-align: center; }
        .stats-card { background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <!-- Header -->
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center bg-primary text-white rounded">
                <h1 class="display-5"><i class="bi bi-globe2"></i> World Population Viewer</h1>
                <p class="lead">Selecciona un país para ver sus ciudades y población</p>
            </div>
        </div>

        <!-- Selector de país -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <label for="country-select" class="form-label fw-bold">
                    <i class="bi bi-flag"></i> Selecciona un país:
                </label>
                <select id="country-select" class="form-select form-select-lg" required>
                    <option value="">-- Elige un país --</option>
                    <?php
                    require_once 'app/models/CountryModel.php';
                    $countryModel = new CountryModel();
                    $countries = $countryModel->getAll();
                    foreach($countries as $country):
                    ?>
                        <option value="<?php echo htmlspecialchars($country['Code']); ?>">
                            <?php echo htmlspecialchars($country['Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Loading spinner -->
        <div id="loading" class="text-center my-5" style="display: none;">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando ciudades...</p>
        </div>

        <!-- Resultados -->
        <div id="results" style="display: none;">
            <!-- Tarjeta de estadísticas -->
            <div class="card shadow-sm stats-card text-white mb-4">
                <div class="card-body">
                    <h3 class="h5">Resultados para <span id="selected-country" class="fw-bold"></span></h3>
                    <div class="row text-center mt-3">
                        <div class="col-md-4 mb-2">
                            <div class="bg-white bg-opacity-25 rounded p-2">
                                <i class="bi bi-buildings"></i>
                                <div class="small">Total ciudades</div>
                                <span id="total-cities" class="fw-bold fs-4">0</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="bg-white bg-opacity-25 rounded p-2">
                                <i class="bi bi-star"></i>
                                <div class="small">Ciudad más poblada</div>
                                <span id="max-city" class="fw-bold">-</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="bg-white bg-opacity-25 rounded p-2">
                                <i class="bi bi-people"></i>
                                <div class="small">Población máxima</div>
                                <span id="max-population" class="fw-bold">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de ciudades -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Ciudad</th>
                                    <th>Población</th>
                                    <th>Escala (0-10)</th>
                                </tr>
                            </thead>
                            <tbody id="cities-tbody">
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle"></i> Selecciona un país
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error -->
        <div id="error" class="alert alert-danger mt-4" style="display: none;">
            <i class="bi bi-exclamation-triangle"></i>
            Error al cargar datos. Intenta de nuevo.
        </div>

        <!-- Footer -->
        <footer class="text-center text-muted mt-5">
            <p>© 2026 - Prueba Técnica | mrmojo16</p>
        </footer>
    </div>

    <!-- Bootstrap JS (opcional para interactividad) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tu script personalizado -->
    <script src="assets/js/script.js"></script>
</body>
</html>