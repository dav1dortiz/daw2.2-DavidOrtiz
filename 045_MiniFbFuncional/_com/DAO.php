<?php
require_once "_com/Clases.php";
require_once "_com/_Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "MiniFb";
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
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }



    /* USUARIO */

    private static function usuarioCrearDesdeRs(array $fila): Usuario
    {
        return new Usuario($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["identificador"], $fila["contrasenna"]);
    }

    public static function usuarioObtenerPorId(int $id): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario WHERE id=?",
            [$id]
        );
        if ($rs) return self::crearUsuarioDesdeRs($rs[0]);
        else return null;
    }

    public static function usuarioActualizar($id, $nombre, $apellidos)
    {
        self::ejecutarActualizacion(
            "UPDATE Usuario SET nombre=?, apellidos=? WHERE id=?",
            [$nombre, $apellidos, $id]
        );
    }

    public static function usuarioCrear(string $nombre, string $apellidos, string $identificador, string $contrasenna)
    {
        self::ejecutarActualizacion(
            "INSERT INTO Usuario (nombre,apellidos,identificador,contrasenna) VALUES (?,?,?,?)",
            [$nombre, $apellidos, $identificador, $contrasenna]
        );
    }

    public static function usuarioObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $usuario = self::usuarioCrearDesdeRs($fila);
            array_push($datos, $usuario);
        }

        return $datos;
    }

    /* PUBLICACION */

    private static function publicacionCrearDesdeRs(array $fila): Publicacion
    {
        return new Publicacion($fila["id"], new DateTime($fila["fecha"]), $fila["emisorId"],
            $fila["destinatarioId"],  $fila["destacadaHasta"],
            $fila["asunto"],          $fila["contenido"]);
    }

    public static function publicacionObtenerPorId(int $id): ?Publicacion
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion WHERE id=?",
            [$id]
        );
        if ($rs) return self::crearPublicacionDesdeRs($rs[0]);
        else return null;
    }

    public static function publicacionActualizar($fecha, $asunto, $contenido, $idPublicacion)
    {
        self::ejecutarActualizacion(
            "UPDATE Publicacion SET fecha=?, asunto=?, contenido=? WHERE id=?",
            [$fecha, $asunto, $contenido, $idPublicacion]
        );
    }

    public static function publicacionCrear(int $idPublicacion, timestamp $fecha, int $emisorId, int $destinatarioId,
                                            timestamp $destacadaHasta, string $asunto, string $contenido)
    {
        self::ejecutarActualizacion(
            "INSERT INTO Publicacion (id,fecha,emisorId,destinatarioId,destacadaHasta,asunto,contenido)
                 VALUES (?,?,?,?,?,?,?)",
            [$idPublicacion, $fecha, $emisorId, $destinatarioId, $destacadaHasta, $asunto, $contenido]
        );
    }

    public static function publicacionObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion ORDER BY id",
            []
        );

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }

    public static function publicacionObtenerSinDestinatario(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion WHERE destinatarioId IS NULL ORDER BY fecha"
            ,[]);

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }

    public static function publicacionObtenerPrivado(int $id): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM Publicacion WHERE destinatarioId=? ORDER BY fecha",[$id]);

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }

}