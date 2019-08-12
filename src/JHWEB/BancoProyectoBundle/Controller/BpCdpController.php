<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpCdp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Numbers_Words;

/**
 * Bpcdp controller.
 *
 * @Route("bpcdp")
 */
class BpCdpController extends Controller
{
    /**
     * Lists all bpCdp entities.
     *
     * @Route("/", name="bpcdp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cdps = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cdps) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cdps)." registros encontrados", 
                'data'=> $cdps,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpCdp entity.
     *
     * @Route("/new", name="bpcdp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $fechaExpedicion = new \Datetime($params->fechaExpedicion);

            $cdp = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->find(
                $params->id
            );

            $consecutivo = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->getMaximo(
                $fechaExpedicion->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            
            //$cdp->solicitudConsecutivo($consecutivo);

            $numero = str_pad($consecutivo, 3, '0', STR_PAD_LEFT).'-'.$fechaExpedicion->format('Y');

            $cdp->setNumero($numero);

            $cdp->setFechaRegistro(new \Datetime(date('Y-m-d')));
            $cdp->setFechaExpedicion($fechaExpedicion);
            $cdp->setTerceroIdentificacion($params->terceroIdentificacion);
            $cdp->setTerceroNombre(mb_strtoupper($params->terceroNombre, 'utf-8'));
            $cdp->setObservaciones($params->observaciones);
            $cdp->setActivo(true);
            
            if ($params->idFuncionario) {
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                    $params->idFuncionario
                );
                $cdp->setExpide($funcionario);
            }

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
                'data' => $cdp
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a bpCdp entity.
     *
     * @Route("/{id}/show", name="bpcdp_show")
     * @Method("GET")
     */
    public function showAction(BpCdp $bpCdp)
    {
        $deleteForm = $this->createDeleteForm($bpCdp);

        return $this->render('bpcdp/show.html.twig', array(
            'bpCdp' => $bpCdp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpCdp entity.
     *
     * @Route("/{id}/edit", name="bpcdp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpCdp $bpCdp)
    {
        $deleteForm = $this->createDeleteForm($bpCdp);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpCdpType', $bpCdp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpcdp_edit', array('id' => $bpCdp->getId()));
        }

        return $this->render('bpcdp/edit.html.twig', array(
            'bpCdp' => $bpCdp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpCdp entity.
     *
     * @Route("/{id}/delete", name="bpcdp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpCdp $bpCdp)
    {
        $form = $this->createDeleteForm($bpCdp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpCdp);
            $em->flush();
        }

        return $this->redirectToRoute('bpcdp_index');
    }

    /**
     * Creates a form to delete a bpCdp entity.
     *
     * @param BpCdp $bpCdp The bpCdp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpCdp $bpCdp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpcdp_delete', array('id' => $bpCdp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================== */

    /**
     * Creates a request bpCdp entity.
     *
     * @Route("/request", name="bpcdp_request")
     * @Method({"GET", "POST"})
     */
    public function requestAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $cdp = new BpCdp();

            $solicitudFecha = new \Datetime(date('Y-m-d'));

            $consecutivo = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->getMaximo(
                $solicitudFecha->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);

            $numero = $solicitudFecha->format('Y').(str_pad($consecutivo, 3, '0', STR_PAD_LEFT));

            $cdp->setSolicitudNumero($numero);
            $cdp->setSolicitudFecha($solicitudFecha);
            $cdp->setSolicitudConsecutivo($consecutivo);

            if ($params->idActividad) {
                $actividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($params->idActividad);
                $cdp->setActividad($actividad);
                $cdp->setValor($actividad->getCostoTotal());
                $cdp->setSaldo($actividad->getCostoTotal());

                $valorEnLetras = Numbers_Words::toWords(
                    $actividad->getCostoTotal(), 'es'
                );
                $cdp->setValorLetras(mb_strtoupper($valorEnLetras, 'utf-8'));
            }


            $cdp->setActivo(true);

            $em->persist($cdp);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Busca la solicitud de CDP 
     *
     * @Route("/search/solicitud/numero", name="bpcdp_search_solicitud_numero")
     * @Method({"GET", "POST"})
     */
    public function searchSolicitudByNumeroAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $solicitud = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->findOneBy(
                array(
                    'solicitudNumero' => $params->numero
                )
            );

            if ($solicitud) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito.",
                    'data' => $solicitud,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Solicitud no encontrada.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Busca el CDP por numero
     *
     * @Route("/search/numero", name="bpcdp_search_numero")
     * @Method({"GET", "POST"})
     */
    public function searchByNumeroAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $solicitud = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->findOneBy(
                array(
                    'numero' => $params->numero
                )
            );

            if ($solicitud) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito.",
                    'data' => $solicitud,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Solicitud no encontrada.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Genera pdf de factura seleccionada.
     *
     * @Route("/request/{id}/pdf", name="bpcdp_pdf")
     * @Method("GET")
     */
    public function pdfAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');

        $solicitud = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->find($id);

       
        $html = $this->renderView('@JHWEBBancoProyecto/Default/pdf.solicitud.html.twig', array(
            'fechaActual' => $fechaActual,
            'anio' => $anio,
            'mes' => $mes,
            'dia' => $dia,
            'solicitud'=> $solicitud,
        ));

        $this->get('app.pdf')->templateEmpty($html, $solicitud->getNumero());
    }
}
