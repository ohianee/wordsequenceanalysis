<?php
    namespace view;

    /**
     * Este archivo PHP define la vista principal de la aplicación que describe
     * varias herramientas bioinformáticas. También incluye una redirección automática
     * a la página 'index.php' si el usuario no se encuentra en ella.
     */
    
    // Incluye la clase TFG que contiene utilidades como obtener la URL base de la aplicación
    require_once '../TFG.php';
    
    // Incluye el script que maneja la eliminación de archivos en el servidor
    include '../control/delete_files.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Inicio</title>
  <meta charset="utf-8">
  <script>
    /**
     * Este script redirige automáticamente a la página 'index.php' si el usuario
     * se encuentra en una URL diferente dentro de la aplicación.
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

    <!-- Sección que describe la herramienta WordFreq -->
    <div class="section">
      <h4>WordFreq</h4>
      <div class="content">
        <p>El programa <strong>WordFreq</strong> se encarga de analizar secuencias gen&eacute;ticas en formato .fasta dividi&eacute;ndolas en cadenas de tama&ntilde;o k, conocidas como k-meros. Esta herramienta permite estudiar la frecuencia con la que aparecen diferentes subsecuencias dentro de una secuencia gen&eacute;tica completa. Al conocer la frecuencia de estos k-meros, los investigadores pueden identificar patrones y caracter&iacute;sticas espec&iacute;ficas en los genomas que est&aacute;n estudiando. Esta informaci&oacute;n es vital para entender la composici&oacute;n y las posibles funciones biol&oacute;gicas de las secuencias gen&eacute;ticas analizadas.</p>
      </div>
    </div>

    <!-- Sección que describe la herramienta WordCompar -->
    <div class="section">
      <h4>WordCompar</h4>
      <div class="content">
        <p>El programa <strong>WordCompar</strong> permite comparar secuencias gen&eacute;ticas mediante el uso de palabras de tama&ntilde;o k. Este an&aacute;lisis se realiza calculando dos tipos de distancias entre las secuencias: la distancia euclidiana y la distancia del coseno. La distancia euclidiana mide la diferencia directa entre las frecuencias de los k-meros en dos secuencias, mientras que la distancia del coseno eval&uacute;a la similitud en la orientaci&oacute;n de los vectores de frecuencia. Con esta herramienta, es posible determinar cu&aacute;n similares o diferentes son dos genomas, lo cual es &uacute;til para estudios evolutivos y comparativos.</p>
      </div>
    </div>

    <!-- Sección que describe la herramienta WordFind -->
    <div class="section">
      <h4>WordFind</h4>
      <div class="content">
        <p>El programa <strong>WordFind</strong> se utiliza para buscar un fragmento espec&iacute;fico de una secuencia gen&eacute;tica dentro de un genoma completo. Esta b&uacute;squeda permite identificar en qu&eacute; parte del genoma aparece la subsecuencia deseada. Cuando se utilizan tama&ntilde;os de k mayores, los resultados de la b&uacute;squeda son m&aacute;s precisos y claros, ya que los k-meros largos son menos propensos a aparecer por coincidencia. Esta herramienta es fundamental para localizar genes, motivos espec&iacute;ficos y otras caracter&iacute;sticas importantes en el genoma.</p>
      </div>
    </div>

    <!-- Sección que describe la herramienta FrequencyWord -->
    <div class="section">
      <h4>FrequencyWord</h4>
      <div class="content">
        <p>El programa <strong>FrequencyWord</strong> calcula la frecuencia absoluta de k-meros en dos genomas diferentes. Primero, analiza cada genoma por separado para determinar la frecuencia de cada k-mero. Luego, compara estos valores y representa los resultados en una gr&aacute;fica. Esta comparaci&oacute;n visual permite a los investigadores observar diferencias y similitudes en la composici&oacute;n gen&eacute;tica de los dos genomas analizados, proporcionando una visi&oacute;n clara de c&oacute;mo var&iacute;an entre s&iacute; a nivel de k-meros.</p>
      </div>
    </div>

    <!-- Sección que describe la herramienta FastqAnalysis -->
    <div class="section">
      <h4>FastqAnalysis</h4>
      <div class="content">
        <p>El programa <strong>FastqAnalysis</strong> realiza un an&aacute;lisis detallado de un archivo multifasta, dividiendo las secuencias en palabras de tama&ntilde;o k. Posteriormente, compara estas palabras con etiquetas presentes en un archivo fastq para determinar la distancia m&iacute;nima entre ellas. Este proceso implica encontrar la palabra m&aacute;s cercana a cada etiqueta del archivo fastq y registrar esta distancia m&iacute;nima. Los resultados se presentan en un archivo que muestra cada etiqueta junto con la distancia m&iacute;nima a las secuencias del archivo multifasta. Esta herramienta es crucial para estudios que requieren la identificaci&oacute;n de secuencias espec&iacute;ficas dentro de grandes conjuntos de datos gen&eacute;ticos.</p>
      </div>
    </div>

  </div>
</body>
</html>