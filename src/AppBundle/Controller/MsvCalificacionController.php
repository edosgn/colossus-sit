<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvCalificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvcalificacion controller.
 *
 * @Route("msvcalificacion")
 */
class MsvCalificacionController extends Controller
{
    /**
     * Lists all msvCalificacion entities.
     *
     * @Route("/", name="msvcalificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvCalificacions = $em->getRepository('AppBundle:MsvCalificacion')->findAll();

        return $this->render('msvcalificacion/index.html.twig', array(
            'msvCalificacions' => $msvCalificacions,
        ));
    }

    /**
     * Creates a new msvCalificacion entity.
     *
     * @Route("/new", name="msvcalificacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    $helpers = $this->get("app.helpers");
    $hash = $request->get("authorization", null);
    $authCheck = $helpers->authCheck($hash);
    if ($authCheck == true) {
        $json = $request->get("data", null);
        $params = json_decode($json);
        $em = $this->getDoctrine()->getManager();

        foreach ($params->parametros[0] as $keyParametro => $parametro) {
            foreach ($parametro->variables as $keyVariable => $variable) {
                foreach ($variable->criterios as $keyCriterio => $criterio) {
                    $criterioA = $em->getRepository('AppBundle:MsvCriterio')->find($criterio->id);
                    $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresa);
                    $revision = $em->getRepository('AppBundle:MsvRevision')->find($params->revision);
    
                    $msvCalificacion = new MsvCalificacion();
                    $msvCalificacion->setCriterio($criterioA);
                    $msvCalificacion->setEmpresa($empresa);
                    $msvCalificacion->setRevision($revision);
                    $msvCalificacion->setAplica($criterio->aplica);
                    $msvCalificacion->setEvidencia($criterio->evidencia);
                    $msvCalificacion->setResponde($criterio->responde);
                    $msvCalificacion->setObservacion($criterio->observacion);
                    if ($criterio->responde == true) {
                        $msvCalificacion->setValorObtenido($parametro->valor / $parametro->numeroCriterios);
                    } else {
                        $msvCalificacion->setValorObtenido(0);
                    }
                    $msvCalificacion->setEstado(true);
                    $em->persist($msvCalificacion);
                    $em->flush();
                }
            }
        }
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "Registros creados con éxito",
        );
    } else {
        $response = array(
            'status' => 'error',
            'code' => 400,
            'message' => "Autorización no válida",
        );
    }
    return $helpers->json($response);
}


    /**
     * Finds and displays a msvCalificacion entity.
     *
     * @Route("/{id}", name="msvcalificacion_show")
     * @Method("GET")
     */
    public function showAction(MsvCalificacion $msvCalificacion)
    {
        $deleteForm = $this->createDeleteForm($msvCalificacion);

        return $this->render('msvcalificacion/show.html.twig', array(
            'msvCalificacion' => $msvCalificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvCalificacion entity.
     *
     * @Route("/{id}/edit", name="msvcalificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $cfgPlaca = $em->getRepository('AppBundle:CfgPlaca')->find($params->id);
            $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);

            if ($cfgPlaca != null) {
                $cfgPlaca->setNumero($numero);
                $cfgPlaca->setEstado($estado);
                $cfgPlaca->setClase($clase);
                $cfgPlaca->setSedeOperativa($sedeOperativa);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cfgPlaca);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Placa editada con éxito",
                );

            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La placa no se encuentra en la base de datos",
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autrización no válida para editar placa",
                );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a msvCalificacion entity.
     *
     * @Route("/{id}", name="msvcalificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvCalificacion $msvCalificacion)
    {
        $form = $this->createDeleteForm($msvCalificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvCalificacion);
            $em->flush();
        }

        return $this->redirectToRoute('msvcalificacion_index');
    }

    /**
     * Creates a form to delete a msvCalificacion entity.
     *
     * @param MsvCalificacion $msvCalificacion The msvCalificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvCalificacion $msvCalificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvcalificacion_delete', array('id' => $msvCalificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
