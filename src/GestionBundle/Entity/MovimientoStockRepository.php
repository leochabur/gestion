<?php

use GestionBundle\Entity\SalidaStock;

namespace GestionBundle\Entity;

/**
 * MovimientoStockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovimientoStockRepository extends \Doctrine\ORM\EntityRepository
{

	public function getMovimientosPorArticulo($articulo)
	{
        return $this->getEntityManager()
                    ->createQuery('SELECT a FROM GestionBundle:MovimientoStock a JOIN a.origenMovimiento o WHERE a.articulo = :articulo AND o.afectaCtaCte = :afecta ORDER BY a.fecha, a.id')
                    ->setParameter('articulo', $articulo)
                    ->setParameter('afecta', true)
                    ->getResult();			
	}

	public function getMovimientosInternoPorPeriodo($unidad, $desde, $hasta)
	{
        return $this->getEntityManager()
                    ->createQuery('SELECT s 
                    			   FROM GestionBundle:SalidaStock s 
                    			   WHERE s.fecha between :desde AND :hasta  AND s.unidad = :unidad 
                    			   ORDER BY s.fecha')
                    ->setParameter('desde', $desde)
                    ->setParameter('hasta', $hasta)                    
                    ->setParameter('unidad', $unidad)
                    ->getResult();			
	}	

	public function getMovimientosAgrupadosPorPeriodo($desde, $hasta)
	{
        return $this->getEntityManager()
                    ->createQuery('SELECT 0 as id, max(s.fecha) as fecha, u.interno as unidad, sum(s.cantidad) as cantidad, avg(s.precioUnitario) as precioUnitario, a.descripcion as articulo, u.id as cche
                    	           FROM GestionBundle:SalidaStock s 
                    	           LEFT JOIN s.articulo a
                    	           LEFT JOIN s.unidad u 
                    	           WHERE s.fecha between :desde AND :hasta 
                    	           GROUP BY s.unidad, s.articulo')
                    ->setParameter('desde', $desde)
                    ->setParameter('hasta', $hasta)    
                    ->getResult();			
	}	

	public function getKmRecorridosPorPeriodo($desde, $hasta)
	{
		$conn = mysqli_connect("WIN-PEU1951GJRJ", "root", "leo1979", "promedio");
		$sql = "SELECT c.id, sum(distancia*2)
				FROM bajadasdevuelta b
				inner join vueltasdiarias v on v.id = b.idvueltadiaria
				inner join coches c on c.id = v.idcoche
				inner join vueltas vu on vu.id = v.idvuelta
				inner join servicios s on s.id = vu.idservicioida
				inner join viajes vje on vje.id = s.idviaje
				inner join ciudades d on d.id = vje.iddestino
				WHERE b.fecha BETWEEN '".$desde."' and '".$hasta."'
				group by c.id";
		$data = mysqli_query($conn, $sql);
		$km = array();
		while ($row = mysqli_fetch_array($data)){
			$km[$row[0]] = $row[1];
		}
		mysqli_free_result($data);
		mysqli_close($conn);
		return $km;
	}		
}