<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CtaCteProveedor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\CtaCteProveedorRepository")
 */
class CtaCteProveedor
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
    * @ORM\ManyToOne(targetEntity="Proveedor") 
    * @ORM\JoinColumn(name="id_proveedor", referencedColumnName="id")
    */      
    private $proveedor;  

    /**
     * @ORM\OneToMany(targetEntity="MovimientoCuenta", mappedBy="ctacte", cascade={"all"})
     * @ORM\OrderBy({"orden" = "ASC", "fecha" = "ASC", "id" = "ASC"})
     */
    private $movimientos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="muestraXImporte", type="boolean", nullable=false, options={"default"=true})
     */     

    private $muestraXImporte = true;    

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
     * Set proveedor
     *
     * @param \GestionBundle\Entity\Proveedor $proveedor
     *
     * @return CtaCteProveedor
     */
    public function setProveedor(\GestionBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \GestionBundle\Entity\Proveedor
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add movimiento
     *
     * @param \GestionBundle\Entity\MovimientoCuenta $movimiento
     *
     * @return CtaCteProveedor
     */
    public function addMovimiento(\GestionBundle\Entity\MovimientoCuenta $movimiento)
    {
        $this->movimientos[] = $movimiento;
        
        return $this;
    }

    /**
     * Remove movimiento
     *
     * @param \GestionBundle\Entity\MovimientoCuenta $movimiento
     */
    public function removeMovimiento(\GestionBundle\Entity\MovimientoCuenta $movimiento)
    {
        $this->movimientos->removeElement($movimiento);
    }

    /**
     * Get movimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    public function __toString()
    {
        return $this->proveedor."";
    }

    /**
     * Set muestraXImporte
     *
     * @param boolean $muestraXImporte
     *
     * @return CtaCteProveedor
     */
    public function setMuestraXImporte($muestraXImporte)
    {
        $this->muestraXImporte = $muestraXImporte;

        return $this;
    }

    /**
     * Get muestraXImporte
     *
     * @return boolean
     */
    public function getMuestraXImporte()
    {
        return $this->muestraXImporte;
    }
}
