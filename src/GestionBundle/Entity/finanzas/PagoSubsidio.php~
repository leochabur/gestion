<?php

namespace GestionBundle\Entity\finanzas;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PagoSubsidio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\finanzas\PagoSubsidioRepository")
 */
class PagoSubsidio
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
     * @var integer
     *
     * @ORM\Column(name="periodo_mes", type="integer")
     * @Assert\NotBlank()
     */
    private $periodoMes;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodo_anio", type="integer")
     * @Assert\NotBlank()
     */
    private $periodoAnio;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_pago", type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $numeroPago;    

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $concepto;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float")
     * @Assert\NotBlank()
     */
    private $monto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="date", nullable=true)
     */
    private $fechaIngreso;

    /**
     * @var boolean
     *
     * @ORM\Column(name="percibido", type="boolean", nullable=false, options={"default":false})
     */
    private $percibido = false;

    /**
     * @ORM\ManyToOne(targetEntity="AcreditacionSubsidio", inversedBy="pagos")
     * @ORM\JoinColumn(name="id_acreditacion", referencedColumnName="id")
     */
    private $acreditacion;


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
     * Set periodoMes
     *
     * @param integer $periodoMes
     *
     * @return PagoSubsidio
     */
    public function setPeriodoMes($periodoMes)
    {
        $this->periodoMes = $periodoMes;

        return $this;
    }

    /**
     * Get periodoMes
     *
     * @return integer
     */
    public function getPeriodoMes()
    {
        return $this->periodoMes;
    }

    /**
     * Set periodoAnio
     *
     * @param integer $periodoAnio
     *
     * @return PagoSubsidio
     */
    public function setPeriodoAnio($periodoAnio)
    {
        $this->periodoAnio = $periodoAnio;

        return $this;
    }

    /**
     * Get periodoAnio
     *
     * @return integer
     */
    public function getPeriodoAnio()
    {
        return $this->periodoAnio;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return PagoSubsidio
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set monto
     *
     * @param float $monto
     *
     * @return PagoSubsidio
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return PagoSubsidio
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set percibido
     *
     * @param boolean $percibido
     *
     * @return PagoSubsidio
     */
    public function setPercibido($percibido)
    {
        $this->percibido = $percibido;

        return $this;
    }

    /**
     * Get percibido
     *
     * @return boolean
     */
    public function getPercibido()
    {
        return $this->percibido;
    }

    /**
     * Set numeroPago
     *
     * @param integer $numeroPago
     *
     * @return PagoSubsidio
     */
    public function setNumeroPago($numeroPago)
    {
        $this->numeroPago = $numeroPago;

        return $this;
    }

    /**
     * Get numeroPago
     *
     * @return integer
     */
    public function getNumeroPago()
    {
        return $this->numeroPago;
    }


    /**
     * Set acreditacion
     *
     * @param \GestionBundle\Entity\finanzas\AcreditacionSubsidio $acreditacion
     *
     * @return PagoSubsidio
     */
    public function setAcreditacion(\GestionBundle\Entity\finanzas\AcreditacionSubsidio $acreditacion = null)
    {
        $this->acreditacion = $acreditacion;

        return $this;
    }

    /**
     * Get acreditacion
     *
     * @return \GestionBundle\Entity\finanzas\AcreditacionSubsidio
     */
    public function getAcreditacion()
    {
        return $this->acreditacion;
    }
}
