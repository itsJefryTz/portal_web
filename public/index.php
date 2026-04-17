<?php
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$basePath = dirname($scriptName);
$basePath = str_replace('/public', '', $basePath);
$basePath = rtrim($basePath, '/');
$baseUrl = ($basePath === '/' || $basePath === '\\') ? '' : $basePath;

$path = parse_url($requestUri, PHP_URL_PATH);
if ($basePath && strpos($path, $basePath) === 0) {
  $path = substr($path, strlen($basePath));
}
$path = '/' . trim($path, '/');

$routes = [
  '/characters' => __DIR__ . '/../src/controllers/indexController.php',
  '/character' => __DIR__ . '/../src/controllers/characterController.php',
];

if ($path === '/' || $path === '/index.php') {
  $target = ($baseUrl ?: '') . '/characters?page=1';
  header('Location: ' . $target);
  exit;
}

if (isset($routes[$path])) {
  $file = $routes[$path];
  if (file_exists($file)) {
    require $file;
    exit;
  }
}

http_response_code(404);
echo "<h1>404 - No se encontró la ruta</h1><p>Ruta buscada: " . htmlspecialchars($path) . "</p>";
exit;