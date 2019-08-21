<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgAdmFormatoTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgadmformatotipo controller.
 *
 * @Route("cfgadmformatotipo")
 */
class CfgAdmFormatoTipoController extends Controller
{
    /**
     * Lists all cfgAdmFormatoTipo entities.
     *
     * @Route("/", name="cfgadmformatotipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBConfigBundle:CfgAdmFormatoTipo')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgAdmFormatoTipo entity.
     *
     * @Route("/new", name="cfgadmformatotipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $tipo = new CfgAdmFormatoTipo();

            $tipo->setNombre(strtoupper($params->nombre));
            $tipo->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a cfgAdmFormatoTipo entity.
     *
     * @Route("/{id}/show", name="cfgadmformatotipo_show")
     * @Method("GET")
     */
    public function showAction(CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        $deleteForm = $this->createDeleteForm($cfgAdmFormatoTipo);

        return $this->render('cfgadmformatotipo/show.html.twig', array(
            'cfgAdmFormatoTipo' => $cfgAdmFormatoTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgAdmFormatoTipo entity.
     *
     * @Route("/edit", name="cfgadmformatotipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $tipo = $em->getRepository('JHWEBConfigBundle:CfgAdmFormatoTipo')->find(
                $params->id
            );

            if ($tipo) {
                $tipo->setNombre(strtoupper($params->nombre));

                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cfgAdmFormatoTipo entity.
     *
     * @Route("/{id}/delete", name="cfgadmformatotipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        $form = $this->createDeleteForm($cfgAdmFormatoTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAdmFormatoTipo);
            $em->flush();
        }

        return $this->redirectToRoute('cfgadmformatotipo_index');
    }

    /**
     * Creates a form to delete a cfgAdmFormatoTipo entity.
     *
     * @param CfgAdmFormatoTipo $cfgAdmFormatoTipo The cfgAdmFormatoTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAdmFormatoTipo $cfgAdmFormatoTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgadmformatotipo_delete', array('id' => $cfgAdmFormatoTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de tipos de formato para seleccion con busqueda
     *
     * @Route("/select", name="cfgadminformatotipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('JHWEBConfigBundle:CfgAdmFormatoTipo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
