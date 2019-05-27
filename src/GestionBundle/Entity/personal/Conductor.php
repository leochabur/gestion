<?php
namespace GestionBundle\Entity\personal;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="conductores")
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\personal\ConductorRepository")
 */
class Conductor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $apellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="activo", type="boolean",  nullable=true)
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string",  nullable=true)
     */    
    private $dni;    

    /**
     * @var string
     *
     * @ORM\Column(name="legajo", type="string",  nullable=true)
     */    
    private $legajo;    

    /**
     * @var string
     *
     * @ORM\Column(name="tipoDni", type="string",  nullable=true)
     */    
    private $tipoDni;        

    /**
     * @var integer
     *
     * @ORM\Column(name="titular", type="integer",  nullable=true)
     */    
    private $titular;  

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string",  nullable=true)
     */    
    private $telefono;        

    /**
     * @var \CategoriaPersonal
     *
     * @ORM\ManyToOne(targetEntity="CategoriaPersonal")
     * @ORM\JoinColumn(name="id_categoria", referencedColumnName="id", nullable=true)
     */
    private $categoria;

        /**
     * @var \Ciudad
     *
     * @ORM\ManyToOne(targetEntity="Ciudad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCiudadOrigen", referencedColumnName="id", nullable=true)
     * })
     */
    private $ciudad;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="PagoConductor", mappedBy="conductor")
     */
    private $pagos;


    public function __construct()
    {
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setCategoria(\GestionBundle\Entity\personal\CategoriaPersonal $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }


    public function addPago(\GestionBundle\Entity\personal\PagoConductor $pagos)
    {
        $this->pagos[] = $pagos;

        return $this;
    }


    public function removePago(\GestionBundle\Entity\personal\PagoConductor $pagos)
    {
        $this->pagos->removeElement($pagos);
    }


    public function getPagos()
    {
        return $this->pagos;
    }
    
    public function __toString(){
           return strtoupper($this->apellido.', '.$this->getNombre());
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Conductor
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Conductor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set legajo
     *
     * @param string $legajo
     *
     * @return Conductor
     */
    public function setLegajo($legajo)
    {
        $this->legajo = $legajo;

        return $this;
    }

    /**
     * Get legajo
     *
     * @return string
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     * Set tipoDni
     *
     * @param string $tipoDni
     *
     * @return Conductor
     */
    public function setTipoDni($tipoDni)
    {
        $this->tipoDni = $tipoDni;

        return $this;
    }

    /**
     * Get tipoDni
     *
     * @return string
     */
    public function getTipoDni()
    {
        return $this->tipoDni;
    }

    /**
     * Set ciudad
     *
     * @param \GestionBundle\Entity\personal\CategoriaPersonal $ciudad
     *
     * @return Conductor
     */
    public function setCiudad(\GestionBundle\Entity\personal\CategoriaPersonal $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \GestionBundle\Entity\personal\CategoriaPersonal
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set titular
     *
     * @param integer $titular
     *
     * @return Conductor
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return integer
     */
    public function getTitular()
    {
        return $this->titular;
    }
}
