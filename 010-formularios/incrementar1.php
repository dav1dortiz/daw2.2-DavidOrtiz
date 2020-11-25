<?php
if (!isset($_REQUEST["acumulado"]) || isset($_REQUEST["reset"])) { // Si NO hay formulario enviado (1ª vez), o piden resetear.
    $acumulado = 0;
}
if (isset($_REQUEST["+1"])){
    $acumulado = (int) $_REQUEST["acumulado"] + 1;
}
if (isset($_REQUEST["-1"])){
    $acumulado = (int) $_REQUEST["acumulado"] - 1;
}


?>
<html>

<head>INCREMENTAR VALOR</head>

<p><?=$acumulado?></p>
<form method="get">



    <input type="submit" name="-1" value="-">

    <input type="text" name="acumulado" value="<?=$acumulado?>">

    <input type="submit" name="+1" value="+">

    <br><br>

    <input type="submit" name="reset" value="Resetear">
</form>




</html>
