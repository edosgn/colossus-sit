<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgFestivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Cfgfestivo controller.
 *
 * @Route("cfgFestivo")
 */
class CfgFestivoController extends Controller
{
    /**
     * Lists all cfgFestivo entities.
     *
     * @Route("/", name="cfgfestivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgFestivos = $em->getRepository('AppBundle:CfgFestivo')->findBy( array('activo' => 1));

        $response = array(
                    'status' => 'succes',
                    'code' => 200,
                    'msj' => "listado festivos",
                    'data' => $cfgFestivos,
        );

        return $helpers ->json($response);
    }

    /**
     * Creates a new cfgFestivo entity.
     *
     * @Route("/new", name="cfgfestivo_new")
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
            
                $festivo = new Cfgfestivo();
                $festivo->setFecha(new \Datetime($params->fecha));
                $festivo->setDescripcion($params->descripcion);
                $festivo->setActivo(true);
                $em->persist($festivo);
                $em->flush();
                $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "Festivo creado con éxito",
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
     * Finds and displays a cfgFestivo entity.
     *
     * @Route("/show/{id}", name="cfgfestivo_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if(authCheck == true ){
            $em = $this->getDoctrine()->getManager();
            $festivo = $em->getRepository('AppBundle:CfgFestivo')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Festivo encontrado",
                'data' => $festivo,
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj'=> "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cfgFestivo entity.
     *
     * @Route("/edit", name="cfgfestivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck==true){
           $json = $request->get("json",null);
           $params = json_decode($json);  

           $em = $this->getDoctrine()->getManager();
           $festivo = $em->getRepository('AppBundle:CfgFestivo')->find($params->id);
           if($festivo != null){
               $festivo->setFecha(new \Datetime($params->fecha));
               $festivo->setDescripcion($params->descripcion);
               $festivo->setActivo(true);

               $em->persist($festivo);
               $em->flush();

               $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Festivo editado con éxito.", 
            );
           }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "El festivo no se encuentra en la base de datos", 
            );
           }
        }
           else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorización no valida para editar banco", 
            );
           }
        return $helpers->json($response);
    }

    /**
     * Deletes a cfgFestivo entity.
     *
     * @Route("/delete", name="cfgfestivo_delete")
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
            $festivo = $em->getRepository('AppBundle:CfgFestivo')->find($params);
            
            $festivo->setActivo(0);
            $em->persist($festivo);
            $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Festivo eliminado con éxito", 
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
     * Creates a form to delete a cfgFestivo entity.
     *
     * @param CfgFestivo $cfgFestivo The cfgFestivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgFestivo $cfgFestivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgfestivo_delete', array('id' => $cfgFestivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
