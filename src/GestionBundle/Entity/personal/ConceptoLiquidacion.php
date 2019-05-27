<?php
namespace GestionBundle\Entity\personal;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="conceptosliquidacion")
 * @ORM\Entity
 */
class ConceptoLiquidacion
{
    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="descripcion", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    private $descripcion;

    /**
    * @ORM\Column(name="cant_unidades", type="integer")
    */
    private $cantidad;
    
    /**
     * @ORM\Column(name="importe", type="float")
     */
    private $importe;
    
    /**
     * @ORM\Column(name="unitario", type="float")
     */
    private $unitario;
    
    /**
     * @ORM\ManyToOne(targetEntity="ConceptoPago")
     * @ORM\JoinColumn(name="id_concepto", referencedColumnName="id")
     */
    private $concepto;
    
    /**
     * @ORM\ManyToOne(targetEntity="AplicacionConcepto")
     * @ORM\JoinColumn(name="id_aplicacion", referencedColumnName="id")
     */
    private $aplicacion;
    
    
    public function __construct($des, $cant, $uni, $tot, $con, $apli) {
        $this->descripcion = $des;
        $this->cantidad = $cant;
        $this->importe = $tot;
        $this->unitario = $uni;
        $this->concepto = $con;
        $this->aplicacion = $apli;
    }
    

    public function getId()
    {
        return $this->id;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
    
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    public function getImporte()
    {
        return $this->importe;
    }
    
    public function setUnitario($unitario)
    {
        $this->unitario = $unitario;
    }

    public function getUnitario()
    {
        return $this->unitario;
    }
    
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
    }

    public function getConcepto()
    {
        return $this->concepto;
    }
    
    public function setAplicacion($aplicacion)
    {
        $this->aplicacion = $aplicacion;
    }

    public function getAplicacion()
    {
        return $this->aplicacion;
    }
}
