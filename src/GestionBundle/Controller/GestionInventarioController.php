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
use GestionBundle\Form\MovimientoDebitoType;
use GestionBundle\Form\SalidaStockType;
use GestionBundle\Form\ArticuloRepository;
use GestionBundle\Entity\CtaCteProveedor;
use GestionBundle\Entity\MovimientoDebito;
use GestionBundle\Entity\MovimientoCredito;
use GestionBundle\Entity\taller\TareaMantenimiento;
use GestionBundle\Entity\taller\DiagramaTarea;
use GestionBundle\Form\MovimientoCreditoType;
use GestionBundle\Form\MovimientoPlanCuotaType;
use GestionBundle\Form\finanzas\ArchivoSubsidioType;
use GestionBundle\Entity\finanzas\ArchivoSubsidio;
use GestionBundle\Entity\finanzas\PagoSubsidio;
use Symfony\Component\HttpFoundation\JsonResponse;
use GestionBundle\Entity\stock\OrdenCompra;
use GestionBundle\Form\taller\TareaMantenimientoType;
use GestionBundle\Form\stock\OrdenCompraType;
use GestionBundle\Entity\stock\ItemMovimiento;
use GestionBundle\Form\taller\DiagramaTareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use GestionBundle\Entity\UnidadRepository;

class GestionInventarioController extends Controller
{

    public function nuevaOrdenCompraAction(Request $request)
    {
        $oc = new OrdenCompra();
        $form = $this->createFormOrdenCompra($oc);
        return $this->render('GestionBundle:stock:altaOrdenCompra.html.twig', array('form'=>$form->createView())); 
    }

    private function createFormOrdenCompra($oc)
    {
        return $this->createForm(new OrdenCompraType(), $oc, array('action'=>$this->generateUrl('gestion_inventario_orden_compra_procesar'), 'method'=>'POST'));
    }

    public function procesarOrdenCompraAction(Request $request)
    {
        $orden = new OrdenCompra();
        $form = $this->createFormOrdenCompra($orden);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $orden->setUsuarioCarga($this->getUser());
            $em = $this->getDoctrine()->getManager();         
            $em->persist($orden);                
            $em->flush();    
            return $this->redirectToRoute('gestion_inventario_orden_compra_asignar', array('id' => $orden->getId())); 
        }
        return $this->render('GestionBundle:stock:altaOrdenCompra.html.twig', array('form'=>$form->createView()));         
    }

    public function aisgnarOrdenCompraAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $orden = $em->find('GestionBundle:stock\OrdenCompra', $id);
        $articulos = $em->getRepository('GestionBundle:Articulo')->listadoArticulos();  
        $forms = array();
        foreach ($articulos as $art) {
            $forms[$art->getId()] = $this->formAddArticuloOC('gestion_inventario_add_articulo_orden_compra', $art->getId(), $orden->getId(), 'POST')->createView();
        }

        $formItems = array();
        foreach ($orden->getItems() as $it) {
            $formItems[$it->getId()] = $this->getFormDeleteItem($it->getId(), 'gestion_inventario_delete_item_orden_compra', 'POST')->createView();
        }
        return $this->render('GestionBundle:stock:addArtOc.html.twig', array('orden' => $orden, 'forms'=>$forms, 'articulos' => $articulos, 'formDelete' => $formItems));      
    }



//////////////////////Incorpora el articulo de la orden de compra al stock
    public function ingresarStockOcAction($id){
        $em = $this->getDoctrine()->getManager();
        $orden = $em->find('GestionBundle:stock\OrdenCompra', $id);

        $forms = array();
        foreach ($orden->getItems() as $item) {
            $forms[$item->getId()] = $this->formIngresoStockArticulo('gestion_inventario_orden_compra_ingresar_stock_procesar', $item)->createView();
        }
        return $this->render('GestionBundle:stock:ingresarArtOC.html.twig', array('orden' => $orden, 'forms' => $forms));              
    }

    private function formIngresoStockArticulo($url, $item)
    {
        return $this->createFormBuilder()
                    ->add('cantidad', 'number', array('data' => $item->getCantidad(), 'constraints' => array(new NotBlank())))            
                    ->add('precio', 'text', array('data' => $item->getUnitario(), 'constraints' => array(new NotBlank())))       
                    ->add('unidad', 'entity', array('class' => 'GestionBundle:Unidad','empty_value'   => '',
                                            'query_builder' => function(UnidadRepository $er){
                                                                                                return $er->createQueryBuilder('u')
                                                                                                          ->where('u.activo = :activo')
                                                                                                          ->setParameter('activo', true);
                                                                                             }))                                                       
                    ->add('add', 'submit', array('label'=>'+'))
                    ->setAction($this->generateUrl($url, array('item' => $item->getId())))
                    ->setMethod('POST')                       
                    ->getForm();           
    }    

    public function ingresarStockOcProcesarAction($item)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $item = $em->find('GestionBundle:stock\ItemMovimiento', $item);
        $form = $this->formIngresoStockArticulo('gestion_inventario_orden_compra_ingresar_stock_procesar', $item);
        $form->handleRequest($request);
        if ($form->isValid()){
            $data = $form->getData();
            if ($data['unidad']){
                try{  
                    $salida = new SalidaStock();
                    $salida->setItemOrdenCompra($item);
                    $salida->setFecha(new \DateTime());
                    $salida->setCantidad($data['cantidad']);
                    $salida->setUnidad($data['unidad']);
                    $salida->setNumComprobante($item->getMovimiento()->getId());
                    $origen = $em->find('GestionBundle:OrigenMovimiento', 2);
                    $salida->setOrigenMovimiento($origen);
                    $item->getArticulo()->setUltimoPrecio($data['precio']);
                    $item->getArticulo()->setUltimaActualizacionPrecio(new \DateTime());
                    $salida->setArticulo($item->getArticulo());
                    $salida->setPrecioUnitario($data['precio']);
                    $item->setIngresadoAStock(true);
                    $em->persist($salida);
                    $em->flush();
                    return new JsonResponse(array('status' => true, 'msge' => 'Articulo asignado al interno '.$data['unidad']->getInterno()));
                }
                catch (\Exception $e){ 
                                        return new JsonResponse(array('status' => false, 'msge' => $e->getMessage()));
                                     }
            }
            else{
                try{
                    $entrada = new EntradaStock();
                    $entrada->setItemOrdenCompra($item);
                    $entrada->setFecha(new \DateTime());
                    $entrada->setProveedor($item->getMovimiento()->getProveedor());
                    $entrada->setCantidad($data['cantidad']);
                    $entrada->setNumComprobante($item->getMovimiento()->getId());
                    $item->getArticulo()->setUltimoPrecio($data['precio']);
                    $item->getArticulo()->setUltimaActualizacionPrecio(new \DateTime());                    
                    $origen = $em->find('GestionBundle:OrigenMovimiento', 1);
                    $entrada->setOrigenMovimiento($origen);
                    $entrada->setArticulo($item->getArticulo());
                    $entrada->setPrecioUnitario($data['precio']);
                    $item->setIngresadoAStock(true);
                    $em->persist($entrada);
                    $em->flush();
                    return new JsonResponse(array('status' => true, 'msge' => 'Ingresado al stock exitosamente!'));
                }
                catch (\Exception $e){ 
                                        return new JsonResponse(array('status' => false, 'msge' => $e->getMessage()));
                                     }
            }
        }
        else
            return new JsonResponse(array('status' => false, 'msge' => $form->getErrorsAsString()));

    }
///////////////////fin//////////////////////////////////////////////////////////////
    public function deleteItemAction($it)
    {
        try
        {
            $em = $this->getDoctrine()->getManager();
            $item = $em->find('GestionBundle:stock\ItemMovimiento', $it);
            $orden = $item->getMovimiento();
            if ($orden->getAutorizada()){
                $response = new JsonResponse();
                $response->setData(array('status' => false, 'msge' => 'La orden ya ha sido autorizada, no se pueden eliminar los items!'));
                return $response;                  
            }
            $orden->removeItem($item);
            $em->remove($item);
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


    private function getFormDeleteItem($item, $url, $method)
    {
        return $this->createFormBuilder()                               
                    ->add('delete', 'submit', array('label'=>'-'))
                    ->setAction($this->generateUrl($url, array('it' => $item)))
                    ->setMethod($method)                       
                    ->getForm();         
    }

    private function formAddArticuloOC($url, $idArt, $idOc, $method)
    {
        return $this->createFormBuilder()
                    ->add('cantidad', 'number', array('constraints' => array(new NotBlank())))            
                    ->add('precio', 'number')                                        
                    ->add('add', 'submit', array('label'=>'+'))
                    ->setAction($this->generateUrl($url, array('oc' => $idOc, 'art'=> $idArt)))
                    ->setMethod($method)                       
                    ->getForm();           
    }

    public function listarOCAction()
    {
        $em = $this->getDoctrine()->getManager();    
        $repo = $em->getRepository('GestionBundle:stock\OrdenCompra');
        $ordenes = $repo->getOrdenesCompra();
        return $this->render('GestionBundle:stock:listarOC.html.twig', array('ordenes' => $ordenes));          
    }    

    public function autorizarOCAction($id)
    {
        try{
                $em = $this->getDoctrine()->getManager();    
                $repo = $em->getRepository('GestionBundle:stock\OrdenCompra'); 
                $orden = $repo->find($id); 
                if ($orden->getAutorizada()){
                    $response = new JsonResponse();
                    $response->setData(array('status' => false, 'msge' => 'La orden ya ha sido autorizada!'));
                    return $response;                            
                } 
                $orden->setUsuarioAutorizante($this->getUser());
                $orden->setAutorizada(true);
                $em->flush();
                $response = new JsonResponse();
                $response->setData(array('status' => true, 'msge' => 'Orden autorizada exitosamente!'));
                return $response;           
        }
        catch(Exception $e){
                            $response = new JsonResponse();
                            $response->setData(array('status' => false, 'msge' => $e->getMessage()));
                            return $response;                
        }
     
    }  

    public function deleteOCAction($id)
    {
        try{
                $em = $this->getDoctrine()->getManager();    
                $repo = $em->getRepository('GestionBundle:stock\OrdenCompra'); 
                $orden = $repo->find($id); 
                $orden->setUsuarioElimino($this->getUser());
                $orden->setEliminada(true);
                $em->flush();
                $response = new JsonResponse();
                $response->setData(array('status' => true, 'msge' => 'Orden eliminada exitosamente!'));
                return $response;           
        }
        catch(Exception $e){
                            $response = new JsonResponse();
                            $response->setData(array('status' => false, 'msge' => $e->getMessage()));
                            return $response;                
        }        
    }  

    public function openOCAction($id)
    {
        try{
                $em = $this->getDoctrine()->getManager();    
                $repo = $em->getRepository('GestionBundle:stock\OrdenCompra'); 
                $orden = $repo->find($id); 
                $orden->setAutorizada(false);
                $em->flush();
                $response = new JsonResponse();
                $response->setData(array('status' => true, 'msge' => 'Orden abierta exitosamente!'));
                return $response;           
        }
        catch(Exception $e){
                            $response = new JsonResponse();
                            $response->setData(array('status' => false, 'msge' => $e->getMessage()));
                            return $response;                
        }        
    }      

    public function imprimirOCAction($id)
    {
        try{
                $em = $this->getDoctrine()->getManager();    
                $repo = $em->getRepository('GestionBundle:stock\OrdenCompra'); 
                $orden = $repo->find($id); 

                $handle = printer_open('HP LaserJet Pro MFP M127-M128 PCLmS');

                printer_start_doc($handle, "Mi Documento");
                printer_start_page($handle);



                $despX = 0; //corre el puntero hacia la izquierda
                $inicioX = 580; //inicializa la posicion del puntero en x

                $inicioY = 900;
                $despY = 0;

                $encaX = 1210;
                $encaY = 550;

                $font = printer_create_font("Arial", 75, 50, 400, false, false, false, 0);
                printer_select_font($handle, $font);     

                printer_draw_text($handle, "ORDEN COMPRA N:  ".$orden->getId(), ($encaX + 1600), ($encaY - 400));
                printer_draw_text($handle, "PROVEEDOR:  ".$orden->getProveedor(), ($encaX -1000), ($encaY -250));
                printer_draw_text($handle, "FECHA:  ".$orden->getFecha()->format('d/m/Y'), ($encaX + 2350), ($encaY - 250));
                printer_draw_line($handle, ($encaX -1000), ($encaY -100), ($encaX + 3200), ($encaY -100));

                $x = $encaX -1000;
                $y = $encaY -50;
                //////cabecera de los items
                printer_draw_text($handle, "Cantidad", $x, $y);
                printer_draw_text($handle, "Descripcion", ($x + 550), $y);
                printer_draw_text($handle, "Unitario", ($x + 2900), $y);        
                printer_draw_text($handle, "Total", ($x + 3600), $y);            
                //////fin cabecera de los items

                $y+=175;
                foreach ($orden->getItems() as $item) {
                    printer_draw_text($handle, $item->getCantidad(), $x, $y);
                    printer_draw_text($handle, strtoupper($item->getArticulo()), ($x + 550), $y);
                    printer_draw_text($handle, $item->getUnitario(), ($x + 2900), $y);        
                    printer_draw_text($handle, $item->getTotal(), ($x + 3600), $y);  
                    $y+=175;   
                }

                $y+=175;

                printer_draw_text($handle, "PEDIDO POR:  ".$orden->getUsuarioCarga(), ($encaX -1000), ($y));
                printer_draw_text($handle, "AUTORIZADO POR:  ".$orden->getUsuarioAutorizante(), ($encaX -1000), ($y+220));

                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle); 
                $orden->setImpresa(true);
                $em->flush();      
                $response = new JsonResponse();
                $response->setData(array('status' => true));
                return $response;                        
        }
        catch(Exception $e){
                            $response = new JsonResponse();
                            $response->setData(array('status' => false, 'msge' => $e->getMessage()));
                            return $response;                
        } 
    }    

    public function addArtOCAction($oc, $art, Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();      
            $articulo = $em->find('GestionBundle:Articulo', $art);
            $ordenCompra = $em->find('GestionBundle:stock\OrdenCompra', $oc);  
            if ($ordenCompra->getAutorizada()){
                $response = new JsonResponse();
                $response->setData(array('status' => false, 'msge' => 'La orden ya ha sido autorizada, no se pueden agregar items!'));
                return $response;                  
            }                           
            $form = $this->formAddArticuloOC('gestion_inventario_add_articulo_orden_compra', $art, $oc, 'POST');
            $form->handleRequest($request);       
            try{
                if ($form->isValid()){
                    $data = $form->getData();
                    $cantidad = $data['cantidad'];
                    $precio = $data['precio'];
                    if ($cantidad){
                        $item = new ItemMovimiento();
                        $item->setCantidad($cantidad);
                        $item->setArticulo($articulo);
                        $item->setUnitario($precio);
                        $item->setMovimiento($ordenCompra);
                        $em->persist($item);
                        $ordenCompra->addItem($item);
                    }
                    $em->flush();
                    $response = new JsonResponse();
                    $response->setData(array('status' => true));
                    return $response;   
                }
                else{
                                    $response = new JsonResponse();
                                    $response->setData(array('status' => false, 'msge' => 'Valores Invalida'));
                                    return $response;                      
                }
            }
            catch (\Exception $e){
                                    $response = new JsonResponse();
                                    $response->setData(array('status' => false, 'msge' => $e->getMessage()));
                                    return $response;  
            }            
        }
    }

}