<?php
namespace GestionBundle\Entity\personal;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//include 'ConceptoLiquidacion.php';
/**
 * PagoConductor
 *
 * @ORM\Table(name="pagoconductores")
 * @ORM\Entity
 */
 

class PagoConductor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodo_mes", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $mes;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodo_anio", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $anio;

    /**
     * @var string
     *
     * @ORM\Column(name="monto_percibido", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity="Conductor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_conductor", referencedColumnName="id", nullable=true)
     * })
     */
    private $conductor;
    
    /**
     * @ORM\ManyToMany(targetEntity="ConceptoLiquidacion")
     * @ORM\JoinTable(name="conceptosxpagos",
     *      joinColumns={@ORM\JoinColumn(name="id_pagoconductor", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_conceptoliquidacion", referencedColumnName="id")}
     *      )
     */
    private $conceptos;
    
    
    public function __construct() {
        $this->conceptos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    public function getMes()
    {
        return $this->mes;
    }

    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function setConductor(\Conductor $conductor = null)
    {
        $this->conductor = $conductor;

        return $this;
    }

    public function getConductor()
    {
        return $this->conductor;
    }
    
    public function setConceptos($conceptos)
    {
        $this->conceptos = $conceptos;
    }

    public function getConceptos()
    {
        return $this->conceptos;
    }
    
    public function show()
    {
           return strtoupper($this->conductor->getApellido().", ".$this->conductor->getNombre()." (".$this->mes."/".$this->anio.")");
    }
    
    public function addConcepto(\ConceptoLiquidacion $concepto)
    {
        $this->conceptos[] = $concepto;
    }
    
    public function deleteConcepto(\ConceptoLiquidacion $concepto)
    {
        $this->conceptos->removeElement($concepto);
    }
    
    public function getMontos(){
           $ing=0;
           $egr=0;
           $saldo=0;
           foreach ($this->getConceptos() as $concepto){
               if ($concepto->getConcepto()->getCalculaSueldo())
               {
                   if ($concepto->getConcepto()->getSuma()){
                      $ing+=$concepto->getImporte();
                   }
                   else{
                        $egr+=$concepto->getImporte();
                   }
               }
           
           }
           return array('i'=>$ing, 'e'=>$egr, 's'=>($ing-$egr));
    }

    /**
     * Remove concepto
     *
     * @param \GestionBundle\Entity\personal\ConceptoLiquidacion $concepto
     */
    public function removeConcepto(\GestionBundle\Entity\personal\ConceptoLiquidacion $concepto)
    {
        $this->conceptos->removeElement($concepto);
    }
}
