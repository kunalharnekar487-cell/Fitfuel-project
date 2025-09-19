<?php
require_once '../config/cors.php';
require_once '../config/database.php';

// Simple API router
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

// Remove query string from URI and normalize path relative to this script directory
$uri = parse_url($request_uri, PHP_URL_PATH);
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // e.g. /fitfuel/api
if ($scriptDir !== '' && $scriptDir !== '/') {
    // Strip the script directory prefix so /fitfuel/api/products -> /products
    if (strpos($uri, $scriptDir) === 0) {
        $uri = substr($uri, strlen($scriptDir));
    }
}
// Ensure leading slash and collapse empty to '/'
if ($uri === '' || $uri === false) { $uri = '/'; }
if ($uri[0] !== '/') { $uri = '/' . $uri; }
// Trim trailing slash except for root
if ($uri !== '/' && substr($uri, -1) === '/') { $uri = rtrim($uri, '/'); }

// Handle preflight OPTIONS at router level as well
if ($request_method === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(["message" => "OK"]);
    exit;
}

// API Routes
switch($uri) {
    case '/':
        echo json_encode(array(
            "message" => "FitFuel API v1.0",
            "endpoints" => array(
                "POST /auth/login" => "User login",
                "POST /auth/register" => "User registration",
                "GET /products" => "Get all products",
                "GET /products?category=1" => "Get products by category",
                "GET /products?search=whey" => "Search products",
                "POST /cart/add" => "Add to cart",
                "GET /cart" => "Get cart items",
                "POST /wishlist/add" => "Add to wishlist"
            )
        ));
        break;

    case '/ping':
        echo json_encode(["status" => "ok", "time" => date('c')]);
        break;

    case '/products':
        require_once __DIR__ . '/products/get_products.php';
        break;

    case '/auth/login':
        require_once __DIR__ . '/auth/login.php';
        break;

    case '/auth/register':
        require_once __DIR__ . '/auth/register.php';
        break;

    case '/cart/add':
        require_once __DIR__ . '/cart/add_to_cart.php';
        break;

    case '/cart':
        require_once __DIR__ . '/cart/get_cart.php';
        break;

    case '/wishlist/add':
        require_once __DIR__ . '/wishlist/add_to_wishlist.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(array("message" => "Endpoint not found"));
        break;
}
?>
