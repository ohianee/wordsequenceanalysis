<?php
    namespace view;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resultados WordFreq</title>
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
                 * @brief Muestra los resultados de la operación de WordFreq.
                 *
                 * Este script verifica si hay un archivo de salida para descargar
                 * y si hay resultados obtenidos. Genera enlaces para la descarga
                 * y muestra los resultados de forma segura.
                 */
                function mostrarResultadosWordFreq() {
                    if (isset($_REQUEST['output-file'])) {
                        $filename = basename($_REQUEST['output-file']);
                        $filepath = '../files/' . $filename;
                        
                        if (file_exists($filepath) && is_readable($filepath)) {
                            $encoded_filename = urlencode($filename);
                            $download_link = '../files/' . $encoded_filename;
                            echo '<a href="' . $download_link . '" download="' . $filename . '">Descargar archivo de resultados</a><br>';
                        } else {
                            echo "El archivo no est&aacute; disponible para descargar.";
                        }
                        
                    } else {
                        echo "No se proporcion&oacute; un archivo para descargar.<br>";
                    }
                    
                    if (isset($_REQUEST['total-sequences'])) {
                        $totalSequences = (float) $_REQUEST['total-sequences'];
                        echo 'Total de secuencias procesadas por segundo: ' . number_format($totalSequences, 0) . '<br>';
                    }
                    
                    if (isset($_REQUEST['time'])) {
                        echo 'Tiempo de procesamiento del servidor: ' . $_REQUEST['time'] . ' seg<br>';
                    }
                    
                    echo "\n\n";
                    
                    if (isset($_REQUEST['resultados-obtenidos'])) {
                        if ($_REQUEST['resultados-obtenidos'] == '0') {
                            echo "Los resultados ocupan mucho espacio por lo tanto no pueden mostrarse.";
                        } else {
                            echo htmlspecialchars($_REQUEST['resultados-obtenidos']);
                        }
                    } else {
                        echo "No se encontraron resultados.";
                    }
                }

                // Llamamos a la función para mostrar los resultados
                mostrarResultadosWordFreq();
            ?>
            </pre>
          </div>
        </div>
    </div>
</body>
</html>