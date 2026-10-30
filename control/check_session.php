<?php
    namespace control;
    
    // Iniciar la sesión
    session_start();
    
    /**
     * Controlador que verifica si el usuario está logueado
     *
     * Esta función verifica si existe una sesión iniciada con la variable `$_SESSION['loggedin']`
     * y devuelve una respuesta en formato JSON indicando si el usuario está logueado o no.
     *
     * @return void Esta función no retorna ningún valor, pero envía una respuesta JSON.
     */
    function check_session() {
        // Establece el tipo de contenido de la respuesta a JSON
        header('Content-Type: application/json');
        
        // Verifica si la sesión está iniciada y si la variable 'loggedin' está configurada como verdadera
        $response = ['loggedin' => isset($_SESSION['loggedin']) && $_SESSION['loggedin']];
        
        // Envía la respuesta en formato JSON
        echo json_encode($response);
        
        // Finaliza la ejecución del script
        exit();
    }
    
    // Llamamos a la función para ejecutar el proceso
    check_session();
?>