<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLicenciaConduccionRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userlicenciaconduccionrestriccion controller.
 *
 * @Route("userlicenciaconduccionrestriccion")
 */
class UserLicenciaConduccionRestriccionController extends Controller
{
    /**
     * Lists all userLicenciaConduccionRestriccion entities.
     *
     * @Route("/", name="userlicenciaconduccionrestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLicenciaConduccionRestriccions = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccionRestriccion')->findAll();

        return $this->render('userlicenciaconduccionrestriccion/index.html.twig', array(
            'userLicenciaConduccionRestriccions' => $userLicenciaConduccionRestriccions,
        ));
    }

    /**
     * Creates a new userLicenciaConduccionRestriccion entity.
     *
     * @Route("/new", name="userlicenciaconduccionrestriccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $userLicenciaConduccionRestriccion = new UserLicenciaConduccionRestriccion();

            $userLicenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->find($params->idLicenciaConduccion);
            $userLicenciaConduccionRestriccion->setUserLicenciaConduccion($userLicenciaConduccion);
            $userLicenciaConduccionRestriccion->setFechaResolucion(new \Datetime($params->fechaResolucion));
            $userLicenciaConduccionRestriccion->setFechaResolucion(new \Datetime($params->fechaResolucion));
            $userLicenciaConduccionRestriccion->setTipoActo($params->tipoActo);
            $userLicenciaConduccionRestriccion->setNumResolucion($params->numResolucion);
            $userLicenciaConduccionRestriccion->setEstado('ACTIVO');
            if($params->tipo == 'CANCELACION'){
                $userLicenciaConduccionRestriccion->setFechaCancelacion(new \Datetime($params->fechaCancelacion));
                $userLicenciaConduccionRestriccion->setTipo('CANCELACION');
                $userLicenciaConduccion->setEstado('CANCELADA');

            }else{
                $userLicenciaConduccionRestriccion->setFechaInicio(new \Datetime($params->fechaFin));
                $userLicenciaConduccionRestriccion->setFechaFin(new \Datetime($params->fechaFin));
                $userLicenciaConduccionRestriccion->setTipo('SUSPENSION');
                $userLicenciaConduccion->setEstado('SUSPENDIDA');


            }

            $em->persist($userLicenciaConduccionRestriccion);
            $em->persist($userLicenciaConduccion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito.", 
            );
        } else {
          $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userLicenciaConduccionRestriccion entity.
     *
     * @Route("/{id}", name="userlicenciaconduccionrestriccion_show")
     * @Method("GET")
     */
    public function showAction(UserLicenciaConduccionRestriccion $userLicenciaConduccionRestriccion)
    {
        $deleteForm = $this->createDeleteForm($userLicenciaConduccionRestriccion);

        return $this->render('userlicenciaconduccionrestriccion/show.html.twig', array(
            'userLicenciaConduccionRestriccion' => $userLicenciaConduccionRestriccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userLicenciaConduccionRestriccion entity.
     *
     * @Route("/{id}/edit", name="userlicenciaconduccionrestriccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserLicenciaConduccionRestriccion $userLicenciaConduccionRestriccion)
    {
        $deleteForm = $this->createDeleteForm($userLicenciaConduccionRestriccion);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserLicenciaConduccionRestriccionType', $userLicenciaConduccionRestriccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userlicenciaconduccionrestriccion_edit', array('id' => $userLicenciaConduccionRestriccion->getId()));
        }

        return $this->render('userlicenciaconduccionrestriccion/edit.html.twig', array(
            'userLicenciaConduccionRestriccion' => $userLicenciaConduccionRestriccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userLicenciaConduccionRestriccion entity.
     *
     * @Route("/{id}", name="userlicenciaconduccionrestriccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserLicenciaConduccionRestriccion $userLicenciaConduccionRestriccion)
    {
        $form = $this->createDeleteForm($userLicenciaConduccionRestriccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userLicenciaConduccionRestriccion);
            $em->flush();
        }

        return $this->redirectToRoute('userlicenciaconduccionrestriccion_index');
    }

    /**
     * Creates a form to delete a userLicenciaConduccionRestriccion entity.
     *
     * @param UserLicenciaConduccionRestriccion $userLicenciaConduccionRestriccion The userLicenciaConduccionRestriccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserLicenciaConduccionRestriccion $userLicenciaConduccionRestriccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userlicenciaconduccionrestriccion_delete', array('id' => $userLicenciaConduccionRestriccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
