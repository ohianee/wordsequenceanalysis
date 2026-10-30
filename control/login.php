<?php
    namespace control;

    /**
     * Función para manejar el inicio de sesión de un usuario.
     * Verifica las credenciales proporcionadas y devuelve una respuesta en formato JSON.
     *
     * @return void Devuelve una respuesta JSON que indica el resultado de la operación.
     */
    function login() {
        // Iniciar la sesión
        session_start();
        
        // Definir el encabezado de la respuesta como JSON
        header('Content-Type: application/json');
        
        // Variable para almacenar la respuesta
        $response = [];
        
        // Verificar si se han enviado las credenciales de usuario y contraseña a través de POST
        if (isset($_POST['username']) && isset($_POST['password'])) {
            // Obtener los valores de las credenciales desde el formulario POST
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Comparar las credenciales proporcionadas con las esperadas
            if ($username !== 'usuario' || $password !== '1029') {
                // Credenciales incorrectas
                $response = ['success' => false, 'message' => 'Error: Usuario o contraseña incorrectos'];
            } else {
                // Credenciales correctas, iniciar sesión
                $_SESSION['loggedin'] = true;
                $response = ['success' => true, 'message' => 'Inicio de sesión exitoso'];
            }
        } else {
            // Si no se han recibido las credenciales
            $response = ['success' => false, 'message' => 'Error: No se han recibido las credenciales'];
        }
        
        // Devolver la respuesta en formato JSON
        echo json_encode($response);
        exit();
    }
    
    // Llamada a la función
    login();
?>