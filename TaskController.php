<?php

class TaskController {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function login() {
        $loginApiUrl = $this->config['loginApiUrl'];
        $loginToken = $this->config['loginToken'];
        $username = $this->config['vero_username'];
        $password = $this->config['vero_password'];

        $postData = json_encode([
            'username' => $username,
            'password' => $password,
        ]);

        $ch = curl_init($loginApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $loginToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['oauth']['access_token'])) {
            return [
                'access_token' => $data['oauth']['access_token'],
                'expires_in' => $data['oauth']['expires_in'],
            ];
        } else {
            return ['error' => 'Login failed'];
        }
    }

    public function index() {
        $tasksResponse = $this->getTasks(false);

        // Decode the JSON response
        $tasksData = json_decode($tasksResponse, true);

        // Check if decoding successful
        if ($tasksData && isset($tasksData['status']) && $tasksData['status'] == 200) {
            // Extract the tasks data
            $tasks = $tasksData['data'];

            require 'views/home.php';
        } 
    }

    public function getTasks($isAjax = true) {
        $taskApiUrl = $this->config['task_api_url'];
        $loginResult = $this->login();

        if (isset($loginResult['access_token'])) {
            $accessToken = $loginResult['access_token'];

            $ch = curl_init($taskApiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $tasks = json_decode($response, true);

            if ($tasks) {
                // Encode the tasks data as JSON
                $responseData = json_encode(['status' => 200, 'data' => $tasks]);
            } else {
                $responseData = json_encode(['status' => 500, 'data' => ['error' => 'Failed to fetch tasks']]);
            }
        } else {
            $responseData = json_encode(['status' => 500, 'data' => $loginResult]);
        }

        // Check if the request is Ajax
        if ($isAjax && $this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo $responseData;
        }

        return $responseData;
    }

    // this function checks if request is ajax
    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
