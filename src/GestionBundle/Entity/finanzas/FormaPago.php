<?php

namespace GestionBundle\Entity\finanzas;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormaPago
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1:"FormaPago", 2:"TarjetaPrepago", 3:"CupoMensual", 4:"ValoresTerceros"}) 
 */
abstract class FormaPago
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

    public abstract function cargarCuentaExterna($credito);
    public abstract function getProveedorExterno();
}
