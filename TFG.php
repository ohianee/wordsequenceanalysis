<?php

/**
 * Clase TFG
 * 
 * Esta clase proporciona funciones útiles para el desarrollo de la aplicación,
 * como la obtención de la URL base de la aplicación.
 */
class TFG
{
    /**
     * Obtiene y devuelve la URL base de la aplicación a partir de la solicitud actual.
     * 
     * La función analiza la URL solicitada y extrae la ruta base del directorio.
     *
     * @return string URL base de la aplicación
     */
    public static function app_dir()
    {
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url)['path'];
        $datos = explode("/", $path);
        echo "/".$datos[1];
    }
};
    
?>