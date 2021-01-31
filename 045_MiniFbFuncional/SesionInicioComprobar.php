<?php

require_once "_com/_Varios.php";

$arrayUsuario = obtenerUsuarioPorContrasenna($_REQUEST["identificador"], $_REQUEST["contrasenna"]);

if ($arrayUsuario) { // Identificador existía y contraseña era correcta.
    establecerSesionRam($arrayUsuario);

    if (isset($_REQUEST["recordar"])) {
        establecerSesionCookie($arrayUsuario);
    }

    redireccionar("MuroVerGlobal.php");
} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}