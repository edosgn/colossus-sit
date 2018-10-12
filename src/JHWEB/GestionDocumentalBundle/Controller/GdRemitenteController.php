<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdRemitente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gdremitente controller.
 *
 * @Route("gdremitente")
 */
class GdRemitenteController extends Controller
{
    /**
     * Lists all gdRemitente entities.
     *
     * @Route("/", name="gdremitente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $remitentes = $em->getRepository('JHWEBGestionDocumentalBundle:GdRemitente')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($remitentes) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($remitentes)." Registros encontrados", 
                'data'=> $remitentes,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdRemitente entity.
     *
     * @Route("/new", name="gdremitente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $gdRemitente = new Gdremitente();
        $form = $this->createForm('JHWEB\GestionDocumentalBundle\Form\GdRemitenteType', $gdRemitente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gdRemitente);
            $em->flush();

            return $this->redirectToRoute('gdremitente_show', array('id' => $gdRemitente->getId()));
        }

        return $this->render('gdremitente/new.html.twig', array(
            'gdRemitente' => $gdRemitente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gdRemitente entity.
     *
     * @Route("/show", name="gdremitente_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $deleteForm = $this->createDeleteForm($gdRemitente);

        return $this->render('gdremitente/show.html.twig', array(
            'gdRemitente' => $gdRemitente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gdRemitente entity.
     *
     * @Route("/edit", name="gdremitente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $deleteForm = $this->createDeleteForm($gdRemitente);
        $editForm = $this->createForm('JHWEB\GestionDocumentalBundle\Form\GdRemitenteType', $gdRemitente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gdremitente_edit', array('id' => $gdRemitente->getId()));
        }

        return $this->render('gdremitente/edit.html.twig', array(
            'gdRemitente' => $gdRemitente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gdRemitente entity.
     *
     * @Route("/delete", name="gdremitente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GdRemitente $gdRemitente)
    {
        $form = $this->createDeleteForm($gdRemitente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gdRemitente);
            $em->flush();
        }

        return $this->redirectToRoute('gdremitente_index');
    }

    /**
     * Creates a form to delete a gdRemitente entity.
     *
     * @param GdRemitente $gdRemitente The gdRemitente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdRemitente $gdRemitente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gdremitente_delete', array('id' => $gdRemitente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca remitente por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/search/identificacion", name="gdremitente_search_identificacion")
     * @Method({"GET", "POST"})
     */
    public function searchByIdentificacionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $remitente = null;
 
        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $remitente = $em->getRepository('JHWEBGestionDocumentalBundle:GdRemitente')->findOneBy(
                array(
                    'activo' => true,
                    'identificacion' => $params->identificacion
                )
            );

            if ($remitente) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $remitente,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "¡No existe el remitente con ese número de identificación, por favor registrelo!", 
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
