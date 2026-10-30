<?php
    namespace control;
    use model\acceso_bd;
    
    require_once('../model/acceso_bd.php');
    
    header('Content-Type: application/json');
    
    /**
     * Función que elimina un genoma de la base de datos basada en el nombre del genoma proporcionado.
     *
     * Esta función recibe el nombre de un genoma a través de una petición POST, verifica que el nombre del genoma
     * solo contenga caracteres válidos (letras minúsculas, números y guiones bajos), y luego intenta eliminar dicho
     * genoma usando el método eliminarTabla() de la clase acceso_bd.
     *
     * @return void Devuelve una respuesta JSON que indica el resultado de la operación.
     */
    function delete_genome()
    {
        // Inicializamos un arreglo vacío para la respuesta
        $response = [];
        
        // Verificamos si se ha recibido el nombre de la tabla en la petición POST
        if (isset($_POST['tableName'])) {
            $tableName = $_POST['tableName'];
            
            // Validamos que el nombre de la tabla solo contenga caracteres válidos
            if (preg_match('/^[a-z0-9_]+$/', $tableName) === 0) {
                // Si no pasa la validación, devolvemos un mensaje de error
                $response = ['success' => false, 'message' => 'Error: El nombre del genoma contiene caracteres inválidos'];
                echo json_encode($response);
                exit();
            }
            
            // Intentamos eliminar la tabla utilizando el método eliminarTabla de la clase acceso_bd
            if (acceso_bd::eliminarTabla($tableName)) {
                $response = ['success' => true, 'message' => "Genoma '$tableName' eliminado exitosamente"];
            } else {
                $response = ['success' => false, 'message' => 'Error al eliminar el genoma'];
            }
        } else {
            // Si no se recibe el nombre de la tabla en la petición, devolvemos un error
            $response = ['success' => false, 'message' => 'Error: No se ha recibido el nombre del genoma'];
        }
        
        // Devolvemos la respuesta en formato JSON
        echo json_encode($response);
        exit();
    }
    
    // Llamamos a la función eliminarGenoma para ejecutar el proceso
    delete_genome();

?>