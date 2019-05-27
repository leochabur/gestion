<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoDesperfecto
 *
 * @ORM\Table(name="norm_tipodesperfecto")
 * @ORM\Entity
 */
class TipoDesperfecto
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
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;


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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return TipoDesperfecto
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function __toString()
    {
        return $this->tipo;
    }

    /**
     * Set tipoDesperfecto
     *
     * @param \GestionBundle\Entity\taller\TipoDesperfecto $tipoDesperfecto
     *
     * @return TipoDesperfecto
     */
    public function setTipoDesperfecto(\GestionBundle\Entity\taller\TipoDesperfecto $tipoDesperfecto = null)
    {
        $this->tipoDesperfecto = $tipoDesperfecto;

        return $this;
    }

    /**
     * Get tipoDesperfecto
     *
     * @return \GestionBundle\Entity\taller\TipoDesperfecto
     */
    public function getTipoDesperfecto()
    {
        return $this->tipoDesperfecto;
    }
}
