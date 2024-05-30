<?php

require 'TaskController.php';

$config = [
    'loginApiUrl' => 'https://api.baubuddy.de/index.php/login',
    'loginToken' => 'QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz',
    'vero_username' => '365',
    'vero_password' => '1',
    'task_api_url' => 'https://api.baubuddy.de/dev/index.php/v1/tasks/select'
];

$controller = new TaskController($config);

// Normalize the request URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = trim($requestUri, '/');

// Debugging: output the request URI and matched routes
echo "Request URI: $requestUri<br>";

// Define routes
$routes = [
    '' => 'index',
    'index' => 'index',
    'tasks/update' => 'getTasks',
    // 'tasks/search' => 'searchTasks' // Uncomment this if you implement a search function
];

// Debugging: output the available routes
echo "Available Routes: <pre>" . print_r($routes, true) . "</pre><br>";

// Route handling
if (array_key_exists($requestUri, $routes)) {
    $method = $routes[$requestUri];
    // Debugging: output the matched method
    echo "Matched Method: $method<br>";
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Method $method not found in controller.";
    }
} else {
    echo "404 Not Found";
}
?>
