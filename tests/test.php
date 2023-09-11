<?php

// Function to send HTTP requests and handle responses
function sendRequest($url, $method, $data = null)
{
    $ch = curl_init($url);

    // Set common cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if ($method === 'POST') {
        // Configure POST request
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    } elseif ($method === 'PUT') {
        // Configure PUT request
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    } elseif ($method === 'DELETE') {
        // Configure DELETE request
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    // Execute the request
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Test Create (Post) operation
function testCreatePerson($apiBaseUrl)
{
    $data = [
        "name" => "Brown Dude",
        "age" => "25",
        "track" => "Videographic"
    ];

    $url = $apiBaseUrl;

    $response = sendRequest($url, 'POST', $data);
    echo "Create Operation:\n";
    echo $response . "\n";
}

// Test Read (GET) operation
function testReadPerson($apiBaseUrl)
{
    $personName = 'John Doe';

    $url = $apiBaseUrl . '?name=' . urlencode($personName);

    $response = sendRequest($url, 'GET');
    echo "Read Operation:\n";
    echo $response . "\n";
}

// Test Update (PUT) operation
function testUpdatePerson($apiBaseUrl)
{
    $personName = 'John Doe';

    $data = [
        "name" => "John Doe",
        "age" => "15",
        "track" => "Backend"
    ];

    $url = $apiBaseUrl . '?name=' . urlencode($personName);

    $response = sendRequest($url, 'PUT', $data);
    echo "Update Operation:\n";
    echo $response . "\n";
}

// Test Delete (DELETE) operation
function testDeletePerson($apiBaseUrl)
{
    $personName = 'Brown Dude';

    $url = $apiBaseUrl . '?name=' . urlencode($personName);

    $response = sendRequest($url, 'DELETE');
    echo "Delete Operation:\n";
    echo $response . "\n";
}

if (count($argv) < 2) {
    echo "Usage: php test.php <base_url>\n";
    exit(1);
}

$apiBaseUrl = $argv[1];

// Run all CRUD operations
testCreatePerson($apiBaseUrl);
testReadPerson($apiBaseUrl);
testUpdatePerson($apiBaseUrl);
testDeletePerson($apiBaseUrl);
