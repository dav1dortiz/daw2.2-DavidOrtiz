<?php

require_once "_com/Clases.php";
require_once "_com/Varios.php";

class DAO
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

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta("SELECT * FROM categoria ORDER BY nombre",[]);

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }

    public static function categoriaCrear(string $nombre): ?Categoria
    {
        $idAutogenerado = self::ejecutarInsert("INSERT INTO categoria (nombre) VALUES (?)", [$nombre]);

        if ($idAutogenerado == null) return null;
        else return self::categoriaObtenerPorId($idAutogenerado);
    }

    public static function categoriaActualizar(Categoria $categoria): ?Categoria
    {
        $filasAfectadas = self::ejecutarUpdate("UPDATE categoria SET nombre=? WHERE id=?",
            [$categoria->getNombre(), $categoria->getId()]);

        if ($filasAfectadas = null) return null;
        else return $categoria;
    }

    public static function categoriaEliminarPorId(int $id): bool
    {
        $filasAfectadas = self::ejecutarUpdate("DELETE FROM categoria WHERE id=?", [$id]);

        return ($filasAfectadas == 1);
    }

    public static function categoriaEliminar(Categoria $categoria): bool
    {
        return self::categoriaEliminarPorId($categoria->id);
    }

    /* PERSONA */

    private static function personaCrearDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["telefono"],
            $fila["categoriaId"], $fila["estrella"]);
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {
        $rs = self::ejecutarConsulta("SELECT * FROM persona WHERE id=?", [$id]);

        if ($rs) return self::personaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function personaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta("SELECT * FROM persona ORDER BY nombre", []);

        foreach ($rs as $fila) {
            $persona = self::personaCrearDesdeRs($fila);
            array_push($datos, $persona);
        }

        return $datos;
    }
    //bool $estrella --> probar a meter este parametro
    //string $apellidos, int $telefono, int $categoriaId
    public static function personaCrear(string $nombre, string $apellidos, int $telefono, int $categoriaId): ?Persona
    {
        $idAutogenerado = self::ejecutarInsert(
            "INSERT INTO persona (nombre,apellidos,telefono,categoriaId) VALUES (?,?,?,?)",
            [$nombre,$apellidos,$telefono,$categoriaId]
        );

        if ($idAutogenerado == null) return null;
        else return self::personaObtenerPorId($idAutogenerado);
    }

    public static function personaActualizar(Persona $persona): ?Persona
    {
        $filasAfectadas = self::ejecutarUpdate(
            "UPDATE persona SET nombre=?, apellidos=?, telefono=?, categoriaId=? WHERE id=?",
            [$persona->getNombre(), $persona->getApellidos(), $persona->getTelefono(),
                $persona->getCategoriaId(), $persona->getId()]
        );

        if ($filasAfectadas = null) return null;
        else return $persona;
    }
    /* ??? CREAR personaActualizarNombre, personaActualizarApellido...*/

    public static function personaEliminarPorId(int $id): bool
    {
        $filasAfectadas = self::ejecutarUpdate(
            "DELETE FROM persona WHERE id=?",
            [$id]
        );

        return ($filasAfectadas == 1);
    }

    public static function personaEliminar(Persona $persona): bool
    {
        return self::personaEliminarPorId($persona->id);
    }
}
