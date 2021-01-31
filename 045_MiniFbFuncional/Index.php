<?php

require_once "_com/_Varios.php";
require_once "_com/DAO.php";

$sesionIniciada=haySesionRamIniciada();

?>


<html>

<head>
    <meta charset='UTF-8'>
    <?php
    if($sesionIniciada){?>
        <p>Hola, <a href='UsuarioPerfilVer.php'><?=$_SESSION["nombre"]?> <?=$_SESSION["apellidos"]?></a> <a href='SesionCerrar.php'>(Cerrar Sesión)</a></p>
        <?php
    }
    ?>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>MiniFb</h1>

<p>¡Bienvenido a MiniFb! Con un sin fin de aventuras</p>
<p>Crea tu cuenta y participa.</p>

<a href='MuroVerGlobal.php'>Observa las novedades del muro si ya tienes una cuenta.</a>

</body>

</html>
