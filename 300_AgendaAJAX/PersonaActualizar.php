<?php

require_once "_com/Clases.php";
require_once "_com/DAO.php";


$persona = new Persona($_REQUEST["id"], $_REQUEST["nombre"], $_REQUEST["apellidos"], $_REQUEST["telefono"],
    $_REQUEST["categoriaId"], $_REQUEST["estrella"]);
//$persona = new Persona(24, "Arturo", "Pérez", 628451793, 12, false);
$persona = DAO::personaActualizar($persona);

echo json_encode($persona);
