<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdCfgTipoCorrespondencia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gdcfgtipocorrespondencium controller.
 *
 * @Route("gdcfgtipocorrespondencia")
 */
class GdCfgTipoCorrespondenciaController extends Controller
{
    /**
     * Lists all gdCfgTipoCorrespondencia entities.
     *
     * @Route("/", name="gdcfgtipocorrespondencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $GdCfgTipoCorrespondencias = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($GdCfgTipoCorrespondencias) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($GdCfgTipoCorrespondencias)." Registros encontrados", 
                'data'=> $GdCfgTipoCorrespondencias,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdCfgTipoCorrespondencia entity.
     *
     * @Route("/new", name="gdcfgtipocorrespondencia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $gdCfgTipoCorrespondencia = new GdCfgTipoCorrespondencia();
            $gdCfgTipoCorrespondencia->setNombre($params->nombre);
            $gdCfgTipoCorrespondencia->setActivo(true);
            
            $em->persist($gdCfgTipoCorrespondencia);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con éxito",
            );
        
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a gdCfgTipoCorrespondencia entity.
     *
     * @Route("/{id}", name="gdcfgtipocorrespondencia_show")
     * @Method("GET")
     */
    public function showAction(GdCfgTipoCorrespondencia $gdCfgTipoCorrespondencia)
    {
        $deleteForm = $this->createDeleteForm($gdCfgTipoCorrespondencia);

        return $this->render('gdcfgtipocorrespondencia/show.html.twig', array(
            'gdCfgTipoCorrespondencia' => $gdCfgTipoCorrespondencia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgCargo entity.
     *
     * @Route("/edit", name="gdcfgtipocorrespondencia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $gdCfgTipoCorrespondencia = $em->getRepository("JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia")->find($params->id);

            if ($gdCfgTipoCorrespondencia!=null) {
                $gdCfgTipoCorrespondencia->setNombre($params->nombre);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $gdCfgTipoCorrespondencia,
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
     * Deletes a cfgCargo entity.
     *
     * @Route("/delete", name="gdcfgtipocorrespondencia_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $gdCfgTipoCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->find($params->id);
            
            $gdCfgTipoCorrespondencia->setActivo(false);
            $em->flush();

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro eliminado con éxito", 
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a gdCfgTipoCorrespondencia entity.
     *
     * @param GdCfgTipoCorrespondencia $gdCfgTipoCorrespondencia The gdCfgTipoCorrespondencia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdCfgTipoCorrespondencia $gdCfgTipoCorrespondencia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gdcfgtipocorrespondencia_delete', array('id' => $gdCfgTipoCorrespondencia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
