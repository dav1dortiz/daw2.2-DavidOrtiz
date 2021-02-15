<?php
require_once "_com/Varios.php";

$conexionBD = obtenerPdoConexionBD();

$id = $_REQUEST["id"];

$sql = "UPDATE Persona SET estrella = (NOT (SELECT estrella FROM Persona WHERE id=?)) WHERE id=?";
$sentencia = $conexionBD->prepare($sql);
$sentencia->execute([$id, $id]);

redireccionar("PersonaListado.php");
?>
