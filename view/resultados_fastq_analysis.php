<?php
namespace view;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resultados FastqAnalysis</title>
    <meta charset="utf-8">
</head>
<body>
    <div class="cuerpo">
        <div class="section">
          <h4>Resultados</h4>
          <div class="content">
            <pre>
                <?php
                    /**
                     * @brief Muestra los resultados obtenidos por una operación anterior.
                     *
                     * Este script verifica si hay resultados en la variable global
                     * $_REQUEST['resultados-obtenidos'], los cuales consisten en archivos
                     * y/o imágenes que se mueven a un directorio destino y se generan
                     * enlaces de descarga para los archivos.
                     */
                    function mostrarResultadosFatsqAnalysis() {
                        // Verificamos si la variable 'resultados-obtenidos' está definida en $_REQUEST
                        if (isset($_REQUEST['resultados-obtenidos'])) {
                            $resultados = $_REQUEST['resultados-obtenidos']; // Recuperamos los resultados
                            $lineas = explode("\n", $resultados); // Dividimos los resultados por líneas, asumiendo que son nombres de archivos
                            
                            $destino = '../files/'; // Carpeta destino donde se moverán los archivos e imágenes
                            $totalSequences = ''; // Variable para almacenar la última línea

                            // Recorremos cada línea de resultados para procesar los archivos
                            foreach ($lineas as $linea) {
                                // Verificamos si la línea no está vacía
                                if (!empty(trim($linea))) {
                                    $nombreArchivo = htmlspecialchars($linea); // Limpiamos el nombre del archivo para evitar XSS
                                    $totalSequences = $linea; // Guardamos la última línea procesada
                                    
                                    $rutaOrigen = $nombreArchivo; // Ruta original del archivo
                                    $rutaDestino = $destino . basename($nombreArchivo); // Nueva ubicación en el directorio 'files'
                
                                    // Verificamos si el archivo existe en su ruta original
                                    if (file_exists($rutaOrigen)) {
                                        // Movemos el archivo al directorio destino
                                        if (rename($rutaOrigen, $rutaDestino)) {
                                            // Codificamos el nombre del archivo para generar un enlace de descarga seguro
                                            $encoded_filename = urlencode($nombreArchivo);
                                            $download_link = '../files/' . $encoded_filename; // Enlace para descargar el archivo
                                            
                                            // Mostramos un enlace para descargar el archivo
                                            echo '<a href="' . $download_link . '" download="' . $nombreArchivo . '">Descargar ' . $nombreArchivo . '</a><br>';
                                        } else {
                                            echo "Error al mover el archivo: $nombreArchivo<br>"; // Error si no se puede mover el archivo
                                        }
                                    }
                                }
                            }
                            
                            // Procesamos las imágenes asociadas, si existen
                            foreach ($lineas as $linea) {
                                // Verificamos si la línea no está vacía
                                if (!empty(trim($linea))) {
                                    $nombreImagen = htmlspecialchars($linea) . '.png'; // Asumimos que el archivo de imagen tiene extensión '.png'
                                    $rutaOrigenImagen = $nombreImagen; // Ruta original de la imagen
                                    $rutaDestinoImagen = $destino . $nombreImagen; // Nueva ubicación en el directorio 'files'
                                    
                                    // Verificamos si la imagen existe en su ruta original
                                    if (file_exists($rutaOrigenImagen)) {
                                        // Movemos la imagen al directorio destino
                                        if (rename($rutaOrigenImagen, $rutaDestinoImagen)) {
                                            // Mostramos la imagen en la página
                                            echo "<img src='../files/{$nombreImagen}' alt='{$nombreImagen}' class='responsive'>";
                                        } else {
                                            echo "Error al mover la imagen: $nombreImagen<br>"; // Error si no se puede mover la imagen
                                        }
                                    }
                                }
                            }

                            echo '<br>' . htmlspecialchars($totalSequences);
                            
                        } else {
                            // Mensaje mostrado si no hay resultados en $_REQUEST
                            echo "No se encontraron resultados.";
                        }
                        
                        if (isset($_REQUEST['time'])){
                            // Mostrar el tiempo de procesamiento del servidor
                            echo '<br>Tiempo de procesamiento del servidor: ' . $_REQUEST['time'] . ' seg';
                        }
                    }

                    // Llamamos a la función para mostrar los resultados
                    mostrarResultadosFatsqAnalysis();
                ?>
            </pre>
          </div>
        </div>
    </div>
</body>
</html>