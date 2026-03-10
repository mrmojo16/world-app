@"
<?php
require_once 'app/controllers/CityController.php';

\$controller = new CityController();

\$action = isset(\$_GET['action']) ? \$_GET['action'] : 'index';

switch(\$action) {
    case 'getCities':
        \$controller->getCities();
        break;
    case 'searchCountry':
        \$controller->searchCountry();
        break;
    case 'topCities':
        \$controller->topCities();
        break;
    default:
        \$controller->index();
        break;
}
?>
"@ | Out-File -FilePath index.php -Encoding UTF8