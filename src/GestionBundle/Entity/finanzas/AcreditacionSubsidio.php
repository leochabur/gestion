<?php

namespace GestionBundle\Entity\finanzas;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AcreditacionSubsidio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\finanzas\AcreditacionSubsidioRepository")
 */
class AcreditacionSubsidio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     * @ORM\OrderBy({"fecha" = "DESC"})
     * @Assert\NotBlank()
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="importe", type="float")
     * @Assert\NotBlank()
     */
    private $importe;

    /**
     * @ORM\OneToMany(targetEntity="PagoSubsidio", mappedBy="acreditacion")
     */
    private $pagos;    


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return AcreditacionSubsidio
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return AcreditacionSubsidio
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pago
     *
     * @param \GestionBundle\Entity\finanzas\PagoSubsidio $pago
     *
     * @return AcreditacionSubsidio
     */
    public function addPago(\GestionBundle\Entity\finanzas\PagoSubsidio $pago)
    {
        $this->pagos[] = $pago;
        $pago->setAcreditacion($this);

        return $this;
    }

    /**
     * Remove pago
     *
     * @param \GestionBundle\Entity\finanzas\PagoSubsidio $pago
     */
    public function removePago(\GestionBundle\Entity\finanzas\PagoSubsidio $pago)
    {
        $this->pagos->removeElement($pago);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    public function __toString()
    {
        return $this->fecha->format('d/m/Y')."  $".$this->importe;
    }
}
