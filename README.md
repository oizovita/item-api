# Item API

This is a simple API built with PHP that allows users to manage items.

## Table of Contents

- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Docker Installation](#docker-installation)
- [Usage](#usage)
- [Authentication](#authentication)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing
purposes.

### Prerequisites

- PHP 8.3.4 or higher
- Composer

### Installation

1. Clone the repository:
    ```
    git clone https://github.com/oizovita/item-api.git
    ```
2. Navigate to the project directory:
    ```
    cd item-api
    ```
3. Copy the `config.example.php` file to `config.php`:
    ```
    cp config.example.php config.php
    ```
4. Composer install for autoload classes:
    ```
    composer install
    ```
5. Start the PHP built-in server:
    ```
    php -S localhost:8000 -t public
    ```
6. Open your browser and navigate to `http://localhost:8000`.

### Docker Installation

If you have Docker installed, you can use it to run the application without having to install PHP and Composer on your
local machine.

1. Build the Docker image:
    ```
    docker build -t item-api .
    ```

2. Run the Docker container:
    ```
    docker run -p 8000:8000 item-api
    ```

3. Open your browser and navigate to `http://localhost:8000`.

Please note that the Dockerfile included in this project is set up to expose port 8000, so make sure that port is
available on your machine.

## Usage

The API provides the following endpoints:

- `GET api/v1/items`: Retrieve all items.
- `GET api/v1/items/{id}`: Retrieve a single item by its ID.

## Authentication

The API uses Basic Authentication. You need to provide your username and password with each request.