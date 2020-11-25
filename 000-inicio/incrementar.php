<?php
    if (!isset($_REQUEST["acumulado"]));
         $acumulado = $_REQUEST["acumulado"];

?>

<html>

<h1>0</h1>

<form method='get'>

    <input type='hidden' name='acumulado' value='<?=$acumulado?>'>

    <input type='submit' value=' - ' name='resta'>
    <input type='number' name='diferencia' value='1'>
    <input type='submit' value=' + ' name='suma'>

    <br /><br />

    <input type='submit' value='Resetear' name='reset'>



</form>

</html>



