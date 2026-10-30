<?php
    namespace view;
    // Incluimos las dependencias necesarias para ejecutar la funcionalidad
    // 'TFG.php' contiene funciones utilitarias como obtener la URL base de la aplicación
    require_once '../TFG.php';
    
    // Incluimos el archivo que contiene la lógica para eliminar archivos en el servidor
    include '../control/delete_files.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>FastqAnalysis</title>
    <meta charset="utf-8">
    <script>
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
      <h4>FastqAnalysis</h4>
      <div class="content">
      	<!-- Formulario para subir archivos de secuencias y definir par&aacute;metros de an&aacute;lisis -->
        <form method="post" enctype="multipart/form-data" onsubmit="mostrarCarga(); ProcesarForm(this,'<?php \TFG::app_dir()?>/control/fastq_analysis_controller.php','contenido');return false">
          <!-- Input para subir archivos MULTI-FASTA -->
          <label for="fileToUpload1">Formato MULTI-FASTA</label>
          <input type="file" name="fileToUpload1" id="fileToUpload1" accept=".fasta,.fa" required><br><br>
          <!-- Input para subir archivos FASTQ -->
          
          <label for="fileToUpload2">Formato FASTQ</label>
          <input type="file" name="fileToUpload2" id="fileToUpload2" accept=".fastq" required><br><br>
          
          <!-- Selector para definir el tamaño de palabra (entre 3 y 9) -->
          <label for="wordSize">Word size (K)</label>
          <input type="number" id="wordSize" name="wordSize" min="3" max="9" required><br><br>
          
          <!-- Input para definir el umbral (Threshold) del análisis -->
          <label for="umbral">Umbral</label>
          <input type="number" id="umbral" name="umbral" min="0.00" max="1" step="0.01" required><br><br>
          <input type="radio" id="mayor" name="comparacion" value="1" required>
          
          <!-- Opciones de comparación para seleccionar "Mayor que" o "Menor que" -->
          <label for="mayor">Mayor que</label><br>
          <input type="radio" id="menor" name="comparacion" value="0">
          <label for="menor">Menor que</label><br><br>
          
          <!-- Botón de envío -->
          <input type="submit" value="Confirmar">
          <!-- Icono con instrucciones adicionales -->
          <i class="bi bi-question-circle" title="Instrucciones: Rellene los archivos en formato MULTI-FASTA y FASTQ, elija el tamaño de palabra entre 3 y 9, y establezca un umbral entre 0.00 y 1.00. Seleccione el tipo de comparación deseado."></i>
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