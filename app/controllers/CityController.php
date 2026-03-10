<?php
require_once "app/models/CountryModel.php";
require_once "app/models/CityModel.php";

class CityController {
    
    public function index() {
        $countryModel = new CountryModel();
        $countries = $countryModel->getAll();
        include "app/views/index_view.php";
    }
    
    public function getCities() {
        if (ob_get_level()) ob_clean();
        header("Content-Type: application/json");
        
        if(!isset($_GET["country_code"]) || empty($_GET["country_code"])) {
            echo json_encode(["success" => false, "message" => "Código de país requerido"]);
            return;
        }
        
        $countryCode = $_GET["country_code"];
        $cityModel = new CityModel();
        $cities = $cityModel->getByCountryCode($countryCode);
        
        if(empty($cities)) {
            echo json_encode(["success" => true, "data" => [], "total" => 0]);
            return;
        }
        
        $maxPopulation = $cities[0]["Population"];
        $result = [];
        
        foreach($cities as $city) {
            $scale = ($maxPopulation > 0) ? round(($city["Population"] / $maxPopulation) * 10, 1) : 0;
            
            $scaleClass = "low";
            if ($scale >= 8) $scaleClass = "high";
            elseif ($scale >= 5) $scaleClass = "medium";
            
            $result[] = [
                "name" => htmlspecialchars($city["Name"]),
                "population" => number_format($city["Population"]),
                "raw_population" => $city["Population"],
                "scale" => $scale,
                "scale_class" => $scaleClass
            ];
        }
        
        echo json_encode([
            "success" => true,
            "data" => $result,
            "total" => count($result),
            "max_population" => number_format($maxPopulation),
            "max_city" => htmlspecialchars($cities[0]["Name"])
        ]);
    }

    public function searchCountry() {
        if (ob_get_level()) ob_clean();
        header("Content-Type: application/json");
        
        if(!isset($_GET["name"]) || empty($_GET["name"])) {
            echo json_encode(["success" => false, "message" => "Nombre requerido"]);
            return;
        }
        
        $countryModel = new CountryModel();
        $countries = $countryModel->getByName($_GET["name"]);
        echo json_encode(["success" => true, "data" => $countries]);
    }

    public function topCities() {
        if (ob_get_level()) ob_clean();
        header("Content-Type: application/json");
        
        $limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 10;
        $cityModel = new CityModel();
        $cities = $cityModel->getTopCities($limit);
        echo json_encode(["success" => true, "data" => $cities]);
    }
}
?>