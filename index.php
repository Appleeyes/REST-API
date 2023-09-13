<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

// Extract the id parameter from the rewritten URL
$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', $uri);
$id = urldecode(end($uriParts));

// Create a new person
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"));

        // Validate input
        if (!isset($data->name) || !is_string($data->name)) {
            http_response_code(400); // Bad Request
            echo json_encode(["message" => "Invalid name"]);
            exit();
        }

        $name = $data->name;

        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $db->prepare("INSERT INTO people (name) VALUES (:name)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $lastInsertId = $db->lastInsertId();

        http_response_code(201);
        echo json_encode(["message" => "Person created successfully", "id" => $lastInsertId]);
    } catch (PDOException $e) {
         // Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}

// Retrieve details of a person by id
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Get the id from the URL
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        // If id is not found in $_GET, try to parse it from the URL
        if (empty($id)) {
            $uri = $_SERVER['REQUEST_URI'];
            $uriParts = explode('/', $uri);
            $id = urldecode(end($uriParts));
        }

        // Create a database connection
        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch data from the database based on the id
        $stmt = $db->prepare("SELECT * FROM people WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $person = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$person) {
            http_response_code(404);
            echo json_encode(["message" => "Person not found"]);
        } else {
            http_response_code(200);
            echo json_encode($person);
        }
    } catch (PDOException $e) {
        // Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}

// Update details of an existing person by id
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the id from both $_GET and the URL
    $idFromQuery = isset($_GET['id']) ? $_GET['id'] : '';
    $idFromURL = isset($id) ? $id : '';

    // Use the id from the query parameter if available, otherwise use the id from the URL
    $id = !empty($idFromQuery) ? $idFromQuery : $idFromURL;

    // Get the updated data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Validate input
    if (!isset($data->name) || !is_string($data->name)) {
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Invalid name"]);
        exit();
    }

    $newName = $data->name;

    // Update data in the database
    try {
        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update data in the database based on the person's id
        $stmt = $db->prepare("UPDATE people SET name = :newName WHERE id = :id");
        $stmt->bindParam(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            // Person updated successfully
            http_response_code(200);
            echo json_encode(["message" => "Person updated successfully"]);
        } else {
            // Person not found
            http_response_code(404);
            echo json_encode(["message" => "Person not found"]);
        }
    } catch (PDOException $e) {
        // Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}

// Remove a person by id
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the id from both $_GET and the URL
    $idFromQuery = isset($_GET['id']) ? $_GET['id'] : '';
    $idFromURL = isset($id) ? $id : '';

    // Use the id from the query parameter if available, otherwise use the id from the URL
    $id = !empty($idFromQuery) ? $idFromQuery : $idFromURL;

    // Delete data from the database
    try {
        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete data from the database based on the person's id
        $stmt = $db->prepare("DELETE FROM people WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            // Person deleted successfully
            http_response_code(200);
            echo json_encode(["message" => "Person deleted successfully"]);
        } else {
            // Person not found
            http_response_code(404);
            echo json_encode(["message" => "Person not found"]);
        }
    } catch (PDOException $e) {
         // Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}
