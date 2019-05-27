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
use GestionBundle\Entity\taller\Anomalia;
use GestionBundle\Form\taller\TareaMantenimientoType;
use GestionBundle\Form\taller\AnomaliaType;
use GestionBundle\Form\taller\DiagramaTareaType;
use GestionBundle\Entity\taller\PlanillaRecepcionAnomalia;
use GestionBundle\Entity\taller\NovedadInterno;
use GestionBundle\Entity\taller\ResultadoNovedad;
use GestionBundle\Entity\personal\ConductorRepository;
use GestionBundle\Entity\taller\AnomaliaDiagramada;

use Symfony\Component\Validator\Constraints\NotBlank;

class GestionTallerController extends Controller
{


	public function altaAnomaliaAction()
	{
        $anomalia = new Anomalia();
        $form = $this->createFormIngresoAnomalia($anomalia);
        return $this->render('GestionBundle:taller:ingresoAnomalia.html.twig', array('form'=>$form->createView())); 
	}

    private function createFormIngresoAnomalia($anomalia)
    {
        return $this->createForm(new AnomaliaType(), $anomalia, array('action'=>$this->generateUrl('taller_alta_anomalia_procesar'), 'method'=>'POST'));
    }

    public function procesarAnomaliaAction(Request $request)
    {
        $anomalia = new Anomalia();
        $form = $this->createFormIngresoAnomalia($anomalia);
        $form->handleRequest($request);
        if ($form->isValid()){
            $anomalia->setPersonaje($this->getUser()->getPersonaje());
            $em = $this->getDoctrine()->getManager();
            $em->persist($anomalia);
            $em->flush();
            return $this->redirectToRoute('taller_alta_anomalia');        	
        }
        return $this->render('GestionBundle:taller:ingresoAnomalia.html.twig', array('form'=>$form->createView()));         
    }   

    public function listaAnomaliaAction()
    {
        $em = $this->getDoctrine()->getManager();    	
    	$repo = $em->getRepository('GestionBundle:taller\Anomalia');
    	return $this->render('GestionBundle:taller:listaAnomalias.html.twig', array('anomalias'=>$repo->getAnomalias()));  
    }	

    public function diagramarTareaAction(Request $request)
    {       
         $form = $this->createFormDiagramacionTareas();
        if ( $request->isMethod('POST'))
        {               
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $data = $request->request->get('form'); 
                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('GestionBundle:taller\Anomalia');
               // $salidad = $this->getResultSalidas($data['desde'], $data['hasta']);
                $anomalias = $repo->getAnomaliasPendientes();
                return $this->render('GestionBundle:taller:diagramarTareas.html.twig', array('form'=>$form->createView(), 'anomalias' => $anomalias)); 
            }
        }            
        return $this->render('GestionBundle:taller:diagramarTareas.html.twig', array('form'=>$form->createView()));  

    }   
    
    private function createFormDiagramacionTareas($label = 'Generar Planilla')
    {
        return $this->createFormBuilder()
                    ->add('desde', 'date', array('widget' => 'single_text', 'constraints' => new  NotBlank()))
                     ->add('empleado', 'entity', array('class' => 'GestionBundle:personal\Conductor',
                                            'query_builder' => function(ConductorRepository $er){
                                                                                                return $er->createQueryBuilder('u')
                                                                                                          ->where('u.activo = :activo')
                                                                                                          ->orderBy('u.apellido')
                                                                                                          ->setParameter('activo', true);
                                                                                             }))                                            
                    ->add('save', 'submit', array('label'=> $label))                  
                    ->getForm();        
                    //->add('hasta', 'date', array('widget' => 'single_text', 'required' => true, 'invalid_message'=>'invalid_message for birthday'))                      
    }

    private function getResultSalidas ($desde, $hasta)
    {
        $sql = "SELECT r.fecha as fecha, concat(upper(apellidos),', ', upper(nombre)) as conductor, SUBTIME(min(s.horasalida),'00:10:00') as citacion, min(s.horasalida) as salida, interno, r.id
                FROM recorridos r
                inner join vueltasxrecorrido vxr on vxr.idrecorrido = r.id
                inner join vueltasdiarias v on v.id = vxr.idvueltadiaria
                inner join coches ch on ch.id = idcoche
                inner join conductores c on c.id = v.idconductor
                inner join vueltas vu on vu.id = v.idvuelta
                inner join servicios s on s.id = vu.idservicioida
                inner join servicios vta on vta.id = vu.idserviciovuelta
                WHERE r.fecha BETWEEN '$desde' and '$hasta'
                group by r.id
                ORDER BY r.fecha, citacion";
        $link = mysqli_connect('WIN-PEU1951GJRJ', 'root', 'leo1979', 'promedio');
        $result = mysqli_query($link, $sql);
        return $result;
    }   

    public function nuevaTareaPlanMantenimientoAction()
    {
        $tarea = new TareaMantenimiento();
        $form = $this->createFormAltaTareaProgramada($tarea);
        return $this->render('GestionBundle:taller:ingresoTarea.html.twig', array('form'=>$form->createView())); 
    }    

    private function createFormAltaTareaProgramada($tarea)
    {
        return $this->createForm(new TareaMantenimientoType(), $tarea, array('action'=>$this->generateUrl('taller_nueva_tarea_plan_mantenimiento_procesar'), 'method'=>'POST'));
    }    

    public function nuevaTareaPlanMantenimientoProcesarAction(Request $request)
    {
        $tarea = new TareaMantenimiento();
        $form = $this->createFormAltaTareaProgramada($tarea);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($tarea);
            $em->flush();
            return $this->redirectToRoute('taller_nueva_tarea_plan_mantenimiento');          
        }
        return $this->render('GestionBundle:taller:ingresoTarea.html.twig', array('form'=>$form->createView()));              
    }

    public function asignarTareaPlanAction()
    {
        $form = $this->createFormAsignacionTareasAPlanMantenimiento();
        return $this->render('GestionBundle:taller:addTareaPlan.html.twig', array('form'=>$form->createView()));          
    }

    private function createFormAsignacionTareasAPlanMantenimiento()
    {
        return $this->createFormBuilder()
                    ->add('planes', 'entity', array('class' => 'GestionBundle:taller\PlanMantenimiento'))     
                    ->add('tareas', 'entity', array('class' => 'GestionBundle:taller\TareaMantenimiento'))        
                    ->add('save', 'submit', array('label'=>'Asignar Tarea')) 
                    ->add('view', 'submit', array('label'=>'Ver Tareas Asignadas'))    
                    ->setAction($this->generateUrl('taller_asignar_tarea_plan_procesar'))
                    ->setMethod('POST')                    
                    ->getForm();        
    }   

    public function asignarTareaPlanProcesarAction(Request $request)
    {
        $form = $this->createFormAsignacionTareasAPlanMantenimiento();
        $form->handleRequest($request);
        $viewPlan = false;
        if ($form->isValid())
        {
            $data = $form->getData();
            $plan = $data['planes'];
            $tarea = $data['tareas'];            
            if ($form->get('view')->isClicked())
            {
                $viewPlan = true;
            }
            else
            {
                $em = $this->getDoctrine()->getManager();
                $tarea->setPlanMantenimiento($plan);
                $em->flush();                
            }
        }
        return $this->render('GestionBundle:taller:addTareaPlan.html.twig', array('form'=>$form->createView(), 'view'=> $viewPlan, 'plan' => $plan));
    } 

    public function nuevoDiagramaAction()
    {
        $diagrama = new DiagramaTarea();
        $form = $this->createFormNuevoDiagrama($diagrama);
        return $this->render('GestionBundle:taller:nuevoDiagrama.html.twig', array('form'=>$form->createView()));        
    }

    private function createFormNuevoDiagrama($diagrama)
    {
        return $this->createForm(new DiagramaTareaType(), $diagrama, array('action'=>$this->generateUrl('taller_diagramar_tarea_proc'), 'method'=>'POST'));
    }     

    public function nuevoDiagramaProcesarAction(Request $request)
    {
        $diagrama = new DiagramaTarea();
        $form = $this->createFormNuevoDiagrama($diagrama); 
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $diagrama->setUsuarioCarga($this->getUser());
            $em->persist($diagrama);
            $em->flush();
            //$form = $this->getFormAddTareaDiagrama($diagrama);  
            return $this->redirectToRoute('taller_diagramar_agregar_tareas', array('id' => $diagrama->getId()));      
           // return $this->render('GestionBundle:taller:nuevoDiagrama.html.twig', array('form'=>$form->createView()));                 
        }  
        return $this->render('GestionBundle:taller:nuevoDiagrama.html.twig', array('form'=>$form->createView()));        
    }

    public function addTareaDiagramaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $diagrama = $em->find('GestionBundle:taller\DiagramaTarea', $id);
        $repo = $em->getRepository('GestionBundle:taller\Anomalia');
        $anomalias = $repo->getAnomaliasPendientes();
        $forms = array();
        foreach ($anomalias as $anom) {
            $forms[$anom->getId()] = $this->getFormDiagTarea($diagrama->getId(), $anom->getId())->createView();
        }

        $formPlan = $this->getFormPlanesMantenimiento();
        return $this->render('GestionBundle:taller:diagramarTareas.html.twig', array('diagrama' => $diagrama, 'anomalias' => $anomalias, 'forms' => $forms, 'formPlan' => $formPlan->createView()));               
    }

    private function getFormPlanesMantenimiento()
    {
        return $this->createFormBuilder()   
                    ->add('diagrama', 'entity', array('class' => 'GestionBundle:taller\PlanMantenimiento'))                                    
                    ->add('procesar', 'submit', array('label'=>'Diagramar'))   
                    ->setAction($this->generateUrl('taller_diagramar_agregar_plan_a_diagrama'))                    
                    ->setMethod('POST')                    
                    ->getForm();            
    }      

    public function addPlanADiagramaAction(Request $request){
        $form = $this->getFormPlanesMantenimiento();
        $form->handleRequest($request);
        $data = $form->getData();
        return new JsonResponse(array('msge' => $data['diagrama']."   fafafaf"));
    }


//procesa la vuelta del diagrama de tareas
    public function procesarDiagramaTareasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $diagrama = $em->find('GestionBundle:taller\DiagramaTarea', $id);
        $forms = array();
        foreach ($diagrama->getTareasProgramadas() as $tarea) {
            $forms[$tarea->getId()] = $this->getFormProcesarDiagTarea($tarea)->createView();
        }
        return $this->render('GestionBundle:taller:procesarDiagramaTareas.html.twig', array('diagrama' => $diagrama, 'anomalias' => $anomalias, 'forms' => $forms));          
    }


    private function getFormProcesarDiagTarea($tarea)
    {
        return $this->createFormBuilder()   
                    ->add('tarea', 'text', array('data' => strtoupper($tarea->getDescripcionTrabajo())))
                    ->add('realizada', 'choice', array('choices'  => array('Si' => true,'No' => false), 'data' => $tarea->getRealizada(), 'choices_as_values' => true))                                    
                    ->add('procesar', 'submit', array('label'=>'+'))   
                    ->setAction($this->generateUrl('taller_diagramar_tareas_procesar_tarea_diagramada', array('id' => $tarea->getId())))
                    ->setMethod('POST')                    
                    ->getForm();            
    }    
///////////////////////////////////////////////////////

    public function finalizarDiagramaAction($id)
    {
        try
        {
            $em = $this->getDoctrine()->getManager();
            $diagrama = $em->find('GestionBundle:taller\DiagramaTarea', $id);            
            $diagrama->setCerrada(true);
            $em->flush();
            return new JsonResponse(array('status' => true));
        }
        catch (Exception $e){print new JsonResponse(array('status' => false, 'msge' => $e->getMessage()));}

    }    

    private function getFormDiagTarea($diagrama, $anomalia)
    {
        return $this->createFormBuilder()   
                    ->add('tarea', 'text', array('constraints' => new  NotBlank()))                
                    ->add('diagramar', 'submit', array('label'=>'+'))   
                    ->setAction($this->generateUrl('taller_diagramar_agregar_tareas_procesar', array('diagrama' => $diagrama, 'anomalia' => $anomalia)))
                    ->setMethod('POST')                    
                    ->getForm();            
    }

    public function addTareaDiagramaProcesarAction($diagrama, $anomalia, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $diagrama = $em->find('GestionBundle:taller\DiagramaTarea', $diagrama);
        if ($diagrama->getCerrada())
            return new JsonResponse(array('status' => false, 'msge' => 'El diagrama se encuentra cerrado!'));
        $anomalia = $em->find('GestionBundle:taller\Anomalia', $anomalia);   
        $form = $this->getFormDiagTarea($diagrama->getId(), $anomalia->getId());
        $form->handleRequest($request); 
        if ($form->isValid()){        
            try{    
                $data = $form->getData();
                $desc = $data['tarea'];
                $tarea = new AnomaliaDiagramada();
                $tarea->setDescripcion($desc);
                $tarea->setDiagramaTarea($diagrama);
                $tarea->setUnidad($anomalia->getUnidad());
                $tarea->setAnomalia($anomalia);
                $anomalia->setDiagramada(true);
                $em->persist($tarea);
                $em->flush();
                return new JsonResponse(array('status' => true));
            }
            catch(\Exception $e){
                            return new JsonResponse(array('status' => false, 'msge' => $e->getMessage()));
            }
        } 
        else{
            return new JsonResponse(array('status' => false, 'msge' => 'Informacion incompleta'));
        }
    }

    public function deleteTareaDiagramaAction($id)
    {
            try
            {
                $em = $this->getDoctrine()->getManager();
                $tarea = $em->find('GestionBundle:taller\TareaDiagramada', $id);       
                $diagrama = $tarea->getDiagramaTarea();
                if ($diagrama->getCerrada())
                    return new JsonResponse(array('status' => false, 'msge' => 'El diagrama se encuentra cerrado!'));                           
                $diagrama->removeTareasProgramada($tarea);      
                $tarea->getAnomaliaDiagramada()->setDiagramada(false);
                $em->remove($tarea);
                $em->flush();
                return new JsonResponse(array('status' => true));
            }
            catch(\Exception $e){
                            return new JsonResponse(array('status' => false, 'msge' => $e->getMessage()));
            }        
    }


    private function getFormAddTareaDiagrama($diagrama)
    {
        return $this->createFormBuilder()   
                    ->add('planes', 'entity', array('class' => 'GestionBundle:taller\PlanMantenimiento'))     
                    ->add('tareas', 'entity', array('class' => 'GestionBundle:taller\TareaMantenimiento'))        
                    ->add('unidades', 'entity', array('class' => 'GestionBundle:Unidad'))                         
                    ->add('save', 'submit', array('label'=>'Asignar Tarea'))   
                    ->setAction($this->generateUrl('taller_asignar_tarea_plan_procesar'))
                    ->setMethod('POST')                    
                    ->getForm();                
    }

    public function recepcionarF015Action()
    {
        $form = $this->getFormLoadF0015();
        $request = $this->getRequest();
        if ( $request->isMethod('POST'))
        {            
            try{
                    $form->handleRequest($request);
                    $data = $request->request->get('form');
                    $em = $this->getDoctrine()->getManager();  
                    $repo = $em->getRepository('GestionBundle:taller\PlanillaRecepcionAnomalia');
                    $planilla = $repo->getPlanillaNovedad($data['numero']);
                    $cerrada = true;
                    if (!$planilla)
                    {                        
                        $cerrada = false;
                        $link = $this->getLink();
                        $sql = "SELECT c.id as idCond, concat(upper(apellidos),', ', upper(c.nombre)) as conductor, ch.id as idCoche, interno, r.fecha
                                FROM recorridos r
                                inner join vueltasxrecorrido vxr on vxr.idrecorrido = r.id
                                inner join vueltasdiarias v on v.id = vxr.idvueltadiaria
                                inner join coches ch on ch.id = idcoche
                                inner join conductores c on c.id = v.idconductor
                                WHERE r.id = $data[numero]
                                group by ch.id";
                        $result = mysqli_query($link, $sql);                      
                        $listaNovedad = $repo->getListaNovedadActiva();
                        $planilla = new PlanillaRecepcionAnomalia();
                       // $row = mysqli_fetch_array($result);
                        while ($row = mysqli_fetch_array($result))
                        {
                            $conductor = $row['idCond'];
                            $fecha = $row['fecha'];
                            $coche = $row['idCoche'];
                            $unidad = $em->find('GestionBundle:Unidad', $coche); /// levanta el coche para generar la planilla de novedades correspondiente al mismo 
                            
                          //  while (($row) && ($coche == $row['idCoche']))
                          //  {
                                $novedadInterno = new NovedadInterno();
                                $novedadInterno->setUnidad($unidad);
                                foreach ($listaNovedad->getItemsNovedad() as $item) {   ////recorre todos los items de las novedades para asi generarle una a cada coche
                                    $resNov = new ResultadoNovedad();
                                    $resNov->setItemNovedad($item);
                                    $novedadInterno->addResultadosNovedad($resNov);
                                }
                                $em->persist($novedadInterno);
                                
                                $planilla->addNovedad($novedadInterno);
                          //  }
                            
                        }
                        $conductor = $em->find('GestionBundle:personal\Conductor', $conductor);
                        $planilla->setConductor($conductor);            
                        $planilla->setFecha(date_create_from_format('Y-m-d', $fecha));
                        $planilla->setUserAlta($this->getUser());
                        $planilla->setNumeroF0015($data['numero']);
                        $em->persist($planilla);
                        $em->flush();
                        
                       //return $this->render('GestionBundle:taller:loadForm0015.html.twig', array('form'=>$form->createView(), 'planilla' => $planilla));    
                    }
                    else{
                            if ($planilla->getCerrada())
                            {
                                $cerrada = true;
                                $this->addFlash('warning', 'La Planilla ya ha sido cerrada, no se podran realizar modificaciones!!');  
                            }
                            else{
                                $cerrada = false;
                            }                        
                    }
                }
                catch(\Exception $e){ return new Response($e->getMessage());}
                $formAction = $this->getFormCloseDeletePlanilla($planilla->getId())->createView();
                $formsNove = array();
                foreach ($planilla->getNovedad() as $datas) {
                    foreach ($datas->getResultadosNovedad() as $result) {
                        $formsNove[$result->getId()] = $this->getFormResultNovedad($result)->createView();
                    }
                    
                }
                return $this->render('GestionBundle:taller:loadForm0015.html.twig', array('cerrada' => $cerrada, 'form'=>$form->createView(), 'planilla' => $planilla, 'results' => $formsNove, 'actions' => $formAction)); 

        }
        return $this->render('GestionBundle:taller:loadForm0015.html.twig', array('form'=>$form->createView()));         
    }

    private function getFormCloseDeletePlanilla($planilla)
    {
        return $this->createFormBuilder()                  
                    ->add('close', 'submit', array('label' => 'Cerrar Planila'))            
                    ->add('delete', 'submit', array('label' => 'Eliminar Planila'))                
                    ->add('action', 'hidden')                                    
                    ->setAction($this->generateUrl('taller_recepcionar_form0015_action_planilla', array('planilla' => $planilla)))
                    ->setMethod('POST')                    
                    ->getForm();                 
    }


    public function accionPlanillaAction($planilla, Request $request)
    {
        if ($request->isXmlHttpRequest())
        {        
            $form = $this->getFormCloseDeletePlanilla($planilla);
            $form->handleRequest($request);
            $data = $request->request->get('form');  
            $em = $this->getDoctrine()->getManager();
            $planilla = $em->find('GestionBundle:taller\PlanillaRecepcionAnomalia', $planilla);
            if ($planilla->getCerrada()){
                $this->addFlash('error', 'La Planilla ya ha sido cerrada!!');               
            }            
            else
            {
                try{                
                        if ($data['action'] == 'c'){
                            $planilla->setCerrada(true);
                            foreach ($planilla->getNovedad() as $novedad) {
                                foreach ($novedad->getResultadosNovedad() as $result) {
                                    if ($result->getFalla()){
                                        $anomalia = new Anomalia();
                                        $anomalia->setFecha($planilla->getFecha());
                                        $anomalia->setObservacion($result->getItemNovedad()->getNombre()." ".$result->getObservacion());
                                        $anomalia->setTipoDesperfecto($result->getItemNovedad()->getTipoDesperfecto());
                                        $anomalia->setNumPlanilla($planilla->getNumeroF0015());
                                        $anomalia->setUnidad($novedad->getUnidad());
                                        $anomalia->setPersonaje($planilla->getConductor());
                                        $em->persist($anomalia);
                                    }
                                }
                            }
                            $this->addFlash('success', 'Planilla cerrada exitosamente!!');   
                        }
                        else{
                            $em->remove($planilla);
                            $this->addFlash('success', 'Planilla eliminada exitosamente!!');                     
                        }
                        $em->flush();
                    }
                    catch (\Exception $e){        return new JsonResponse(array('status' => false, 'msge' => $e->getMessage()));}
            }
        }
        return new JsonResponse(array('status' => true));
    }

    public function changeResultAction(Request $request){
        if ($request->isXmlHttpRequest())
        {
            $data = $request->get('form');
            $em = $this->getDoctrine()->getManager();
            $result = $em->find('GestionBundle:taller\ResultadoNovedad', $data['result']);
            $result->setObservacion($data['obs']);
            $result->setFalla($data['fallo']);
            $em->flush();            
            return new JsonResponse(array('msge' => 'Cambios realizados exitosamente!')); 
        }
    }

    private function getFormResultNovedad($result)
    {
        return $this->createFormBuilder()        
                    ->add('fallo', 'choice', array('choices'  => array('No' => false,'Si' => true),'choices_as_values' => true, 'data' => $result->getFalla()))
                    ->add('obs', 'text', array('data' => $result->getObservacion()))      
                    ->add('result', 'hidden', array('data' => $result->getId()))              
                    ->add('load', 'submit', array('label' => '+'))                       
                    ->setAction($this->generateUrl('taller_recepcionar_form0015_set_result'))
                    ->setMethod('POST')                    
                    ->getForm();         
    }

    private function getFormLoadF0015()
    {
        return $this->createFormBuilder()        
                    ->add('numero', 'number')  
                    ->add('load', 'submit', array('label' => 'Cargar F 0015'))                       
                    ->setAction($this->generateUrl('taller_recepcionar_form0015'))
                    ->setMethod('POST')                    
                    ->getForm();                
    } 

    private function getLink(){
        return mysqli_connect('WIN-PEU1951GJRJ', 'root', 'leo1979', 'promedio');        
    }

    public function listarDiagramaTareasAction()
    {
        $form = $this->createFormDiagramacionTareas('Cargar Diagramas');
        $request = $this->getRequest();
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('GestionBundle:taller\DiagramaTarea');
            $result = $repo->getDiagramaTareaPendiente($data['empleado'], $data['desde']);   
            return $this->render('GestionBundle:taller:viewDiagramasTareas.html.twig', array('form'=>$form->createView(), 'diagramas' => $result));                   
        }
        return $this->render('GestionBundle:taller:viewDiagramasTareas.html.twig', array('form'=>$form->createView()));         

    }

    public function procesarTareaDiagramadaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tarea = $em->find('GestionBundle:taller\TareaDiagramada', $id);    
        $diagrama =  $tarea->getDiagramaTarea();
        if ($diagrama->getProcesada()){
            return new JsonResponse(array('status' => false, 'msge' => 'El diagrama ya ha sido procesado!'));
        } 
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()){
            $data = $request->get('form');  
            $tarea->setRealizada($data['realizada']);
            $tarea->setDescripcionTrabajo($data['tarea']);
            $em->flush();
            return new JsonResponse(array('ok' => true));     
        }
        return new JsonResponse(array('ok' => false));    
    }

    public function finalizarProcesarDiagramaTareasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $diagrama = $em->find('GestionBundle:taller\DiagramaTarea', $id);    
        if ($diagrama->getProcesada()){
            return new JsonResponse(array('status' => false, 'msge' => 'El diagrama ya ha sido procesado!'));
        }
        $diagrama->setProcesada(true); 
        $diagrama->setFechaProcesado(new \DateTime());
        $diagrama->setUsuarioProcesado($this->getUser());

        foreach ($diagrama->getTareasProgramadas() as $tarea) {
            $tarea->resultadoTarea();
        }
        $em->flush();
        return $this->redirectToRoute('taller_diagramar_tareas_procesar', array('id' => $id));   
    }

    public function imprimirDiagramaTareasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $diagrama = $em->find('GestionBundle:taller\DiagramaTarea', $id);    

        $pdf = $this->get('app.fpdf');

        $pdf->AliasNbPages();
        $pdf->AddPage('L', 'A4');
        $pdf->SetFont('Times','',8);
        $pdf->SetAutoPageBreak(true,0);  

        $pdf->SetFillColor(255, 255, 255);

        $manager = $this->get('templating.helper.assets');
        $logo = $manager->getURL('/bundles/gestion/images/sta_rita.jpg');

        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/bundles/gestion/images/sta_rita.jpg';        
     //   return new Response($publicResourcesFolderPath);

        $pdf->Image($publicResourcesFolderPath,$pdf->getX(),$pdf->getY(), 50,15);//(80,7,' ',1, 0, 'C', True);
        $pdf->SetFont('Times','',13);          
        $pdf->Cell(80,15,'',1, 0, 'C', False);
        $pdf->Cell(80,15,'PARTE DIARIO',1, 0, 'C', False);        
        $pdf->Cell(0,15,'FORM: 0016   Version: 1.0   Vigencia: 16/04/2019',1, 1, 'C', TRUE);      
        $pdf->SetFont('Times','',13);        
        $pdf->Cell(100,13,'RESPONSABLE: '.$diagrama->getResponsable(),'LB', 0, 'L', False);         
        $pdf->Cell(60,13,'PARTE NRO.: '.str_pad($diagrama->getId(), 6, "0", STR_PAD_LEFT),0, 0, 'C', False);              
        $pdf->Cell(0,13,'FECHA: '.$diagrama->getFecha()->format('d/m/Y'),'RB', 1, 'R', TRUE);    

        $pdf->SetFont('Times','',10);        
        $pdf->Cell(20,7,'INTERNO', 1, 0, 'C', False);         
        $pdf->Cell(120,7,'TRABAJO A REALIZAR',1, 0, 'C', False);                
        $pdf->Cell(25,7,'REALIZADA',1, 0, 'C', False);    
        $pdf->Cell(0,7,'OBSERVACIONES',1, 1, 'C', False);    


        foreach ($diagrama->getTareasProgramadas() as $tarea) {
            $pdf->Cell(20,10,$tarea->getUnidad(), 1, 0, 'C', False);         
            $pdf->Cell(120,10,strtoupper($tarea->getDescripcion()),1, 0, 'L', False);                
            $pdf->Cell(25,10,'',1, 0, 'C', False);    
            $pdf->Cell(0,10,'',1, 1, 'C', False);               
        }

        $pdf->Text($pdf->getX(),200,'FIRMA:__________________________________                                                DIAGRAMADO POR: '.$diagrama->getUsuarioCarga());    
        return new Response($pdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'));
    }
}