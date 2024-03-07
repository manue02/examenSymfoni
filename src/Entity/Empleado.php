<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpleadoRepository::class)]
class Empleado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\OneToMany(targetEntity: Servicio::class, mappedBy: 'idEmpleado')]
    private Collection $servicio;

    #[ORM\OneToMany(targetEntity: Factura::class, mappedBy: 'idEmpleado')]
    private Collection $factura;

    #[ORM\Column(length: 50)]
    private ?string $puesto = null;

    #[ORM\Column(length: 50)]
    private ?string $apellido = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    public function __construct()
    {
        $this->servicio = new ArrayCollection();
        $this->factura = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Servicio>
     */
    public function getServicio(): Collection
    {
        return $this->servicio;
    }

    public function addServicio(Servicio $servicio): static
    {
        if (!$this->servicio->contains($servicio)) {
            $this->servicio->add($servicio);
            $servicio->setIdEmpleado($this);
        }

        return $this;
    }

    public function removeServicio(Servicio $servicio): static
    {
        if ($this->servicio->removeElement($servicio)) {
            // set the owning side to null (unless already changed)
            if ($servicio->getIdEmpleado() === $this) {
                $servicio->setIdEmpleado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Factura>
     */
    public function getFactura(): Collection
    {
        return $this->factura;
    }

    public function addFactura(Factura $factura): static
    {
        if (!$this->factura->contains($factura)) {
            $this->factura->add($factura);
            $factura->setIdEmpleado($this);
        }

        return $this;
    }

    public function removeFactura(Factura $factura): static
    {
        if ($this->factura->removeElement($factura)) {
            // set the owning side to null (unless already changed)
            if ($factura->getIdEmpleado() === $this) {
                $factura->setIdEmpleado(null);
            }
        }

        return $this;
    }

    public function getPuesto(): ?string
    {
        return $this->puesto;
    }

    public function setPuesto(string $puesto): static
    {
        $this->puesto = $puesto;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
