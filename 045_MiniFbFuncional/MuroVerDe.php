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

$id = $_SESSION["id"];
//echo $id;
$mensajes = DAO::publicacionObtenerPrivado($id);


?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>Muro de ______</h1>
<p>/Aquí mostraremos los mensajes que hayan sido publicados para el usuario indicado como parámetro. Si no indican nada, veo los mensajes dirigidos a mí. Si indican otra cosa, veo los mensajes dirigidos a ese usuario.</p>

<table border='1'>
    <tr>
        <td>Id Publicacion</td>
        <td>Fecha</td>
        <td>Id Emisor</td>
        <td>Id Destinatario</td>
        <td>Asunto</td>
        <td>Contenido</td>
        <?php foreach ($mensajes as $publicacion) {
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
<a href='Index.php'>Volver al Inicio</a>
<br><br>
<a href='MuroVerGlobal.php'>Muro Global</a>

</body>

</html>