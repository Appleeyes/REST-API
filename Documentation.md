# REST-API Documentation

## Introduction

This REST-API documentation provides details on how to interact with the RESTful API for managing people. It includes information on endpoints, request/response formats, setup instructions, and sample API usage.

## Base URL

The base URL for accessing the API is:

```
http://your-api-domain.com/api
```


## Endpoints

### Create a New Person

- **Endpoint:** `http://your-api-domain.com/api`
- **Method:** POST
- **Request Body:**
  - Content-Type: application/json
  - Example:

    ```json
    {
        "name": "John Doe",
    }
    ```

- **Response:**
  - Status Code: 201 Created
  - Example:

    ```json
    {
        "message": "Person created successfully"
    }
    ```

### Retrieve Details of a Person by Name

- **Endpoint:** `http://your-api-domain.com/api/{id}`
- **Method:** GET
- **Response:**
  - Status Code: 200 OK
  - Example:

    ```json
    {
        "name": "John Doe",
    }
    ```
  - Status Code: 404 Not Found (If the person is not found)
  - Example:

    ```json
    {
        "message": "Person not found"
    }
    ```

### Update Details of an Existing Person by Name

- **Endpoint:** `http://your-api-domain.com/api/{id}`
- **Method:** PUT
- **Request Body:**
  - Content-Type: application/json
  - Example:

    ```json
    {
        "name": "John Doe",
    }
    ```

- **Response:**
  - Status Code: 200 OK
  - Example:

    ```json
    {
        "message": "Person updated successfully"
    }
  - Status Code: 404 Not Found (If the person is not found)
  - Example:

    ```json
    {
        "message": "Person not found"
    }
    ```

### Remove a Person by Name

- **Endpoint:** `http://your-api-domain.com/api/{id}`
- **Method:** DELETE
- **Response:**
  - Status Code: 200 OK
  - Example:

    ```json
    {
        "message": "Person deleted successfully"
    }
  - Status Code: 404 Not Found (If the person is not found)
  - Example:

    ```json
    {
        "message": "Person not found"
    }
    ```

## Setup Instructions

To set up and run this API locally, follow these steps:

1. Clone the repository to your local machine:

   ```
   git clone https://github.com/REST-API
   ```

2. Configure the database connection by updating the `config/database.php` file with your database credentials.


3. Start the local development server:
   ```
   php -S localhost:8000
   ```

4. If you are using loaclhost:8000, then you can access your endpoint using:
   ```
   http://localhost:8000/api
   ```

# Sample API Usage
Here are some sample REST-API requests using curl:

- Create a new person:
   ```
   curl -X POST http://localhost:8000/api -H "Content-Type: application/json" -d '{"name": "John Doe"}'
   ```

- Retrieve details of a person by name:
  ```
   curl http://localhost:8000/api/2
  ```

- Update details of an existing person by name:
  ```
   curl -X PUT http://localhost:8000/api/2 -H "Content-Type: application/json" -d '{"name": "John Doe"}'
  ```
- Remove a person by name:
  ```
  curl -X DELETE http://localhost:8000/api/2
  ```



# Test Script Usage

This section provides instructions on how to use the test script for the REST-API. The test script is a PHP script that demonstrates how to interact with the API endpoints using HTTP requests.

## Prerequisites

Before using the test script, ensure that you have the following prerequisites:

- PHP installed on your local machine.
- Composer installed for managing PHP dependencies.
- The REST-API server is running and accessible.

## Running the Test Script

To run the test script, follow these steps:

1. Navigate into the test script folder in your terminal e.g:
     ```
      http://localhost:8000/tests/test.php
     ```

2. Execute the test script by providing the base URL of the REST-API as an  e.g:
     ```
      php test.php http://localhost/REST-API/index.php
    ```


3. Go to the base of the `test.php` file and comment out other request incase you want to run just one request.

# Conclusion
This API documentation provides a comprehensive guide for interacting with the REST-API. If you have any questions or encounter any issues, please refer to the API documentation.

Note: Replace `http://your-api-domain.com` or `http://localhost:8000` with the actual base URL of your API.