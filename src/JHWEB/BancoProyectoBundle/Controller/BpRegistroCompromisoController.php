<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpregistrocompromiso controller.
 *
 * @Route("bpregistrocompromiso")
 */
class BpRegistroCompromisoController extends Controller
{
    /**
     * Lists all bpRegistroCompromiso entities.
     *
     * @Route("/", name="bpregistrocompromiso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $registros = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($registros) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($registros)." registros encontrados", 
                'data'=> $registros,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpRegistroCompromiso entity.
     *
     * @Route("/new", name="bpregistrocompromiso_new")
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

            $registroOld = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->findOneBy(
                array(
                    'numero' => $params->numero,
                )
            );

            if (!$registroOld) {
                $registro = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->find(
                    $params->id
                );

                if ($params->valorApropiado <= $registro->getCdp()->getSaldo()) {
                    $registro->setNumero($params->numero);
                    $registro->setFechaRegistro(new \Datetime(date('Y-m-d')));
                    $registro->setFechaExpedicion(new \Datetime($params->fechaExpedicion));
                    $registro->setContratoNumero($params->contratoNumero);
                    $registro->setContratoTipo($params->contratoTipo);
                    $registro->setContratoEstado($params->contratoEstado);
                    $registro->setValorApropiado($params->valorApropiado);
                    $registro->setSaldo($params->valorApropiado);
                    $registro->setEstado('REGISTRADO');

                    if ($registro->getCdp()) {
                        //Consulta cdp
                        $cdp = $registro->getCdp();
                        //Actualiza saldo del cdp
                        $cdp->setSaldo($cdp->getSaldo() - $params->valorApropiado);
                        //Consulta proyecto
                        $proyecto = $cdp->getActividad()->getCuenta()->getProyecto();
                        //Actualiza saldo del proyecto
                        $proyecto->setSaldoTotal($proyecto->getSaldoTotal() - $params->valorApropiado);
                    }
                    
                    $em->flush();

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito.",
                        'data' => $registro
                    );
                } else {
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => "El valor a apropiar no puede superar el saldo disponible del CDP.",
                    );
                }                
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ya existe un registro de compromismo con el mismo número.",
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a bpRegistroCompromiso entity.
     *
     * @Route("/{id}", name="bpregistrocompromiso_show")
     * @Method("GET")
     */
    public function showAction(BpRegistroCompromiso $bpRegistroCompromiso)
    {
        $deleteForm = $this->createDeleteForm($bpRegistroCompromiso);

        return $this->render('bpregistrocompromiso/show.html.twig', array(
            'bpRegistroCompromiso' => $bpRegistroCompromiso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpRegistroCompromiso entity.
     *
     * @Route("/{id}/edit", name="bpregistrocompromiso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpRegistroCompromiso $bpRegistroCompromiso)
    {
        $deleteForm = $this->createDeleteForm($bpRegistroCompromiso);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpRegistroCompromisoType', $bpRegistroCompromiso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpregistrocompromiso_edit', array('id' => $bpRegistroCompromiso->getId()));
        }

        return $this->render('bpregistrocompromiso/edit.html.twig', array(
            'bpRegistroCompromiso' => $bpRegistroCompromiso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpRegistroCompromiso entity.
     *
     * @Route("/{id}", name="bpregistrocompromiso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpRegistroCompromiso $bpRegistroCompromiso)
    {
        $form = $this->createDeleteForm($bpRegistroCompromiso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpRegistroCompromiso);
            $em->flush();
        }

        return $this->redirectToRoute('bpregistrocompromiso_index');
    }

    /**
     * Creates a form to delete a bpRegistroCompromiso entity.
     *
     * @param BpRegistroCompromiso $bpRegistroCompromiso The bpRegistroCompromiso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpRegistroCompromiso $bpRegistroCompromiso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpregistrocompromiso_delete', array('id' => $bpRegistroCompromiso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================== */

    /**
     * Lista todos los datos en estado REGISTRADO.
     *
     * @Route("/index/register", name="bpregistrocompromiso_index_register")
     * @Method("GET")
     */
    public function indexRegisterAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $registros = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->findBy(
            array(
                'estado' => 'REGISTRADO',
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($registros) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($registros)." registros encontrados", 
                'data'=> $registros,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Crea la solicitud de registro de compromiso.
     *
     * @Route("/request", name="bpregistrocompromiso_request")
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

            $registro = new BpRegistroCompromiso();

            $solicitudFecha = new \Datetime($params->fecha);

            $consecutivo = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->getMaximo(
                $solicitudFecha->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);

            $numero = $solicitudFecha->format('Ym').(str_pad($consecutivo, 4, '0', STR_PAD_LEFT));

            $registro->setSolicitudNumero($numero);
            $registro->setSolicitudFecha($solicitudFecha);
            $registro->setSolicitudConsecutivo($consecutivo);
            $registro->setCuentaNumero($params->cuentaNumero);
            $registro->setCuentaTipo($params->cuentaTipo);
            $registro->setBancoNombre(mb_strtoupper($params->bancoNombre));
            $registro->setValor($params->valor);
            $registro->setConcepto($params->concepto);
            $registro->setEstado('SOLICITUD');

            if ($params->idCdp) {
                //Consulta cdp
                $cdp = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->find($params->idCdp);
                $registro->setCdp($cdp);
            }

            if ($params->idCiudadano) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                    $params->idCiudadano
                );
                $registro->setCiudadano($ciudadano);
            }

            if ($params->idEmpresa) {
                $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                    $params->idEmpresa
                );
                $registro->setEmpresa($empresa);
            }

            $registro->setActivo(true);

            $em->persist($registro);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
                'data' => $registro,
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
     * Busca la solicitud de registro de compromiso 
     *
     * @Route("/search/solicitud/numero", name="bpregistrocompromiso_search_solicitud_numero")
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

            $solicitud = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->findOneBy(
                array(
                    'solicitudNumero' => $params->numero
                )
            );

            if ($solicitud) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Solicitud encontrada con éxito.",
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
     * Busca el registro de compromiso por numero
     *
     * @Route("/search/numero", name="bpregistrocompromiso_search_numero")
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

            $solicitud = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->findOneBy(
                array(
                    'numero' => $params->numero
                )
            );

            if ($solicitud) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito.",
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
     * Genera pdf de solicitud seleccionada.
     *
     * @Route("/request/{id}/pdf", name="bpregistrocompromiso_pdf")
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

        $solicitud = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->find($id);

        $html = $this->renderView('@JHWEBBancoProyecto/Default/pdf.solicitud.compromiso.html.twig', array(
            'fechaActual' => $fechaActual,
            'anio' => $anio,
            'mes' => $mes,
            'dia' => $dia,
            'solicitud'=> $solicitud,
        ));

        $this->get('app.pdf')->templateEmpty($html, $solicitud->getNumero());
    }

    /**
     * Busca registro de compromiso por numero de contrato
     *
     * @Route("/search/numero/contrato", name="bpregistrocompromiso_search_numero_contrato")
     * @Method({"GET", "POST"})
     */
    public function searchByNumeroContratoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $registro = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->findOneBy(
                array(
                    'contratoNumero' => $params->numero
                )
            );

            if ($registro) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito.",
                    'data' => $registro,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No exite registro para el numero de contrato: ".$params->numero." no encontrado.", 
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
}
