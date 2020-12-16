<?php
require_once "_Varios.php";

if (haySesionIniciada()) redireccionar("ContenidoPrivado1.php");

$datosErroneos = isset($_REQUEST["datosErroneos"]);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>

<?php if ($datosErroneos) { ?>
    <p style='color: red;'>No se ha podido iniciar sesión con los datos proporcionados. Inténtelo de nuevo.</p>
<?php } ?>

<form action='SesionInicioComprobar.php' method='get'>
    <p>Usuario: <input type='text' name='identificador' /></p>
    <p>Contraseña: <input type='password' name='contrasenna' /></p>
    <label for='recordar'>Recuérdame aunque cierre el navegador</label>
    <input type='checkbox' name='recordar' id='recordar'><br><br>
    <input type='submit' name='boton' value="Enviar" />
</form>


</body>

</html>
