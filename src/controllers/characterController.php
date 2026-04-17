<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalles del Personaje - Rick and Morty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #202329; color: white; }
    .character-card { background-color: #3c3e44; border: none; border-radius: 10px; overflow: hidden; }
    .status-indicator { height: 10px; width: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
    .status-alive { background-color: #55cc44; }
    .status-dead { background-color: #d63d2e; }
    .status-unknown { background-color: #9e9e9e; }
    .text-gray { color: #9e9e9e; }
  </style>
</head>
<body>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <a href="<?php echo $baseUrl; ?>/characters?page=1" class="btn btn-outline-success mb-4">
            &larr; Volver al portal
        </a>

        <div id="character-detail" class="character-card shadow-lg">
          <div class="row g-0">
            <div class="col-md-5" id="char-image-container">
                </div>
            <div class="col-md-7">
              <div class="card-body p-4">
                <h1 id="char-name" class="display-5 fw-bold text-success">Cargando...</h1>
                
                <p class="fs-5">
                  <span id="char-status-icon" class="status-indicator"></span>
                  <span id="char-status-text"></span> - <span id="char-species"></span>
                </p>

                <div class="mt-4">
                  <p class="mb-0 text-gray">Última ubicación conocida:</p>
                  <p id="char-location" class="fs-5"></p>
                </div>

                <div class="mt-3">
                  <p class="mb-0 text-gray">Origen:</p>
                  <p id="char-origin" class="fs-5"></p>
                </div>

                <div class="mt-3">
                  <p class="mb-0 text-gray">Género:</p>
                  <p id="char-gender" class="fs-5"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function() {
      const characterId = <?php echo $_GET['id'] ?? 1; ?>;

      $.ajax({
        url: `https://rickandmortyapi.com/api/character/${characterId}`,
        method: 'GET',
        success: function(data) {
          $('#char-name').text(data.name);
          $('title').text(data.name + ' - Detalles');
          $('#char-species').text(data.species);
          $('#char-gender').text(data.gender);
          $('#char-location').text(data.location.name);
          $('#char-origin').text(data.origin.name);

          $('#char-image-container').html(`
            <img src="${data.image}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="${data.name}">
          `);

          const status = data.status.toLowerCase();
          $('#char-status-text').text(data.status);
          $('#char-status-icon').addClass('status-' + status);
        },
        error: function() {
          $('#character-detail').html(`
            <div class="p-5 text-center">
              <h2>¡Oh no! Este personaje fue borrado por un portal mal calculado.</h2>
              <p>El ID ${characterId} no existe en esta dimensión.</p>
            </div>
          `);
        }
      });
    });
  </script>
</body>
</html>