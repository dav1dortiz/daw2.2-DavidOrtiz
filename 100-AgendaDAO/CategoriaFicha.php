<?php
require_once "_com/Dao.php";
require_once "_com/_Varios.php";
require_once "_com/Utilidades.php";

$conexion = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$resultado=Dao::categoriaObtenerPorId($id);

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) {
    $categoriaNombre = "<introduzca nombre>";
} else {
    $sql = "SELECT nombre FROM categoria WHERE id=?";

    $select = $conexion->prepare($sql);

    $select->execute([$id]);

    $rs = $select->fetchAll();

    $categoriaNombre = $rs[0]["nombre"];
}

$sql = "SELECT * FROM persona WHERE categoriaId=? ORDER BY nombre";

$select = $conexion->prepare($sql);

$select->execute([$id]); // Array vacío porque la consulta preparada no requiere parámetros.

$rsPersonasDeLaCategoria = $select->fetchAll();

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de categoría</h1>
<?php } else { ?>
    <h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='CategoriaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre' value='<?=$categoriaNombre?>' />
    <br/>

    <br/>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear categoría' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<br />

<p>Personas que pertenecen actualmente a la categoría:</p>

<ul>
    <?php
    foreach ($rsPersonasDeLaCategoria as $fila) {
        echo "<li>$fila[nombre] $fila[apellidos]</li>";
    }
    ?>
</ul>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='CategoriaEliminar.php?id=<?=$id?>'>Eliminar categoría</a>
<?php } ?>

<br />
<br />

<a href='CategoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>
