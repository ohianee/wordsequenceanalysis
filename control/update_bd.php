<?php
    namespace control;
    use model\acceso_bd;
    
    require_once('../model/acceso_bd.php');
    
    header('Content-Type: application/json');
    
    /**
     * Realiza el proceso de actualización de la base de datos si la contraseña es correcta.
     *
     * Esta función verifica una contraseña proporcionada, y si es correcta, realiza una copia de seguridad
     * y luego intenta actualizar la base de datos desde un sitio web.
     * 
     * @return void Devuelve una respuesta JSON que indica el resultado de la operación.
     */
    function update_bd() {
        $response = [];
        
        // Verificar si se ha recibido la contraseña mediante POST
        if (isset($_POST['password'])) {
            $password = $_POST['password'] ?? '';
            
            // Verificar si la contraseña coincide con la esperada
            if ($password !== '1029') {
                $response = ['success' => false, 'message' => 'Error: Contraseña incorrecta'];
            } else {
                // Intentar crear una copia de seguridad
                $backupFile = acceso_bd::hacerCopiaDeSeguridad("../backup");
                
                if ($backupFile === false) {
                    $response = ['success' => false, 'message' => 'Error al crear la copia de seguridad'];
                } else {
                    // Intentar actualizar las tablas desde el sitio web
                    $actualizacionExitosa = acceso_bd::actualizarTodasLasTablasDesdeSitioWeb();
                    
                    if ($actualizacionExitosa) {
                        $response = ['success' => true, 'message' => 'La base de datos ha sido actualizada.'];
                    } else {
                        $response = ['success' => false, 'message' => 'Error al actualizar la base de datos'];
                    }
                }
            }
        } else {
            $response = ['success' => false, 'message' => 'Error: No se ha recibido la contraseña'];
        }
        
        echo json_encode($response);
        exit();
    }
    
    // Ejecutar la función
    update_bd();
?>