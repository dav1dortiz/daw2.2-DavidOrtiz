<?php

require_once "_com/DAO.php";

$persona = DAO::personaCrear($_REQUEST["nombre"]);

echo json_encode($persona);
