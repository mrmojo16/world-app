<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Population Viewer</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🌍 World Population Viewer</h1>
            <p class="subtitle">Selecciona un país para ver sus ciudades y población</p>
        </header>
        
        <main>
            <div class="search-section">
                <label for="country-select">🌎 País:</label>
                <select id="country-select" class="country-select" required>
                    <option value="">-- Selecciona un país --</option>
                    <?php
                    // Cargar países desde el modelo
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
            
            <div id="loading" class="loading" style="display: none;">
                <div class="spinner"></div>
                <p>Cargando ciudades...</p>
            </div>
            
            <div id="results" class="results" style="display: none;">
                <h2>Resultados para <span id="selected-country"></span></h2>
                
                <div class="stats-card">
                    <p>🏙️ <strong>Total ciudades:</strong> <span id="total-cities">0</span></p>
                    <p>🌟 <strong>Ciudad más poblada:</strong> <span id="max-city">-</span></p>
                    <p>📊 <strong>Población máxima:</strong> <span id="max-population">0</span></p>
                </div>
                
                <div class="table-container">
                    <table id="cities-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ciudad</th>
                                <th>Población</th>
                                <th>Escala (0-10)</th>
                            </tr>
                        </thead>
                        <tbody id="cities-tbody">
                            <tr><td colspan="4" class="text-center">Selecciona un país</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="error" class="error" style="display: none;">
                <p>❌ Error al cargar datos. Intenta de nuevo.</p>
            </div>
        </main>
        
        <footer>
            <p>© 2024 - Prueba Técnica Analista de Soporte Nivel 1</p>
        </footer>
    </div>
    
    <script src="assets/js/script.js"></script>
</body>
</html>
