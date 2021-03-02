<?php
require_once "Clases.php";
require_once "Utilidades.php";

class Dao
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "agenda"; // Schema
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

    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);
        if (!$sqlConExito) return null;
        return $actualizacion->rowCount();
    }


    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta("SELECT * FROM categoria WHERE id=?", [$id]);
        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaActualizar($id, $nombre)
    {
        self::ejecutarActualizacion("UPDATE categoria SET nombre=? WHERE id=?", [$nombre, $id]);
    }

    public static function categoriaCrear(string $nombre)
    {
        self::ejecutarActualizacion("INSERT INTO categoria (nombre) VALUES (?)", [$nombre]);
    }

    public static function categoriaObtenerTodas(): ?array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM categoria ORDER BY nombre", []);
        foreach ($rs as $fila) {
            $categoria=self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }
        return $datos;
    }

    public static  function  categoriaEliminar($id): ?int
    {
        $rs=self::ejecutarConsulta("DELETE FROM categoria WHERE id=?", []);
    }
    /*--------------------------------------------------------------------------------------*/
    /* PERSONA */
    private static function personaCrearDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"],       $fila["nombre"],      $fila["apellidos"],
            $fila["telefono"], $fila["categoriaId"], $fila["estrella"]);
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {
        $rs = self::ejecutarConsulta("SELECT * FROM persona WHERE id=?", [$id]);
        if ($rs) return self::personaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function personaActualizar($id, $nombre, $apellidos, $telefono, $categoriaId, $estrella)
    {
        self::ejecutarActualizacion(
            "UPDATE persona SET nombre=?,apellidos=?,telefono=?,categoriaId=?,estrella=? WHERE id=?",
            [$nombre, $id, $apellidos, $telefono, $categoriaId, $estrella]);
    }

    public static function personaCrear(string $nombre, string $apellidos, int $telefono, int $categoriaId, bool $estrella)
    {
        self::ejecutarActualizacion(
            "INSERT INTO persona (nombre,apellidos,telefono,categoriaId,estrella) VALUES (?,?,?,?,?)",
            [$nombre, $apellidos, $telefono, $categoriaId, $estrella]);
    }

    public static function personaObtenerTodas(): ?array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM persona ORDER BY nombre", []);
        foreach ($rs as $fila) {
            $persona=self::personaCrearDesdeRs($fila);
            array_push($datos, $persona);
        }

        return $datos;
    }

    public static  function  personaEliminar($id): ?int
    {
        $rs=self::ejecutarConsulta("DELETE FROM persona WHERE id=?", []);;
    }


}
