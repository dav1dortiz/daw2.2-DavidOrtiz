<?php

require_once "_com/DAO.php";

$resultado = DAO::personaEliminarPorId($_REQUEST["id"]);

echo json_encode($resultado);