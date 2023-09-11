<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

// Extract the name parameter from the rewritten URL
$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', $uri);
$name = urldecode(end($uriParts));

// Create a new person
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"));

        // Validate input
        if (!isset($data->name) || !is_string($data->name)) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input data"]);
            exit();
        }

        $name = $data->name;
        $age = $data->age;
        $track = $data->track;

        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $db->prepare("INSERT INTO people (name, age, track) VALUES (:name, :age, :track)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_STR);
        $stmt->bindParam(':track', $track, PDO::PARAM_STR);
        $stmt->execute();

        http_response_code(201);
        echo json_encode(["message" => "Person created successfully"]);
    } catch (PDOException $e) {
         // Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}

// Retrieve details of a person by name
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Get the name from the URL
        $name = isset($_GET['name']) ? $_GET['name'] : '';

        // If name is not found in $_GET, try to parse it from the URL
        if (empty($name)) {
            $uri = $_SERVER['REQUEST_URI'];
            $uriParts = explode('/', $uri);
            $name = urldecode(end($uriParts));
        }

        // Create a database connection
        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch data from the database based on the name
        $stmt = $db->prepare("SELECT * FROM people WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
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

// Update details of an existing person by name
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the name from both $_GET and the URL
    $nameFromQuery = isset($_GET['name']) ? $_GET['name'] : '';
    $nameFromURL = isset($name) ? $name : '';

    // Use the name from the query parameter if available, otherwise use the name from the URL
    $name = !empty($nameFromQuery) ? $nameFromQuery : $nameFromURL;

    // Get the updated data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Validate input data
    if (!isset($data->name) || !is_string($data->name)) {
        // Bad Request
        http_response_code(400);
        echo json_encode(["message" => "Invalid input data"]);
        exit();
    }

    $newName = $data->name;
    $age = $data->age;
    $track =$data->track;
    

    // Update data in the database
    try {
        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update data in the database based on the person's name
        $stmt = $db->prepare("UPDATE people SET name = :newName, age = :age, track = :track WHERE name = :name");
        $stmt->bindParam(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_STR);
        $stmt->bindParam(':track', $track, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        // Check if any rows were affected
        $rowCount = $stmt->rowCount();
        var_dump($rowCount);
        var_dump($name);
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


// Remove a person by name
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the name from both $_GET and the URL
    $nameFromQuery = isset($_GET['name']) ? $_GET['name'] : '';
    $nameFromURL = isset($name) ? $name : '';

    // Use the name from the query parameter if available, otherwise use the name from the URL
    $name = !empty($nameFromQuery) ? $nameFromQuery : $nameFromURL;

    // Delete data from the database
    try {
        $db = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete data from the database based on the person's name
        $stmt = $db->prepare("DELETE FROM people WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
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
