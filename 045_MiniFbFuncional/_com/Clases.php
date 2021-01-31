<?php

abstract class Dato
{
}

trait Identificable
{
    protected  $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Usuario extends Dato
{
    use Identificable;

    private $nombre;
    private $apellidos;
    private $identificador;
    private $contrasenna;
    private $codigoCookie;
    private $caducidadCodigoCookie;

    public function __construct(int $id, string $nombre, string $apellidos, string $identificador, string $contrasenna)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
        $this->setIdentificador($identificador);
        $this->setContrasenna($contrasenna);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador)
    {
        $this->identificador = $identificador;
    }

    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }

    public function setContrasenna(string $contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }
}

class Publicacion extends Dato
{
    use Identificable;

    private $idPublicacion;
    private $fecha;
    private $emisorId;
    private $destinatarioId;
    private $destacadaHasta;
    private $asunto;
    private $contenido;

    public function __construct(int $idPublicacion, DateTime $fecha, int $emisorId,  $destinatarioId,
                                $destacadaHasta, string $asunto, string $contenido)
    {
        $this->setIdPublicacion($idPublicacion);
        $this->setFecha($fecha);
        $this->setEmisorId($emisorId);
        //$this->setDestinatarioId($destinatarioId);
        $this->destinatarioId=$destinatarioId;
        //$this->setDestacadaHasta($destacadaHasta);
        $this->destacadaHasta=$destacadaHasta;
        $this->setAsunto($asunto);
        $this->setContenido($contenido);
    }

    public function getIdPublicacion(): int
    {
        return $this->idPublicacion;
    }

    public function setIdPublicacion(int $idPublicacion)
    {
        $this->idPublicacion = $idPublicacion;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEmisorId(): int
    {
        return $this->emisorId;
    }

    public function setEmisorId(int $emisorId)
    {
        $this->emisorId = $emisorId;
    }

    public function getDestinatarioId():  int
    {
        if ($this->destinatarioId != null)
            return $this->destinatarioId;
        else
            return 0;
        //  HE MODIFICADO ESTO PARA QUE CUANDO EL DESTINATARIO DEL MENSAJE SEA NULL QUE LO PONGA A 0 EN LUGAR DE NULL
    }

    public function setDestinatarioId(int $destinarioId)
    {
        if ($destinarioId!=null)
            $this->destinatarioId = $destinarioId;
        else if ($destinarioId==null)
            $this->destinatarioId = null;

    }

    public function getDestacadaHasta(): DateTime
    {
        return $this->destacadaHasta;
    }

    public function setDestacadaHasta(DateTime $destacadoHasta)
    {
        if ($destacadoHasta!=null)
            $this->destacadaHasta = $destacadoHasta;
        elseif ($destacadoHasta==null)
            $this->destacadaHasta = null;
    }

    public function getAsunto(): string
    {
        return $this->asunto;
    }

    public function setAsunto(string $asunto)
    {
        $this->asunto = $asunto;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }

    public function setContenido(String $contenido)
    {
        $this->contenido = $contenido;
    }

}
