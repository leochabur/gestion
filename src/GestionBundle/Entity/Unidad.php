<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unidad
 *
 * @ORM\Table(name="coches")
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\UnidadRepository")
 */
class Unidad
{
    /**
     * @var bigint
     *
     * @ORM\Column(name="id", type="bigint", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="modelo", type="integer", length=255, nullable=true)
     */
    private $modelo;   

    /**
     * @var float
     *
     * @ORM\Column(name="consumo", type="float", nullable=true)
     */
    private $consumo;     

    /**
     * @var string
     *
     * @ORM\Column(name="interno", type="string", length=255, nullable=true)
     */
    private $interno;

    /**
     * @var string
     *
     * @ORM\Column(name="patente", type="string", length=255, nullable=true)
     */
    private $patente;

    /**
     * @var string
     *
     * @ORM\Column(name="chasisMarca", type="string", length=255, nullable=true)
     */
    private $chasisMarca;

    /**
     * @var string
     *
     * @ORM\Column(name="chasisModelo",type="string", length=255, nullable=true)
     */
    private $chasisModelo;    

    /**
     * @var string
     *
     * @ORM\Column(name="chasisNumero",type="string", length=255, nullable=true)
     */
    private $chasisNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="motorMarca",type="string", length=255, nullable=true)
     */
    private $motorMarca;

    /**
     * @var string
     *
     * @ORM\Column(name="motorModelo",type="string", length=255, nullable=true)
     */
    private $motorModelo;    

    /**
     * @var string
     *
     * @ORM\Column(name="motorNumero",type="string", length=255, nullable=true)
     */
    private $motorNumero;    

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroCilindros",nullable=true)
     */
    private $numeroCilindros;    

    /**
     * @var float
     *
     * @ORM\Column(name="cilindrada",type="float", nullable=true)
     */
    private $cilindrada;    

    /**
     * @var string
     *
     * @ORM\Column(name="carroMarca",type="string", length=255, nullable=true)
     */
    private $carroMarca;

            /**
     * @var string
     *
     * @ORM\Column(name="carroModelo",type="string", length=255, nullable=true)
     */
    private $carroModelo;    

    /**
     * @var string
     *
     * @ORM\Column(name="carroNumero",type="string", length=255, nullable=true)
     */
    private $carroNumero;       
     
    /**
     * @var integer
     *
     * @ORM\Column(name="carroCapacidad",type="integer", nullable=true)
     */
    private $carroCapacidad;  

    /**
     * @var boolean
     *
     * @ORM\Column(name="carroBar",type="boolean",  nullable=true)
     */
    private $carroBar;               

    /**
     * @var boolean
     *
     * @ORM\Column(name="carroVideo",type="boolean",  nullable=true)
     */
    private $carroVideo; 

    /**
     * @var boolean
     *
     * @ORM\Column(name="carroAC",type="boolean",  nullable=true)
     */
    private $carroAC; 

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $micro;    

    /**
     * @var bigint
     *
     * @ORM\Column(name="tipo_gasoil", type="bigint", nullable=true)
     */
    private $tipoGasOil;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $turismo;      

    /**
     * @var boolean
     *
     * @ORM\Column(name="charter", type="boolean")
     */
    private $charter;    


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
     * Set dominio
     *
     * @param string $dominio
     *
     * @return Unidad
     */
    public function setPatente($dominio)
    {
        $this->patente = $dominio;

        return $this;
    }

    /**
     * Get dominio
     *
     * @return string
     */
    public function getPatente()
    {
        return $this->patente;
    }

    /**
     * Set interno
     *
     * @param string $interno
     *
     * @return Unidad
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;

        return $this;
    }

    /**
     * Get interno
     *
     * @return string
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set consumo
     *
     * @param float $consumo
     *
     * @return Unidad
     */
    public function setConsumo($consumo)
    {
        $this->consumo = $consumo;

        return $this;
    }

    /**
     * Get consumo
     *
     * @return float
     */
    public function getConsumo()
    {
        return $this->consumo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Unidad
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    public function __toString()
    {
        return $this->interno."";
    }

    /**
     * Set charter
     *
     * @param boolean $charter
     *
     * @return Unidad
     */
    public function setCharter($charter)
    {
        $this->charter = $charter;

        return $this;
    }

    /**
     * Get charter
     *
     * @return boolean
     */
    public function getCharter()
    {
        return $this->charter;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Unidad
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set modelo
     *
     * @param integer $modelo
     *
     * @return Unidad
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return integer
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set chasisMarca
     *
     * @param string $chasisMarca
     *
     * @return Unidad
     */
    public function setChasisMarca($chasisMarca)
    {
        $this->chasisMarca = $chasisMarca;

        return $this;
    }

    /**
     * Get chasisMarca
     *
     * @return string
     */
    public function getChasisMarca()
    {
        return $this->chasisMarca;
    }

    /**
     * Set chasisModelo
     *
     * @param string $chasisModelo
     *
     * @return Unidad
     */
    public function setChasisModelo($chasisModelo)
    {
        $this->chasisModelo = $chasisModelo;

        return $this;
    }

    /**
     * Get chasisModelo
     *
     * @return string
     */
    public function getChasisModelo()
    {
        return $this->chasisModelo;
    }

    /**
     * Set chasisNumero
     *
     * @param string $chasisNumero
     *
     * @return Unidad
     */
    public function setChasisNumero($chasisNumero)
    {
        $this->chasisNumero = $chasisNumero;

        return $this;
    }

    /**
     * Get chasisNumero
     *
     * @return string
     */
    public function getChasisNumero()
    {
        return $this->chasisNumero;
    }

    /**
     * Set motorMarca
     *
     * @param string $motorMarca
     *
     * @return Unidad
     */
    public function setMotorMarca($motorMarca)
    {
        $this->motorMarca = $motorMarca;

        return $this;
    }

    /**
     * Get motorMarca
     *
     * @return string
     */
    public function getMotorMarca()
    {
        return $this->motorMarca;
    }

    /**
     * Set motorModelo
     *
     * @param string $motorModelo
     *
     * @return Unidad
     */
    public function setMotorModelo($motorModelo)
    {
        $this->motorModelo = $motorModelo;

        return $this;
    }

    /**
     * Get motorModelo
     *
     * @return string
     */
    public function getMotorModelo()
    {
        return $this->motorModelo;
    }

    /**
     * Set motorNumero
     *
     * @param string $motorNumero
     *
     * @return Unidad
     */
    public function setMotorNumero($motorNumero)
    {
        $this->motorNumero = $motorNumero;

        return $this;
    }

    /**
     * Get motorNumero
     *
     * @return string
     */
    public function getMotorNumero()
    {
        return $this->motorNumero;
    }

    /**
     * Set numeroCilindros
     *
     * @param string $numeroCilindros
     *
     * @return Unidad
     */
    public function setNumeroCilindros($numeroCilindros)
    {
        $this->numeroCilindros = $numeroCilindros;

        return $this;
    }

    /**
     * Get numeroCilindros
     *
     * @return string
     */
    public function getNumeroCilindros()
    {
        return $this->numeroCilindros;
    }

    /**
     * Set cilindrada
     *
     * @param float $cilindrada
     *
     * @return Unidad
     */
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;

        return $this;
    }

    /**
     * Get cilindrada
     *
     * @return float
     */
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * Set carroMarca
     *
     * @param string $carroMarca
     *
     * @return Unidad
     */
    public function setCarroMarca($carroMarca)
    {
        $this->carroMarca = $carroMarca;

        return $this;
    }

    /**
     * Get carroMarca
     *
     * @return string
     */
    public function getCarroMarca()
    {
        return $this->carroMarca;
    }

    /**
     * Set carroModelo
     *
     * @param string $carroModelo
     *
     * @return Unidad
     */
    public function setCarroModelo($carroModelo)
    {
        $this->carroModelo = $carroModelo;

        return $this;
    }

    /**
     * Get carroModelo
     *
     * @return string
     */
    public function getCarroModelo()
    {
        return $this->carroModelo;
    }

    /**
     * Set carroNumero
     *
     * @param string $carroNumero
     *
     * @return Unidad
     */
    public function setCarroNumero($carroNumero)
    {
        $this->carroNumero = $carroNumero;

        return $this;
    }

    /**
     * Get carroNumero
     *
     * @return string
     */
    public function getCarroNumero()
    {
        return $this->carroNumero;
    }

    /**
     * Set carroCapacidad
     *
     * @param integer $carroCapacidad
     *
     * @return Unidad
     */
    public function setCarroCapacidad($carroCapacidad)
    {
        $this->carroCapacidad = $carroCapacidad;

        return $this;
    }

    /**
     * Get carroCapacidad
     *
     * @return integer
     */
    public function getCarroCapacidad()
    {
        return $this->carroCapacidad;
    }

    /**
     * Set carroBar
     *
     * @param boolean $carroBar
     *
     * @return Unidad
     */
    public function setCarroBar($carroBar)
    {
        $this->carroBar = $carroBar;

        return $this;
    }

    /**
     * Get carroBar
     *
     * @return boolean
     */
    public function getCarroBar()
    {
        return $this->carroBar;
    }

    /**
     * Set carroVideo
     *
     * @param boolean $carroVideo
     *
     * @return Unidad
     */
    public function setCarroVideo($carroVideo)
    {
        $this->carroVideo = $carroVideo;

        return $this;
    }

    /**
     * Get carroVideo
     *
     * @return boolean
     */
    public function getCarroVideo()
    {
        return $this->carroVideo;
    }

    /**
     * Set carroAC
     *
     * @param boolean $carroAC
     *
     * @return Unidad
     */
    public function setCarroAC($carroAC)
    {
        $this->carroAC = $carroAC;

        return $this;
    }

    /**
     * Get carroAC
     *
     * @return boolean
     */
    public function getCarroAC()
    {
        return $this->carroAC;
    }

    /**
     * Set micro
     *
     * @param boolean $micro
     *
     * @return Unidad
     */
    public function setMicro($micro)
    {
        $this->micro = $micro;

        return $this;
    }

    /**
     * Get micro
     *
     * @return boolean
     */
    public function getMicro()
    {
        return $this->micro;
    }

    /**
     * Set tipoGasOil
     *
     * @param integer $tipoGasOil
     *
     * @return Unidad
     */
    public function setTipoGasOil($tipoGasOil)
    {
        $this->tipoGasOil = $tipoGasOil;

        return $this;
    }

    /**
     * Get tipoGasOil
     *
     * @return integer
     */
    public function getTipoGasOil()
    {
        return $this->tipoGasOil;
    }

    /**
     * Set turismo
     *
     * @param boolean $turismo
     *
     * @return Unidad
     */
    public function setTurismo($turismo)
    {
        $this->turismo = $turismo;

        return $this;
    }

    /**
     * Get turismo
     *
     * @return boolean
     */
    public function getTurismo()
    {
        return $this->turismo;
    }
}
