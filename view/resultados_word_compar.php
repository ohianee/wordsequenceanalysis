<?php
    namespace view;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Resultados WordCompar</title>
    <meta charset="utf-8">
</head>
<body>
    <div class="cuerpo">
        <div class="section">
          <h4>Resultados</h4>
          <div class="content">
            <pre>
                <?php
                    /**
                     * @brief Muestra los resultados obtenidos de la solicitud.
                     *
                     * Verifica si existen resultados en la variable global $_REQUEST
                     * bajo el índice 'resultados-obtenidos'. Si es así, los muestra de
                     * manera segura con htmlspecialchars para evitar inyecciones de código.
                     * Si no se encuentra el valor, se muestra un mensaje predeterminado.
                     */
                    function mostrarResultadosWordCompar() {
                        // Si se encuentra el parámetro 'resultados-obtenidos', se muestran los resultados
                        if (isset($_REQUEST['resultados-obtenidos'])) {
                            // htmlspecialchars se utiliza para prevenir inyección de código en la salida
                            echo htmlspecialchars($_REQUEST['resultados-obtenidos']);
                            if (isset($_REQUEST['time'])){
                                // Mostrar el tiempo de procesamiento del servidor
                                echo 'Tiempo de procesamiento del servidor: ' . $_REQUEST['time'] . ' seg';
                            }
                        } else {
                            // Si no hay resultados, se muestra un mensaje de "No se encontraron resultados"
                            echo "No se encontraron resultados.";
                        }
                    }

                    // Llamamos a la función para mostrar los resultados
                    mostrarResultadosWordCompar();
                ?>
            </pre>
          </div>
        </div>
    </div>
</body>
</html>