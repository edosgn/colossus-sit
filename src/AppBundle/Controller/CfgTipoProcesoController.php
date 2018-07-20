<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgTipoProceso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgtipoproceso controller.
 *
 * @Route("cfgTipoProceso")
 */
class CfgTipoProcesoController extends Controller
{
    /**
     * Lists all cfgTipoProceso entities.
     *
     * @Route("/", name="cfgtipoproceso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->findBy(
            array('estado' => 1)
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tipos de proceso", 
                    'data'=> $tipoProceso,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new cfgTipoProceso entity.
     *
     * @Route("/new", name="cfgtipoproceso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

                $nombre = $params->nombre;

                $em = $this->getDoctrine()->getManager();
                $tipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->findOneByNombre($params->nombre);

                if ($tipoProceso==null) {
                    $tipoProceso = new CfgTipoProceso();
    
                    $tipoProceso->setNombre(strtoupper($nombre));
                    $tipoProceso->setEstado(true);
    
                    $em->persist($tipoProceso);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Tipo Producto creado con exito", 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "El nombre del tipoProceso ya se encuentra registrado", 
                    );
                }

            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cfgTipoProceso entity.
     *
     * @Route("/show/{id}", name="cfgtipoproceso_show")
     * @Method("POST")
     */
    public function showAction(CfgTipoProceso $cfgTipoProceso)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgTipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "cfgTipoProceso encontrado", 
                    'data'=> $cfgTipoProceso,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cfgTipoProceso entity.
     *
     * @Route("/edit", name="cfgtipoproceso_edit")
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

            $nombre = $params->nombre;
            $em = $this->getDoctrine()->getManager();
            $cfgTipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->find($params->id);
            if ($cfgTipoProceso!=null) {

                $cfgTipoProceso->setNombre($nombre);
                $cfgTipoProceso->setEstado(true);
               
                $em->persist($cfgTipoProceso);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Limitación editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La limitación no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cfgTipoProceso entity.
     *
     * @Route("/{id}/delete", name="cfgtipoproceso_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $tipoProceso = $em->getRepository('AppBundle:CfgTipoProceso')->find($id);

            $tipoProceso->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tipoProceso);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Tipo proceso eliminada con exito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a cfgTipoProceso entity.
     *
     * @param CfgTipoProceso $cfgTipoProceso The cfgTipoProceso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgTipoProceso $cfgTipoProceso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgtipoproceso_delete', array('id' => $cfgTipoProceso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

        /**
     * datos para select 
     *
     * @Route("/select", name="tipoProducto_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tipoProcesos = $em->getRepository('AppBundle:CfgTipoProceso')->findBy(
        array('estado' => 1)
    );
      foreach ($tipoProcesos as $key => $tipoProceso) {
        $response[$key] = array(
            'value' => $tipoProceso->getId(),
            'label' => $tipoProceso->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
