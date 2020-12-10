<?php

// TODO ...$_REQUEST["..."]...
require_once "_Varios.php";
if (isset($_REQUEST["identificador"])){
    $identificador = $_REQUEST["identificador"];
} else{
    $identificador = "";
}

if (isset($_REQUEST["contrasenna"])){
    $contrasenna = $_REQUEST["contrasenna"];
} else{
    $contrasenna = "";
}

// TODO Verificar (usar funciones de _Varios.php) identificador y contrasenna recibidos y redirigir a ContenidoPrivado1 (si OK) o a iniciar sesión (si NO ok).

$arrayUsuario = obtenerUsuario($identificador, $contrasenna);

if ($arrayUsuario) { // HAN venido datos: identificador existía y contraseña era correcta.
    marcarSesionComoIniciada($arrayUsuario);
    // echo print_r($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
} else {
    redireccionar("SesionInicioMostrarFormulario.php");
}
?>