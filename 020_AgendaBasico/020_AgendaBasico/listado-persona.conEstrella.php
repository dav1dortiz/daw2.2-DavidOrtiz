<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$sql = " SELECT
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
                WHERE p.Estrella = 1   
                ORDER BY p.nombre";

$select = $conexion->prepare($sql);

$select->execute([]);

$resultSet = $select->fetchAll();
?>

<html>
<head> <meta charset="UTF-8"> </head>
<body>
<h1>Listado de Favoritos</h1>

<table border='1'>
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Categorìa Id</th>
        <th>Categoría</th>
    </tr>
    <tr>
        <?php
        foreach ($resultSet as $filaFavoritos) { ?>
    <tr>
        <td><a href='persona-ficha.php?id=<?=$filaFavoritos["pId"]?>'>  <?=$filaFavoritos["pNombre"]?>      </a></td>
        <td><a href='persona-ficha.php?id=<?=$filaFavoritos["pId"]?>'>  <?=$filaFavoritos["pApellidos"]?>   </a></td>
        <td><a href='persona-ficha.php?id=<?=$filaFavoritos["pId"]?>'>  <?=$filaFavoritos["cId"]?>          </a></td>
        <td><a href='persona-ficha.php?id=<?=$filaFavoritos["pId"]?>'>  <?=$filaFavoritos["cNombre"]?>      </a></td>
    </tr>
    <?php } ?>
    </tr>
</table>

<br><br>

<a href='persona-listado.php'>Volver al listado de Personas.</a>

</body>
</html>

