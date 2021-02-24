<?php

require_once "_com/Clases.php";
require_once "_com/DAO.php";

$persona = new Persona($_REQUEST["id"], $_REQUEST["nombre"]);

$persona = DAO::personaActualizar($persona);

echo json_encode($persona);
