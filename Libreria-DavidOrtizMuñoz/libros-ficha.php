<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$nuevoLibro = ($id == -1);

if ($nuevoLibro) {
    $nombreLibro = "";
    $autorLibro = "";
    $idCategoria = "";
} else {
    $sqlLibros = "SELECT nombre, autor, categoriaId FROM libro WHERE isbn=?";

    $select = $conexion->prepare($sqlLibros);
    $select->execute([$id]);
    $resultSetPersona = $select->fetchAll();

    $nombreLibro = $resultSetPersona[0]["nombre"];
    $autorLibro = $resultSetPersona[0]["autor"];
    $idCategoria = $resultSetPersona[0]["categoriaId"];
}

// Dejamos preparado un recordset con las categorías.

$sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

$select = $conexion->prepare($sqlCategorias);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$resultSetCategorias = $select->fetchAll();


?>



<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<?php if ($nuevoLibro) { ?>
    <h1>Nuevo Libro</h1>
<?php } else { ?>
    <h1>Ficha del libro</h1>
<?php } ?>

<form method='post' action='libros-guardar.php'>
    <input type='hidden' name='id' value='<?=$id?>' />
    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$nombreLibro?>' />
        </li>
        <li>
            <strong> Autor: </strong>
            <input type='text' name='autor' value='<?=$autorLibro?>' />
        </li>
        <li>
            <strong>ID-Categoría: </strong>
            <input type='number' name='categoriaId' value='<?=$idCategoria?>'>
        </li>
    </ul>

    <?php if ($nuevoLibro) { ?>
        <input type='submit' name='crear-persona' value='Crear libro' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>
</form>
<br>

<?php if (!$nuevoLibro){ ?>
    <a href="libros-eliminar.php?id=<?=$id?>">Eliminar libro</a>
<?php } ?>

<br>
<a href="libros-listado.php">Volver a la lista de Libros.</a>

</body>

</html>