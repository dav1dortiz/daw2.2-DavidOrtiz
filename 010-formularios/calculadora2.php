<?php
$tipo=$_REQUEST["tipo"];
$numero1=$_REQUEST["numero1"];
$numero2=$_REQUEST["numero2"];
$valor=0;
$texto= "La $tipo de $numero1 y $numero2 es igual a ";

switch ($tipo){
    case "suma":
        $valor= $numero1 + $numero2;
        echo $texto . $valor;
        break;
    case "resta":
        $valor= $numero1 - $numero2;
        echo $texto . $valor;
        break;
    case "multip":
        $valor= $numero1 * $numero2;
        echo $texto . $valor;
        break;
    case "division":
        if ($numero2 == 0){
            echo "La división no se puede realizar porque es imposible dividir entre 0.";
            break;
        }
        $valor= $numero1 / $numero2;
        echo $texto . $valor;
        break;
}
?>
