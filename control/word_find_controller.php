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
     * Procesa la carga de archivos y ejecuta un comando para analizar los archivos descomprimidos.
     */
    function word_find_controller() {
        $start_time = microtime(true);
        if (isset($_POST['wordSize']) && isset($_POST['range'])) {
            $wordSize = $_POST['wordSize'];
            $range = $_POST['range'];
            
            $fileToProcess_1 = null;
            $fileToProcess_2 = null;
            $name1 = null;
            $name2 = null;
            
            // Maneja la carga del primer archivo.
            if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
                $tmp_file = $_FILES['fileToUpload']['tmp_name'];
                $fileToProcess_1 = $tmp_file;
                $name1 = $_FILES['fileToUpload']['name'];
            } else {
                echo "Error: No se ha especificado un archivo local.<br>";
            }
            
            // Maneja la carga del segundo archivo desde la base de datos o un archivo local.
            if (isset($_POST['file']) && !empty($_POST['file']) && isset($_POST['table']) && !empty($_POST['table'])) {
                $table = $_POST['table'];
                $file = $_POST['file'];
                
                $url = acceso_bd::obtenerURLTabla($table);
                $ruta = $url . $table . '/dna/' . $file;
                
                if (@fopen($ruta, 'r')) {
                    $fileToProcess_2 = procesarArchivo($ruta);
                    $name2 = $file;
                } else {
                    echo "Error: No se pudo abrir el archivo de entrada.";
                    exit(1);
                }
            } elseif (isset($_FILES['fileToUpload2']) && $_FILES['fileToUpload2']['error'] == 0) {
                $tmp_file_2 = $_FILES['fileToUpload2']['tmp_name'];
                $fileToProcess_2 = $tmp_file_2;
                $name2 = $_FILES['fileToUpload2']['name'];
            } else {
                echo "Error: No se ha especificado un archivo remoto.<br>";
            }
            
            // Verifica que ambos archivos se han procesado correctamente.
            if ($fileToProcess_1 && $fileToProcess_2 && is_readable($fileToProcess_1) && is_readable($fileToProcess_2)) {
                $compile = "gcc -o word_find word_find.c";
                $run = "word_find {$fileToProcess_1} {$fileToProcess_2} {$wordSize} {$range} {$name1} {$name2} 2>&1";
                
                $compileOutput = shell_exec($compile);
                if ($compileOutput !== null && strpos($compileOutput, 'error') !== false) {
                    echo "Error during compilation: $compileOutput<br>";
                    exit(1);
                }
                
                $runOutput = shell_exec($run);
                if ($runOutput !== null && strpos($runOutput, 'error') !== false) {
                    echo "Error during run: $runOutput<br>";
                    exit(1);
                }
                
                $resultados = $runOutput;
                
                // Al final del procesamiento, después de la ejecución del programa, medimos el tiempo
                $end_time = microtime(true);
                $execution_time = $end_time - $start_time;
                $formatted_execution_time = number_format($execution_time, 2);
                
                $_REQUEST['resultados-obtenidos'] = $resultados;
                $_REQUEST['time'] = $formatted_execution_time;
                include_once '../view/resultados_word_find.php';
            } else {
                echo "Error: No se pudo abrir el archivo de entrada.<br>";
            }
        } else {
            echo "Error: No se han recibido los datos necesarios.<br>";
        }
    }
    
    // Llama a la función principal.
    word_find_controller();
?>