<?php
    namespace control;
    
    /**
     * Procesa la carga de dos archivos, compila y ejecuta un análisis FASTQ.
     *
     * Esta función gestiona la carga de archivos, la compilación de un programa
     * en C y la ejecución del mismo con los archivos y parámetros proporcionados.
     *
     * @return void
     */
    function fastq_analysis_controller() {
        $start_time = microtime(true);
        $fileToProcess_1 = $fileToProcess_2 = null;
        
        // Verificar que se hayan recibido los parámetros necesarios
        if (isset($_POST['wordSize']) && isset($_POST['umbral']) && isset($_POST['comparacion'])) {
            $wordSize = $_POST['wordSize'];
            $umbral = $_POST['umbral'];
            $comparacion = $_POST['comparacion'];
            
            // Comprobar que ambos archivos han sido subidos
            if (!empty($_FILES['fileToUpload1']['tmp_name']) && !empty($_FILES['fileToUpload2']['tmp_name'])) {
                $tmp_file_1 = $_FILES['fileToUpload1']['tmp_name'];
                $tmp_file_2 = $_FILES['fileToUpload2']['tmp_name'];
                
                $fileToProcess_1 = $tmp_file_1;
                $fileToProcess_2 = $tmp_file_2;
                
                // Obtener los nombres originales de los archivos
                $originalName1 = pathinfo($_FILES['fileToUpload1']['name'], PATHINFO_FILENAME);
                $originalName2 = pathinfo($_FILES['fileToUpload2']['name'], PATHINFO_FILENAME);
            } else {
                echo "Error: No se han recibido los datos necesarios.";
                exit(1);
            }
            
            // Comando para compilar el programa en C
            $compile = "gcc -o fastq_analysis fastq_analysis.c";
            // Comando para ejecutar el programa compilado
            $run = "fastq_analysis {$fileToProcess_1} {$fileToProcess_2} {$wordSize} {$originalName1} {$originalName2} {$umbral} {$comparacion} 2>&1";
            
            // Verificar que los archivos son legibles antes de proceder
            if (is_readable($fileToProcess_1) && is_readable($fileToProcess_2)) {
                // Compilar el programa
                $compileOutput = shell_exec($compile);
                if (strpos($compileOutput, 'error') !== false) {
                    echo "Error during compilation: $compileOutput";
                    exit(1);
                }
                
                // Ejecutar el programa
                $runOutput = shell_exec($run);
                if (strpos($runOutput, 'error') !== false) {
                    echo "Error during run: $runOutput";
                    exit(1);
                }
                
                // Almacenar los resultados obtenidos
                $resultados = $runOutput;
                
                // Al final del procesamiento, después de la ejecución del programa, medimos el tiempo
                $end_time = microtime(true);
                $execution_time = $end_time - $start_time;
                $formatted_execution_time = number_format($execution_time, 2);
                
                // Pasar los resultados a la vista
                $_REQUEST['resultados-obtenidos'] = $resultados;
                $_REQUEST['time'] = $formatted_execution_time;
                include_once '../view/resultados_fastq_analysis.php';
            } else {
                echo "Error: No se pudo abrir algún archivo de entrada.";
                exit(1);
            }
        } else {
            echo "Error: No se han recibido los datos necesarios.";
        }
    }
    
    // Llamar a la función para procesar el análisis FASTQ
    fastq_analysis_controller();
?>