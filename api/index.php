<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once '../config/database.php';

// Create a new person
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"));

        // Validate input
        if (!isset($data->name) || !is_string($data->name)) {
            http_response_code(400); // Bad Request
            echo json_encode(["message" => "Invalid input data"]);
            exit();
        }

        $name = $data->name;

        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $db->prepare("INSERT INTO people (name) VALUES (:name)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        http_response_code(201); // Created
        echo json_encode(["message" => "Person created successfully"]);
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}

