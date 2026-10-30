<?php
    // Requiere la clase TFG para acceder a las funciones de la aplicación.
    require 'TFG.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Sequence Analysis</title>
    <link href="<?php TFG::app_dir()?>/css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="<?php TFG::app_dir()?>/img/wordsequenceanalysis_icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
     <script>var appDir = '<?php echo TFG::app_dir(); ?>';</script>
    <script src="<?php TFG::app_dir()?>/js/app_functions.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        	// Carga la vista home.php al inicio y configura el men&uacute;
            Cargar('<?php TFG::app_dir()?>/view/home.php', 'contenido');

            // Oculta el botón de confirmar si está presente
            var btnConfirmar = document.getElementById('btnConfirmar');
            if (btnConfirmar) btnConfirmar.style.display = 'none';

            // Comprueba si hay una sesi&oacute;n iniciada
            checkSession();

            var navbarToggler = document.querySelector('.navbar-toggler');
            var navbarCollapse = document.querySelector('#collapsibleNavbar');
         	// Cierra la barra de navegación al hacer clic en los enlaces
            function closeNavbar() {
                var bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    toggle: false
                });
                bsCollapse.hide();
            }
            var navLinks = document.querySelectorAll('#collapsibleNavbar .nav-link');
            navLinks.forEach(function (link) {
                link.addEventListener('click', closeNavbar);
            });
        });

        // Carga vistas previas en función de la navegación por el historial
        window.addEventListener('popstate', function(event) {
            if (event.state) {
                Cargar(event.state.url, event.state.capa, false);
            }
        });
    </script>
</head>
<body>

<!-- Men&uacute; de navegaci&oacute;n -->
<nav class="navbar navbar-expand-sm navbar-dark barra">
    <div class="container-fluid">
        <div class="d-flex justify-content-start w-100 align-items-center">
            <a href="#" onclick="closeNavbar();Cargar('<?php TFG::app_dir()?>/view/home.php','contenido')" class="navbar-brand d-flex align-items-center">
                <img src="./img/wordsequenceanalysis.png" alt="Logotipo" class="logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse barra" id="collapsibleNavbar">
                <ul class="navbar-nav ms-3 d-flex justify-content-center align-items-center">
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="javascript:void(0)" onclick="Cargar('<?php TFG::app_dir()?>/view/word_freq.php','contenido')">WordFreq</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="javascript:void(0)" onclick="Cargar('<?php TFG::app_dir()?>/view/word_compar.php','contenido')">WordCompar</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="javascript:void(0)" onclick="Cargar('<?php TFG::app_dir()?>/view/word_find.php','contenido')">WordFind</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="javascript:void(0)" onclick="Cargar('<?php TFG::app_dir()?>/view/frequency_word.php','contenido')">FrequencyWord</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="javascript:void(0)" onclick="Cargar('<?php TFG::app_dir()?>/view/fastq_analysis.php','contenido')">FastqAnalysis</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <button id="btnSession" class="btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-person-fill"></i>
                        </button>
                        <div id="dropdownMenuButton" class="btn-group ms-2" style="display: none;">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-check-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button id="btnActualizar" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                        <i class="bi bi-arrow-repeat"></i> Actualizar
                                    </button>
                                </li>
                                <li>
                                    <button id="btnConfirmar" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                        <i class="bi bi-check2-circle"></i> Confirmar
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addTableModal">
                                        <i class="bi bi-plus"></i> A&ntilde;adir Genoma
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteTableModal">
                                        <i class="bi bi-x"></i> Eliminar Genoma
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" onclick="cerrarSesion()">
                                        <i class="bi bi-person-dash-fill"></i> Cerrar sesi&oacute;n
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<br><br>

<!-- Contenedor donde se cargará; dinámicamente el contenido de las vistas -->
<div id="contenido" class="container"></div>
<br><br>

<!-- Pie de página -->
<footer>
	<div id="final_pagina">
        &copy; <?php echo date("Y"); ?> - Word Sequence Analysis
        <a class="nav-link" href="<?php TFG::app_dir()?>/docs/index.html">
        	<i class="bi bi-info-circle-fill"></i>
        </a>
    </div>
</footer>

<!-- Actualizar -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Actualizar Base de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateForm" method="post" onsubmit="actualizarBD(event)">
          <div class="mb-3">
            <label for="passwordInput" class="form-label">Contrase&ntilde;a</label>
            <input type="password" class="form-control" id="passwordInput" name="password" required>
          </div>
          <div id="actualizandoMensaje" style="display: none;">
    		<p>Actualizando la base de datos...</p>
		</div>
          <div class="modal-footer">
            <button id="btn-cancelar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="btn-actualizar" type="submit" class="btn">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Confirmar -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualizaci&oacute;n</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>La base de datos ha sido actualizada. ¿Est&aacute; todo correcto?</p>
      </div>
      <div class="modal-footer">
        <form id="confirmForm" method="post" onsubmit="controlarBotonConfirmar(false);confirmarBD(event);">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label id="confirm-no" class="btn">
                            <input type="radio" name="confirm-option" value="no" required> No
                        </label>
                        <label id="confirm-si" class="btn">
                            <input type="radio" name="confirm-option" value="yes"> S&iacute;
                        </label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end mt-3">
                <div class="col-auto">
                    <button id="confirm-confirmar" type="submit" class="btn">Confirmar</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Iniciar Sesi&oacute;n</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="loginForm" method="post" onsubmit="iniciarSesion(event)">
          <div class="mb-3">
            <label for="usernameInput" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usernameInput" name="username" autocomplete="username" required>
          </div>
          <div class="mb-3">
            <label for="passwordInputLogin" class="form-label">Contrase&ntilde;a</label>
            <input type="password" class="form-control" id="passwordInputLogin" name="password" required>
          </div>
          <div class="modal-footer">
            <button id="btn-inicancel" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="btn-iniciar" type="submit" class="btn">Iniciar Sesi&oacute;n</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Añadir Genoma -->
<div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTableModalLabel">A&ntilde;adir Nuevo Genoma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTableForm" method="post" onsubmit="addTable(event)">
                    <div class="mb-3">
                        <label for="tableNameInput" class="form-label">Nombre del Genoma</label>
                        <input type="text" class="form-control" id="tableNameInput" name="tableName" required>
                    </div>
                    <div class="mb-3">
                        <label for="tableUrlInput" class="form-label">URL</label>
                        <input type="text" class="form-control" id="tableUrlInput" name="tableUrl" required>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-addCancel" type="button" class="btn" data-bs-dismiss="modal">Cancelar</button>
                        <button id="btn-add" type="submit" class="btn">A&ntilde;adir Genoma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar Genoma -->
<div class="modal fade" id="deleteTableModal" tabindex="-1" aria-labelledby="deleteTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTableModalLabel">Eliminar Genoma Existente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteTableForm" method="post" onsubmit="deleteTable(event)">
                    <div class="mb-3">
                        <label for="deleteTableNameInput" class="form-label">Nombre del Genoma</label>
                        <input type="text" class="form-control" id="deleteTableNameInput" name="tableName" required>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-deleteCancel" type="button" class="btn" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar Genoma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>