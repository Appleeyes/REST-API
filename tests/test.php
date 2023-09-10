<?php

// Test: Create a new person
$data = json_encode(["name" => "Jane Doe"]);
$url = 'http://localhost/REST-API/api/index.php'; // Replace with your actual API URL

$options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $data,
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);
echo $response;

