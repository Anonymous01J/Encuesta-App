<?php
    namespace Anonymous01j\Encuesta\Models;
    use PDOException;
    use PDO;

    class Conexion extends PDO {
        function __construct() {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "encuesta";
            try {
                parent::__construct("mysql:host=$servername;dbname=$dbname", $username, $password);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Error en la conexión: " . $e->getMessage());
            }
        }
    }
?>