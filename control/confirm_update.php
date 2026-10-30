<?php
    namespace control;
    use model\acceso_bd;
    
    require_once('../model/acceso_bd.php');
    
    /**
     * Gestiona el proceso de confirmación de actualización o reversión de la base de datos desde una copia de seguridad.
     *
     * @return void Devuelve una respuesta JSON que indica el resultado de la operación.
     */
    function confirm_update() {
        header('Content-Type: application/json');
        
        // Inicializa la variable de respuesta como un arreglo vacío
        $response = [];
        
        // Verifica si el formulario POST contiene la opción 'confirm-option'
        if (isset($_POST['confirm-option'])) {
            $opcion = $_POST['confirm-option'];  // Almacena el valor de la opción seleccionada por el usuario
            $rutaArchivo = "../backup";  // Ruta donde se almacenan las copias de seguridad
            
            // Si el usuario confirma con 'yes', se procede a eliminar todos los archivos excepto el más reciente
            if ($opcion === 'yes') {
                // Obtiene todos los archivos en el directorio de backup
                $archivos = glob($rutaArchivo . '/*');
                
                // Ordena los archivos por fecha de modificación de más reciente a más antiguo
                usort($archivos, function($a, $b) {
                    return filemtime($b) - filemtime($a);
                });
                    
                    // Recorre los archivos y elimina todos excepto el más reciente
                    for ($i = 1; $i < count($archivos); $i++) {
                        if (is_file($archivos[$i])) {
                            unlink($archivos[$i]);  // Elimina el archivo
                        }
                    }
                    
                    // Respuesta exitosa para la opción de confirmar actualización
                    $response = ['success' => true, 'message' => 'Actualización confirmada.'];
            }
            // Si el usuario selecciona 'no', se intenta revertir la base de datos desde la copia de seguridad
            elseif ($opcion === 'no') {
                // Llama a la función para revertir la base de datos usando el método 'revertirDesdeCopiaDeSeguridad'
                $reversionExitosa = acceso_bd::revertirDesdeCopiaDeSeguridad($rutaArchivo);
                
                // Verifica si la reversión fue exitosa
                if ($reversionExitosa) {
                    $response = ['success' => true, 'message' => 'La base de datos ha sido revertida a la copia de seguridad.'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al revertir la base de datos'];
                }
            }
            // Opción seleccionada no válida
            else {
                $response = ['success' => false, 'message' => 'Opción no válida seleccionada.'];
            }
        }
        // Si no se seleccionó ninguna opción
        else {
            $response = ['success' => false, 'message' => 'No se ha seleccionado ninguna opción.'];
        }
        
        // Devuelve la respuesta en formato JSON
        echo json_encode($response);
        exit();
    }
    
    // Llama a la función para gestionar el proceso
    confirm_update();
?>