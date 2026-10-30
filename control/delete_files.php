<?php
    namespace control;
    
    /**
     * Elimina todos los archivos en un directorio dado y archivos de extensiones específicas en otro directorio.
     */
    function delete_files() {
        // Obtener todos los archivos del primer directorio
        $files = glob('../files' . '/*');
        
        // Recorrer cada archivo y eliminar si es un archivo válido
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Elimina el archivo
            }
        }
        
        $extensions = ['log', 'txt', 'gp', 'png'];
        
        // Recorrer las extensiones especificadas para eliminar los archivos correspondientes en el segundo directorio
        foreach ($extensions as $extension) {
            // Obtener archivos con la extensión actual
            $files = glob('../control' . '/*.' . $extension);
            
            // Recorrer cada archivo y eliminar si es un archivo válido
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Elimina el archivo
                }
            }
        }
    }
    
    // Llama a la función para gestionar el proceso
    delete_files();

?>
