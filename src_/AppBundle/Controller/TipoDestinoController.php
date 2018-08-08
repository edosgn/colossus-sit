<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoDestino;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Tipodestino controller.
 *
 * @Route("tipodestino")
 */
class TipoDestinoController extends Controller
{
    /**
     * Lists all tipoDestino entities.
     *
     */
    public function indexAction()
    {
        /*$helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposDestino = $em->getRepository('AppBundle:TipoDestino')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tiposDestino) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($tiposDestino)." Registros encontrados",
                'data'=> $tiposDestino,
            );
        }

        return $helpers->json($response);*/

        $em = $this->getDoctrine()->getManager();

        $tipoDestinos = $em->getRepository('AppBundle:TipoDestino')->findAll();

        return $this->render('tipodestino/index.html.twig', array(
            'tipoDestinos' => $tipoDestinos,
        ));
    }

    /**
     * Creates a new tipoDestino entity.
     *
     */
    public function newAction(Request $request)
    {
        $tipoDestino = new Tipodestino();
        $form = $this->createForm('AppBundle\Form\TipoDestinoType', $tipoDestino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoDestino);
            $em->flush();

            return $this->redirectToRoute('tipodestino_show', array('id' => $tipoDestino->getId()));
        }

        return $this->render('tipodestino/new.html.twig', array(
            'tipoDestino' => $tipoDestino,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoDestino entity.
     *
     */
    public function showAction(TipoDestino $tipoDestino)
    {
        $deleteForm = $this->createDeleteForm($tipoDestino);

        return $this->render('tipodestino/show.html.twig', array(
            'tipoDestino' => $tipoDestino,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoDestino entity.
     *
     */
    public function editAction(Request $request, TipoDestino $tipoDestino)
    {
        $deleteForm = $this->createDeleteForm($tipoDestino);
        $editForm = $this->createForm('AppBundle\Form\TipoDestinoType', $tipoDestino);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipodestino_edit', array('id' => $tipoDestino->getId()));
        }

        return $this->render('tipodestino/edit.html.twig', array(
            'tipoDestino' => $tipoDestino,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoDestino entity.
     *
     */
    public function deleteAction(Request $request, TipoDestino $tipoDestino)
    {
        $form = $this->createDeleteForm($tipoDestino);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoDestino);
            $em->flush();
        }

        return $this->redirectToRoute('tipodestino_index');
    }

    /**
     * Creates a form to delete a tipoDestino entity.
     *
     * @param TipoDestino $tipoDestino The tipoDestino entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoDestino $tipoDestino)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipodestino_delete', array('id' => $tipoDestino->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipodestino_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposDestino = $em->getRepository('AppBundle:TipoDestino')->findBy(
            array('estado' => 1)
        );
        foreach ($tiposDestino as $key => $tipoDestino) {
            $response[$key] = array(
                'value' => $tipoDestino->getId(),
                'label' => $tipoDestino->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
