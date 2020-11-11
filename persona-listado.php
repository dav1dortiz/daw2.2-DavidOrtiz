<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$sql = "
               SELECT
                    p.id        AS pId,
                    p.nombre    AS pNombre,
                    p.apellidos AS pApellidos, 
                    c.id        AS cId,
                    c.nombre    AS cNombre,
                    p.categoriaId AS pCategoriaId
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                ORDER BY p.nombre
        ";

$select = $conexion->prepare($sql);

$select->execute([]);

$resultSet = $select->fetchAll();

?>

<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<h1>Lista de Personas</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Categoria Id</th>
        <th>Categoria Nombre</th>

    </tr>

    <?php
    foreach ($resultSet as $fila) { ?>
        <tr>
            <td><a     href='persona-ficha.php?id=<?=$fila["pId"]?>'>  <?=$fila["pNombre"]?>      </a></td>
            <td><a     href='persona-ficha.php?id=<?=$fila["pId"]?>'>  <?=$fila["pApellidos"]?>   </a></td>
            <td><a     href='persona-ficha.php?id=<?=$fila["pId"]?>'>  <?=$fila["pCategoriaId"]?> </a></td>
            <td><a     href='persona-ficha.php?id=<?=$fila["pId"]?>'>  <?=$fila["cNombre"]?>      </a></td>
            <td><a  href='persona-eliminar.php?id=<?=$fila["pId"]?>'>  [X]                        </a></td>
        </tr>
    <?php } ?>

</table>

<br>

<a href="persona-ficha.php?id=-1">Crear Nueva Persona</a>

<br>
<br>

<a href="persona-listado.php">Gestionar listado de Personas</a>

</body>

</html>
