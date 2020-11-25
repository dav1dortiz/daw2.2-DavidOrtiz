<?php
$oculto=(int) $_REQUEST["oculto"];

if(isset($_REQUEST["intento"])){
    $intento=(int)$_REQUEST["intento"];

    $numIntentos=(int)$_REQUEST["numIntentos"] + 1;
    $asteriscos=1 + abs($intento - $oculto) /10;
    $cercania="";
    for($i=1;)
}
?>
<html>
<head><h1>ADIVINA EL NÚMERO</h1></head>
<?php
if($intento == Null){

}elseif ($intento < $oculto){
    echo "<p> El número que buscas es mayor ($cercania</p>";
}
?>
</html>
