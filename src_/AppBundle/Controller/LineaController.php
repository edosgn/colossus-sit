<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Linea;
use AppBundle\Form\LineaType;

/**
 * Linea controller.
 *
 * @Route("/linea")
 */
class LineaController extends Controller
{
    /**
     * Lists all Linea entities.
     *
     * @Route("/", name="linea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $lineas = $em->getRepository('AppBundle:Linea')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado lineas", 
                    'data'=> $lineas,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Linea entity.
     *
     * @Route("/new", name="linea_new")
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


            // if (count($params)==0) {
            //     $response = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "los campos no pueden estar vacios", 
            //     );
            // }else{
                $nombre = $params->nombre;
                $codigoMt = $params->codigoMt;
                $marcaId = $params->marcaId;
                $em = $this->getDoctrine()->getManager();
                $marca = $em->getRepository('AppBundle:Marca')->find($marcaId);
                $linea = $em->getRepository('AppBundle:Linea')->findBy(
                    array('codigoMt' => $codigoMt)
                );
                    if ($linea==null) {
                        $linea = new Linea();
                        $linea->setNombre($nombre);
                        $linea->setEstado(true);
                        $linea->setCodigoMt($codigoMt);
                        $linea->setMarca($marca);


                        $em = $this->getDoctrine()->getManager();
                        $em->persist($linea);
                        $em->flush();
                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "linea creada con exito", 
                        );
                    }else{
                         $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'msj' => "Codigo de ministerio de transporte debe ser unico",
                        ); 
                    }
                // }
                
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
     * Finds and displays a Linea entity.
     *
     * @Route("/show/{id}", name="linea_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository('AppBundle:Linea')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "linea encontrada", 
                    'data'=> $linea,
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
     * Displays a form to edit an existing Linea entity.
     *
     * @Route("/edit", name="linea_edit")
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
            $marcaId = $params->marcaId;
            $em = $this->getDoctrine()->getManager();
            $marca = $em->getRepository('AppBundle:Marca')->find($marcaId);
            $nombre = $params->nombre;
            $codigoMt = $params->codigoMt;
            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository('AppBundle:Linea')->find($params->id);
            if ($linea!=null) {

                $linea->setNombre($nombre);
                $linea->setEstado(true);
                $linea->setCodigoMt($codigoMt);
                $linea->setMarca($marca);

                $em = $this->getDoctrine()->getManager();
                $em->persist($linea);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "linea editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La linea no se encuentra en la base de datos", 
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
     * Deletes a Linea entity.
     *
     * @Route("/{id}/delete", name="linea_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $linea = $em->getRepository('AppBundle:Linea')->find($id);

            $linea->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($linea);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "linea eliminado con exito", 
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
     * Creates a form to delete a Linea entity.
     *
     * @param Linea $linea The Linea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Linea $linea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('linea_delete', array('id' => $linea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     *busca las lineas de una marca.
     *
     * @Route("/lin/mar/{marcaId}", name="linea_mar")
     * @Method("POST")
     */
    public function LineaMarcaAction($marcaId,Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        

            $em = $this->getDoctrine()->getManager();
            $Lineas = $em->getRepository('AppBundle:Linea')->findBy(
                array('marca' => $marcaId)
            );
            $lineasArray[] = null;
            foreach ($Lineas as $key => $linea) {
            $lineasArray[$key] = array(
                'value' => $linea->getId(),
                'label' => $linea->getCodigoMt()."_".$linea->getNombre(),
                );
            }

         
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lineas encontradas", 
                    'data'=> $lineasArray,
            );
           

        
        return $helpers->json($response);
    }


    /**
     * datos para select 2
     *
     * @Route("/select", name="linea_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $lineas = $em->getRepository('AppBundle:Linea')->findBy(
        array('estado' => 1)
    );
      foreach ($lineas as $key => $linea) {
        $response[$key] = array(
            'value' => $linea->getId(),
            'label' => $linea->getCodigoMt()."_".$linea->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
