@"
<?php
require_once 'config/database.php';

class CityModel {
    private \$conn;
    
    public function __construct() {
        \$database = new Database();
        \$this->conn = \$database->getConnection();
    }
    
    public function getByCountryCode(\$countryCode) {
        \$query = "SELECT Name, Population FROM city 
                  WHERE CountryCode = ? 
                  ORDER BY Population DESC";
        
        \$stmt = \$this->conn->prepare(\$query);
        \$stmt->bind_param("s", \$countryCode);
        \$stmt->execute();
        \$result = \$stmt->get_result();
        
        \$cities = [];
        while(\$row = \$result->fetch_assoc()) {
            \$cities[] = \$row;
        }
        
        \$stmt->close();
        return \$cities;
    }

    public function getTopCities(\$limit = 10) {
        \$query = "SELECT city.Name, city.Population, country.Name as Country 
                  FROM city 
                  INNER JOIN country ON city.CountryCode = country.Code 
                  ORDER BY city.Population DESC 
                  LIMIT ?";
        \$stmt = \$this->conn->prepare(\$query);
        \$stmt->bind_param("i", \$limit);
        \$stmt->execute();
        return \$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
"@ | Out-File -FilePath app\models\CityModel.php -Encoding UTF8