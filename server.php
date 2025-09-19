<?php
// FitFuel PHP Development Server
// This file serves as the main entry point for the PHP backend

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Include CORS headers
require_once 'config/cors.php';

// Get the request URI and method
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

// Parse the URI
$uri = parse_url($request_uri, PHP_URL_PATH);
$uri_segments = explode('/', trim($uri, '/'));

// Route the request
if (empty($uri_segments[0]) || $uri_segments[0] === 'index.php') {
    // Serve the main index.html file
    header('Content-Type: text/html');
    readfile('index.html');
    exit;
}

// API routing
if ($uri_segments[0] === 'api') {
    if (count($uri_segments) < 2) {
        include 'api/index.php';
        exit;
    }

    $endpoint = $uri_segments[1];
    $action = isset($uri_segments[2]) ? $uri_segments[2] : '';

    switch ($endpoint) {
        case 'auth':
            if ($action === 'login') {
                include 'api/auth/login.php';
            } elseif ($action === 'register') {
                include 'api/auth/register.php';
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Auth endpoint not found']);
            }
            break;

        case 'products':
            if ($action === '' || $action === 'get_products') {
                include 'api/products/get_products.php';
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Products endpoint not found']);
            }
            break;

        case 'cart':
            if ($action === 'add' || $action === 'add_to_cart') {
                include 'api/cart/add_to_cart.php';
            } elseif ($action === '' || $action === 'get_cart') {
                include 'api/cart/get_cart.php';
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Cart endpoint not found']);
            }
            break;

        case 'wishlist':
            if ($action === 'add' || $action === 'add_to_wishlist') {
                include 'api/wishlist/add_to_wishlist.php';
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Wishlist endpoint not found']);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['message' => 'API endpoint not found']);
            break;
    }
    exit;
}

// Serve static files
$file_path = __DIR__ . '/' . $uri;
if (file_exists($file_path) && is_file($file_path)) {
    $mime_type = mime_content_type($file_path);
    header('Content-Type: ' . $mime_type);
    readfile($file_path);
    exit;
}

// 404 for everything else
http_response_code(404);
echo '404 - File not found';
?>
