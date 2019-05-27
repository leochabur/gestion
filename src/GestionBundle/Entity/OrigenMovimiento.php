<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrigenMovimiento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OrigenMovimiento
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="afectaCtaCte", type="boolean")
     */
    private $afectaCtaCte;    


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return OrigenMovimiento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    public function __toString()
    {
        return strtoupper($this->nombre);
    }

    /**
     * Set afectaCtaCte
     *
     * @param boolean $afectaCtaCte
     *
     * @return OrigenMovimiento
     */
    public function setAfectaCtaCte($afectaCtaCte)
    {
        $this->afectaCtaCte = $afectaCtaCte;

        return $this;
    }

    /**
     * Get afectaCtaCte
     *
     * @return boolean
     */
    public function getAfectaCtaCte()
    {
        return $this->afectaCtaCte;
    }
}
