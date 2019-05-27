<?php

namespace GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GestionBundle\Form\ProveedorType;
use GestionBundle\Entity\Proveedor;
use GestionBundle\Form\ArticuloType;
use GestionBundle\Entity\Articulo;
use GestionBundle\Entity\EntradaStock;
use GestionBundle\Entity\SalidaStock;
use GestionBundle\Form\EntradaStockType;
use GestionBundle\Form\SalidaStockType;
use GestionBundle\Entity\ArticuloRepository;
use GestionBundle\Entity\CtaCteProveedor;
use GestionBundle\Entity\MovimientoDebito;
use GestionBundle\Entity\UnidadRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class GestionMantController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionBundle:Default:index.html.twig');     
    }

    public function proveedorAltaAction()
    {
        $proveedor = new Proveedor();
        $form = $this->createFormAltaProveedor($proveedor);
        return $this->render('GestionBundle:mant:altaProveedor.html.twig', array('form'=>$form->createView()));      	
    }

    private function createFormAltaProveedor($proveedor)
    {
        return $this->createForm(new ProveedorType(), $proveedor, array('action'=>$this->generateUrl('mant_procesar_proveedor'), 'method'=>'POST'));
    }    

	public function procesarProveedorAction(Request $request)
	{
        $proveedor = new Proveedor();
        $form = $this->createFormAltaProveedor($proveedor);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($proveedor);
            $em->flush();
            return $this->redirectToRoute('mant_alta_proveedor');
        }
        return $this->render('GestionBundle:mant:altaProveedor.html.twig', array('form'=>$form->createView()));     
	}

    public function articuloAltaAction()
    {
        $articulo = new Articulo();
        $form = $this->createFormAltaArticulo($articulo);
        return $this->render('GestionBundle:mant:altaArticulo.html.twig', array('form'=>$form->createView()));      	
    }

    private function createFormAltaArticulo($articulo)
    {
        return $this->createForm(new ArticuloType(), $articulo, array('action'=>$this->generateUrl('mant_procesar_articulo'), 'method'=>'POST'));
    }    

	public function procesarArticuloAction(Request $request)
	{
        $articulo = new Articulo();
        $form = $this->createFormAltaArticulo($articulo);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($articulo);
            $em->flush();
            return $this->redirectToRoute('mant_alta_articulo');
        }
        return $this->render('GestionBundle:mant:altaArticulo.html.twig', array('form'=>$form->createView()));     
	}	

	public function entradaStockAltaAction()
	{
        $entrada = new EntradaStock();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('GestionBundle:Articulo');
        $articulos = $repository->listadoArticulos();        
        $form = $this->createFormAltaEntradaStock($entrada);
        return $this->render('GestionBundle:mant:entradaStock.html.twig', array('form'=>$form->createView(), 'articulos' => $articulos));    		
	}

    private function createFormAltaEntradaStock($entrada)
    {
        return $this->createForm(new EntradaStockType(), $entrada, array('action'=>$this->generateUrl('mant_procesar_entrada_stock'), 'method'=>'POST'));
    }  	

	public function procesarEntradaStockAction(Request $request)
	{
        $entrada = new EntradaStock();
        $form = $this->createFormAltaEntradaStock($entrada);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid()){
            
            $em->persist($entrada);
            $entrada->updatePrecioArticulo();

            /////calcula la afectacion de la cuenta corriente
            $repo = $em->getRepository('GestionBundle:CtaCteProveedor');
            $ctacte = $repo->getCtaCteProveedor($entrada->getProveedor());
            $debito = new MovimientoDebito();
            $debito->setCantidad($entrada->getCantidad());
            $debito->setImporte($entrada->getMontoTotal());
            $debito->setFecha($entrada->getFecha());
            $debito->setDetalle("Compra ".$entrada->getArticulo());
            $debito->setMovimiento($entrada);

            if (!$ctacte)
            {
                $ctacte = new CtaCteProveedor();
                $ctacte->setProveedor($entrada->getProveedor());
                $ctacte->addMovimiento($debito);
                $em->persist($ctacte);
            }
            $debito->setCtacte($ctacte);
            $ctacte->addMovimiento($debito);
            
            ////Fin afectacion cuenta corriente
            $em->flush();
            return $this->redirectToRoute('mant_alta_entrada_stock');
        }
        $repository = $em->getRepository('GestionBundle:Articulo');
        $articulos = $repository->listadoArticulos();                
        return $this->render('GestionBundle:mant:entradaStock.html.twig', array('form'=>$form->createView(), 'articulos' => $articulos));     
	}

    public function salidaStockAltaAction()
    {
        $entrada = new SalidaStock();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('GestionBundle:Articulo');
        $articulos = $repository->listadoArticulos();
        $form = $this->createFormAltaSalidaStock($entrada);
        return $this->render('GestionBundle:mant:salidaStock.html.twig', array('form'=>$form->createView(), 'articulos' => $articulos));      
    }

    private function createFormAltaSalidaStock($salida)
    {
        return $this->createForm(new SalidaStockType(), $salida, array('action'=>$this->generateUrl('mant_procesar_salida_stock'), 'method'=>'POST'));
    }    

    public function procesarSalidaStockAction(Request $request)
    {
        $salida = new SalidaStock();
        $form = $this->createFormAltaSalidaStock($salida);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid()){
            $em->persist($salida);
            $salida->updatePrecioArticulo();            
            $em->flush();
            return $this->redirectToRoute('mant_alta_salida_stock');
        }
        $repository = $em->getRepository('GestionBundle:Articulo');
        $articulos = $repository->listadoArticulos();        
        return $this->render('GestionBundle:mant:salidaStock.html.twig', array('form'=>$form->createView(), 'articulos' => $articulos));     
    }

    public function resumenCtaArticuloAction($art)
    {
        $form = $this->createFormSelectArticulo(0,0);
        $request = $this->getRequest();
        if ( $request->isMethod('POST')){
            $form->handleRequest($request);
            $data = $request->request->get('form');                 
            $em = $this->getDoctrine()->getManager();
            $articulo = $em->find('GestionBundle:Articulo', $data['articulo']);
            $repo = $em->getRepository('GestionBundle:MovimientoStock');
            $movimientos = $repo->getMovimientosPorArticulo($articulo);
            $forms = array();
            foreach ($movimientos as $mov) {
                $forms[$mov->getId()] = $this->getFormDeleteMovimiento($mov->getId(), 'mant_delete_movimiento')->createView();
            }
            return $this->render('GestionBundle:mant:resumenCtaArticulo.html.twig', array('form'=>$form->createView(), 'movimientos' => $movimientos, 'forms' => $forms));
        }        
        return $this->render('GestionBundle:mant:resumenCtaArticulo.html.twig', array('form'=>$form->createView()));
    }

    public function deleteMovimientoAction($mov, Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $movimiento = $em->find('GestionBundle:MovimientoStock', $mov);
            $em->remove($movimiento);
            $em->flush();            
            $response = new JsonResponse();
            $response->setData(array('status' => true));
            return $response;              
        }
        catch (\Exception $e){
                                    $response = new JsonResponse();
                                    $response->setData(array('status' => false, 'msge' => $e->getMessage()));
                                    return $response;  
        }              
    }

    private function getFormDeleteMovimiento($id, $url)
    {
        return $this->createFormBuilder()                        
                    ->add('delete', 'submit', array('label'=>'X'))
                    ->setAction($this->generateUrl($url, array('mov' => $id)))
                    ->setMethod('POST')                                         
                    ->getForm();   
    }

    private function createFormSelectArticulo($url, $id)
    {
        return $this->createFormBuilder()
                    ->add('articulo', 'entity', array('class' => 'GestionBundle:Articulo',
                                                      'query_builder' => function(ArticuloRepository $er){
                                                                                return $er->createQueryBuilder('p')
                                                                                          ->orderBy('p.descripcion');                                                                                            
                                                                              })) 
                    ->add('load', 'submit', array('label'=>'Cargar Resumen'))
                    ->getForm();        
    }

    public function consumoPeriodoAction()
    {
        $request = $this->getRequest();
        $form = $this->createFormCtaCtePeriodo();
        if ( $request->isMethod('POST'))
        {   

            $form->handleRequest($request);
            $data = $request->request->get('form'); 
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('GestionBundle:MovimientoStock');             
            if (!isset($data['agrupa']))
            {
                $vencimientos = $repo->getMovimientosInternoPorPeriodo($data['unidad'], $data['desde'], $data['hasta']);
                return $this->render('GestionBundle:mant:consumoperiodo.html.twig', array('form'=>$form->createView(), 'vtos' => $vencimientos));  
            }
            else
            {
               // return new Response(($data['desde']));
                $km = $repo->getKmRecorridosPorPeriodo($data['desde'], $data['hasta']);
                $vencimientos = $repo->getMovimientosAgrupadosPorPeriodo($data['desde'], $data['hasta']);
                return $this->render('GestionBundle:mant:consumoperiodo.html.twig', array('form'=>$form->createView(), 'vtos' => $vencimientos, 'km' => $km));     
            }   
            
        }        
        return $this->render('GestionBundle:mant:consumoperiodo.html.twig', array('form'=>$form->createView()));  
    }

    private function createFormCtaCtePeriodo()
    {
        return $this->createFormBuilder()
                    ->add('desde', 'date', array('widget' => 'single_text'))
                    ->add('hasta', 'date', array('widget' => 'single_text'))
                     ->add('unidad', 'entity', array('class' => 'GestionBundle:Unidad',
                                            'query_builder' => function(UnidadRepository $er){
                                                                                                return $er->createQueryBuilder('u')
                                                                                                          ->where('u.activo = :activo')
                                                                                                          ->setParameter('activo', true);
                                                                                             }))                      
                    ->add('load', 'submit', array('label'=>'Cargar Resumen'))
                    ->add('agrupa', 'checkbox', array('label'     => 'Agrupar por interno','required'  => false))                    
                    ->getForm();        
    }

    public function listadoArticulosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('GestionBundle:Articulo');
        $articulos = $repository->listadoArticulos();   
        return $this->render('GestionBundle:mant:listadoArticulos.html.twig', array('articulos'=>$articulos));         
    }          

    public function editArticuloAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $articulo = $em->find('GestionBundle:Articulo', $id);
        $form = $this->getFormEditArticulo($articulo);
        return $this->render('GestionBundle:mant:editArticulo.html.twig', array('form'=>$form->createView()));   

    }

    private function getFormEditArticulo($articulo)
    {
        return $this->createForm(new ArticuloType(), $articulo, array('action'=>$this->generateUrl('mant_articulo_update', array('id' => $articulo->getId())), 'method'=>'POST'));
    }

    public function updateArticuloAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $articulo = $em->find('GestionBundle:Articulo', $id);
        $form = $this->getFormEditArticulo($articulo);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('mant_listado_articulos');
        }        
    }

    
}
