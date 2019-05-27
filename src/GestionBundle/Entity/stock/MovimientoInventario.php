<?php

namespace GestionBundle\Entity\stock;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MovimientoInventario
 *
 * @ORM\Table(name="norm_movimiento_inventario")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1:"MovimientoInventario", 2:"OrdenCompra"})
 */
abstract class MovimientoInventario
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
     * @var date
     *
     * @ORM\Column(name="fecha", type="date")
    * @Assert\NotNull
     */
    private $fecha;

    /**
     * @ORM\OneToMany(targetEntity="ItemMovimiento", mappedBy="movimiento")
     */
    private $items;  

    /**
    * @ORM\ManyToOne(targetEntity="GestionUsuariosBundle\Entity\Usuario") 
    * @ORM\JoinColumn(name="id_usuario_carga", referencedColumnName="id")
    */    
    private $usuarioCarga;

    /**
    * @ORM\ManyToOne(targetEntity="GestionUsuariosBundle\Entity\Usuario") 
    * @ORM\JoinColumn(name="id_usuario_autorizante", referencedColumnName="id", nullable=true)
    */    
    private $usuarioAutorizante;  

    /**
    * @ORM\ManyToOne(targetEntity="GestionUsuariosBundle\Entity\Usuario") 
    * @ORM\JoinColumn(name="id_usuario_eliminante", referencedColumnName="id", nullable=true)
    */    
    private $usuarioElimino;     

    /**
     * @ORM\Column(type="boolean", name="eliminada", nullable=false, options={"default":false})
     */
    private $eliminada = false;    

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
     * @return MovimientoInventario
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
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add item
     *
     * @param \GestionBundle\Entity\stock\ItemMovimiento $item
     *
     * @return MovimientoInventario
     */
    public function addItem(\GestionBundle\Entity\stock\ItemMovimiento $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \GestionBundle\Entity\stock\ItemMovimiento $item
     */
    public function removeItem(\GestionBundle\Entity\stock\ItemMovimiento $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }



   

    /**
     * Set usuarioCarga
     *
     * @param \GestionUsuariosBundle\Entity\Usuario $usuarioCarga
     *
     * @return MovimientoInventario
     */
    public function setUsuarioCarga(\GestionUsuariosBundle\Entity\Usuario $usuarioCarga = null)
    {
        $this->usuarioCarga = $usuarioCarga;

        return $this;
    }

    /**
     * Get usuarioCarga
     *
     * @return \GestionUsuariosBundle\Entity\Usuario
     */
    public function getUsuarioCarga()
    {
        return $this->usuarioCarga;
    }

    /**
     * Set usuarioAutorizante
     *
     * @param \GestionUsuariosBundle\Entity\Usuario $usuarioAutorizante
     *
     * @return MovimientoInventario
     */
    public function setUsuarioAutorizante(\GestionUsuariosBundle\Entity\Usuario $usuarioAutorizante = null)
    {
        $this->usuarioAutorizante = $usuarioAutorizante;

        return $this;
    }

    /**
     * Get usuarioAutorizante
     *
     * @return \GestionUsuariosBundle\Entity\Usuario
     */
    public function getUsuarioAutorizante()
    {
        return $this->usuarioAutorizante;
    }

    /**
     * Set eliminada
     *
     * @param boolean $eliminada
     *
     * @return MovimientoInventario
     */
    public function setEliminada($eliminada)
    {
        $this->eliminada = $eliminada;

        return $this;
    }

    /**
     * Get eliminada
     *
     * @return boolean
     */
    public function getEliminada()
    {
        return $this->eliminada;
    }

    /**
     * Set usuarioElimino
     *
     * @param \GestionUsuariosBundle\Entity\Usuario $usuarioElimino
     *
     * @return MovimientoInventario
     */
    public function setUsuarioElimino(\GestionUsuariosBundle\Entity\Usuario $usuarioElimino = null)
    {
        $this->usuarioElimino = $usuarioElimino;

        return $this;
    }

    /**
     * Get usuarioElimino
     *
     * @return \GestionUsuariosBundle\Entity\Usuario
     */
    public function getUsuarioElimino()
    {
        return $this->usuarioElimino;
    }
}
