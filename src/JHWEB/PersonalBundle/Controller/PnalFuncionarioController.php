<?php

namespace JHWEB\PersonalBundle\Controller;

use JHWEB\PersonalBundle\Entity\PnalFuncionario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pnalfuncionario controller.
 *
 * @Route("pnalfuncionario")
 */
class PnalFuncionarioController extends Controller
{
    /**
     * Lists all pnalFuncionario entities.
     *
     * @Route("/", name="pnalfuncionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pnalFuncionarios = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findAll();

        return $this->render('pnalfuncionario/index.html.twig', array(
            'pnalFuncionarios' => $pnalFuncionarios,
        ));
    }

    /**
     * Creates a new pnalFuncionario entity.
     *
     * @Route("/new", name="pnalfuncionario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pnalFuncionario = new Pnalfuncionario();
        $form = $this->createForm('JHWEB\PersonalBundle\Form\PnalFuncionarioType', $pnalFuncionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pnalFuncionario);
            $em->flush();

            return $this->redirectToRoute('pnalfuncionario_show', array('id' => $pnalFuncionario->getId()));
        }

        return $this->render('pnalfuncionario/new.html.twig', array(
            'pnalFuncionario' => $pnalFuncionario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pnalFuncionario entity.
     *
     * @Route("/{id}/show", name="pnalfuncionario_show")
     * @Method("GET")
     */
    public function showAction(PnalFuncionario $pnalFuncionario)
    {
        $deleteForm = $this->createDeleteForm($pnalFuncionario);

        return $this->render('pnalfuncionario/show.html.twig', array(
            'pnalFuncionario' => $pnalFuncionario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pnalFuncionario entity.
     *
     * @Route("/{id}/edit", name="pnalfuncionario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PnalFuncionario $pnalFuncionario)
    {
        $deleteForm = $this->createDeleteForm($pnalFuncionario);
        $editForm = $this->createForm('JHWEB\PersonalBundle\Form\PnalFuncionarioType', $pnalFuncionario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pnalfuncionario_edit', array('id' => $pnalFuncionario->getId()));
        }

        return $this->render('pnalfuncionario/edit.html.twig', array(
            'pnalFuncionario' => $pnalFuncionario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pnalFuncionario entity.
     *
     * @Route("/{id}/delete", name="pnalfuncionario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PnalFuncionario $pnalFuncionario)
    {
        $form = $this->createDeleteForm($pnalFuncionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pnalFuncionario);
            $em->flush();
        }

        return $this->redirectToRoute('pnalfuncionario_index');
    }

    /**
     * Creates a form to delete a pnalFuncionario entity.
     *
     * @param PnalFuncionario $pnalFuncionario The pnalFuncionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PnalFuncionario $pnalFuncionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pnalfuncionario_delete', array('id' => $pnalFuncionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================ */

    /**
     * Busca el funcionario logueado por identificación.
     *
     * @Route("/search/login", name="pnalfuncionario_search_login")
     * @Method({"GET", "POST"})
     */
    public function searchLoginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneByIdentificacion(
                $params->identificacion
            );

            if ($ciudadano) {
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->findOneBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true,
                    )
                );

                if ($funcionario) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro encontrado.',
                        'data' => $funcionario,
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El ciudadano no tiene registros de nombramientos vigentes.',
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'EL registro no existe en la base de datos.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.',
            );
        }

        return $helpers->json($response);
    }
}
