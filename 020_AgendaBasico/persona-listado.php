<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$sql = "
               SELECT
                    p.id          AS pId,
                    p.nombre      AS pNombre,
                    p.apellidos   AS pApellidos, 
                    p.estrella    AS pEstrella,
                    p.categoriaId AS pCategoriaId,
                    c.id          AS cId,
                    c.nombre      AS cNombre
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
        <th>Favorito</th>
        <th>Categoria Id</th>
        <th>Categoria Nombre</th>

    </tr>

    <?php
    foreach ($resultSet as $fila) { ?>
        <tr>
            <td><a     href='persona-eliminar.php?id=<?=$fila["pId"]?>'>  <?=$fila["pNombre"]?>      </a></td>
            <td><a     href='persona-eliminar.php?id=<?=$fila["pId"]?>'>  <?=$fila["pApellidos"]?>   </a></td>
            <td> <!-- <a href='persona-ficha.php?id=<?=$fila["pId"]?>'> <?=$fila["pEstrella"]?>  </a>  Esta línea era provisional, hacia aparecer un 1 o un 0 en la columna favoritos-->
                <?php
                echo "";
                if ($fila["pEstrella"]) {
                    $imagenEstrella = "estrellaRellena.png";
                    $paramEstrella = "estrella";
                } else {
                    $imagenEstrella = "estrellaVacia.png";
                    $paramEstrella = "";
                }
                echo "<a href='persona-estado-estrella.php?$paramEstrella'><img src='$imagenEstrella' width='16' height='16'></a>";
                ?></td>

            <td><a     href='persona-eliminar.php?id=<?=$fila["pId"]?>'>  <?=$fila["pCategoriaId"]?> </a></td>
            <td><a     href='persona-eliminar.php?id=<?=$fila["pId"]?>'>  <?=$fila["cNombre"]?>      </a></td>
            <td><a  href='persona-eliminar.php?id=<?=$fila["pId"]?>'>  [X]                        </a></td>
        </tr>
    <?php } ?>

</table>

<br>

<a href='persona-eliminar.php?id=-1'>Crear Nueva Persona</a>

<br><br>

<a href='persona-listado.php'>Gestionar listado de Personas</a>

<br><br>

<a href='listado-persona-conEstrella.php'>Lista de Favoritos</a>

<br><br>

<a href='listado-persona-sinEstrella.php'>Lista de No Favoritos</a>

</body>

</html>