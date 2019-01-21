<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoNotificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdonotificacion controller.
 *
 * @Route("cvcdonotificacion")
 */
class CvCdoNotificacionController extends Controller
{
    /**
     * Lists all cvCdoNotificacion entities.
     *
     * @Route("/", name="cvcdonotificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $notificaciones = $em->getRepository('JHWEBContravencionalBundle:CvCdoNotificacion')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($notificaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($notificaciones)." registros encontrados", 
                'data'=> $notificaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoNotificacion entity.
     *
     * @Route("/new", name="cvcdonotificacion_new")
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

            if ($params->notificacion->idComparendoEstado) {
                $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                    $params->notificacion->idComparendoEstado
                );
            }

            foreach ($params->arrayCargos as $key => $idCargo) {
                $notificacion = new CvCdoNotificacion();

                $notificacion->setDia($params->notificacion->dia);
                $notificacion->setHora(new \Datetime($params->notificacion->hora));
                $notificacion->setActivo(true);
                $notificacion->setEstado($estado);
                
                $cargo = $em->getRepository('AppBundle:CfgCargo')->find(
                    $idCargo
                );
                $notificacion->setCargo($cargo);

                $em->persist($notificacion);
            }

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
     * Finds and displays a cvCdoNotificacion entity.
     *
     * @Route("/{id}", name="cvcdonotificacion_show")
     * @Method("GET")
     */
    public function showAction(CvCdoNotificacion $cvCdoNotificacion)
    {
        $deleteForm = $this->createDeleteForm($cvCdoNotificacion);

        return $this->render('cvcdonotificacion/show.html.twig', array(
            'cvCdoNotificacion' => $cvCdoNotificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCdoNotificacion entity.
     *
     * @Route("/edit", name="cvcdonotificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $notificacion = $em->getRepository("JHWEBContravencionalBundle:CvCdoNotificacion")->find($params->id);

            if ($notificacion) {
                $notificacion->setDia($params->notificacion->dia);
                $notificacion->setHora(new \Datetime($params->notificacion->hora));

                if ($params->notificacion->idComparendoEstado) {
                    $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                        $params->notificacion->idComparendoEstado
                    );
                    $notificacion->setEstado($estado);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $notificacion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvCdoNotificacion entity.
     *
     * @Route("/delete", name="cvcdonotificacion_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $notificacion = $em->getRepository('JHWEBContravencionalBundle:CvCdoNotificacion')->find(
                $params->id
            );

            $notificacion->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
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
     * Creates a form to delete a cvCdoNotificacion entity.
     *
     * @param CvCdoNotificacion $cvCdoNotificacion The cvCdoNotificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoNotificacion $cvCdoNotificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdonotificacion_delete', array('id' => $cvCdoNotificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}