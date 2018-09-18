<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvSenialInventarioMunicipio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svsenialinventariomunicipio controller.
 *
 * @Route("svsenialinventariomunicipio")
 */
class SvSenialInventarioMunicipioController extends Controller
{
    /**
     * Lists all svSenialInventarioMunicipio entities.
     *
     * @Route("/", name="svsenialinventariomunicipio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svSenialInventarioMunicipios = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventarioMunicipio')->findAll();

        return $this->render('svsenialinventariomunicipio/index.html.twig', array(
            'svSenialInventarioMunicipios' => $svSenialInventarioMunicipios,
        ));
    }

    /**
     * Creates a new svSenialInventarioMunicipio entity.
     *
     * @Route("/new", name="svsenialinventariomunicipio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $svSenialInventarioMunicipio = new Svsenialinventariomunicipio();
        $form = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialInventarioMunicipioType', $svSenialInventarioMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($svSenialInventarioMunicipio);
            $em->flush();

            return $this->redirectToRoute('svsenialinventariomunicipio_show', array('id' => $svSenialInventarioMunicipio->getId()));
        }

        return $this->render('svsenialinventariomunicipio/new.html.twig', array(
            'svSenialInventarioMunicipio' => $svSenialInventarioMunicipio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a svSenialInventarioMunicipio entity.
     *
     * @Route("/{id}", name="svsenialinventariomunicipio_show")
     * @Method("GET")
     */
    public function showAction(SvSenialInventarioMunicipio $svSenialInventarioMunicipio)
    {
        $deleteForm = $this->createDeleteForm($svSenialInventarioMunicipio);

        return $this->render('svsenialinventariomunicipio/show.html.twig', array(
            'svSenialInventarioMunicipio' => $svSenialInventarioMunicipio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svSenialInventarioMunicipio entity.
     *
     * @Route("/{id}/edit", name="svsenialinventariomunicipio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvSenialInventarioMunicipio $svSenialInventarioMunicipio)
    {
        $deleteForm = $this->createDeleteForm($svSenialInventarioMunicipio);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvSenialInventarioMunicipioType', $svSenialInventarioMunicipio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svsenialinventariomunicipio_edit', array('id' => $svSenialInventarioMunicipio->getId()));
        }

        return $this->render('svsenialinventariomunicipio/edit.html.twig', array(
            'svSenialInventarioMunicipio' => $svSenialInventarioMunicipio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svSenialInventarioMunicipio entity.
     *
     * @Route("/{id}", name="svsenialinventariomunicipio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvSenialInventarioMunicipio $svSenialInventarioMunicipio)
    {
        $form = $this->createDeleteForm($svSenialInventarioMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svSenialInventarioMunicipio);
            $em->flush();
        }

        return $this->redirectToRoute('svsenialinventariomunicipio_index');
    }

    /**
     * Creates a form to delete a svSenialInventarioMunicipio entity.
     *
     * @param SvSenialInventarioMunicipio $svSenialInventarioMunicipio The svSenialInventarioMunicipio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvSenialInventarioMunicipio $svSenialInventarioMunicipio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svsenialinventariomunicipio_delete', array('id' => $svSenialInventarioMunicipio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/tiposenial", name="svsenialinventariomunicipio_search_tiposenial")
     * @Method({"GET", "POST"})
     */
    public function searchByTipoSenialAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvSenialInventarioMunicipio')->findByTipoSenial($params->idTipoSenial);

            if ($seniales) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($seniales)." inventario(s) encontrado(s)",
                    'data'=> $seniales
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún registro no encontrado"
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
