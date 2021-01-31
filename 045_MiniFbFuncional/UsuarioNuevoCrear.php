<?php
// TODO ...$_REQUEST["..."]...
// TODO Intentar crear (añadir funciones en Varios.php para crear y tal).
// TODO Y redirigir a donde sea.
//$arrayUsuario = crearUsuario($identificador, $contrasenna, ....);
// TODO ¿Excepciones?
//if ($arrayUsuario) {
/*} else {
}
*/
require_once "_com/_Varios.php";
require_once "_com/DAO.php";

if (isset($_REQUEST["nombre"])        && isset($_REQUEST["apellidos"]) &&
    isset($_REQUEST["identificador"]) && isset($_REQUEST["contrasenna"])){
    //validamos si los campos introducidos son vacíos o no (se debe hacer una validación mejor)
    if ($_REQUEST["nombre"]=="" || $_REQUEST["nombre"]==null) {
        redireccionar("UsuarioNuevoFormulario.php");
    } else {
        $nombre=$_REQUEST["nombre"];
    }
    if ($_REQUEST["apellidos"]=="" || $_REQUEST["apellidos"]==null) {
        redireccionar("UsuarioNuevoFormulario.php");
    } else {
        $apellidos=$_REQUEST["apellidos"];
    }
    if ($_REQUEST["identificador"]=="" || $_REQUEST["identificador"]==null) {
        redireccionar("UsuarioNuevoFormulario.php");
    } else {
        $identificador=$_REQUEST["identificador"];
    }
    if ($_REQUEST["contrasenna"]=="" || $_REQUEST["contrasenna"]==null) {
        redireccionar("UsuarioNuevoFormulario.php");
    } else {
        $contrasenna=$_REQUEST["contrasenna"];
    }
    DAO::usuarioCrear($nombre, $apellidos, $identificador, $contrasenna);
    redireccionar("SesionInicioFormulario.php");
} else {
    redireccionar("UsuarioNuevoFormulario.php");
}


?>
