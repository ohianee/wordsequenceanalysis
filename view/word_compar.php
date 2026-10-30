<?php
    namespace view;
    use model\acceso_bd;
    
    // Incluimos las dependencias necesarias para ejecutar la funcionalidad
    require_once '../TFG.php'; // 'TFG.php' contiene funciones utilitarias como obtener la URL base de la aplicación
    require_once '../model/acceso_bd.php'; // Modelo para el acceso a la base de datos
    include '../control/delete_files.php'; // Script que contiene la lógica para eliminar archivos en el servidor
    
    /**
     * Este script obtiene una lista de tablas desde la base de datos, y luego
     * genera dinámicamente listas de nombres asociados a esas tablas.
     * Los nombres obtenidos se utilizarán para seleccionar genomas y cromosomas
     * en una interfaz web donde se suben y procesan archivos FASTA.
     */
    
    // Obtenemos un listado de tablas desde la base de datos
    $tablas = acceso_bd::obtenerListadoTablas();
    // Guardamos las tablas en la variable global $_REQUEST para su uso en la interfaz
    $_REQUEST['tablas'] = $tablas;
    
    // Recorremos las tablas y obtenemos los nombres asociados a cada una
    $indice = 1;
    foreach ($tablas as $tabla) {
        $variableNombre = "nombres" . $indice;
        // Almacenamos los nombres asociados a cada tabla en la variable global $_REQUEST
        $_REQUEST[$variableNombre] = acceso_bd::obtenerListadoNombres($tabla);
        $indice++;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>FrequencyWord</title>
  <meta charset="utf-8">
  <script>
    <?php
    // Generamos variables JavaScript que contienen los nombres obtenidos de cada tabla
    $indice = 1;
    foreach ($tablas as $tabla) {
        $variableNombre = "nombres" . $indice;
        echo "var " . $variableNombre . " = " . json_encode($_REQUEST[$variableNombre]) . ";";
        $indice++;
    }
    ?>
    var nombres = [];  // Variable global que contendrá los nombres correspondientes a una tabla seleccionada

    /**
     * Función que actualiza la lista de archivos (cromosomas) según el genoma seleccionado.
     * 
     * @param {string} selectId - El ID del elemento <select> que contiene las tablas (genomas)
     */
    function Upload(selectId) {
        var selectTable = document.getElementById(selectId);
        var selectFile = selectTable.nextElementSibling;

        // Reiniciamos las opciones del select correspondiente a los archivos
        selectFile.innerHTML = '<option value="">Selecciona un archivo</option>';

        var selectedTable = selectTable.value;

        // Asignamos a 'nombres' el listado correspondiente a la tabla seleccionada
        <?php
        $indice = 1;
        foreach ($tablas as $tabla) {
            echo "if (selectedTable == '" . $tabla . "') { nombres = nombres" . $indice . "; }";
            $indice++;
        }
        ?>

        // Añadimos las opciones correspondientes a los nombres de archivos (cromosomas)
        nombres.forEach(function(nombre) {
            var option = document.createElement("option");
            option.value = nombre;
            option.text = nombre;
            selectFile.appendChild(option);
        });
    }

    /**
     * Función que se ejecuta cuando se carga la página. Inicializa los selectores
     * de tablas y archivos automáticamente.
     */
    window.onload = function() {
        Upload('select_table_1'); // Cargamos los archivos para el primer selector
        Upload('select_table_2'); // Cargamos los archivos para el segundo selector
    };

    /**
     * Redirige al usuario a la página principal si no se encuentra en ella.
     * Verifica si la ruta actual es diferente de 'index.php' y, de ser así, redirige.
     */
    window.addEventListener('load', function() {
        if (window.location.pathname !== '<?php \TFG::app_dir()?>/index.php') {
            window.location.href = '<?php \TFG::app_dir()?>/index.php';
        }
    });
  </script>
</head>
<body>
    <div class="cuerpo">
        <div class="section">
          <h4>WordCompar</h4>
          <div class="content">
            <!-- Formulario para seleccionar tablas y archivos, y subir archivos FASTA -->
            <form method="post" enctype="multipart/form-data" onsubmit="mostrarCarga(); ProcesarForm(this,'<?php \TFG::app_dir()?>/control/word_compar_controller.php','contenido');return false">
              <!-- Selector para la primera tabla (genoma) -->
              <select id="select_table_1" name="table_1" onchange="Upload('select_table_1')">
                <option value="">Selecciona un genoma</option>
                <?php foreach ($tablas as $tabla) { ?>  
                  <option value="<?php echo $tabla ?>"><?php echo $tabla ?></option>
                <?php } ?> 
              </select>

              <!-- Selector para los archivos (cromosomas) correspondientes al primer genoma -->
              <select id="select_file_1" name="file_1">
                <option value="">Selecciona un cromosoma</option>
              </select>

              <!-- Selector para la segunda tabla (genoma) -->
              <select id="select_table_2" name="table_2" onchange="Upload('select_table_2')">
                <option value="">Selecciona un genoma</option>
                <?php foreach ($tablas as $tabla) { ?>  
                  <option value="<?php echo $tabla ?>"><?php echo $tabla ?></option>
                <?php } ?> 
              </select>

              <!-- Selector para los archivos (cromosomas) correspondientes al segundo genoma -->
              <select id="select_file_2" name="file_2">
                <option value="">Selecciona un cromosoma</option>
              </select><br><br>

              <!-- Input para subir archivos FASTA -->
              <input type="file" name="fileToUpload1" id="fileToUpload1" accept=".fasta,.fa">
              <input type="file" name="fileToUpload2" id="fileToUpload2" accept=".fasta,.fa"><br><br>

              <!-- Selector para definir el tamaño de palabra (entre 3 y 12) -->
              <label for="wordSize">Word size (K)</label>
              <input type="number" id="wordSize" name="wordSize" min="3" max="12" required><br><br>

              <!-- Botón de envío -->
              <input type="submit" value="Confirmar">
              <!-- Icono con instrucciones adicionales -->
              <i class="bi bi-question-circle" title="Instrucciones: Selecciona un genoma y cromosoma de las listas o sube los archivos en formato FASTA, y define el tamaño de palabra entre 3 y 12."></i><br><br>
            </form>
          </div>
        </div>
    </div>
    
    <!-- Sección de carga que muestra una animación mientras se procesa la solicitud -->
    <div id="carga">
        <?php include './loading.php'; ?>
    </div>
</body>
</html>