<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal de Personajes - Rick and Morty</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    body { 
      background-color: #202329; 
      color: white; 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .main-title {
      color: #00ff00; /* Verde neón estilo portal */
      text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
      font-weight: bold;
    }

    .character-card {
      background-color: #3c3e44;
      border: none;
      border-radius: 10px;
      transition: transform 0.2s, box-shadow 0.2s;
      height: 100%;
      overflow: hidden;
    }

    .character-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.5);
      border: 1px solid #00ff00;
    }

    .character-card img {
      filter: grayscale(20%);
      transition: filter 0.2s;
    }

    .character-card:hover img {
      filter: grayscale(0%);
    }

    .page-link {
      background-color: #3c3e44;
      color: #00ff00;
      border: 1px solid #202329;
    }

    .page-link:hover, .page-item.active .page-link {
      background-color: #00ff00;
      color: #202329;
      border-color: #00ff00;
    }

    .page-item.disabled .page-link {
      background-color: #202329;
      color: #555;
      border-color: #333;
    }

    .status-indicator {
      height: 8px;
      width: 8px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 5px;
    }
    .status-alive { background-color: #55cc44; }
    .status-dead { background-color: #d63d2e; }
    .status-unknown { background-color: #9e9e9e; }
  </style>
</head>
<body>

  <div class="container py-5">
    <div class="text-center mb-5">
      <h1 class="main-title display-4">MULTIVERSO RICK & MORTY</h1>
      <p class="text-secondary">Explora los habitantes de todas las dimensiones conocidas.</p>
    </div>

    <div id="characters" class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
      <div class="col-12 text-center">
        <div class="spinner-border text-success" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
      </div>
    </div>

    <nav aria-label="Navegación de personajes" class="mt-5">
      <ul id="pagination-items" class="pagination justify-content-center flex-wrap"></ul>
    </nav>

    <footer class="text-center mt-5 text-secondary">
      <p>&copy; 2026 Portal de Personajes - Rick and Morty. Todos los derechos reservados.</p>
      <p> Desarrollado por Jefry Urdaneta. GitHub: <a href="https://github.com/itsJefryTz/portal_web" target="_blank">Code here!</a></p>
    </footer>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function() {
      const base = "<?php echo $baseUrl; ?>";
      const page = <?php echo $_GET['page'] ?? 1; ?>;

      function renderCharacters(characters) {
        const container = $('#characters');
        container.empty();

        characters.forEach(character => {
          const characterUrl = base ? base + '/character?id=' + character.id : '/character?id=' + character.id;
          const statusClass = character.status.toLowerCase();

          const characterCard = `
            <div class="col">
              <a href="${characterUrl}" class="text-decoration-none">
                <div class="card character-card h-100 text-white">
                  <img src="${character.image}" class="card-img-top" alt="${character.name}">
                  <div class="card-body p-3 text-center">
                    <h5 class="card-title fs-6 mb-1 text-truncate">${character.name}</h5>
                    <p class="card-text small mb-0">
                      <span class="status-indicator status-${statusClass}"></span>
                      ${character.status} - ${character.species}
                    </p>
                  </div>
                </div>
              </a>
            </div>
          `;
          container.append(characterCard);
        });
      }

      function renderPagination(totalPages, currentPage) {
        const pagination = $('#pagination-items');
        pagination.empty();

        pagination.append(`
          <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="${base}/characters?page=${currentPage - 1}">Anterior</a>
          </li>
        `);

        let start = Math.max(1, currentPage - 2);
        let end = Math.min(totalPages, currentPage + 2);

        if (currentPage <= 3) end = Math.min(totalPages, 5);
        if (currentPage >= totalPages - 2) start = Math.max(1, totalPages - 4);

        for (let i = start; i <= end; i++) {
          const activeClass = (i === currentPage) ? 'active' : '';
          pagination.append(`
            <li class="page-item ${activeClass}">
              <a class="page-link" href="${base}/characters?page=${i}">${i}</a>
            </li>
          `);
        }

        pagination.append(`
          <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="${base}/characters?page=${currentPage + 1}">Siguiente</a>
          </li>
        `);
      }
      
      $.ajax({
        url: `https://rickandmortyapi.com/api/character?page=${page}`,
        method: 'GET',
        success: function(data) {
          renderCharacters(data.results);
          renderPagination(data.info.pages, page);
        },
        error: function() {
          $('#characters').html('<div class="col-12 text-center text-danger">Error al conectar con la Ciudadela de Ricks.</div>');
        }
      });
  });
  </script>
</body>
</html>