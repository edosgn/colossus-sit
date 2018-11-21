<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdCfgSeccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gdcfgseccion controller.
 *
 * @Route("gdcfgseccion")
 */
class GdCfgSeccionController extends Controller
{
    /**
     * Lists all gdCfgSeccion entities.
     *
     * @Route("/", name="gdcfgseccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $secciones = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgSeccion')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($secciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($secciones)." Registros encontrados", 
                'data'=> $secciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdCfgSeccion entity.
     *
     * @Route("/new", name="gdcfgseccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $seccion = new GdCfgSeccion();

            $seccion->setNombre(strtoupper($params->nombre));
            $seccion->setActivo(true);
            
            $em->persist($seccion);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito",
            );
        
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a gdCfgSeccion entity.
     *
     * @Route("/{id}/show", name="gdcfgseccion_show")
     * @Method("GET")
     */
    public function showAction(GdCfgSeccion $gdCfgSeccion)
    {
        $deleteForm = $this->createDeleteForm($gdCfgSeccion);

        return $this->render('gdcfgseccion/show.html.twig', array(
            'gdCfgSeccion' => $gdCfgSeccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gdCfgSeccion entity.
     *
     * @Route("/edit", name="gdcfgseccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $seccion = $em->getRepository("JHWEBGestionDocumentalBundle:GdCfgSeccion")->find($params->id);

            if ($seccion) {
                $seccion->setNombre(strtoupper($params->nombre));
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $seccion,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a gdCfgSeccion entity.
     *
     * @Route("/{id}/delete", name="gdcfgseccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GdCfgSeccion $gdCfgSeccion)
    {
        $form = $this->createDeleteForm($gdCfgSeccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gdCfgSeccion);
            $em->flush();
        }

        return $this->redirectToRoute('gdcfgseccion_index');
    }

    /**
     * Creates a form to delete a gdCfgSeccion entity.
     *
     * @param GdCfgSeccion $gdCfgSeccion The gdCfgSeccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdCfgSeccion $gdCfgSeccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gdcfgseccion_delete', array('id' => $gdCfgSeccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =============================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="gdcfgseccion_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $secciones = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgSeccion')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($secciones as $key => $seccion) {
            $response[$key] = array(
                'value' => $seccion->getId(),
                'label' => $seccion->getNombre()
            );
        }
        
        return $helpers->json($response);
    }
}
