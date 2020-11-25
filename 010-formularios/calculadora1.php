<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
</head>
<body>
<label>Introduzca la operacion que desea realizar.</label>


<form action="calculadora2.php" method="get">
<input type="number" name="numero1" value="Operando1">
    <select name="tipo">
        <option value="suma">Suma</option>
        <option value="resta">Resta</option>
        <option value="multip">Multiplicación</option>
        <option value="division">División</option>
    </select>
<input type="number" name="numero2" value="Operando2">
<input type="submit" value="Enviar">

</form>

</body>
</html>
