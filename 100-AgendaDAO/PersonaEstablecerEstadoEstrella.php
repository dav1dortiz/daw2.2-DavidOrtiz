<?php

require_once "_com/Dao.php";
require_once "_com/Varios.php";

$conexion = obtenerPdoConexionBD();

$id=$_REQUEST["id"];

$sql = "UPDATE persona SET estrella = (NOT(SELECT estrella FROM persona WHERE id=?)) WHERE id=?";

$sentencia = $conexion->prepare($sql);

$sqlConExito = $sentencia->execute([$id, $id]);

redireccionar("PersonaListado.php");
