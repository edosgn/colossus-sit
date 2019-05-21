<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgPropietario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgpropietario controller.
 *
 * @Route("cfgpropietario")
 */
class CfgPropietarioController extends Controller
{
    /**
     * Lists all cfgPropietario entities.
     *
     * @Route("/", name="cfgpropietario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cfgPropietarios = $em->getRepository('JHWEBConfigBundle:CfgPropietario')->findAll();

        return $this->render('cfgpropietario/index.html.twig', array(
            'cfgPropietarios' => $cfgPropietarios,
        ));
    }

    /**
     * Creates a new cfgPropietario entity.
     *
     * @Route("/new", name="cfgpropietario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cfgPropietario = new Cfgpropietario();
        $form = $this->createForm('JHWEB\ConfigBundle\Form\CfgPropietarioType', $cfgPropietario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgPropietario);
            $em->flush();

            return $this->redirectToRoute('cfgpropietario_show', array('id' => $cfgPropietario->getId()));
        }

        return $this->render('cfgpropietario/new.html.twig', array(
            'cfgPropietario' => $cfgPropietario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cfgPropietario entity.
     *
     * @Route("/{id}", name="cfgpropietario_show")
     * @Method("GET")
     */
    public function showAction(CfgPropietario $cfgPropietario)
    {
        $deleteForm = $this->createDeleteForm($cfgPropietario);

        return $this->render('cfgpropietario/show.html.twig', array(
            'cfgPropietario' => $cfgPropietario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgPropietario entity.
     *
     * @Route("/{id}/edit", name="cfgpropietario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CfgPropietario $cfgPropietario)
    {
        $deleteForm = $this->createDeleteForm($cfgPropietario);
        $editForm = $this->createForm('JHWEB\ConfigBundle\Form\CfgPropietarioType', $cfgPropietario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cfgpropietario_edit', array('id' => $cfgPropietario->getId()));
        }

        return $this->render('cfgpropietario/edit.html.twig', array(
            'cfgPropietario' => $cfgPropietario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cfgPropietario entity.
     *
     * @Route("/{id}", name="cfgpropietario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgPropietario $cfgPropietario)
    {
        $form = $this->createDeleteForm($cfgPropietario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgPropietario);
            $em->flush();
        }

        return $this->redirectToRoute('cfgpropietario_index');
    }

    /**
     * Creates a form to delete a cfgPropietario entity.
     *
     * @param CfgPropietario $cfgPropietario The cfgPropietario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgPropietario $cfgPropietario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgpropietario_delete', array('id' => $cfgPropietario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ===================================================== */

    /**
     * Actualiza la imagen de cabecera del pdf.
     *
     * @Route("/upload/header", name="cfgpropietario_upload_header")
     * @Method({"GET", "POST"})
     */
    public function uploadHeaderAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                if ($extension == '.png') {
                    $filename = "header.".$extension;
                    $dir=__DIR__.'/../../../../web/img';

                    $file->move($dir,$filename);

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Cabecera de pagina cargada con exito.'
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Solo se admite formato .png"
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún archivo seleccionado"
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

    /**
     * Actualiza la imagen de cabecera del pdf.
     *
     * @Route("/upload/footer", name="cfgpropietario_upload_footer")
     * @Method({"GET", "POST"})
     */
    public function uploadFooterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                if ($extension == '.png') {
                    $filename = "footer.".$extension;
                    $dir=__DIR__.'/../../../../web/img';

                    $file->move($dir,$filename);

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Pie de pagina cargada con exito.'
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Solo se admite formato .png"
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún archivo seleccionado"
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
