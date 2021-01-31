<?php

require_once "_com/_Varios.php";
require_once "_com/DAO.php";

// Comprobamos si hay sesión-usuario iniciada.
//   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
//     (Mostrar info del usuario logueado y tal...)
//   - Si NO la hay, redirigimos a SesionInicioFormulario.php

if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
    redireccionar("SesionInicioFormulario.php");
}
$publicaciones=DAO::publicacionObtenerSinDestinatario();
?>

<!--
3. Completa el script MuroVerGlobal.php. Aquí deben aparecer todas las publicaciones que los usuarios publican
"al viento" (destinatarioId = null). Ordenados por fecha. Publicaciones más nuevas, arriba.
-->

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>Muro global</h1>
<!--
<p>Aquí mostraremos todos los mensajes de todos a todos.</p>
-->
<table border='1'>
    <tr>
        <td>Id Publicacion</td>
        <td>Fecha</td>
        <td>Id Emisor</td>
        <td>Id Destinatario</td>
        <td>Asunto</td>
        <td>Contenido</td>
        <?php foreach ($publicaciones as $publicacion) {
        $fechaDatetime=$publicacion->getFecha();
        $fechaString=$fechaDatetime->format('Y-m-d H:i:s');
        ?>
    <tr>
        <td><?=$publicacion->getIdPublicacion()?>   </td>
        <td><?=$fechaString?>                       </td>
        <td><?=$publicacion->getEmisorId()?>        </td>
        <td><?=$publicacion->getDestinatarioId()?>  </td>
        <td><?=$publicacion->getAsunto()?>          </td>
        <td><?=$publicacion->getContenido()?>       </td>
        <?php } ?>
    </tr>
</table>
<br><br>
<a href='MuroVerDe.php'>Ir a mi muro</a>
<br><br>
<a href='Index.php'>Volver al Inicio</a>

</body>

</html>
