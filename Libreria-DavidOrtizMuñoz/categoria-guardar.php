<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

// Se recogen los datos del formulario de la request.
$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) {
    // Quieren CREAR una nueva entrada, así que es un INSERT.
    $sql = "INSERT INTO categoria (nombre) VALUES (?)";
    $parametros = [$nombre];
} else {
    // Quieren MODIFICAR una categoría existente y es un UPDATE.
    $sql = "UPDATE categoria SET nombre=? WHERE id=?";
    $parametros = [$nombre, $id];
}

$sentencia = $conexion->prepare($sql);
//Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
$sqlConExito = $sentencia->execute($parametros); // Se añaden los parámetros a la consulta preparada.

//Se consulta la cantidad de filas afectadas por la ultima sentencia sql.
$unaFilaAfectada = ($sentencia->rowCount() == 1);
$ningunaFilaAfectada = ($sentencia->rowCount() == 0);

// Está todo correcto de forma normal si NO ha habido errores y se ha visto afectada UNA fila.
$correcto = ($sqlConExito && $unaFilaAfectada);

// Si los datos no se habían modificado, también está correcto.
$datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<?php
// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
if ($correcto || $datosNoModificados) { ?>

    <?php if ($id == -1) { ?>
        <h1>Inserción completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

        <?php if ($datosNoModificados) { ?>
            <p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
        <?php } ?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <h1>Error en la modificación.</h1>
    <p>No se han podido guardar los datos de la categoría.</p>

    <?php
}
?>

<a href="categoria-listado.php">Volver al listado de Categorías.</a>
<br>
<br>
<a href="persona-listado.php">Volver al listado de Personas.</a>
<br>
<br>
<a href='libros-listado.php'>Volver al listado de Libros</a>

</body>

</html>