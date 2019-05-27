<?php

namespace GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GestionBundle\Form\trafico\NotificacionInspectorType;
use GestionBundle\Entity\trafico\NotificacionInspector;

class GestionTraficoController extends Controller
{

	public function notificacionInspectorAction()
	{
		$notificacion = new NotificacionInspector();
		$form = $this->createFormAltaNotificacionInspector($notificacion);
        return $this->render('GestionBundle:trafico:ingresoNotificacionInspector.html.twig', array('form'=>$form->createView()));
	}

    private function createFormAltaNotificacionInspector($notificacion)
    {        
        return $this->createForm(new NotificacionInspectorType(), $notificacion, array('action'=>$this->generateUrl('gestion_trafico_alta_notificacion_inspector_procesar'), 'method'=>'POST'));  
    }	

    public function notificacionInspectorProcesarAction(Request $request)
    {
		$notificacion = new NotificacionInspector();
		$form = $this->createFormAltaNotificacionInspector($notificacion);
		$form->handleRequest($request);
		if ($form->isValid())
		{
            $em = $this->getDoctrine()->getManager();
            $em->persist($notificacion);
            $em->flush();    
            return $this->redirectToRoute('gestion_trafico_alta_notificacion_inspector');  
		} 
        return $this->createForm(new NotificacionInspectorType(), $notificacion, array('action'=>$this->generateUrl('gestion_trafico_alta_notificacion_inspector_procesar'), 'method'=>'POST'));  		   	
    }

    public function printPlanillasAction(Request $request)
    {
        $form = $this->createFormImprimirPlanilla();
        if ( $request->isMethod('POST'))
        {               
            $form->handleRequest($request);
            if ($form->isValid()){
                $data = $request->get('form'); 
                $result = $this->getResultSalidas($data['fecha']);
                $formsPrint = array();
                foreach ($result as $value) {
                    $formsPrint[$value['id']] = $this->formPrint($value['id'])->createView();
                }
                return $this->render('GestionBundle:trafico:printPlanillas.html.twig', array('form'=>$form->createView(), 'recorridos' => $result, 'prints' => $formsPrint));                                 
            }
        }        
        return $this->render('GestionBundle:trafico:printPlanillas.html.twig', array('form'=>$form->createView()));  
    }

    public function printAction(Request $request, $reco)
    {
        try{
        $sql = "SELECT concat(upper(apellidos),', ', upper(c.nombre)) as conductor, date_format(r.fecha, '%d/%m/%Y') as fecha,
                        time_format(s.horasalida, '%H:%i') as salidaida, time_format(s.horallegada, '%H:%i') as llegadaida,
                        time_format(vta.horasalida, '%H:%i') as salidavta, time_format(vta.horallegada, '%H:%i') as llegadavta, interno, ci.impresion
                        FROM recorridos r
                        inner join vueltasxrecorrido vxr on vxr.idrecorrido = r.id
                        inner join vueltasdiarias v on v.id = vxr.idvueltadiaria
                        inner join coches ch on ch.id = idcoche
                        inner join conductores c on c.id = v.idconductor
                        inner join vueltas vu on vu.id = v.idvuelta
                        inner join servicios s on s.id = vu.idservicioida
                        inner join viajes vje on vje.id = s.idviaje
                        inner join ciudades ci on ci.id = vje.iddestino
                        inner join servicios vta on vta.id = vu.idserviciovuelta
                        WHERE r.id = $reco and s.visible and s.imprimible
                ORDER BY salidaida";        
        $link = $this->getLink();
        $result = mysqli_query($link, $sql);
        $handle = printer_open('HP LaserJet Pro MFP M127-M128 PCLmS');

        printer_start_doc($handle, "Mi Documento");
        printer_start_page($handle);



        $despX = 0; //corre el puntero hacia la izquierda
        $inicioX = 580; //inicializa la posicion del puntero en x

        $inicioY = 900;
        $despY = 0;
        $internos = array();
        $imprimioEncabezado = false;

        $encaX = 1210;
        $encaY = 550;
        foreach ($result as $value) {
            $font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
            printer_select_font($handle, $font);     
            if (!$imprimioEncabezado){
                printer_draw_text($handle, $value['conductor'], ($encaX), ($encaY));
                printer_draw_text($handle, $value['fecha'], ($encaX + 2350), ($encaY));
                printer_draw_text($handle, $reco, ($encaX + 1300), ($encaY - 400));
                $imprimioEncabezado = true;
            }
            if ($value['interno'])
            {
                if (!in_array($value['interno'], $internos))
                    $internos[] = $value['interno']; 
            }
                   
            printer_draw_text($handle, $value['impresion'], ($inicioX + $despX), ($inicioY + $despY));
            printer_delete_font($font);
            ////servicios de ida
            $font = printer_create_font("Arial", 84, 40, 400, false, false, false, 0);
            printer_select_font($handle, $font);            
            printer_draw_text($handle, $value['salidaida'], ($inicioX + $despX), ($inicioY + $despY +350));
            printer_draw_text($handle, $value['llegadaida'], ($inicioX + $despX), ($inicioY + $despY + 550));   

            /////////////imprime  el coche
            printer_draw_text($handle, $value['interno'], ($inicioX + $despX + 100), ($inicioY + $despY + 750));   
            /////////// imprime el coche

            printer_draw_text($handle, $value['salidavta'], ($inicioX + $despX + 250), ($inicioY + $despY +350));
            printer_draw_text($handle, $value['llegadavta'], ($inicioX + $despX + 250), ($inicioY + $despY + 550)); 

            printer_delete_font($font);            
                          
            $despX+=0;
            $inicioX+=510;
        }
        $font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
        printer_select_font($handle, $font);   
        $inicioX = 1950;
        foreach ($internos as $int) {
            printer_draw_text($handle, $int, ($inicioX + $despX), (2650)); 
            $despX+=512;
        }
        printer_end_page($handle);
        printer_end_doc($handle);
        printer_close($handle);   
        }catch (Exception $e){
            return new JsonResponse(array('msge'=> $e->getMessagge()));
        }     
    }    

    private function formPrint($id)
    {
        return $this->createFormBuilder()              
                    ->add('print', 'submit', array('label'=>'Imprimir'))      
                    ->setAction($this->generateUrl('gestion_trafico_print_planilla', array('reco' => $id)))
                    ->setMethod('POST')   
                    ->getForm();         
    }

    private function createFormImprimirPlanilla()
    {
        return $this->createFormBuilder()
                    ->add('fecha', 'date', array('widget' => 'single_text', 'required' => true, 'invalid_message'=>'invalid_message for birthday'))                   
                    ->add('save', 'submit', array('label'=>'Cargar Salidas'))                  
                    ->getForm();        
    }

    private function getResultSalidas ($fecha)
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
                WHERE r.fecha = '$fecha'
                group by r.id
                ORDER BY r.fecha, citacion";
        $link = $this->getLink();
        $result = mysqli_query($link, $sql);
        return $result;
    }          

    private function getLink(){
        return mysqli_connect('WIN-PEU1951GJRJ', 'root', 'leo1979', 'promedio');        
    }

}