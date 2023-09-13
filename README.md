# REST API

The REST-API is a RESTful web service that allows you to manage information about people. You can create, read, update, and delete person records using this API.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
  - [Installation](#installation)
- [Usage](#usage)
  - [API Endpoints](#api-endpoints)
  - [Documentation](#documentation)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP (>= 7.0) installed on your local machine.
- Composer installed for managing PHP dependencies.
- A running web server (e.g., Apache) to host the API.
- Database server (e.g., MySQL) for storing data.

## Getting Started

Follow these steps to set up and run the REST-API on your local machine.

### Installation

1. Clone this repository:

   ```bash
   git clone https://github.com/Apple/REST-API.git

2. Navigate to the project directory:

   ```
   cd REST-API

3. Configure the database connection by updating the `config/database.php` file with your database credentials.

# Usage
## API Endpoints
The REST-API provides the following endpoints:

- `POST /api:` Create a new person.
- `GET /api/{id}:` Retrieve details of a person by name.
- `PUT /api/{id}:` Update details of an existing person by name.
- `DELETE /api/{id}:` Remove a person by name.

## Documentation

For detailed information about the API, request/response formats, and sample API usage, please refer to the [API Documentation](Documentation.md).
