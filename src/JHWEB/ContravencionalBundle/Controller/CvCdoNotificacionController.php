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
            $json = $request->get("json",null);
            $params = json_decode($json);
           
            $notificacion = new CvCdoNotificacion();

            $notificacion->setDia($params->notificacion->dia);
            $notificacion->setHora(new \Datetime($params->notificacion->hora));
            $notificacion->setActivo(true);

            if ($params->notificacion->idComparendoEstado) {
                $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                    $params->notificacion->idComparendoEstado
                );
                $notificacion->setEstado($estado);
            }

            /*foreach ($params->arrayCargos as $key => $cargo) {
                # code...
            }*/

            var_dump($params->arrayCargos);
            die();

            $em = $this->getDoctrine()->getManager();
            $em->persist($notificacion);
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
     * @Route("/{id}/edit", name="cvcdonotificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCdoNotificacion $cvCdoNotificacion)
    {
        $deleteForm = $this->createDeleteForm($cvCdoNotificacion);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoNotificacionType', $cvCdoNotificacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcdonotificacion_edit', array('id' => $cvCdoNotificacion->getId()));
        }

        return $this->render('cvcdonotificacion/edit.html.twig', array(
            'cvCdoNotificacion' => $cvCdoNotificacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCdoNotificacion entity.
     *
     * @Route("/{id}", name="cvcdonotificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoNotificacion $cvCdoNotificacion)
    {
        $form = $this->createDeleteForm($cvCdoNotificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoNotificacion);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdonotificacion_index');
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
