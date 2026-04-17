<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
</head>
<body>
  <h1>Ruta Home</h1>
  <p>Esta es la ruta <strong>/home</strong>.</p>
  <p>Regresa a <a href="<?php echo htmlspecialchars($baseUrl ? $baseUrl . '/' : '/'); ?>"><?php echo htmlspecialchars($baseUrl ? $baseUrl . '/' : '/'); ?></a></p>
</body>
</html>
