<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgFuncion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Svcfgfuncion controller.
 *
 * @Route("svcfgfuncion")
 */
class SvCfgFuncionController extends Controller
{
    /**
     * Lists all svCfgFuncion entities.
     *
     * @Route("/", name="svcfgfuncion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgFunciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->findAll();

        return $this->render('svcfgfuncion/index.html.twig', array(
            'svCfgFunciones' => $svCfgFunciones,
        ));
    }

    /**
     * Creates a new svCfgFuncion entity.
     *
     * @Route("/new", name="svcfgfuncion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $funcion = new SvCfgFuncion();

            $em = $this->getDoctrine()->getManager();

            $soat->setNombre($params->nombre);
            $soat->setActivo(true);
            $em->persist($soat);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
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
     * Finds and displays a svCfgFuncion entity.
     *
     * @Route("/{id}/show", name="svcfgfuncion_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(SvCfgFuncion $svCfgFuncion)
    {
        $deleteForm = $this->createDeleteForm($svCfgFuncion);
        return $this->render('svCfgFuncion/show.html.twig', array(
            'svCfgFuncion' => $svCfgFuncion,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing SvCfgFuncion entity.
     *
     * @Route("/{id}/edit", name="svcfgfuncion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCfgFuncion $svCfgFuncion)
    {
        $deleteForm = $this->createDeleteForm($svCfgFuncion);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\SvCfgFuncionType', $svCfgFuncion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svcfgfuncion_edit', array('id' => $svCfgFuncion->getId()));
        }

        return $this->render('svcfgfuncion/edit.html.twig', array(
            'svcfgfuncion' => $svCfgFuncion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svCfgFuncion entity.
     *
     * @Route("/{id}", name="svcfgfuncion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgFuncion $svCfgFuncion)
    {
        $form = $this->createDeleteForm($svCfgFuncion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgFuncion);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgfuncion_index');
    }

    /**
     * Creates a form to delete a SvCfgFuncion entity.
     *
     * @param SvCfgFuncion $svCfgFuncion The SvCfgFuncion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgFuncion $svCfgFuncion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svCfgFuncion_delete', array('id' => $svCfgFuncion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="funcion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $funciones = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgFuncion')->findBy(
        array('activo' => 1)
    );
      foreach ($funciones as $key => $funcion) {
        $response[$key] = array(
            'value' => $funcion->getId(),
            'label' => $funcion->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
