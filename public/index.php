<?php
// routes.
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$basePath = dirname($scriptName);
$basePath = str_replace('/public', '', $basePath);
$basePath = rtrim($basePath, '/');
$baseUrl = $basePath === '/' ? '' : $basePath;

$path = parse_url($requestUri, PHP_URL_PATH);
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
$path = '/' . trim($path, '/');
if ($path === '/.') {
    $path = '/';
}

$routes = [
    '/' => __DIR__ . '/../src/controllers/indexController.php',
    '/home' => __DIR__ . '/../src/controllers/homeController.php',
];

if (isset($routes[$path]) && file_exists($routes[$path])) {
    require $routes[$path];
    exit;
}

http_response_code(404);
echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">  <title>404 - No encontrado</title></head><body>  <h1>404 - No se encontró la ruta</h1>  <p>Ruta: ' . htmlspecialchars($path) . '</p></body></html>';
exit;
