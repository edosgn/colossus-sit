<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MflTipoRecaudo;
use AppBundle\Form\MflTipoRecaudoType;

/**
 * MflTipoRecaudo controller.
 *
 * @Route("/mfltiporecaudo")
 */
class MflTipoRecaudoController extends Controller
{
    /**
     * Lists all MflTipoRecaudo entities.
     *
     * @Route("/", name="tipoRecaudo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $mflTiposRecaudo = $em->getRepository('AppBundle:MflTipoRecaudo')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado mflTiposRecaudo", 
                    'data'=> $mflTiposRecaudo,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new MflTipoRecaudo entity.
     *
     * @Route("/new", name="tipoRecaudo_new")
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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $nombre = $params->nombre;

                $em = $this->getDoctrine()->getManager();
                $tipoRecaudo = $em->getRepository('AppBundle:MflTipoRecaudo')->findOneByNombre($params->nombre);

                if ($tipoRecaudo==null) {
                    $tipoRecaudo = new MflTipoRecaudo();
    
                    $tipoRecaudo->setNombre(strtoupper($nombre));
                    $tipoRecaudo->setEstado(true);
    
                    $em->persist($tipoRecaudo);
                    $em->flush();
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "MflTipoRecaudo creado con exito", 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "El nombre del tipoRecaudo ya se encuentra registrado", 
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
     * Finds and displays a MflTipoRecaudo entity.
     *
     * @Route("/show/{id}", name="tipoRecaudo_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tipoRecaudo = $em->getRepository('AppBundle:MflTipoRecaudo')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tipoRecaudo encontrado", 
                    'data'=> $tipoRecaudo,
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
     * Displays a form to edit an existing MflTipoRecaudo entity.
     *
     * @Route("/edit", name="tipoRecaudo_edit")
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
            $tipoRecaudo = $em->getRepository('AppBundle:MflTipoRecaudo')->find($params->id);
            if ($tipoRecaudo!=null) {

                $tipoRecaudo->setNombre($nombre);
                $tipoRecaudo->setEstado(true);
               

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoRecaudo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tipoRecaudo editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La tipoRecaudo no se encuentra en la base de datos", 
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
     * Deletes a MflTipoRecaudo entity.
     *
     * @Route("/{id}/delete", name="tipoRecaudo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $tipoRecaudo = $em->getRepository('AppBundle:MflTipoRecaudo')->find($id);

            $tipoRecaudo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tipoRecaudo);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tipoRecaudo eliminado con exito", 
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
     * Creates a form to delete a MflTipoRecaudo entity.
     *
     * @param MflTipoRecaudo $tipoRecaudo The MflTipoRecaudo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MflTipoRecaudo $tipoRecaudo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoRecaudo_delete', array('id' => $tipoRecaudo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="tipoRecaudo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tipoRecaudos = $em->getRepository('AppBundle:MflTipoRecaudo')->findBy(
        array('estado' => 1)
    );
    $response=null;
    foreach ($tipoRecaudos as $key => $tipoRecaudo) {
        $response[$key] = array(
            'value' => $tipoRecaudo->getId(),
            'label' => $tipoRecaudo->getNombre(),
        );
      }
       return $helpers->json($response);
    }
}
