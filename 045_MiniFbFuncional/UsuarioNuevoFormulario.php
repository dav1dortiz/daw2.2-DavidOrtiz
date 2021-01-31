<?php
require_once "_com/_Varios.php";
require_once "_com/DAO.php";

?>


<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Crear Usuario</h1>
<div>
    <form action='UsuarioNuevoCrear.php' method='post'>
        <label><strong>Nombre: </strong></label>
        <input type='text' name='nombre'><br><br>
        <label><strong>Apellidos: </strong></label>
        <input type='text' name='apellidos'><br><br>
        <label> <strong>Usuario: </strong></label>
        <input type='text' name='identificador'><br><br>
        <label> <strong>Contraseña: </strong></label>
        <input type='password' name='contrasenna'><br><br>
        <input type='submit' name='boton' value="Enviar" />
    </form>
</div>
<br>
<a href='SesionInicioFormulario.php'>Ya estoy registrado</a><br><br>
<a href="Index.php">Volver al Inicio</a>

</body>
</html>