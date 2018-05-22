<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TramitePrecio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tramiteprecio controller.
 *
 * @Route("tramiteprecio")
 */
class TramitePrecioController extends Controller
{
    /**
     * Lists all tramitePrecio entities.
     *
     * @Route("/", name="tramiteprecio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramitePrecios = $em->getRepository('AppBundle:TramitePrecio')->findBy(
            array('estado' => 1)
        );
        
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tramitePrecios", 
                    'data'=> $tramitePrecios,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new tramitePrecio entity.
     *
     * @Route("/new", name="tramiteprecio_new")
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

                $valor = $params->valor;
                $anio = $params->anio;
                $smldv = $params->smldv;
                $valorEstampilla = $params->valorEstampilla;
                $tramiteId = $params->tramiteId;
                $tipoVehiculoId = $params->tipoVehiculoId;


                $em = $this->getDoctrine()->getManager();
                $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
                $tipoVehiculo = $em->getRepository('AppBundle:TipoVehiculo')->find($tipoVehiculoId);
                
                  
                $tramitePrecio = new TramitePrecio();
                $tramitePrecio->setValor($valor);
                $tramitePrecio->setAnio($anio);
                $tramitePrecio->setValorEstampilla($valorEstampilla);
                $tramitePrecio->setSmldv($smldv);
                $tramitePrecio->setTramite($tramite);
                $tramitePrecio->setTipoVehiculo($tipoVehiculo);
                $tramitePrecio->setEstado(true);


                $em = $this->getDoctrine()->getManager();
                $em->persist($tramitePrecio);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "precio creada con exito", 
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
     * Finds and displays a tramitePrecio entity.
     *
     * @Route("/{id}", name="tramiteprecio_show")
     * @Method("GET")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramitePrecio encontrada", 
                    'data'=> $tramitePrecio,
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
     * Displays a form to edit an existing Color entity.
     *
     * @Route("/edit", name="tramiteprecio_edit")
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
            
            $valor = $params->valor;
            $anio = $params->anio;
            $smldv = $params->smldv;
            $valorEstampilla = $params->valorEstampilla;
            $tramiteId = $params->tramiteId;
            $tipoVehiculoId = $params->tipoVehiculoId;


            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $tipoVehiculo = $em->getRepository('AppBundle:TipoVehiculo')->find($tipoVehiculoId);
            $tramitePrecio = $em->getRepository("AppBundle:TramitePrecio")->find($params->id);

            if ($tramitePrecio!=null) {

                $tramitePrecio->setValor($valor);
                $tramitePrecio->setAnio($anio);
                $tramitePrecio->setValorEstampilla($valorEstampilla);
                $tramitePrecio->setSmldv($smldv);
                $tramitePrecio->setTramite($tramite);
                $tramitePrecio->setTipoVehiculo($tipoVehiculo);
                $tramitePrecio->setEstado(true);


                $em = $this->getDoctrine()->getManager();
                $em->persist($tramitePrecio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "precio editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La precio no se encuentra en la base de datos", 
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
     * Deletes a tramitePrecio entity.
     *
     * @Route("/{id}", name="tramiteprecio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TramitePrecio $tramitePrecio)
    {
        $form = $this->createDeleteForm($tramitePrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramitePrecio);
            $em->flush();
        }

        return $this->redirectToRoute('tramiteprecio_index');
    }

    /**
     * Creates a form to delete a tramitePrecio entity.
     *
     * @param TramitePrecio $tramitePrecio The tramitePrecio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramitePrecio $tramitePrecio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramiteprecio_delete', array('id' => $tramitePrecio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
