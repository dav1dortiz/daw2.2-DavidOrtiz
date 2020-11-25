<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

$sql = "
               SELECT
                    p.isbn        AS pIsbn,
                    p.nombre    AS pNombre,
                    p.autor AS pAutor, 
                    c.id        AS cId,
                    c.nombre    AS cNombre,
                    p.categoriaId AS pCategoriaId
                FROM
                   libro AS p INNER JOIN categoria AS c
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

<h1>Lista de Libros</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Autor</th>
        <th>Categoria Id</th>
        <th>Categoria Nombre</th>

    </tr>

    <?php
    foreach ($resultSet as $fila) { ?>
        <tr>
            <td><a     href='libros-ficha.php?id=<?=$fila["pIsbn"]?>'>  <?=$fila["pNombre"]?>      </a></td>
            <td><a     href='libros-ficha.php?id=<?=$fila["pIsbn"]?>'>  <?=$fila["pAutor"]?>   </a></td>
            <td><a     href='libros-ficha.php?id=<?=$fila["pIsbn"]?>'>  <?=$fila["pCategoriaId"]?> </a></td>
            <td><a     href='libros-ficha.php?id=<?=$fila["pIsbn"]?>'>  <?=$fila["cNombre"]?>      </a></td>
            <td><a  href='libros-eliminar.php?id=<?=$fila["pIsbn"]?>'>  [X]                        </a></td>
        </tr>
    <?php } ?>

</table>

<br>

<a href="libros-ficha.php?id=-1">Crear Nuevo Libro</a>

<br>
<br>

<a href="libros-listado.php">Gestionar listado de Libros</a>
<br>
<br>
<a href="categoria-listado.php">Gestionar listado de Categorias</a>
<br>
<br>
<a href="persona-listado.php">Gestionar listado de Personas</a>

</body>

</html>
