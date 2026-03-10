<?php
require_once 'config/database.php';

class CountryModel {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getAll() {
        $query = "SELECT Code, Name FROM country ORDER BY Name ASC";
        $result = $this->conn->query($query);
        
        $countries = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $countries[] = $row;
            }
        }
        return $countries;
    }

    public function getByName($name) {
        $query = "SELECT Code, Name FROM country WHERE Name LIKE ?";
        $stmt = $this->conn->prepare($query);
        $search = "%$name%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
