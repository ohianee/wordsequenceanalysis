<?php
    namespace model;
    use mysqli;
    
    /**
     * Clase para el acceso a la base de datos.
     */
    class acceso_bd
    {
        /**
         * Establece una conexión con la base de datos.
         *
         * @return mysqli Devuelve la conexión a la base de datos.
         */
        private static function conectar()
        {
            $bbdd = mysqli_connect("localhost", "root", "", "sequences");
            if (mysqli_connect_error()) {
                printf("Error conectando a la base de datos: %s\n", mysqli_connect_error());
                exit();
            }
            return $bbdd;
        }
        
        /**
         * Cierra la conexión a la base de datos.
         *
         * @param mysqli $bbdd La conexión a la base de datos que se debe cerrar.
         */
        private static function desconectar($bbdd)
        {
            mysqli_close($bbdd);
        }
        
        /**
         * Obtiene un listado de las tablas de la base de datos, excluyendo 'tabla_url'.
         *
         * @return array Un array con los nombres de las tablas.
         */
        public static function obtenerListadoTablas()
        {
            $bbdd = acceso_bd::conectar();
            $listado = [];
            
            if ($resultado = mysqli_query($bbdd, "SHOW TABLES")) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $nombreTabla = $fila[0];
                    if ($nombreTabla != 'tabla_url') {
                        array_push($listado, $nombreTabla);
                    }
                }
                mysqli_free_result($resultado);
            }
            
            acceso_bd::desconectar($bbdd);
            
            return $listado;
        }
        
        /**
         * Obtiene un listado de nombres de una tabla específica.
         *
         * @param string $tabla El nombre de la tabla.
         * @return array Un array con los nombres de la tabla.
         */
        public static function obtenerListadoNombres($tabla)
        {
            $bbdd = acceso_bd::conectar();
            
            $listado = [];
            
            if ($tabla !== 'tabla_url' && $resultado = mysqli_query($bbdd, "SELECT nombre FROM {$tabla}")) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    array_push($listado, $fila['nombre']);
                }
            }
            
            acceso_bd::desconectar($bbdd);
            
            return $listado;
        }
        
        /**
         * Obtiene la URL asociada a una tabla específica.
         *
         * @param string $tabla El nombre de la tabla.
         * @return string|null La URL de la tabla o null si no se encuentra.
         */
        public static function obtenerURLTabla($tabla)
        {
            $bbdd = acceso_bd::conectar();
            
            $url = null;
            
            if ($resultado = mysqli_query($bbdd, "SELECT url FROM tabla_url WHERE tabla = '{$tabla}'")) {
                if (mysqli_num_rows($resultado) > 0) {
                    $fila = mysqli_fetch_assoc($resultado);
                    $url = $fila['url'];
                }
                mysqli_free_result($resultado);
            }
            
            acceso_bd::desconectar($bbdd);
            
            return $url;
        }
        
        /**
         * Obtiene un listado de tablas y sus respectivas URLs.
         *
         * @return array Un array asociativo con los nombres de las tablas como claves y sus URLs como valores.
         */
        public static function obtenerTablasyURLs()
        {
            $bbdd = acceso_bd::conectar();
            
            $listado = [];
            
            if ($resultado = mysqli_query($bbdd, "SELECT tabla, url FROM tabla_url")) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $listado[$fila['tabla']] = $fila['url'];
                }
                
                mysqli_free_result($resultado);
            } else {
                echo "Error en la consulta: " . mysqli_error($bbdd);
            }
            
            acceso_bd::desconectar($bbdd);
            
            return $listado;
        }
        
        /**
         * Actualiza los nombres en una tabla específica.
         *
         * @param string $tabla El nombre de la tabla.
         * @param array $nuevosNombres Un array de nuevos nombres a insertar o actualizar.
         * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
         */
        public static function actualizarNombres($tabla, $nuevosNombres)
        {
            $bbdd = acceso_bd::conectar();
            
            $ok = true;
            
            $nombresActuales = acceso_bd::obtenerListadoNombres($tabla);
            
            foreach ($nuevosNombres as $id => $nuevoNombre) {
                $nuevoNombre = mysqli_real_escape_string($bbdd, $nuevoNombre);
                
                if (array_key_exists($id, $nombresActuales)) {
                    $query = "UPDATE {$tabla} SET nombre = '{$nuevoNombre}' WHERE id = " . ($id + 1);
                } else {
                    $query = "INSERT INTO {$tabla} (nombre) VALUES ('{$nuevoNombre}')";
                }
                
                if (!mysqli_query($bbdd, $query)) {
                    $ok = false;
                    break;
                }
            }
            
            acceso_bd::desconectar($bbdd);
            
            return $ok;
        }
        
        /**
         * Actualiza todas las tablas desde el sitio web.
         *
         * @param string|null $tabla El nombre de la tabla (opcional). Si es null, actualiza todas las tablas.
         * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
         */
        public static function actualizarTodasLasTablasDesdeSitioWeb($tabla = null)
        {
            $bbdd = acceso_bd::conectar();
            
            $ok = true;
            
            if ($tabla == null) {
                $tablas_y_urls = acceso_bd::obtenerTablasyURLs();
                
                foreach ($tablas_y_urls as $tabla => $url) {
                    $contenido = file_get_contents($url . $tabla . '/dna/');
                    $matches = [];
                    $match = [];
                    preg_match_all('/href=\"(.*?)\"/', $contenido, $matches);
                    
                    $nuevosNombres = [];
                    $nombresToplevel = [];
                    $nombresOtros = [];
                    $nombretabla = ucfirst($tabla);
                    
                    foreach ($matches[1] as $nombre) {
                        if (preg_match('/' . preg_quote($nombretabla) . '\.(.*?)\.dna\.(.*?)(\.fa\.gz)$/', $nombre, $match)) {
                            $nuevoNombre = $match[0];
                            if ($match[2] === 'toplevel') {
                                $nombresToplevel[] = $nuevoNombre;
                            } else {
                                $nombresOtros[] = $nuevoNombre;
                            }
                        }
                    }
                    
                    $nuevosNombres = array_merge($nombresOtros, $nombresToplevel);
                    $ok = acceso_bd::actualizarNombres($tabla, $nuevosNombres);
                    
                    if ($ok === false) {
                        break;
                    }
                }
            } else {
                $url = acceso_bd::obtenerURLTabla($tabla);
                $contenido = file_get_contents($url . $tabla . '/dna/');
                $matches = [];
                $match = [];
                preg_match_all('/href=\"(.*?)\"/', $contenido, $matches);
                
                $nuevosNombres = [];
                $nombresToplevel = [];
                $nombresOtros = [];
                $nombretabla = ucfirst($tabla);
                
                foreach ($matches[1] as $nombre) {
                    if (preg_match('/' . preg_quote($nombretabla) . '\.(.*?)\.dna\.(.*?)(\.fa\.gz)$/', $nombre, $match)) {
                        $nuevoNombre = $match[0];
                        if ($match[2] === 'toplevel') {
                            $nombresToplevel[] = $nuevoNombre;
                        } else {
                            $nombresOtros[] = $nuevoNombre;
                        }
                    }
                }
                
                $nuevosNombres = array_merge($nombresOtros, $nombresToplevel);
                $ok = acceso_bd::actualizarNombres($tabla, $nuevosNombres);
                
                if ($ok === false) {
                    return false;
                }
            }
            
            acceso_bd::desconectar($bbdd);
            
            return $ok;
        }
        
        /**
         * Realiza una copia de seguridad de la base de datos.
         *
         * @param string $rutaArchivo La ruta donde se guardará la copia de seguridad.
         * @return string|bool La ruta del archivo de copia de seguridad o false en caso de error.
         */
        public static function hacerCopiaDeSeguridad($rutaArchivo)
        {
            $host = "localhost";
            $usuario = "root";
            $contrasena = "";
            $baseDeDatos = "sequences";
            
            $returnValue = null;
            $output = [];
            
            $mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe";
            
            $backupFilename = realpath($rutaArchivo) . '\\backup_' . date('Ymd_His') . '.sql';
            
            $command = "\"{$mysqldumpPath}\" --user={$usuario} --password={$contrasena} --host={$host} {$baseDeDatos} --result-file=\"{$backupFilename}\" --complete-insert --extended-insert";
            
            exec($command . ' 2>&1', $output, $returnValue);
            
            if ($returnValue !== 0) {
                echo "Error al crear la copia de seguridad. C&oacute;digo de error: " . $returnValue . "\n";
                echo "Salida del comando: " . implode("\n", $output) . "\n";
                return false;
            }
            
            return $backupFilename;
        }
        
        /**
         * Restaura la base de datos desde una copia de seguridad.
         *
         * @param string $rutaArchivo La ruta donde se encuentra la copia de seguridad.
         * @return bool Retorna true si la restauración fue exitosa, false en caso contrario.
         */
        public static function revertirDesdeCopiaDeSeguridad($rutaArchivo)
        {
            $host = "localhost";
            $usuario = "root";
            $contrasena = "";
            $baseDeDatos = "sequences";
            
            $returnValue = null;
            $output = [];
            
            $backupFiles = glob(realpath($rutaArchivo) . '\\backup_*.sql');
            if (empty($backupFiles)) {
                echo "No se encontraron archivos de copia de seguridad.";
                return false;
            }
            
            usort($backupFiles, function($a, $b) {
                return filemtime($b) - filemtime($a);
            });
                
                $backupFilename = $backupFiles[0];
                
                $mysqlPath = "C:\\xampp\\mysql\\bin\\mysql.exe";
                
                $command = "\"{$mysqlPath}\" --user={$usuario} --password={$contrasena} --host={$host} {$baseDeDatos} < \"{$backupFilename}\"";
                
                exec($command . ' 2>&1', $output, $returnValue);
                
                if ($returnValue !== 0) {
                    echo "Error al restaurar la base de datos. C&oacute;digo de error: " . $returnValue . "\n";
                    echo "Salida del comando: " . implode("\n", $output) . "\n";
                    return false;
                }
                
                return true;
        }
        
        /**
         * Inserta una fila en la tabla 'tabla_url'.
         *
         * @param string $nombreTabla El nombre de la tabla.
         * @param string $url La URL asociada a la tabla.
         * @return bool Retorna true si la inserción fue exitosa, false en caso contrario.
         */
        public static function insertarFilaEnTablaURL($nombreTabla, $url)
        {
            $bbdd = acceso_bd::conectar();
            
            if (mysqli_query($bbdd, "INSERT INTO tabla_url (tabla, url) VALUES ('{$nombreTabla}', '{$url}')")) {
                return true;
            } else {
                return false;
            }
            
            acceso_bd::desconectar($bbdd);
        }
        
        /**
         * Elimina una fila en la tabla 'tabla_url'.
         *
         * @param string $nombreTabla El nombre de la tabla.
         * @return bool Retorna true si la eliminación fue exitosa, false en caso contrario.
         */
        public static function eliminarFilaEnTablaURL($nombreTabla)
        {
            $bbdd = acceso_bd::conectar();
            
            $nombreTabla = mysqli_real_escape_string($bbdd, $nombreTabla);
            
            if (mysqli_query($bbdd, "DELETE FROM tabla_url WHERE tabla = '{$nombreTabla}'")) {
                return true;
            } else {
                return false;
            }
            
            acceso_bd::desconectar($bbdd);
        }
        
        /**
         * Crea una nueva tabla y añade su URL.
         *
         * @param string $nombreTabla El nombre de la nueva tabla.
         * @param string $url La URL asociada a la tabla.
         * @return bool Retorna true si la tabla fue creada con éxito, false en caso contrario.
         */
        public static function crearNuevaTabla($nombreTabla, $url)
        {
            $bbdd = acceso_bd::conectar();
            
            $query = "CREATE TABLE {$nombreTabla} (id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(255) NOT NULL)";
            
            if (mysqli_query($bbdd, $query)) {
                if (acceso_bd::insertarFilaEnTablaURL($nombreTabla, $url)) {
                    if (acceso_bd::actualizarTodasLasTablasDesdeSitioWeb($nombreTabla)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
            
            acceso_bd::desconectar($bbdd);
        }
        
        /**
         * Elimina una tabla específica y su fila asociada en 'tabla_url'.
         *
         * @param string $nombreTabla El nombre de la tabla a eliminar.
         * @return bool Retorna true si la eliminación fue exitosa, false en caso contrario.
         */
        public static function eliminarTabla($nombreTabla)
        {
            $bbdd = acceso_bd::conectar();
            
            $checkTableQuery = "SHOW TABLES LIKE '{$nombreTabla}'";
            $result = mysqli_query($bbdd, $checkTableQuery);
            
            if (mysqli_num_rows($result) > 0) {
                $dropQuery = "DROP TABLE {$nombreTabla}";
                
                if (mysqli_query($bbdd, $dropQuery)) {
                    if (acceso_bd::eliminarFilaEnTablaURL($nombreTabla)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
            
            acceso_bd::desconectar($bbdd);
        }
    }
?>