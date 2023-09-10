<?php


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

// // Function to make a GET request and return the response as an associative array
// function get($url)
// {
//     $response = file_get_contents($url);
//     return json_decode($response, true);
// }

// // Function to make a POST request and return the response as an associative array
// function post($url, $data)
// {
//     $options = [
//         'http' => [
//             'method' => 'POST',
//             'header' => 'Content-Type: application/json',
//             'content' => json_encode($data),
//         ],
//     ];

//     $context = stream_context_create($options);
//     $response = file_get_contents($url, false, $context);

//     return json_decode($response, true);
// }

// // Function to make a PUT request and return the response as an associative array
// function put($url, $data)
// {
//     $options = [
//         'http' => [
//             'method' => 'PUT',
//             'header' => 'Content-Type: application/json',
//             'content' => json_encode($data),
//         ],
//     ];

//     $context = stream_context_create($options);
//     $response = file_get_contents($url, false, $context);

//     return json_decode($response, true);
// }

// // Function to make a DELETE request and return the response as an associative array
// function delete($url)
// {
//     $options = [
//         'http' => [
//             'method' => 'DELETE',
//         ],
//     ];

//     $context = stream_context_create($options);
//     $response = file_get_contents($url, false, $context);

//     return json_decode($response, true);
// }

// // Test: Create a new person
// $data = ['name' => 'John Doe'];
// $response = post("$apiBaseUrl/index.php", $data);
// echo "Create a new person:\n";
// var_dump($response);

// // Test: Retrieve details of a person by name
// $name = 'John Doe';
// $response = get("$apiBaseUrl/index.php?name=$name");
// echo "Retrieve details of a person by name:\n";
// var_dump($response);

// // Test: Update details of an existing person by name
// $newName = 'Jane Doe';
// $response = put("$apiBaseUrl/index.php?name=$name", ['name' => $newName]);
// echo "Update details of an existing person by name:\n";
// var_dump($response);

// // Test: Remove a person by name
// $response = delete("$apiBaseUrl/index.php?name=$newName");
// echo "Remove a person by name:\n";
// var_dump($response);
