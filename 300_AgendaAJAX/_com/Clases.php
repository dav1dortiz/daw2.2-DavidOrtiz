<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Categoria extends Dato implements JsonSerializable
{
    use Identificable;

    private string $nombre;
    private array $personasPertenecientes;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function jsonSerialize()
    {
        return [
            "nombre" => $this->nombre,
            "id" => $this->id,
        ];

        // Esto sería lo mismo:
        //$array["nombre"] = $this->nombre;
        //$array["id"] = $this->id;
        //return $array;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function obtenerPersonasPertenecientes(): array
    {
        if ($this->personasPertenecientes == null) $personasPertenecientes = DAO::personaObtenerPorCategoria($this->id);

        return $personasPertenecientes;
    }
}

class Persona extends Dato implements JsonSerializable
{
    use Identificable;

    private string $nombre;
    private string $apellidos;
    // ...
    private int $personaId;
    private Persona $persona;

    public function jsonSerialize()
    {
        return [
            "nombre" => $this->nombre,
            "id" => $this->id,
        ];

        // Esto sería lo mismo:
        //$array["nombre"] = $this->nombre;
        //$array["id"] = $this->id;
        //return $array;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function obtenerPersonasPertenecientes(): array
    {
        if ($this->personasPertenecientes == null) $personasPertenecientes = DAO::personaObtenerPorCategoria($this->id);

        return $personasPertenecientes;
    }
}
