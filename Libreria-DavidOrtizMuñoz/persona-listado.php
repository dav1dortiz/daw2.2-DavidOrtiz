<?php
    require_once "varios.php";

    $conexion = obtenerPdoConexionBD();


    $sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos AS pApellidos,
                    p.telefono AS pTelefono,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                ORDER BY p.nombre
            ";

    $select = $conexion->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();


    // INTERFAZ:
    // $rs
    // $_SESSION
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Persona</th>
        <th>Teléfono</th>
        <th></th>
    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <td>
                <?php

                    echo "<a href='persona-eliminar.php?id=$fila[pId]'>";
                    echo "$fila[pNombre]";
                    if ($fila["pApellidos"] != "") {
                        echo " $fila[pApellidos]";
                    }
                    echo "</a>";
                ?>
            </td>
            <td><a href= 'persona-ficha.php?id=<?=$fila["pId"]?>'> <?= $fila["pTelefono"] ?> </a></td>
            <td><a href='persona-eliminar.php?id=<?=$fila["pId"]?>'> (X)                      </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<br />
<br />

<a href='persona-ficha.php?id=-1'>Crear entrada</a>

<br />
<br />


<a href='categoria-listado.php'>Gestionar listado de Categorías</a>
<br>
<br>
<a href='libros-listado.php'>Gestionar listado de Libros</a>


</body>

</html>