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

// // Retrieve details of a person by name
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     try {
//         $name = $_GET['name'];

//         $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Fetch data from the database based on the name
//         $stmt = $db->prepare("SELECT * FROM people WHERE name = :name");
//         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//         $stmt->execute();

//         $person = $stmt->fetch(PDO::FETCH_ASSOC);

//         if (!$person) {
//             http_response_code(404); // Not Found
//             echo json_encode(["message" => "Person not found"]);
//         } else {
//             http_response_code(200); // OK
//             echo json_encode($person);
//         }
//     } catch (PDOException $e) {
//         http_response_code(500); // Internal Server Error
//         echo json_encode(["message" => "Database error: " . $e->getMessage()]);
//     }
// }

// // Update details of an existing person by name
// if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
//     try {
//         $name = $_GET['name'];

//         $data = json_decode(file_get_contents("php://input"));

//         // Validate input
//         if (!isset($data->name) || !is_string($data->name)) {
//             http_response_code(400); // Bad Request
//             echo json_encode(["message" => "Invalid input data"]);
//             exit();
//         }

//         $newName = $data->name;

//         $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Update data in the database
//         $stmt = $db->prepare("UPDATE people SET name = :newName WHERE name = :name");
//         $stmt->bindParam(':newName', $newName, PDO::PARAM_STR);
//         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//         $stmt->execute();

//         http_response_code(200); // OK
//         echo json_encode(["message" => "Person updated successfully"]);
//     } catch (PDOException $e) {
//         http_response_code(500); // Internal Server Error
//         echo json_encode(["message" => "Database error: " . $e->getMessage()]);
//     }
// }

// // Remove a person by name
// if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
//     try {
//         $name = $_GET['name'];

//         $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Delete data from the database
//         $stmt = $db->prepare("DELETE FROM people WHERE name = :name");
//         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//         $stmt->execute();

//         http_response_code(200); // OK
//         echo json_encode(["message" => "Person deleted successfully"]);
//     } catch (PDOException $e) {
//         http_response_code(500); // Internal Server Error
//         echo json_encode(["message" => "Database error: " . $e->getMessage()]);
//     }
// }
