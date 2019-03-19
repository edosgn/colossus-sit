<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLicenciaTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userlicenciatransito controller.
 *
 * @Route("userlicenciatransito")
 */
class UserLicenciaTransitoController extends Controller
{
    /**
     * Lists all userLicenciaTransito entities.
     *
     * @Route("/", name="userlicenciatransito_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLicenciaTransitos = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaTransito')->findAll();

        return $this->render('userlicenciatransito/index.html.twig', array(
            'userLicenciaTransitos' => $userLicenciaTransitos,
        ));
    }

    /**
     * Creates a new userLicenciaTransito entity.
     *
     * @Route("/new", name="userlicenciatransito_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userLicenciaTransito = new Userlicenciatransito();
        $form = $this->createForm('JHWEB\UsuarioBundle\Form\UserLicenciaTransitoType', $userLicenciaTransito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userLicenciaTransito);
            $em->flush();

            return $this->redirectToRoute('userlicenciatransito_show', array('id' => $userLicenciaTransito->getId()));
        }

        return $this->render('userlicenciatransito/new.html.twig', array(
            'userLicenciaTransito' => $userLicenciaTransito,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userLicenciaTransito entity.
     *
     * @Route("/{id}/show", name="userlicenciatransito_show")
     * @Method("GET")
     */
    public function showAction(UserLicenciaTransito $userLicenciaTransito)
    {
        $deleteForm = $this->createDeleteForm($userLicenciaTransito);

        return $this->render('userlicenciatransito/show.html.twig', array(
            'userLicenciaTransito' => $userLicenciaTransito,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userLicenciaTransito entity.
     *
     * @Route("/{id}/edit", name="userlicenciatransito_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserLicenciaTransito $userLicenciaTransito)
    {
        $deleteForm = $this->createDeleteForm($userLicenciaTransito);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserLicenciaTransitoType', $userLicenciaTransito);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userlicenciatransito_edit', array('id' => $userLicenciaTransito->getId()));
        }

        return $this->render('userlicenciatransito/edit.html.twig', array(
            'userLicenciaTransito' => $userLicenciaTransito,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userLicenciaTransito entity.
     *
     * @Route("/{id}/delete", name="userlicenciatransito_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserLicenciaTransito $userLicenciaTransito)
    {
        $form = $this->createDeleteForm($userLicenciaTransito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userLicenciaTransito);
            $em->flush();
        }

        return $this->redirectToRoute('userlicenciatransito_index');
    }

    /**
     * Creates a form to delete a userLicenciaTransito entity.
     *
     * @param UserLicenciaTransito $userLicenciaTransito The userLicenciaTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserLicenciaTransito $userLicenciaTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userlicenciatransito_delete', array('id' => $userLicenciaTransito->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================== */

    /**
     * Finds and displays a userCfgEmpresaTipo entity.
     *
     * @Route("/search/actual", name="usercfgempresatipo_search_actual")
     * @Method("GET")
     */
    public function searchActualAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $licenciaTransito = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaTransito')->findOneBy(
                array(
                    'propietario' => $params->idPropietario,
                    'activo' => true,
                )
            );

            $em->persist($licenciaTransito);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $licenciaTransito
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
}
