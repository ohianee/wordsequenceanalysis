<?php
    namespace model;
    require_once('acceso_bd.php');
?>
<html lang="es">
<head>
    <style>
        .ok {
            color: green;
        }
        
        .error {
            color: red;
        }
    </style>
</head>
<body>
<h1>Tests unitarios</h1>
<ul>
    <li>
        <h2>Test obtenerListadoTablas</h2>
        <?php testObtenerListadoTablas(); ?>
    </li>
    
    <li>
        <h2>Test obtenerListadoNombres</h2>
        <?php testObtenerListadoNombres(); ?>
    </li>
    
    <li>
        <h2>Test actualizarBaseDeDatos</h2>
        <?php testActualizarBaseDeDatos(); ?>
    </li>
    
    <li>
        <h2>Test hacerCopiaDeSeguridad</h2>
        <?php testHacerCopiaDeSeguridad(); ?>
    </li>
    
    <li>
        <h2>Test revertirDesdeCopiaDeSeguridad</h2>
        <?php testRevertirDesdeCopiaDeSeguridad(); ?>
    </li>
    
    <li>
        <h2>Test crearNuevaTabla</h2>
        <?php testCrearNuevaTabla(); ?>
    </li>
    
    <li>
        <h2>Test eliminarTabla</h2>
        <?php testEliminarTabla(); ?>
    </li>
</ul>

<?php
    /**
     * @brief Test para obtener el listado de tablas.
     * Esta prueba invoca la función `obtenerListadoTablas` de la clase `acceso_bd`.
     * Verificamos si el número de tablas es mayor que cero.
     */
    function testObtenerListadoTablas() {
        $tablas = acceso_bd::obtenerListadoTablas();
        if (count($tablas) > 0) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
    
    /**
     * @brief Test para obtener el listado de nombres.
     * Esta prueba invoca la función `obtenerListadoNombres` con el parámetro 'mus_musculus'.
     * Se espera que retorne un arreglo con 25 elementos.
     */
    function testObtenerListadoNombres() {
        $nombres = acceso_bd::obtenerListadoNombres('mus_musculus');
        if (count($nombres) == 25) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
    
    /**
     * @brief Test para actualizar la base de datos.
     * Esta prueba invoca la función `actualizarTodasLasTablasDesdeSitioWeb`.
     * Se espera que la función retorne verdadero si la actualización fue exitosa.
     *
     * @return bool Indica si la actualización fue exitosa.
     */
    function testActualizarBaseDeDatos() {
        $resultado = acceso_bd::actualizarTodasLasTablasDesdeSitioWeb();
        if ($resultado) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
    
    /**
     * @brief Test para realizar una copia de seguridad.
     * Esta prueba invoca la función `hacerCopiaDeSeguridad` pasando como parámetro el directorio de backup.
     *
     * @return bool Indica si la copia de seguridad fue exitosa.
     */
    function testHacerCopiaDeSeguridad() {
        $resultado = acceso_bd::hacerCopiaDeSeguridad("../backup");
        if ($resultado) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
    
    /**
     * @brief Test para revertir desde una copia de seguridad.
     * Esta prueba invoca la función `revertirDesdeCopiaDeSeguridad` pasando como parámetro el directorio de backup.
     * Se espera que la función retorne verdadero si la operación fue exitosa.
     *
     * @return bool Indica si la operación fue exitosa.
     */
    function testRevertirDesdeCopiaDeSeguridad() {
        $resultado = acceso_bd::revertirDesdeCopiaDeSeguridad("../backup");
        if ($resultado) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
    
    /**
     * @brief Test para crear una nueva tabla.
     * Esta prueba invoca la función `crearNuevaTabla` con los parámetros 'ejemplo_tabla' y 'http://ejemplo'.
     *
     * @return bool Indica si la creación de la tabla fue exitosa.
     */
    function testCrearNuevaTabla() {
        $resultado = acceso_bd::crearNuevaTabla('ejemplo_tabla', 'http://ejemplo');
        if ($resultado) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
    
    /**
     * @brief Test para eliminar una tabla.
     * Esta prueba invoca la función `eliminarTabla` con el parámetro 'ejemplo_tabla'.
     *
     * @return bool Indica si la eliminación de la tabla fue exitosa.
     */
    function testEliminarTabla() {
        $resultado = acceso_bd::eliminarTabla("ejemplo_tabla");
        if ($resultado) {
            echo "<span class='ok'>OK</span>";
        } else {
            echo "<span class='error'>ERROR</span>";
        }
    }
?>
</body>
</html>