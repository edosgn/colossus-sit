<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresa controller.
 *
 * @Route("userempresa")
 */
class UserEmpresaController extends Controller
{
    /**
     * Lists all userEmpresa entities.
     *
     * @Route("/", name="userempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userEmpresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findAll();

        return $this->render('userempresa/index.html.twig', array(
            'userEmpresas' => $userEmpresas,
        ));
    }

    /**
     * Creates a new userEmpresa entity.
     *
     * @Route("/new", name="userempresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userEmpresa = new Userempresa();
        $form = $this->createForm('JHWEB\UsuarioBundle\Form\UserEmpresaType', $userEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userEmpresa);
            $em->flush();

            return $this->redirectToRoute('userempresa_show', array('id' => $userEmpresa->getId()));
        }

        return $this->render('userempresa/new.html.twig', array(
            'userEmpresa' => $userEmpresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userEmpresa entity.
     *
     * @Route("/show", name="userempresa_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                $params->id
            );

            $em->persist($empresa);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $empresa
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
     * Displays a form to edit an existing userEmpresa entity.
     *
     * @Route("/{id}/edit", name="userempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserEmpresa $userEmpresa)
    {
        $deleteForm = $this->createDeleteForm($userEmpresa);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserEmpresaType', $userEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userempresa_edit', array('id' => $userEmpresa->getId()));
        }

        return $this->render('userempresa/edit.html.twig', array(
            'userEmpresa' => $userEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userEmpresa entity.
     *
     * @Route("/{id}/delete", name="userempresa_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, UserEmpresa $userEmpresa)
    {
        $form = $this->createDeleteForm($userEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userEmpresa);
            $em->flush();
        }

        return $this->redirectToRoute('userempresa_index');
    }

    /**
     * Creates a form to delete a userEmpresa entity.
     *
     * @param UserEmpresa $userEmpresa The userEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserEmpresa $userEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userempresa_delete', array('id' => $userEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================================*/
    /**
     * Busca empresas por NIT o Nombre.
     *
     * @Route("/show/nit/nombre", name="userempresa_show_nit_nombre")
     * @Method({"GET", "POST"})
     */
    public function showNitOrNombreAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("json",null);
        $params = json_decode($json);
        
        $em = $this->getDoctrine()->getManager();
        if ($authCheck == true) {
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->getByNitOrNombre($params); 
              
            if ($empresa) { 
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $empresa,
                );
            }          
            else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no Encontrada", 
                );
            }
        } else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Listado de grupos sanguineos para seleccion con busqueda
     *
     * @Route("/select", name="userempresa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($empresas as $key => $empresa) {
            $response[$key] = array(
                'value' => $empresa->getId(),
                'label' => $empresa->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
