<?php
	require_once "varios.php";

	$conexion = obtenerPdoConexionBD();
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una persona existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$personaNombre = "";
        $personaApellidos = "";
		$personaTelefono = "";

	} else { // Quieren VER la ficha de una persona existente, cuyos datos se cargan.
        $sqlPersona = "SELECT * FROM persona WHERE id=?";

        $select = $conexion->prepare($sqlPersona);
        $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
        $rsPersona = $select->fetchAll();

        // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
		$personaNombre = $rsPersona[0]["nombre"];
        $personaApellidos = $rsPersona[0]["apellidos"];
		$personaTelefono = $rsPersona[0]["telefono"];
		$personaCategoriaId = $rsPersona[0]["categoriaId"];
	}

	
	
	// Con lo siguiente se deja preparado un recordset con todas las categorías.
	
	$sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

    $select = $conexion->prepare($sqlCategorias);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsCategorias = $select->fetchAll();



    // INTERFAZ:
    // $personaNombre
    // $personaTelefono
    // $personaApellidos
    // $personaEstrella
    // $personaCategoriaId
    // $rsCategorias
?>




<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de persona</h1>
<?php } else { ?>
	<h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='persona-guardar.php'>

<input type='hidden' name='id' value='<?= $id ?>' />

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre' value='<?=$personaNombre ?>' />
    <br/>

    <label for='apellidos'> Apellidos</label>
    <input type='text' name='apellidos' value='<?=$personaApellidos ?>' />
    <br/>

    <label for='telefono'> Teléfono</label>
    <input type='text' name='telefono' value='<?=$personaTelefono ?>' />
    <br/>


        <?php
            foreach ($rsCategorias as $filaCategoria) {
                $categoriaId = (int) $filaCategoria["id"];
                $categoriaNombre = $filaCategoria["nombre"];

                // Alternativa (peor):
                // if ($categoriaId == $personaCategoriaId) echo "<option value='$categoriaId' selected='true'>$categoriaNombre</option>";
                // else                                     echo "<option value='$categoriaId'                >$categoriaNombre</option>";
            }
        ?>
    </select>
    <br/>


    <br/>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear persona' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='persona-eliminar.php?id=<?=$id ?>'>Eliminar persona</a>
<?php } ?>

<br />
<br />

<a href='persona-listado.php'>Volver al listado de personas.</a>

</body>

</html>