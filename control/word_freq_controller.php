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
     * Procesa la carga de un archivo, ya sea desde una URL o una subida.
     */
    function word_freq_controller() {
        $start_time = microtime(true);
        $fileToProcess = null;
        
        // Verifica si se han recibido datos de un formulario.
        if (isset($_POST['wordSize'], $_POST['table'], $_POST['file']) && !empty($_POST['wordSize']) && !empty($_POST['table']) && !empty($_POST['file'])) {
            $wordSize = $_POST['wordSize'];
            $table = $_POST['table'];
            $file = $_POST['file'];
            
            $url = acceso_bd::obtenerURLTabla($table);
            $ruta = $url . $table . '/dna/' . $file;
            
            if (@fopen($ruta, 'r')) {
                $fileToProcess = $ruta;
            } else {
                echo "Error: No se pudo abrir el archivo de entrada.";
                exit(1);
            }
        } elseif (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $tmp_file = $_FILES['fileToUpload']['tmp_name'];
            $wordSize = isset($_POST['wordSize']) ? $_POST['wordSize'] : 3;
            
            $fileToProcess = $tmp_file;
        } else {
            echo "Error: No se han recibido los datos necesarios.";
            exit(1);
        }
        
        if (is_readable($fileToProcess)) {
            $compile = "gcc -o word_freq word_freq.c";
            $run = "word_freq {$fileToProcess} {$wordSize} 2>&1";
            
            $compileOutput = shell_exec($compile);
            if (strpos($compileOutput, 'error') !== false) {
                echo "Error durante la compilación: $compileOutput";
                exit(1);
            }
            
            $runOutput = shell_exec($run);
            if (strpos($runOutput, 'error') !== false) {
                echo "Error durante la ejecución: $runOutput";
                exit(1);
            }
            
            // Procesa la salida
            $outputLines = explode("\n", trim($runOutput));
            if (count($outputLines) < 2) {
                echo "Error: La salida de word_freq.c no es la esperada.";
                exit(1);
            }
            
            // Almacena el nombre del archivo y el total de secuencias procesadas
            $outputFileName = $outputLines[0];
            $totalSequencesProcessed = $outputLines[1];
            
            if (!is_readable($outputFileName)) {
                echo "Error: El archivo de salida de word_freq no se encontró o no es legible.";
                exit(1);
            }
            
            $resultados = file_get_contents($outputFileName);
            
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            $formatted_execution_time = number_format($execution_time, 2);
            
            $_REQUEST['resultados-obtenidos'] = $wordSize > 10 ? '0' : $resultados;
            $_REQUEST['output-file'] = $outputFileName;
            $_REQUEST['time'] = $formatted_execution_time;
            $_REQUEST['total-sequences'] = $totalSequencesProcessed;
            
            include_once '../view/resultados_word_freq.php';
        } else {
            echo "Error: No se pudo abrir el archivo de entrada.";
            exit(1);
        }
    }
    
    // Llama a la función principal para procesar la carga del archivo.
    word_freq_controller();
?>