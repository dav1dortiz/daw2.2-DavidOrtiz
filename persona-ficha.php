<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$nuevaPersona = ($id == -1);

if ($nuevaPersona) {
    $nombrePersona = "<introduzca nombre>";
    $apellidosPersona = "<introduzca apellidos>";
    $telefonoPersona = "<introduzca su teléfono>";
    $idCategoria = "<introduzca el id de la categoría a la que pertenece>";
} else {
    $sqlPersonas = "SELECT nombre, apellidos, telefono, categoriaId FROM persona WHERE id=?";

    $select = $conexion->prepare($sqlPersonas);
    $select->execute([$id]);
    $resultSetPersona = $select->fetchAll();

    $nombrePersona = $resultSetPersona[0]["nombre"];
    $apellidosPersona = $resultSetPersona[0]["apellidos"];
    $telefonoPersona = $resultSetPersona[0]["telefono"];
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

<?php if ($nuevaPersona) { ?>
    <h1>Nueva Persona</h1>
<?php } else { ?>
    <h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='persona-guardar.php'>
    <input type='hidden' name='id' value='<?=$id?>' />
    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$nombrePersona?>' />
        </li>
        <li>
            <strong> Apellidos: </strong>
            <input type='text' name='apellidos' value='<?=$apellidosPersona?>' />
        </li>
        <li>
            <strong>Teléfono: </strong>
            <input type='tel' name='telefono' value='<?=$telefonoPersona?>'>
        </li>
        <li>
            <strong>ID-Categoría: </strong>
            <input type='number' name='categoriaId' value='<?=$idCategoria?>'>
        </li>
    </ul>

    <?php if ($nuevaPersona) { ?>
        <input type='submit' name='crear-persona' value='Crear persona' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>
</form>
<br>

<?php if (!$nuevaPersona){ ?>
    <a href="persona-eliminar.php?id=<?=$id?>">Eliminar persona</a>
<?php } ?>

<br>
<a href="persona-listado.php">Volver a la lista de Personas.</a>

</body>

</html>