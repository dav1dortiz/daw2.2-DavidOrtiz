<?php

declare(strict_types=1);
session_start();
function obtenerPdoConexionBD(): PDO
{
$servidor = "localhost";
$bd = "MiniFb";
$identificador = "root";
$contrasenna = "";
$opciones = [
PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
];

try {
$conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
} catch (Exception $e) {
error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
exit('Error al conectar'); //something a user can understand
}

return $conexion;
}

function obtenerUsuario(string $identificador, string $contrasenna): ?array
{
$conexion = obtenerPdoConexionBD();
$sql1 = "SELECT * FROM Usuario WHERE identificador = ? and BINARY contrasenna = ?;";

$select = $conexion->prepare($sql1);
$select->execute([$identificador,$contrasenna]); // Se añade el parámetro a la consulta preparada.
$rs = $select->fetchAll();

return $select->rowCount()==1 ? $rs[0] : null;
}

function obtenerUsuarioCreado(string $identificador): ?array
{
$conexion = obtenerPdoConexionBD();
$sql1 = "SELECT * FROM Usuario WHERE id = ?;";

$select = $conexion->prepare($sql1);
$select->execute([$identificador]); // Se añade el parámetro a la consulta preparada.
$rs = $select->fetchAll();

return $select->rowCount()==1 ? $rs[0] : null;
}

function marcarSesionComoIniciada(array $arrayUsuario)
{
// TODO Anotar en el post-it todos estos datos:
$_SESSION["id"] = $arrayUsuario["id"];
$_SESSION["identificador"] = $arrayUsuario["identificador"];
$_SESSION["contrasenna"] = $arrayUsuario["contrasenna"];
$_SESSION["nombre"] = $arrayUsuario["nombre"];
$_SESSION["apellidos"] = $arrayUsuario["apellidos"];
}

function haySesionIniciada(): bool
{
// TODO Pendiente hacer la comprobación.

// Está iniciada si isset($_SESSION["id"])
return isset($_SESSION["id"]) ? true : false;

}

function cerrarSesion()
{
session_destroy();
setcookie('codigoCookie', "");
setcookie('identificador',"");
unset($_SESSION);
// TODO session_destroy() y unset de $_SESSION (por si acaso).
}

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
header("Location: $url");
exit;
}


function generarCookieRecordar(array $arrayUsuario)
{
// Creamos un código cookie muy complejo (no necesariamente único).
$codigoCookie = generarCadenaAleatoria(32); // Random...

$conexion = obtenerPdoConexionBD();
$sql = "UPDATE Usuario SET codigoCookie=? WHERE identificador=?";
$parametros = [$codigoCookie,$arrayUsuario["identificador"]];
$sentencia = $conexion->prepare($sql);
$sqlConExito = $sentencia->execute($parametros);

if($sqlConExito){
$arrayUsuario["codigoCookie"] =$codigoCookie;
setcookie('codigoCookie', $codigoCookie);
setcookie('identificador', $arrayUsuario["identificador"]);
}

// TODO $arrayUsuario["codigoCookie"] = ...

// TODO Enviamos al cliente, en forma de cookies, el código cookie y su identificador.
}

function borrarCookieRecordar(array $arrayUsuario)
{
// TODO Eliminar el código cookie de nuestra BD.

// TODO Pedir borrar cookie (setcookie con tiempo time() - negativo...)
}

function generarCadenaAleatoria($longitud): string
{
for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != $longitud; $x = rand(0,$z), $s .= $a[$x], $i++);
return $s;
}

function intentarCanjearSesionCookie(): bool
{
if($_COOKIE["codigoCookie"] && $_COOKIE["identificador"]){
$conexion = obtenerPdoConexionBD();
$sql1 = "SELECT * FROM Usuario WHERE identificador = ? AND BINARY codigoCookie=?;";

$select = $conexion->prepare($sql1);
$select->execute([$_COOKIE["identificador"],$_COOKIE["codigoCookie"]]); // Se añade el parámetro a la consulta preparada.
$rs = $select->fetchAll();
if($select->rowCount()==1){
return true;
}else{
return false;
}
//return  $select->rowCount()==1? true : false;
}else{
return false;
}
}


function syso(string $contenido)
{
file_put_contents('php://stderr', $contenido . "\n");
}