<?php
    namespace view;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resultados WordFind</title>
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
                     * @brief Muestra los resultados obtenidos por la operación de WordFind.
                     *
                     * Este script verifica si hay resultados en la variable global
                     * $_REQUEST['resultados-obtenidos'], que contiene los nombres de archivos
                     * y mueve los archivos a un directorio de destino, generando enlaces
                     * de descarga para los archivos y mostrando las imágenes.
                     */
                    function mostrarResultadosWordFind() {
                        // Verificamos si existen resultados obtenidos en la solicitud
                        if (isset($_REQUEST['resultados-obtenidos'])) {
                            // Separamos los nombres de archivo obtenidos
                            $imageNames = explode("\n", trim($_REQUEST['resultados-obtenidos']));
                            $fileDownload = $imageNames[0] ?? ''; // Primer nombre de archivo para descargar
                            $imageName = $imageNames[1] ?? ''; // Segundo nombre de archivo para mostrar la imagen
                            $totalSequences = $imageNames[2] ?? ''; // Total de secuencias procesadas por segundo
                            $destinationFolder = '../files/'; // Carpeta de destino para mover los archivos
                            
                            // Verificamos si el archivo a descargar existe
                            if (file_exists($fileDownload)) {
                                $newFilePath = $destinationFolder . basename($fileDownload); // Ruta nueva para el archivo a descargar
                                
                                // Movemos el archivo a la carpeta de destino
                                if (rename($fileDownload, $newFilePath)) {
                                    // Enlace para descargar los datos de la gráfica
                                    echo "<a href='{$newFilePath}' download>Descargar datos de la gráfica</a><br>";
                                } else {
                                    echo "Error al mover el archivo para descarga.<br>";
                                }
                            } else {
                                echo "No se encontró el archivo para descargar.<br>";
                            }
        
                            // Verificamos si la imagen existe
                            if (file_exists($imageName)) {
                                $newImagePath = $destinationFolder . basename($imageName); // Ruta nueva para la imagen
                                
                                // Movemos la imagen a la carpeta de destino
                                if (rename($imageName, $newImagePath)) {
                                    // Mostramos la imagen en la página
                                    echo "<img src='{$newImagePath}' alt='Gr&aacute;fica de l&iacute;neas' class='responsive'><br>";
                                } else {
                                    echo "Error al mover archivos a la carpeta de destino.";
                                }
                            } else {
                                echo "No se encontr&oacute; la im&aacute;gen de la gr&aacute;fica.";
                                echo $imageName . '<br>';
                            }
                            
                            if ($totalSequences) {
                                echo $totalSequences . '<br>';
                            }
                            
                            if (isset($_REQUEST['time'])){
                                // Mostrar el tiempo de procesamiento del servidor
                                echo 'Tiempo de procesamiento del servidor: ' . $_REQUEST['time'] . ' seg<br>';
                            }
                        } else {
                            echo "No se encontraron resultados.";
                        }
                    }

                    // Llamamos a la función para mostrar los resultados
                    mostrarResultadosWordFind();
                ?>
            </pre>
          </div>
        </div>
    </div>
</body>
</html>