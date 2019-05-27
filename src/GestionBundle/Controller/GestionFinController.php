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
use GestionBundle\Entity\MovimientoPlanCuota;
use GestionBundle\Form\MovimientoCreditoType;
use GestionBundle\Form\MovimientoPlanCuotaType;
use GestionBundle\Form\finanzas\ArchivoSubsidioType;
use GestionBundle\Entity\finanzas\ArchivoSubsidio;
use GestionBundle\Entity\finanzas\PagoSubsidio;
use Symfony\Component\HttpFoundation\JsonResponse;
use GestionBundle\Entity\finanzas\AcreditacionSubsidio;
use GestionBundle\Form\finanzas\AcreditacionSubsidioType;
use GestionBundle\Form\finanzas\PagoSubsidioType;

class GestionFinController extends Controller
{

    public function ctaCteProvAction()
    {
        $request = $this->getRequest();
        $form = $this->createFormCtaCte();
        if ( $request->isMethod('POST'))
        {   $form->handleRequest($request);
            $data = $request->request->get('form'); 
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('GestionBundle:CtaCteProveedor');
            if (!$data['articulo'])
            { 
                $cta = $repo->getCtaCteProveedor($data['proveedor']);
                if ($cta)
                {
                    $forms = array();
                    $edits = array();                    
                    foreach ($cta->getMovimientos() as $mov) {
                        $forms[$mov->getId()] = $this->createFormDeleteMovimiento($mov->getId(), 'gestion_ctacte_proveedor_delete_movimiento', 'POST')->createView();
                        $edits[$mov->getId()] = $this->createFormUpdateMovimiento($mov->getId(), 'gestion_ctacte_proveedor_uptade_movimiento', 'POST', $mov->getImporte(), $mov->getOrden())->createView();
                    }
                    return $this->render('GestionBundle:finanzas:ctacte.html.twig', array('form'=>$form->createView(), 'cta' => $cta, 'forms'=>$forms, 'edits'=>$edits));  
                }
            }
            else{
                $movimientos = $repo->getCtaCteProveedorArticulo($data['proveedor'], $data['articulo']);
                return $this->render('GestionBundle:finanzas:ctacteart.html.twig', array('form'=>$form->createView(), 'movimientos' => $movimientos));                  
            }
        }        
        return $this->render('GestionBundle:finanzas:ctacte.html.twig', array('form'=>$form->createView()));      	
    }

    private function createFormDeleteMovimiento($id, $url, $method)
    {        
        return $this->createFormBuilder()
                    ->add('delete', 'submit', array('label'=>'Eliminar'))
                    ->setAction($this->generateUrl($url, array('id' => $id)))
                    ->setMethod($method)                       
                    ->getForm();         
    }

    private function createFormUpdateMovimiento($id, $url, $method, $value, $orden)
    {        
        return $this->createFormBuilder()
                    ->add('monto', 'text', array('data' => number_format($value,2,'.','')))       
                    ->add('orden', 'text', array('data' => number_format($orden,2,'.','')))                          
                    ->add('update', 'submit', array('label'=>'Update'))
                    ->setAction($this->generateUrl($url, array('id' => $id)))
                    ->setMethod($method)                       
                    ->getForm();         
    }    

    public function deleteMovimientoAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $movimento = $em->find('GestionBundle:MovimientoCuenta', $id);
        $em->remove($movimento);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array('ok' => true));
        return $response;  
    }

    public function updateMovimientoAction(Request $request, $id){
        if ($request->isXmlHttpRequest())
        {        
            $em = $this->getDoctrine()->getManager();
            $movimiento = $em->find('GestionBundle:MovimientoCuenta', $id);

            $form = $this->createFormUpdateMovimiento($id, 'gestion_ctacte_proveedor_uptade_movimiento', 'POST', $movimiento->getImporte(), $movimiento->getOrden());
            $form->handleRequest($request);
            if ($form->isValid()){
                $data = $form->getData();
                 $movimiento->setImporte($data['monto']);
                 $movimiento->setOrden($data['orden']);
                 $em->flush();
                $response = new JsonResponse();
                $response->setData(array('ok' => true, 'msge' => "OK "));
                return $response;    
        }
        else{
            $response = new JsonResponse();
            $response->setData(array('ok' => false, 'msge' => "no valido ".$form->getErrorsAsString()));
            return $response;                
        }
        

        }      
    }

    private function createFormCtaCte()
    {
        return $this->createFormBuilder()
                    ->add('proveedor', 'entity', array('class' => 'GestionBundle:Proveedor')) 
                    ->add('articulo', 'entity', array('class' => 'GestionBundle:Articulo', 'required' => false)) 
                    ->add('load', 'submit', array('label'=>'Cargar Resumen'))
                    ->getForm();        
    }

    public function ingresarDebitoAction()
    {
        $movimiento = new MovimientoDebito();
        $form = $this->createFormIngresoDebito($movimiento);
        return $this->render('GestionBundle:finanzas:ingresoDebito.html.twig', array('form'=>$form->createView())); 
    }   

    private function createFormIngresoDebito($movimiento)
    {
        return $this->createForm(new MovimientoDebitoType(), $movimiento, array('action'=>$this->generateUrl('gestion_ctacte_proveedor_ingreso_debito_procesar'), 'method'=>'POST'));
    }   

    public function ingresarDebitoProcesarAction(Request $request)
    {
        $debito = new MovimientoDebito();
        $form = $this->createFormIngresoDebito($debito);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($debito);
            $em->flush();    
            return $this->redirectToRoute('gestion_ctacte_proveedor_ingreso_debito');        
        }
        return $this->render('GestionBundle:finanzas:ingresoDebito.html.twig', array('form'=>$form->createView())); 
    }  

    public function ingresarCreditoAction()
    {
        $credito = new MovimientoCredito();
        $form = $this->createFormIngresoCredito($credito);
        return $this->render('GestionBundle:finanzas:cargarPago.html.twig', array('form'=>$form->createView())); 
    }

    private function createFormIngresoCredito($credito)
    {
        return $this->createForm(new MovimientoCreditoType(), $credito, array('action'=>$this->generateUrl('gestion_ctacte_proveedor_ingreso_credito_procesar'), 'method'=>'POST'));
    }     

    public function ingresarCreditoProcesarAction(Request $request)
    {
        $credito = new MovimientoCredito();
        $form = $this->createFormIngresoCredito($credito);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $proovExterno = $credito->getFormaPago()->getProveedorExterno();
            if ($proovExterno)
            {
                $debito = $credito->getFormaPago()->cargarCuentaExterna($credito);
                $repo = $em->getRepository('GestionBundle:CtaCteProveedor'); 
                $cta = $repo->getCtaCteProveedor($proovExterno);  
                if (!$cta)
                {
                    $cta = new CtaCteProveedor();
                    $cta->setProveedor($proovExterno);
                    $em->persist($cta);
                }              
                $debito->setCtaCte($cta);
                $em->persist($debito);
            }
            
            $em->persist($credito);
            $em->flush();    
            return $this->redirectToRoute('gestion_ctacte_proveedor_ingreso_credito');        
        }
        return $this->render('GestionBundle:finanzas:cargarPago.html.twig', array('form'=>$form->createView()));       
    } 

    public function ingresarMovimientoFinancieroAction()
    {
        $finanza = new MovimientoPlanCuota();
        $form = $this->createFormMovFinanciero($finanzas);
        return $this->render('GestionBundle:finanzas:cargarMovimientoFinanciero.html.twig', array('form'=>$form->createView())); 
    }

    private function createFormMovFinanciero($movimiento)
    {
        return $this->createForm(new MovimientoPlanCuotaType(), $movimiento, array('action'=>$this->generateUrl('gestion_ctacte_proveedor_ingreso_mov_financiero_procesar'), 'method'=>'POST')); 
    }

    public function ingresarMovimientoFinancieroProcesarAction(Request $request)
    {
        $plan = new MovimientoPlanCuota();
        $form = $this->createFormMovFinanciero($plan);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();            
            $em->persist($plan);
            $fecha = clone $plan->getFecha();
            $inicio = $plan->getNumeroCuota() + 1;
            for ($i = $inicio; $i <= $plan->getMultiplicaPor(); $i++)
            {
                $fecha->add(new \DateInterval('P1M'));
                $planAux = clone $plan;
                $planAux->setFecha((clone $fecha));
                $planAux->setNumeroCuota($i);
                $em->persist($planAux);
            }


            $em->flush();    
            return $this->redirectToRoute('gestion_ctacte_proveedor_ingreso_mov_financiero');        
        }
        return $this->render('GestionBundle:finanzas:cargarMovimientoFinanciero.html.twig', array('form'=>$form->createView())); 
    }

    public function vtosPeriodoAction()
    {
        $request = $this->getRequest();
        $form = $this->createFormCtaCtePeriodo();
        if ( $request->isMethod('POST'))
        {   
            $form->handleRequest($request);
            $data = $request->request->get('form'); 
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('GestionBundle:CtaCteProveedor'); 
            $vencimientos = $repo->getVencimientosPeriodo($data['desde'], $data['hasta']);
            return $this->render('GestionBundle:finanzas:ctacteperiodo.html.twig', array('form'=>$form->createView(), 'vtos' => $vencimientos));  
        }        
        return $this->render('GestionBundle:finanzas:ctacteperiodo.html.twig', array('form'=>$form->createView()));  
    }

    private function createFormCtaCtePeriodo()
    {
        return $this->createFormBuilder()
                    ->add('desde', 'date', array('widget' => 'single_text'))
                    ->add('hasta', 'date', array('widget' => 'single_text'))
                    ->add('load', 'submit', array('label'=>'Cargar Resumen'))
                    ->getForm();        
    }    

    public function loadSubsidioAction()
    {
        $archivo = new ArchivoSubsidio();
        $form = $this->createForm(new ArchivoSubsidioType(), $archivo, array('action' => $this->generateUrl('gestion_subsidios_procesar_archivo') ));
        return $this->render('GestionBundle:finanzas:loadSubsidio.html.twig', array('form'=>$form->createView()));  
    }

    public function procesarLoadSubsidioAction(Request $request)
    {
        $file = new ArchivoSubsidio();
        $form = $this->createForm(new ArchivoSubsidioType(), $file);
        $form->handleRequest($request);
        $conceptos = array();
        $pagos = array();
        if ($form->isSubmitted() && $form->isValid()) {
            $linea = 0;
            $archivo = fopen($file->getArchivo()->getPathname(), "r");
            $data="";
            while (($datos = fgetcsv($archivo, 1000, ";")) == true){
                    $num = count($datos); /// numero de columnas
                    if ($linea == 0){ ///esta procesando la cabecera del archivo
                        for($i = 4; $i < ($num-1); $i++){
                            $conceptos[$i] = $datos[$i];
                        }
                        $linea++;
                    }
                    elseif ($datos[2] =='30-70986951-1')
                    {
                        for($i = 4; $i < ($num-1); $i++){
                            if ($datos[$i] != 0)
                                $pagos[$conceptos[$i]] = $datos[$i];
                        }
                    }
            }
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('GestionBundle:finanzas\PagoSubsidio');         

        foreach ($pagos as $key => $value) 
        {
            $pagoCargado = $repo->getPagoSubsidio($key, $file->getPeriodoMes(), $file->getPeriodoAnio());
            if (!$pagoCargado)
            {
                $monto = str_replace('.', '', $value);
                $monto = str_replace(',', '.', $monto);
                $pago = new PagoSubsidio();
                $pago->setPeriodoMes($file->getPeriodoMes());
                $pago->setPeriodoAnio($file->getPeriodoAnio());
                $pago->setConcepto($key);
                $pago->setMonto($monto);
                $pago->setNumeroPago($file->getNumeroPago());                
                $em->persist($pago);
            }
        }
        $em->flush();

        return new Response(var_dump($pagos));    
    }

    public function loadAcreditacionAction()
    {
        $acreditacion = new AcreditacionSubsidio();
        $form = $this->createFormAltaAcreditacion($acreditacion);
        return $this->render('GestionBundle:finanzas:cargarAcreditacion.html.twig', array('form'=>$form->createView()));   
    }

    private function createFormAltaAcreditacion($acreditacion)
    {
        return $this->createForm(new AcreditacionSubsidioType(), $acreditacion, array('action'=>$this->generateUrl('gestion_subsidios_acreditacion_procesar'), 'method'=>'POST'));
    }     

    public function procesarAcreditacionAction(Request $request)
    {
        $acreditacion = new AcreditacionSubsidio();
        $form = $this->createFormAltaAcreditacion($acreditacion);       
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $repoSub = $em->getRepository('GestionBundle:finanzas\AcreditacionSubsidio');           
            $existente = $repoSub->existeAcreditacion($acreditacion->getImporte(), $acreditacion->getFecha()); 
            if (!$existente)
            {
                $em->persist($acreditacion);
                $em->flush();                
            }
            else
            {
                $acreditacion = $existente;
            }
            $repo = $em->getRepository('GestionBundle:finanzas\PagoSubsidio');
            $result = $repo->pagosPendientesDeAcreditar();
            $forms = array();

            foreach ($result as $pago) {
                $forms[$pago->getId()] =  $this->getFormAddPago('gestion_subsidios_add_pago_acreditacion', $acreditacion->getId(), $pago->getId())->createView();
            }

            return $this->render('GestionBundle:finanzas:addPagoAcreditacion.html.twig', array('forms'=>$forms, 'acreditacion' => $acreditacion, 'pagos'=> $result));                
        }
        return $this->render('GestionBundle:finanzas:cargarAcreditacion.html.twig', array('form'=>$form->createView()));           
    }

    private function getFormAddPago($url, $acreditacion, $pago)
    {
        return $this->createFormBuilder()
                    ->add('add', 'submit', array('label'=>'+'))
                    ->setAction($this->generateUrl($url, array('acreditacion' => $acreditacion, 'pago' => $pago)))
                    ->getForm(); 
    }

    public function cargaPagoSubsidioAction()
    {
        $pago = new PagoSubsidio();
        $form = $this->createFormPagoSubsidioManual($pago);
        return $this->render('GestionBundle:finanzas:cargaPagoManual.html.twig', array('form'=>$form->createView()));        
    }

    private function createFormPagoSubsidioManual($pago)
    {
        return $this->createForm(new PagoSubsidioType(), $pago, array('action'=>$this->generateUrl('gestion_subsidios_cargar_manual_procesa'), 'method'=>'POST'));
    }

    public function cargaPagoSubsidioProcesarAction(Request $request)
    {
        $pago = new PagoSubsidio();
        $form = $this->createFormPagoSubsidioManual($pago);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($pago);
            $em->flush();         
            return $this->redirectToRoute('gestion_subsidios_cargar_manual');   
        }
        return $this->render('GestionBundle:finanzas:cargaPagoManual.html.twig', array('form'=>$form->createView()));       
    }

    public function addPagoAcreditacionAction($acreditacion, $pago)
    {
        $em = $this->getDoctrine()->getManager();
        $acreditacion = $em->find('GestionBundle:finanzas\AcreditacionSubsidio', $acreditacion);
        $pago = $em->find('GestionBundle:finanzas\PagoSubsidio', $pago);   
        $pago->setPercibido(true);     
        $acreditacion->addPago($pago);
        $em->flush();        
        $total = 0;
        foreach ($acreditacion->getPagos() as $pago) {
            $total+=$pago->getMonto();
        }

        return new JsonResponse(array('ok' => true, 'monto' => $total));

    }

    public function listaAcreditacionesAction()
    {
        $form = $this->createFormAcreditaciones();
        $request = $this->getRequest();
        if ( $request->isMethod('POST'))
        {   
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($form->get('load')->isClicked())
            {
                $data = $request->get('form'); 
                $acreditacion = $em->find('GestionBundle:finanzas\AcreditacionSubsidio', $data['acreditacion']);
                return $this->render('GestionBundle:finanzas:listaAcreditaciones.html.twig', array('form'=>$form->createView(), 'acreditacion' => $acreditacion));                  
            }
            else
            {
                $repository = $em->getRepository('GestionBundle:finanzas\AcreditacionSubsidio');   
                $result = $repository->getAcreditaciones();  
                return $this->render('GestionBundle:finanzas:listaAcreditaciones.html.twig', array('form'=>$form->createView(), 'lista' => $result));                 
            }
        }
        return $this->render('GestionBundle:finanzas:listaAcreditaciones.html.twig', array('form'=>$form->createView()));    
    }

    private function createFormAcreditaciones()
    {
        return $this->createFormBuilder()
                    ->add('acreditacion', 'entity', array('class' => 'GestionBundle:finanzas\AcreditacionSubsidio')) 
                    ->add('load', 'submit', array('label'=>'Cargar Detalle'))      
                    ->add('view', 'submit', array('label'=>'Ver Todas'))                         
                    ->getForm();        
    }

    public function pagosPendientesAction()
    {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('GestionBundle:finanzas\PagoSubsidio');
            $result = $repo->pagosPendientesDeAcreditar();
            return $this->render('GestionBundle:finanzas:pagosPendientes.html.twig', array('pagos'=> $result));          
    }

    
}
