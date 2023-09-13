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
    ];

    $url = $apiBaseUrl;

    $response = sendRequest($url, 'POST', $data);
    echo "Create Operation:\n";
    echo $response . "\n";
}

// Test Read (GET) operation
function testReadPerson($apiBaseUrl)
{
    $personId = 10;

    $url = $apiBaseUrl . '/' . $personId;

    $response = sendRequest($url, 'GET');
    echo "Read Operation:\n";
    echo $response . "\n";
}

// Test Update (PUT) operation
function testUpdatePerson($apiBaseUrl)
{
    $personId = 10;

    $data = [
        "name" => "Updated Brown Dude",
    ];

    $url = $apiBaseUrl . '/' . $personId;

    $response = sendRequest($url, 'PUT', $data);
    echo "Update Operation:\n";
    echo $response . "\n";
}

// Test Delete (DELETE) operation
function testDeletePerson($apiBaseUrl)
{
    $personId = 10;

    $url = $apiBaseUrl . '/' . $personId;

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
