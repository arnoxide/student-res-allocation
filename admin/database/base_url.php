<?php

// Define a constant for your local and server base URLs
define('LOCAL_BASE_URL', 'http://localhost/theboxlab/admin/');
define('SERVER_BASE_URL', 'https://theboxlab.net/admin/');

// Determine the environment (local or server)
$environment = 'local'; // You can change this to 'server' when deploying

// Use the appropriate base URL based on the environment
$base_url = ($environment === 'local') ? LOCAL_BASE_URL : SERVER_BASE_URL;

// Example usage:
// Create a URL using the determined base URL
// $relative_path = 'some-page.php';
// $url = $base_url . $relative_path;


?>