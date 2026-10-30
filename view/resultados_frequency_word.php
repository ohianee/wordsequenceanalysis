<?php
    namespace view;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resultados FrequencyWord</title>
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
                         * Este bloque PHP maneja la visualización de los resultados obtenidos.
                         * Verifica si hay resultados en la variable `$_REQUEST['resultados-obtenidos`, 
                         * luego procesa el archivo de datos y la imagen generada para moverlos a una carpeta de destino.
                         */
                        function mostrarResultadosFrequencyWord() {
                            // Verificamos si existen resultados disponibles en la solicitud
                            if (isset($_REQUEST['resultados-obtenidos'])) {
                                // Extraemos los resultados obtenidos
                                $resultados = $_REQUEST['resultados-obtenidos'];
                                // Dividimos el contenido de la variable en líneas
                                $lineas = explode("\n", trim($resultados));
                                // El último elemento de las líneas será el nombre de la imagen
                                $imageName = end($lineas);
                                // El penúltimo elemento es el archivo para descargar
                                $fileDownload = trim(prev($lineas));
                                // Carpeta de destino para los archivos generados
                                $destinationFolder = '../files/';
                                
                                // Verificamos si el archivo a descargar existe
                                if (file_exists($fileDownload)) {
                                    // Construimos la nueva ruta para el archivo en la carpeta de destino
                                    $newFilePath = $destinationFolder . basename($fileDownload);
                                    
                                    // Intentamos mover el archivo a la carpeta de destino
                                    if (rename($fileDownload, $newFilePath)) {
                                        // Si se mueve correctamente, mostramos un enlace de descarga
                                        echo "<a href='{$newFilePath}' download>Descargar datos de la gráfica</a><br>";
                                    } else {
                                        echo "Error al mover el archivo para descarga.<br>";
                                    }
                                } else {
                                    // Si el archivo no existe, mostramos un mensaje de error
                                    echo "No se encontró el archivo para descargar.<br>";
                                }
                
                                // Verificamos si la imagen de la gráfica existe
                                if (file_exists($imageName)) {
                                    // Construimos la nueva ruta para la imagen en la carpeta de destino
                                    $newImagePath = $destinationFolder . basename($imageName);
                                    
                                    // Intentamos mover la imagen a la carpeta de destino
                                    if (rename($imageName, $newImagePath)) {
                                        // Si se mueve correctamente, mostramos la imagen
                                        echo "<img src='{$newImagePath}' alt='Gr&aacute;fica de frecuencias relativas' class='responsive'><br>";
                                    } else {
                                        echo "Error al mover archivos a la carpeta de destino.<br>";
                                    }
                                } else {
                                    // Si la imagen no existe, mostramos un mensaje de error
                                    echo "No se encontr&oacute; la im&aacute;gen de la gr&aacute;fica.<br>";
                                }
                                if (isset($_REQUEST['total-sequences'])) {
                                    echo $_REQUEST['total-sequences'] . '<br>';
                                }
                                if (isset($_REQUEST['time'])){
                                    // Mostrar el tiempo de procesamiento del servidor
                                    echo 'Tiempo de procesamiento del servidor: ' . $_REQUEST['time'] . ' seg <br>';
                                }
                            } else {
                                // Si no hay resultados, mostramos un mensaje indicando que no se encontraron
                                echo "No se encontraron resultados.<br>";
                            }
                        }

                        // Llamamos a la función para mostrar los resultados
                        mostrarResultadosFrequencyWord();
                    ?>
                </pre>
            </div>
        </div>
    </div>
</body>
</html>