<?php

namespace GestionBundle\Entity\finanzas;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArchivoSubsidio
 */
class ArchivoSubsidio
{
    // ...

    /**
     *
     * @Assert\NotBlank(message="Por seleccione el archivo")
     * @Assert\File
     */
    private $archivo;

      /**
     * @var integer
     *
     * @ORM\Column(name="periodo_mes", type="integer")
     */
    private $periodoMes;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodo_anio", type="integer")
     */
    private $periodoAnio;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_pago", type="integer")
     */
    private $numeroPago;    


    public function getArchivo()
    {
        return $this->archivo;
    }

    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
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

}