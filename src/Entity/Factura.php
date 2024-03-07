<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idFactura = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\ManyToOne(inversedBy: 'factura')]
    #[ORM\JoinColumn(nullable: false, name: "idEmpleado", referencedColumnName: "id")]
    private ?Empleado $idEmpleado = null;

    #[ORM\Column]
    private ?bool $estadoPago = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaEmision = null;

    public function getIdFactura(): ?int
    {
        return $this->idFactura;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getIdEmpleado(): ?Empleado
    {
        return $this->idEmpleado;
    }

    public function setIdEmpleado(?Empleado $idEmpleado): static
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

    public function isEstadoPago(): ?bool
    {
        return $this->estadoPago;
    }

    public function setEstadoPago(bool $estadoPago): static
    {
        $this->estadoPago = $estadoPago;

        return $this;
    }

    public function getFechaEmision(): ?\DateTimeInterface
    {
        return $this->fechaEmision;
    }

    public function setFechaEmision(\DateTimeInterface $fechaEmision): static
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }
}
