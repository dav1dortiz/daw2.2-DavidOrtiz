<?php

abstract class Dato
{
}

trait Identificable
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Categoria extends Dato {
    use Identificable;

    private  $nombre;

    public function __construct($id, $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

}

class Persona extends Dato
{
    use Identificable;

    private $nombre;
    private $apellidos;
    private $telefono;
    private $categoriaId;
    private $estrella;

    function __construct(int $id=null, string $nombre, string $apellidos, int $telefono, int $categoriaId, bool $estrella)
    {
        if ($id != null && $nombre == null) {
            DAO::personaObtenerPorId($id);
        } else if ($id == null && $nombre != null) { // Crear en BD
            DAO::personaCrear($nombre, $apellidos,$telefono,$categoriaId,$estrella);
        } else {
            $this->id = $id;
            $this->nombre = $nombre;
        }
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getTelefono(): float
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): int
    {
        $this->telefono = $telefono;
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(int $categoriaId): int
    {
        $this->categoriaId = $categoriaId;
    }

    public function getEstrella(): bool
    {
        return $this->estrella;
    }

    public function setEstrella(bool $estrella): bool
    {
        $this->estrella = $estrella;
    }
}

