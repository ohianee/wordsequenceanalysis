<?php
    namespace control;    
    use model\acceso_bd;
    
    require_once('../model/acceso_bd.php');
    
    /**
     * Agrega un nuevo genoma a la base de datos.
     *
     * Este script verifica que el nombre de la tabla y la URL proporcionados son válidos.
     * Si la URL es accesible y el nombre es correcto, se intenta crear una nueva tabla
     * en la base de datos. El resultado de la operación se devuelve como un JSON.
     *
     * @return void Devuelve una respuesta JSON que indica el resultado de la operación.
     */
    function add_genome() {
        header('Content-Type: application/json');
        
        $response = [];
        
        // Verificar que se han recibido los parámetros necesarios
        if (isset($_POST['tableName']) && isset($_POST['tableUrl'])) {
            $tableName = $_POST['tableName'];
            $tableUrl = $_POST['tableUrl'];
            
            // Validar que el nombre de la tabla solo contenga caracteres válidos
            if (preg_match('/^[a-z0-9_]+$/', $tableName) === 0) {
                $response = [
                    'success' => false,
                    'message' => 'Error: El nombre del genoma contiene caracteres inválidos'
                ];
                echo json_encode($response);
                exit();
            }
            
            // Construir la URL de prueba
            $testUrl = $tableUrl . $tableName . '/';
            $headers = @get_headers($testUrl);
            
            // Verificar si la URL es accesible
            if ($headers && strpos($headers[0], '200')) {
                // Intentar crear la nueva tabla en la base de datos
                if (acceso_bd::crearNuevaTabla($tableName, $tableUrl)) {
                    $response = [
                        'success' => true,
                        'message' => 'Genoma añadido exitosamente'
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Error al añadir el genoma'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error: La URL proporcionada no existe'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Error: No se ha recibido el nombre o URL del genoma'
            ];
        }
        
        // Devolver la respuesta como JSON
        echo json_encode($response);
        exit();
    }
    
    // Llamar a la función para ejecutar el script
    add_genome();

?>