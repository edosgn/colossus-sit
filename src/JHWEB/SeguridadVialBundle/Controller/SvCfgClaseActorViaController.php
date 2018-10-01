<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgClaseActorVia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgclaseactorvium controller.
 *
 * @Route("svcfgclaseactorvia")
 */
class SvCfgClaseActorViaController extends Controller
{
    /**
     * Lists all svCfgClaseActorVia entities.
     *
     * @Route("/", name="svcfgclaseactorvia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCfgClasesActoresVia = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->findAll();

        return $this->render('svcfgclaseactorvia/index.html.twig', array(
            'svCfgClasesActoresVia' => $svCfgClasesActoresVia,
        ));
    }

    /**
     * Creates a new SvCfgClaseActorVia entity.
     *
     * @Route("/new", name="svcfgclaseactorvia_new")
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
            
            $claseActorVia = new SvCfgClaseActorVia();

            $claseActorVia->setNombreEmpresa($params->nombre);
            $claseActorVia->setActivo(true);
            $em->persist($claseActorVia);
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
     * Finds and displays a svCfgClaseActorVia entity.
     *
     * @Route("/{id}/show", name="svcfgclaseactorvia_show")
     * @Method("GET")
     */
    public function showAction(SvCfgClaseActorVia $svCfgClaseActorVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgClaseActorVia);
        return $this->render('svCfgClaseActorVia/show.html.twig', array(
            'svCfgClaseActorVia' => $svCfgClaseActorVia,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing svCfgClaseActorVia entity.
     *
     * @Route("/{id}/edit", name="svcfgclaseactorvia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvCfgClaseActorVia $svCfgClaseActorVia)
    {
        $deleteForm = $this->createDeleteForm($svCfgClaseActorVia);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvCfgClaseActorViaType', $svCfgClaseActorVia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svcfgclaseactorvia_edit', array('id' => $svCfgClaseActorVia->getId()));
        }

        return $this->render('svCfgClaseActorVia/edit.html.twig', array(
            'svCfgClaseActorVia' => $svCfgClaseActorVia,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SvCfgClaseActorVia entity.
     *
     * @Route("/{id}", name="svcfgclaseactorvia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgClaseActorVia $svCfgClaseActorVia)
    {
        $form = $this->createDeleteForm($svCfgClaseActorVia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgClaseActorVia);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgclaseactorvia_index');
    }

    /**
     * Creates a form to delete a SvCfgClaseActorVia entity.
     *
     * @param SvCfgClaseActorVia $svCfgClaseActorVia The SvCfgClaseActorVia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgClaseActorVia $svCfgClaseActorVia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgclaseactorvia_delete', array('id' => $svCfgClaseActorVia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="claseactorvia_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $clases = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgClaseActorVia')->findBy(
        array('activo' => 1)
    );
      foreach ($clases as $key => $clase) {
        $response[$key] = array(
            'value' => $clase->getId(),
            'label' => $clase->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
