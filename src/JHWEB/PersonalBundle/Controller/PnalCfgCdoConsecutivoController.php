<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalcfgcdoconsecutivo controller.
 *
 * @Route("pnalcfgcdoconsecutivo")
 */
class PnalCfgCdoConsecutivoController extends Controller
{
    /**
     * Lists all pnalCfgCdoConsecutivo entities.
     *
     * @Route("/", name="pnalcfgcdoconsecutivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pnalCfgCdoConsecutivos = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findAll();

        return $this->render('pnalcfgcdoconsecutivo/index.html.twig', array(
            'pnalCfgCdoConsecutivos' => $pnalCfgCdoConsecutivos,
        ));
    }

    /**
     * Creates a new pnalCfgCdoConsecutivo entity.
     *
     * @Route("/new", name="pnalcfgcdoconsecutivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $funcionario = $em->getRepository("JHWEBPersonalBundle:PnalFuncionario")->find(
                $params->idFuncionario
            );

            $divipo = $funcionario->getOrganismoTransito()->getDivipo();
        
            for ($numero = $params->desde; $numero <= $params->hasta; $numero++) {
                if ($funcionario->getOrganismoTransito()->getAsignacionRango()) {
                    $numeroComparendo = $divipo.$numero;
                }else{
                    $numeroComparendo = $numero;
                }
                
                $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findOneByNumero(
                    $numeroComparendo
                );
    
                if ($consecutivo) {
                    $consecutivo->setFechaAsignacion(new \Datetime($params->fechaAsignacion));
                    $consecutivo->setFuncionario($funcionario);
    
                    $em->flush();
                }
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registros creados con exito.',
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida para editar.', 
            );
        }

        return $helpers->json($response);
        
    }

    /**
     * Finds and displays a pnalCfgCdoConsecutivo entity.
     *
     * @Route("/{id}/show", name="pnalcfgcdoconsecutivo_show")
     * @Method("GET")
     */
    public function showAction(PnalCfgCdoConsecutivo $pnalCfgCdoConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($pnalCfgCdoConsecutivo);

        return $this->render('pnalcfgcdoconsecutivo/show.html.twig', array(
            'pnalCfgCdoConsecutivo' => $pnalCfgCdoConsecutivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalCfgCdoConsecutivo entity.
     *
     * @Route("/{id}/edit", name="pnalcfgcdoconsecutivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalCfgCdoConsecutivo $pnalCfgCdoConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($pnalCfgCdoConsecutivo);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalCfgCdoConsecutivoType', $pnalCfgCdoConsecutivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalcfgcdoconsecutivo_edit', array('id' => $pnalCfgCdoConsecutivo->getId()));
        }

        return $this->render('pnalcfgcdoconsecutivo/edit.html.twig', array(
            'pnalCfgCdoConsecutivo' => $pnalCfgCdoConsecutivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalCfgCdoConsecutivo entity.
     *
     * @Route("/{id}/delete", name="pnalcfgcdoconsecutivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalCfgCdoConsecutivo $pnalCfgCdoConsecutivo)
    {
        $form = $this->createDeleteForm($pnalCfgCdoConsecutivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalCfgCdoConsecutivo);
            $em->flush();
        }

        return $this->redirectToRoute('pnalcfgcdoconsecutivo_index');
    }

    /**
     * Creates a form to delete a pnalCfgCdoConsecutivo entity.
     *
     * @param PnalCfgCdoConsecutivo $pnalCfgCdoConsecutivo The pnalCfgCdoConsecutivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalCfgCdoConsecutivo $pnalCfgCdoConsecutivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalcfgcdoconsecutivo_delete', array('id' => $pnalCfgCdoConsecutivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================= */

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/record/funcionario", name="pnalcfgcdoconsecutivo_record_funcionario")
     * @Method({"GET", "POST"})
     */
    public function recordFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $comparendos['data'] = array();

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $comparendos = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findByFuncionario(
                $params->id
            );
                
            if ($comparendos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($comparendos)." registros encontrados",  
                    'data'=> $comparendos,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado",
                    'data' => $response['data'] = array(),
                );
            }

            
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
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/last/funcionario", name="pnalcfgcdoconsecutivo_last_funcionario")
     * @Method({"GET", "POST"})
     */
    public function searchLastByFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->getLastByFuncionario(
                $params->funcionario->id
            );
                 
            if ($consecutivo) {
                $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->find(
                    $consecutivo['id']
                );
                $consecutivo->setEstado('EN TRAMITE');

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Número de comparendo disponible.",  
                    'data'=> $consecutivo,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún número de comparendo disponible para el agente de transito seleccionado.",
                );
            }
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
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/funcionario", name="pnalcfgcdoconsecutivo_funcionario")
     * @Method({"GET", "POST"})
     */
    public function searchByFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $consecutivos['data'] = array();

            $consecutivos = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->getByFuncionario(
                $params
            );
                 
            if ($consecutivos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrados.",  
                    'data'=> $consecutivos,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.",
                );
            }
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
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/numero/funcionario", name="pnalcfgcdoconsecutivo_numero_funcionario")
     * @Method({"GET", "POST"})
     */
    public function searchByNumeroAndFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $consecutivo = $em->getRepository('JHWEBPersonalBundle:PnalCfgCdoConsecutivo')->findOneBy(
                array(
                    'funcionario' => $params->idFuncionario,
                    'numero' => $params->numero,
                )
            );
                 
            if ($consecutivo) {
                if ($consecutivo->getEstado() == 'UTILIZADO') {
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => 'El consecutivo se ecnuetra en estado '.$consecutivo->getEstado().' por lo tanto no se puede diligenciar.',
                    );
                }elseif ($consecutivo->getEstado() == 'ASIGNADO') {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro encontrado con exito.",  
                        'data'=> $consecutivo,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => 'El consecutivo se encuenra en estado '.$consecutivo->getEstado().' para poder utilizarlo debe estar ASIGNADO.',
                    );
                }
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }
}
