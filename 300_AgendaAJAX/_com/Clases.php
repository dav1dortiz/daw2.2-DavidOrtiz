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

class Categoria extends Dato implements JsonSerializable
{
    use Identificable;

    private  $nombre;
    private  $personasPertenecientes;

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

    private  $nombre;
    private  $apellidos;
    private  $telefono;
    private  $categoriaId;
    private  $categoria;
    private  $estrella;

    public function obtenerCategoria(): Categoria
    {
        if ($this->categoria == null) $categoria = DAO::categoriaObtenerPorId($this->categoriaId);

        return $categoria;
    }

    public function __construct($id, $nombre, $apellidos, $telefono,$categoriaId, $estrella)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
        $this->setTelefono($telefono);
        //$this->setCategoriaId($categoriaId);
        $this->setCategoria($categoriaId);
        $this->setEstrella($estrella);
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "apellidos" => $this->apellidos,
            "telefono" => $this->telefono,
            "categoriaId" => $this->categoriaId,
            "categoria" => $this->categoria,
            "estrella" => $this->estrella
        ];

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

    public function getTelefono(): int
    {
        return $this->telefono;
    }
    public function setTelefono(int $telefono)
    {
        $this->telefono = $telefono;
    }

    public function getCategoriaId(): int
    {
        $this->obtenerCategoria();
    }
    public function setCategoriaId(int $categoria)
    {
        $this->categoria = $categoria;
    }

    public function getEstrella(): bool
    {
        return $this->estrella;
    }
    public function setEstrella(bool $estrella)
    {
        $this->estrella = $estrella;
    }

    public function getCategoria(): Categoria
    {
        return $this->obtenerCategoria();
    }
    public function setCategoria(int $categoriaId)
    {
        $this->categoria = $categoriaId;
    }

}
