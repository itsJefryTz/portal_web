<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página principal</title>
</head>
<body>
  <h1>Bienvenido a la página principal</h1>
  <p>Esta es la ruta <strong>/</strong>.</p>
  <p>Prueba <a href="<?php echo htmlspecialchars($baseUrl ? $baseUrl . '/home' : '/home'); ?>"><?php echo htmlspecialchars($baseUrl ? $baseUrl . '/home' : '/home'); ?></a></p>
</body>
</html>
