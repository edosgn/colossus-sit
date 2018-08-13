<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConceptoParametro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conceptoparametro controller.
 *
 * @Route("conceptoparametro")
 */
class ConceptoParametroController extends Controller
{
    /**
     * Lists all conceptoParametro entities.
     *
     * @Route("/", name="conceptoparametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $conceptoParametros = $em->getRepository('AppBundle:ConceptoParametro')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado conceptoParametros", 
                    'data'=> $conceptoParametros,
            );
         
        return $helpers->json($response);

    }

    /**
     * Creates a new conceptoParametro entity.
     *
     * @Route("/new", name="conceptoparametro_new")
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
            $valor = $params->valor;
            $cuenta = $params->cuenta;

            // $conceptoParametros = $em->getRepository('AppBundle:ConceptoParametro')->findBy(
            //     array('estado' => 1,'nombre'=> $nombre)
            // );
    
            // if ($conceptoParametros != null) {
            //     $response = array(
            //             'status' => 'error',
            //             'code' => 400,
            //             'msj' => "registro", 
            //     );
            //     return $helpers->json($response);
            // }
            $em = $this->getDoctrine()->getManager();
            $nombres = $em->getRepository('AppBundle:ConceptoParametro')->findOneByNombre($params->nombre);
// var_dump($params->nombre);
// die();
            if ($nombres==null) {
                
            
            $em = $this->getDoctrine()->getManager();

            $conceptoParametro = new Conceptoparametro();

            $conceptoParametro->setNombre($nombre);
            $conceptoParametro->setCuenta($cuenta);
            $conceptoParametro->setValor($valor);
            $conceptoParametro->setEstado(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($conceptoParametro);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "concepto creado con exito", 
            );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El nombre de este concepto ya se encuentra registrado", 
                );
            }         
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
     * Finds and displays a conceptoParametro entity.
     *
     * @Route("/{id}", name="conceptoparametro_show")
     * @Method("GET")
     */
    public function showAction(ConceptoParametro $conceptoParametro)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $conceptoParametro = $em->getRepository('AppBundle:ConceptoParametro')->find($id);
            
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "conceptoParametro encontrado", 
                    'data'=> $conceptoParametro,
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
     * Displays a form to edit an existing facturaSustrato entity.
     *
     * @Route("/{id}/tramitePrecio/concepto", name="concepto_por_tramitePrecio")
     * @Method({"GET", "POST"})
     */
    public function showConceptoAction(Request $request,$id)
    {

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $em = $this->getDoctrine()->getManager();

        if ($authCheck==true) {
            $conceptoParametro = $em->getRepository('AppBundle:ConceptoParametroTramite')->findBy(
                array('estado' => 1,
                'tramitePrecio'=> $id)
            );
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "conceptoParametro encontrado", 
                'data'=> $conceptoParametro,
            );
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
     * Displays a form to edit an existing Concepto entity.
     *
     * @Route("/edit", name="conceptoParametro_edit")
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
            $valor = $params->valor;
            $cuenta = $params->cuenta;
            $em = $this->getDoctrine()->getManager();

            $conceptoParametro = $em->getRepository('AppBundle:ConceptoParametro')->find($params->id);
            
            $nombreConceptoParametro = $em->getRepository('AppBundle:ConceptoParametro')->findOneByNombre($params->nombre);

            if($nombreConceptoParametro){
            if($nombreConceptoParametro->getId() == $params->id){          
                $conceptoParametro->setNombre($nombre);
                $conceptoParametro->setCuenta($cuenta);
                $conceptoParametro->setValor($valor);
                $conceptoParametro->setEstado(true);
               
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 2500,
                    'msj' => "Actualización exitosa",
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No se puede editar este registro porque el nombre ya esta asignado a un concepto",
                );
            }
        }else if($conceptoParametro){
            if($conceptoParametro->getNombre()!=$params->getNombre()){
                $conceptoParametro->setNombre($nombre);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 2500,
                    'msj' => "Actualización exitosa",
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No se puxgfdfgdfg mbre ya esta asignado a un concepto",
                );
            }

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
     * Deletes a conceptoParametro entity.
     *
     * @Route("/{id}/delete", name="conceptoparametro_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        
        // $form = $this->createDeleteForm($conceptoParametro);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $em = $this->getDoctrine()->getManager();
        //     $em->remove($conceptoParametro);
        //     $em->flush();
        // } 

        // return $this->redirectToRoute('conceptoparametro_index');

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $conceptoParametro = $em->getRepository('AppBundle:ConceptoParametro')->find($id);

            $conceptoParametro->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($conceptoParametro);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "color eliminado con exito", 
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
     * Creates a form to delete a conceptoParametro entity.
     *
     * @param ConceptoParametro $conceptoParametro The conceptoParametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConceptoParametro $conceptoParametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conceptoparametro_delete', array('id' => $conceptoParametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * datos para select 2
     *
     * @Route("/select/concepto", name="conceptoParametro_select_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $conceptoParametros = $em->getRepository('AppBundle:ConceptoParametro')->findBy(
        array('estado' => 1)
    );
    $response = null;
    foreach ($conceptoParametros as $key => $conceptoParametro) {
        $response[$key] = array(
            'value' => $conceptoParametro->getId(),
            'label' => $conceptoParametro->getNombre(),
        );
      }
       return $helpers->json($response);
    }
}
