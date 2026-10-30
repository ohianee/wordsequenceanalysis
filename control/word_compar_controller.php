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
        
        // Crea un archivo temporal para el archivo descomprimido.
        $extractedFile = tempnam(sys_get_temp_dir(), 'extracted_');
        $gz = gzopen($gzFile, 'rb');
        $outFile = fopen($extractedFile, 'wb');
        
        // Lee el archivo GZ y lo escribe en el archivo descomprimido.
        while (!gzeof($gz)) {
            fwrite($outFile, gzread($gz, 4096));
        }
        
        gzclose($gz);
        fclose($outFile);
        
        // Devuelve la ruta del archivo descomprimido.
        return $extractedFile;
    }
    
    /**
     * Procesa los archivos de entrada y ejecuta la comparación de palabras.
     */
    function word_compar_controller() {
        $start_time = microtime(true);
        $fileToProcess_1 = $fileToProcess_2 = null;
        
        // Verifica si se ha recibido el tamaño de palabra.
        if (isset($_POST['wordSize']) && !empty($_POST['wordSize'])) {
            $wordSize = $_POST['wordSize'];
            
            // Procesa archivos de tablas si están disponibles.
            if (!empty($_POST['table_1']) && !empty($_POST['file_1']) && !empty($_POST['table_2']) && !empty($_POST['file_2'])) {
                $table_1 = $_POST['table_1'];
                $file_1 = $_POST['file_1'];
                $table_2 = $_POST['table_2'];
                $file_2 = $_POST['file_2'];
                
                $url_1 = acceso_bd::obtenerURLTabla($table_1);
                $url_2 = acceso_bd::obtenerURLTabla($table_2);
                
                $ruta_1 = $url_1 . $table_1 . '/dna/' . $file_1;
                $ruta_2 = $url_2 . $table_2 . '/dna/' . $file_2;
                
                // Verifica si se pueden abrir los archivos.
                if (@fopen($ruta_1, 'r') && @fopen($ruta_2, 'r')) {
                    $fileToProcess_1 = procesarArchivo($ruta_1);
                    $fileToProcess_2 = procesarArchivo($ruta_2);
                } else {
                    echo "Error: No se pudo abrir algún archivo de entrada.";
                    exit(1);
                }
            }
            // Procesa archivos subidos por el usuario si no se han recibido archivos de tablas.
            elseif (!empty($_FILES['fileToUpload1']['tmp_name']) && !empty($_FILES['fileToUpload2']['tmp_name'])) {
                $tmp_file_1 = $_FILES['fileToUpload1']['tmp_name'];
                $tmp_file_2 = $_FILES['fileToUpload2']['tmp_name'];
                
                $fileToProcess_1 = $tmp_file_1;
                $fileToProcess_2 = $tmp_file_2;
            } else {
                echo "Error: No se han recibido los datos necesarios.";
                exit(1);
            }
            
            // Compila y ejecuta el programa de comparación.
            $compile = "gcc -o word_compar word_compar.c";
            $run = "word_compar {$fileToProcess_1} {$fileToProcess_2} {$wordSize} 2>&1";
            
            // Verifica si los archivos se pueden leer y ejecuta la comparación.
            if (is_readable($fileToProcess_1) && is_readable($fileToProcess_2)) {
                $compileOutput = shell_exec($compile);
                if (strpos($compileOutput, 'error') !== false) {
                    echo "Error during compilation: $compileOutput";
                    exit(1);
                }
                
                $runOutput = shell_exec($run);
                if (strpos($runOutput, 'error') !== false) {
                    echo "Error during run: $runOutput";
                    exit(1);
                }
                
                $resultados = $runOutput;
                
                // Al final del procesamiento, después de la ejecución del programa, medimos el tiempo
                $end_time = microtime(true);
                $execution_time = $end_time - $start_time;
                $formatted_execution_time = number_format($execution_time, 2);
                
                $_REQUEST['resultados-obtenidos'] = $resultados;
                $_REQUEST['time'] = $formatted_execution_time;
                include_once '../view/resultados_word_compar.php';
            } else {
                echo "Error: No se pudo abrir algún archivo de entrada.";
                exit(1);
            }
        } else {
            echo "Error: No se han recibido los datos necesarios.";
            exit(1);
        }
    }

    // Llama a la función principal para procesar los archivos y ejecutar la comparación.
    word_compar_controller();

?>