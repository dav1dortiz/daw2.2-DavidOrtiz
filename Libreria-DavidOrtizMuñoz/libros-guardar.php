<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$autor = $_REQUEST["autor"];
$idCategoria =(int)$_REQUEST["categoriaId"];

$nuevoLibro = ($id == -1);

if ($nuevoLibro) {
    $sql = "INSERT INTO libro (nombre, autor, categoriaId) VALUES (?, ?, ?)";
    $parametros = [$nombre,$autor, $idCategoria];
} else {
    $sql = "UPDATE libro SET nombre=?, autor=?, categoriaId=? WHERE isbn=?";
    $parametros = [$nombre, $autor, $idCategoria, $id];
}

$sentencia = $conexion->prepare($sql);

$sqlConExito = $sentencia->execute($parametros);


$unaFilaAfectada = ($sentencia->rowCount() == 1);
$ningunaFilaAfectada = ($sentencia->rowCount() == 0);

$correctaEjecucion = ($sqlConExito && $unaFilaAfectada);

$datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>

<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<?php

if ($correctaEjecucion || $datosNoModificados) { ?>
    <?php if ($id == -1) { ?>
        <h1>Inserción completada</h1>
        <p>Se han insertado correctamente las nuevas entradas de <?=$nombre?>, <?=$autor?> y <?=$idCategoria?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?=$nombre?>,  <?=$autor?> y <?=$idCategoria?>.</p>

        <?php if ($datosNoModificados) { ?>
            <p>No se ha modificado nada.</p>
        <?php } ?>
    <?php  }  ?>

<?php } else { ?>

    <h1>Error en la modificación.</h1>
    <p>No se han podido guardar los datos del libro.</p>

<?php } ?>

<a href="libros-listado.php">Volver a la lista de Libros.</a>

</body>

</html>