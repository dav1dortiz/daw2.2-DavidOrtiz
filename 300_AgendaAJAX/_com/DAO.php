<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "Agenda"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - int: el id autogenerado para el nuevo registro.
    private static function ejecutarInsert(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $insert = self::$pdo->prepare($sql);
        $sqlConExito = $insert->execute($parametros);

        if (!$sqlConExito) return null;
        else return self::$pdo->lastInsertId();
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarUpdate(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $update = self::$pdo->prepare($sql);
        $sqlConExito = $update->execute($parametros);

        if (!$sqlConExito) return null;
        else return $update->rowCount();
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 o más: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarDelete(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $delete = self::$pdo->prepare($sql);
        $sqlConExito = $delete->execute($parametros);

        if (!$sqlConExito) return null;
        else return $delete->rowCount();
    }


    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria WHERE id=?",
            [$id]
        );

        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }

    public static function categoriaCrear(string $nombre): ?Categoria
    {
        $idAutogenerado = self::ejecutarInsert(
            "INSERT INTO Categoria (nombre) VALUES (?)",
            [$nombre]
        );

        if ($idAutogenerado == null) return null;
        else return self::categoriaObtenerPorId($idAutogenerado);
    }

    public static function categoriaActualizar(Categoria $categoria): ?Categoria
    {
        $filasAfectadas = self::ejecutarUpdate(
            "UPDATE Categoria SET nombre=? WHERE id=?",
            [$categoria->getNombre(), $categoria->getId()]
        );

        if ($filasAfectadas = null) return null;
        else return $categoria;
    }

    public static function categoriaEliminarPorId(int $id): bool
    {
        $filasAfectadas = self::ejecutarUpdate(
            "DELETE FROM Categoria WHERE id=?",
            [$id]
        );

        return ($filasAfectadas == 1);
    }

    public static function categoriaEliminar(Categoria $categoria): bool
    {
        return self::categoriaEliminarPorId($categoria->id);
    }

    /*PERSONAS*/

    private static function personaCrearDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"], $fila["nombre"]);
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Persona WHERE id=?",
            [$id]
        );

        if ($rs) return self::personaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function personaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Persona ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $persona = self::personaCrearDesdeRs($fila);
            array_push($datos, $persona);
        }

        return $datos;
    }

    public static function personaCrear(string $nombre): ?Persona
    {
        $idAutogenerado = self::ejecutarInsert(
            "INSERT INTO Persona (nombre) VALUES (?)",
            [$nombre]
        );

        if ($idAutogenerado == null) return null;
        else return self::personaObtenerPorId($idAutogenerado);
    }

    public static function personaActualizar(Persona $persona): ?Persona
    {
        $filasAfectadas = self::ejecutarUpdate(
            "UPDATE Persona SET nombre=? WHERE id=?",
            [$persona->getNombre(), $persona->getId()]
        );

        if ($filasAfectadas = null) return null;
        else return $persona;
    }

    public static function personaEliminarPorId(int $id): bool
    {
        $filasAfectadas = self::ejecutarUpdate(
            "DELETE FROM Persona WHERE id=?",
            [$id]
        );

        return ($filasAfectadas == 1);
    }

    public static function personaEliminar(Persona $persona): bool
    {
        return self::personaEliminarPorId($persona->id);
    }
}




