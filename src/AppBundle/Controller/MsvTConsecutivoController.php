<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvTConsecutivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvtconsecutivo controller.
 *
 * @Route("msvtconsecutivo")
 */
class MsvTConsecutivoController extends Controller
{
    /**
     * Lists all msvTConsecutivo entities.
     *
     * @Route("/", name="msvtconsecutivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $consecutivos = $em->getRepository('AppBundle:MsvTConsecutivo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($consecutivos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($consecutivos)." Registros encontrados", 
                'data'=> $consecutivos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new msvTConsecutivo entity.
     *
     * @Route("/new", name="msvtconsecutivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            
                $consecutivo = new MsvTConsecutivo();

                $consecutivo->setInicio($params->incio);
                $consecutivo->setFin($params->fin);
                $consecutivo->setFechaAsignación(new \Datetime($params->fechaAsignacion));
                $consecutivo->setNumeroResolucion($params->numeroResolucion);

                $sedeOperativa = $em->getRepository('AppBundle:sedeOperativa')->find(
                    $params->sedeOperativaId
                );
                $consecutivo->setSedeOperativa($sedeOperativa);

                $em = $this->getDoctrine()->getManager();
                $em->persist($consecutivo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",  
                );
            //}
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
     * Finds and displays a msvTConsecutivo entity.
     *
     * @Route("/{id}/show", name="msvtconsecutivo_show")
     * @Method("GET")
     */
    public function showAction(MsvTConsecutivo $msvTConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($msvTConsecutivo);

        return $this->render('msvtconsecutivo/show.html.twig', array(
            'msvTConsecutivo' => $msvTConsecutivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvTConsecutivo entity.
     *
     * @Route("/{id}/edit", name="msvtconsecutivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvTConsecutivo $msvTConsecutivo)
    {
        $deleteForm = $this->createDeleteForm($msvTConsecutivo);
        $editForm = $this->createForm('AppBundle\Form\MsvTConsecutivoType', $msvTConsecutivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvtconsecutivo_edit', array('id' => $msvTConsecutivo->getId()));
        }

        return $this->render('msvtconsecutivo/edit.html.twig', array(
            'msvTConsecutivo' => $msvTConsecutivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvTConsecutivo entity.
     *
     * @Route("/{id}/delete", name="msvtconsecutivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvTConsecutivo $msvTConsecutivo)
    {
        $form = $this->createDeleteForm($msvTConsecutivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvTConsecutivo);
            $em->flush();
        }

        return $this->redirectToRoute('msvtconsecutivo_index');
    }

    /**
     * Creates a form to delete a msvTConsecutivo entity.
     *
     * @param MsvTConsecutivo $msvTConsecutivo The msvTConsecutivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvTConsecutivo $msvTConsecutivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvtconsecutivo_delete', array('id' => $msvTConsecutivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * busca ipat por numero de consecutivo mas reciente.
     *
     * @Route("/search/last/sede", name="msvtconsecutivo_search_last_sede")
     * @Method({"GET", "POST"})
     */
    public function searchLastBySedeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
        
            $ipat = $em->getRepository('AppBundle:MsvTConsecutivo')->getLastBySede(
                $params->sedeOperativa->id
            );

            if ($ipat) {
                $ipat = $em->getRepository('AppBundle:MsvTConsecutivo')->find(
                    $ipat['id']
                );

                if ($ipat) {
                    $ipat->setEstado("EN TRAMITE");

                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro encontrado",
                        'data' => $ipat,
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Registro no encontrado", 
                    );
                }
            }else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No existe ningún IPAT disponible para la sede.", 
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }

        return $helpers->json($response);
    }
     /**
     * busca ipats por sede Operativa.
     *
     * @Route("/operativasede", name="operativasede_search_consecutivos")
     * @Method({"GET", "POST"})
     */
    public function searchBySedeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            /*$ipats = $em->getRepository('AppBundle:MsvTConsecutivo')->getBySede(
                $params->identificacionUsuario
            );*/

            $ipats = $em->getRepository('AppBundle:MsvTConsecutivo')->findById(
                1
            );

            if ($ipats != null) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data' => $ipats,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado", 
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }
}
