<?php

namespace GestionBundle\Entity\finanzas;

use Doctrine\ORM\Mapping as ORM;

/**
 * CupoMensual
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CupoMensual extends FormaPago
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function cargarCuentaExterna($credito)
    {

    }

    public function getProveedorExterno()
    {

    }    

    public function __toString()
    {
        return "Inicializacion Cupo Mensual";
    }
}
