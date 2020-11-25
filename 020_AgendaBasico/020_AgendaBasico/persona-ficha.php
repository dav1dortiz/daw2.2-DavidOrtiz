<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$nuevaPersona = ($id == -1);

if ($nuevaPersona) {
    $nombrePersona = "<introduzca nombre>";
    $apellidosPersona = "<introduzca apellidos>";
    $telefonoPersona = "<introduzca su teléfono>";
    $estrellaPersona = false;
    $idCategoria = "<introduzca el id de la categoría a la que pertenece>";

} else {
    $sqlPersonas = "SELECT * FROM persona WHERE id=?";

    $select = $conexion->prepare($sqlPersonas);
    $select->execute([$id]);
    $resultSetPersona = $select->fetchAll();

    $nombrePersona = $resultSetPersona[0]["nombre"];
    $apellidosPersona = $resultSetPersona[0]["apellidos"];
    $telefonoPersona = $resultSetPersona[0]["telefono"];
    $estrellaPersona = ($resultSetPersona[0]["estrella"] == 1); // En la BDD estáa como tinyint, así lo convertimos a boolean
    $idCategoriaPersona = $resultSetPersona[0]["categoriaId"];
}

// Dejamos preparado un recordset con las categorías.

$sqlCategorias = "SELECT * FROM categoria ORDER BY nombre";

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
            <label for='nombre'> <strong>Nombre: </strong> </label>
            <input type='text' name='nombre' value='<?=$nombrePersona?>' />
        </li>
        <li>
            <label for='apellidos'> <strong> Apellidos: </strong> </label>
            <input type='text' name='apellidos' value='<?=$apellidosPersona?>' />
        </li>
        <li>
            <label for='telefono'> <strong>Teléfono: </strong> </label>
            <input type='tel' name='telefono' value='<?=$telefonoPersona?>'>
        </li>
        <li>
            <!-- Aquí se hace el select del nombre de la categoría  -->
            <label for='categoriaId'> <strong>ID-Categoría: </strong> </label>
            <select name='categoriaId'>
                <?php
                foreach ($resultSetCategorias as $filaCategorias) {
                    $categoriaId = (int)$filaCategorias["id"];
                    $nombreCategoria = $filaCategorias["nombre"];

                    if ($categoriaId == $idCategoriaPersona){
                        $seleccion = "selected = 'true' ";
                    } else {
                        $seleccion = "";
                    }
                    echo "<option value='$categoriaId' $seleccion> $nombreCategoria </option>";
                }
                ?>
            </select>
        </li>
        <li>
            <label for='estrella'> <strong>Favorito</strong> </label>
            <input type='checkbox' name='estrella' <?= $estrellaPersona ? "checked" : "" ?> />
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
