<?php
    namespace control;
    use model\acceso_bd;
    
    require_once('../model/acceso_bd.php');
    
    /**
     * Procesa un archivo comprimido en formato GZ y lo descomprime en un archivo temporal.
     *
     * @param string $ruta Ruta del archivo GZ a procesar.
     * @return string Ruta del archivo descomprimido.
     */
    function procesarArchivo($ruta) {
        // Crea un archivo temporal para almacenar el archivo GZ.
        $gzFile = tempnam(sys_get_temp_dir(), 'gzfile_') . '.gz';
        file_put_contents($gzFile, fopen($ruta, 'r'));
        
        // Crea otro archivo temporal para almacenar el contenido descomprimido.
        $extractedFile = tempnam(sys_get_temp_dir(), 'extracted_');
        $gz = gzopen($gzFile, 'rb');
        $outFile = fopen($extractedFile, 'wb');
        
        // Lee el archivo GZ y escribe su contenido en el archivo de salida.
        while (!gzeof($gz)) {
            fwrite($outFile, gzread($gz, 4096));
        }
        
        // Cierra los manejadores de archivos.
        gzclose($gz);
        fclose($outFile);
        
        // Devuelve la ruta del archivo descomprimido.
        return $extractedFile;
    }
    
    /**
     * Procesa la solicitud de los archivos y ejecuta el análisis correspondiente.
     */
    function frequency_word_controller() {
        $start_time = microtime(true);
        $fileToProcess_1 = $fileToProcess_2 = null;
        
        // Verifica si se ha recibido el tamaño de la palabra.
        if (isset($_POST['wordSize']) && !empty($_POST['wordSize'])) {
            $wordSize = $_POST['wordSize'];
            
            // Manejo de archivos a través de rutas.
            if (!empty($_POST['table_1']) && !empty($_POST['file_1']) && !empty($_POST['table_2']) && !empty($_POST['file_2'])) {
                $file_1 = $_POST['file_1'];
                $file_2 = $_POST['file_2'];
                $table_1 = $_POST['table_1'];
                $table_2 = $_POST['table_2'];
                
                // Obtiene las URL de las tablas desde la base de datos.
                $url_1 = acceso_bd::obtenerURLTabla($table_1);
                $url_2 = acceso_bd::obtenerURLTabla($table_2);
                
                // Construye las rutas de los archivos.
                $ruta_1 = $url_1 . $table_1 . '/dna/' . $file_1;
                $ruta_2 = $url_2 . $table_2 . '/dna/' . $file_2;
                
                // Verifica si los archivos existen antes de procesarlos.
                if (@fopen($ruta_1, 'r') && @fopen($ruta_2, 'r')) {
                    $fileToProcess_1 = procesarArchivo($ruta_1);
                    $fileToProcess_2 = procesarArchivo($ruta_2);
                    
                    $name1 = $file_1;
                    $name2 = $file_2;
                } else {
                    echo "Error: No se pudo abrir algún archivo de entrada.";
                    exit(1);
                }
                // Manejo de archivos subidos.
            } elseif (!empty($_FILES['fileToUpload1']['tmp_name']) && !empty($_FILES['fileToUpload2']['tmp_name'])) {
                $tmp_file_1 = $_FILES['fileToUpload1']['tmp_name'];
                $tmp_file_2 = $_FILES['fileToUpload2']['tmp_name'];
                
                $name1 = $_FILES['fileToUpload1']['name'];
                $name2 = $_FILES['fileToUpload2']['name'];
                
                $fileToProcess_1 = $tmp_file_1;
                $fileToProcess_2 = $tmp_file_2;
            } else {
                echo "Error: No se han recibido los datos necesarios.";
                exit(1);
            }
            
            // Compila y ejecuta el programa para calcular la frecuencia de palabras.
            $compile = "gcc -o frequency_word frequency_word.c";
            $run = "frequency_word {$fileToProcess_1} {$fileToProcess_2} {$wordSize} 2>&1";
            
            if (is_readable($fileToProcess_1) && is_readable($fileToProcess_2)) {
                // Ejecuta la compilación.
                $compileOutput = shell_exec($compile);
                if (strpos($compileOutput, 'error') !== false) {
                    echo "Error during compilation: $compileOutput";
                    exit(1);
                }
                
                // Ejecuta el análisis de frecuencia de palabras.
                $runOutput = shell_exec($run);
                if (strpos($runOutput, 'error') !== false) {
                    echo "Error during run: $runOutput";
                    exit(1);
                }
                
                $outputLines = explode("\n", trim($runOutput));
                $newFile = trim($outputLines[0]); // nombre del archivo
                $totalSequencesProcessed = trim($outputLines[1]); // valor adicional
                
                $oldFile = 'frecuencias_absolutas.txt';
                
                // Renombra el archivo de salida.
                if (file_exists($oldFile)) {
                    if (rename($oldFile, $newFile)) {
                        // Compila y ejecuta el programa para generar gráficos.
                        $compileG = "gcc -o frequency_word_graph frequency_word_graph.c";
                        $runG = "frequency_word_graph {$newFile} {$name1} {$name2} 2>&1";
                        
                        $compileOutputG = shell_exec($compileG);
                        if (strpos($compileOutputG, 'error') !== false) {
                            echo "Error during compilation: $compileOutputG";
                            exit(1);
                        }
                        
                        $runOutputG = shell_exec($runG);
                        if (strpos($runOutputG, 'error') !== false) {
                            echo "Error during run: $runOutputG";
                            exit(1);
                        }
                        
                        $resultados = $runOutputG;
                        
                        // Al final del procesamiento, después de la ejecución del programa, medimos el tiempo
                        $end_time = microtime(true);
                        $execution_time = $end_time - $start_time;
                        $formatted_execution_time = number_format($execution_time, 2);
                        
                        $_REQUEST['resultados-obtenidos'] = $resultados;
                        $_REQUEST['time'] = $formatted_execution_time;
                        $_REQUEST['total-sequences'] = $totalSequencesProcessed;
                        include_once '../view/resultados_frequency_word.php';
                    } else {
                        echo "Error: No se pudo renombrar el archivo.";
                    }
                } else {
                    echo "Error: El archivo $oldFile no existe.";
                }
            } else {
                echo "Error: No se pudo abrir algún archivo de entrada.";
                exit(1);
            }
        } else {
            echo "Error: No se han recibido los datos necesarios.";
        }
    }
    
    // Llama a la función para procesar la solicitud.
    frequency_word_controller();
?>