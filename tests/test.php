<?php


// Test Create (Post) operation
function testCreatePerson()
{
    $apiBaseUrl = 'http://localhost/REST-API/api/index.php';

    // Define test data for creating a new person
    $data = json_encode([
        "name" => "Brown Dude",
        "age" => "25",
        "track" => "Videographic"
    ]);

    // Create a new cURL session
    $ch = curl_init($apiBaseUrl);

    // Set cURL options for the POST request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Execute the POST request
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
}

// Test Read (GET) operation
function testReadPerson()
{
    $apiBaseUrl = 'http://localhost/REST-API/api/index.php';

    // Define the person's name to retrieve
    $personName = 'John Doe';

    // Build the URL for retrieving a person by name
    $url = $apiBaseUrl . '?name=' . urlencode($personName);

    // Create a new cURL session
    $ch = curl_init($url);

    // Set cURL options for the GET request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the GET request
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
}

// Test Read (PUT) operation
function testUpdatePerson()
{
    $apiBaseUrl = 'http://localhost/REST-API/api/index.php';

    // Define the name of the person to update
    $personName = 'John Doe';

    // Define the updated data
    $updatedData = json_encode([
        "name" => "John Doe",
        "age" => "15",
        "track" => "Backend Developer"
    ]);

    // Create a new cURL session
    $ch = curl_init($apiBaseUrl . '/people/' . urlencode($personName));

    // Set cURL options for the PUT request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updatedData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Execute the PUT request
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
}

function testRemovePerson()
{
    // Define the API base URL
    $apiBaseUrl = 'http://localhost/REST-API/api/index.php';

    // Define the name of the person to remove
    $personName = 'Brown Dude';

    // Create a new cURL session for the DELETE request
    $ch = curl_init($apiBaseUrl . '/people/' . urlencode($personName));

    // Set cURL options for the DELETE request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

    // Execute the DELETE request
    $response = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    // Output the response
    echo $response;
}


// testCreatePerson();
testReadPerson();
// testUpdatePerson();
// testRemovePerson();
