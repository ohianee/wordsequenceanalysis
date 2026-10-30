<?php
    namespace control;
    
    /**
     * Cierra la sesión actual del usuario.
     *
     * Esta función destruye la sesión del usuario, limpia todas las variables 
     * de sesión y envía una respuesta en formato JSON indicando el éxito de la operación. 
     *
     * @return void Devuelve una respuesta JSON que indica el resultado de la operación.
     */
    function logout() {
        // Iniciar la sesión
        session_start();
        // Limpiar todas las variables de sesión
        session_unset();
        // Destruir la sesión
        session_destroy();
        
        // Establecer la cabecera como JSON
        header('Content-Type: application/json');
        
        // Crear respuesta
        $response = ['success' => true, 'message' => 'Sesión cerrada correctamente'];
        
        // Enviar respuesta en formato JSON
        echo json_encode($response);
        
        // Terminar la ejecución del script
        exit();
    }
    
    // Llamada a la función para cerrar la sesión
    logout();
?>