<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SalidaStock
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SalidaStock extends MovimientoStock
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
    * @ORM\ManyToOne(targetEntity="Unidad") 
    * @ORM\JoinColumn(name="id_unidad", referencedColumnName="id")
    */      
    private $unidad;  

    /**
     * Get id
     *
     * @return integer
     */
    /*public function getId()
    {
        return $this-*>id;
    }*/

    /**
     * Set unidad
     *
     * @param \GestionBundle\Entity\Unidad $unidad
     *
     * @return SalidaStock
     */
    public function setUnidad(\GestionBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \GestionBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    public function getMovimiento()
    {
        return "Salida";
    }    

    public function getCoche()
    {
        return $this->unidad;
    }     

    public function getIngreso()
    {
        return 0;
    }

    public function getEgreso()
    {
        return $this->getCantidad();;
    }    

    public function getSaldo()
    {
        
    }    

    public function updatePrecioArticulo() ///a
    {
        $this->setPrecioUnitario($this->getArticulo()->getUltimoPrecio());
    }    
}
