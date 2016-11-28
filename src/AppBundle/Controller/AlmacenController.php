<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Almacen; 
use AppBundle\Form\AlmacenType;

/**
 * Almacen controller.
 *
 * @Route("/almacen")
 */
class AlmacenController extends Controller
{
    /**
     * Lists all Almacen entities.
     *
     * @Route("/", name="almacen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $almacenes = $em->getRepository('AppBundle:Almacen')->findBy(
            array('estado' => 1)
        );

        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "lista de almacenes",
                    'data' => $almacenes, 
        );
        return $helpers->json($responce);
        
    }

    /**
     * Creates a new Almacen entity.
     *
     * @Route("/new", name="almacen_new")
     * @Method({"GET", "POST"})
     */
    //{"rangoInicio":"1","rangoFin":"20","lote":"5","disponibles":"1,2,3","servicioId":"1","organismoTransitoId":"1","consumibleId":"1","claseId":"1"}
    public function newAction(Request $request)
    {

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            
            $json = $request->get("json",null);
            $params = json_decode($json);

            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                $rangoInicio = $params->rangoInicio;
                $rangoFin = $params->rangoFin;
                $lote = $params->lote;
                $estado = true;
                $em = $this->getDoctrine()->getManager();
                $servicio = $em->getRepository('AppBundle:Servicio')->find($params->servicioId);
                $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->find($params->organismoTransitoId);
                $consumible = $em->getRepository('AppBundle:Consumible')->find($params->consumibleId);
                $clase = $em->getRepository('AppBundle:Clase')->find($params->claseId);
               
                $almacen = new Almacen();
                $almacen->setRangoInicio($rangoInicio);
                $almacen->setRangoFin($rangoFin);
                $almacen->setLote($lote);
                $almacen->setEstado($estado);
                $almacen->setServicio($servicio);
                $almacen->setOrganismoTransito($organismoTransito);
                $almacen->setConsumible($consumible);
                $almacen->setClase($clase);

                $em->persist($almacen);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Almacen creado con exito", 
                );
            }

         }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
            } 
        return $helpers->json($responce);
    }
    

    /**
     * Finds and displays a Almacen entity.
     *
     * @Route("/show/{id}", name="almacen_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $almacen = $em->getRepository('AppBundle:Almacen')->find($id);

            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Almacen con id"." ".$almacen->getId(), 
                    'data'=> $almacen,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Displays a form to edit an existing Almacen entity.
     *
     * @Route("/edit", name="almacen_edit")
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

                $rangoInicio = $params->rangoInicio;
                $rangoFin = $params->rangoFin;
                $lote = $params->lote;
                $estado = true;
                $em = $this->getDoctrine()->getManager();
                $servicio = $em->getRepository('AppBundle:Servicio')->find($params->servicioId);
                $organismoTransito = $em->getRepository('AppBundle:OrganismoTransito')->find($params->organismoTransitoId);
                $consumible = $em->getRepository('AppBundle:Consumible')->find($params->consumibleId);
                $clase = $em->getRepository('AppBundle:Clase')->find($params->claseId);
                $almacen = $em->getRepository('AppBundle:Almacen')->find($params->id);


                if ($almacen!=null) {
                    $almacen->setRangoInicio($rangoInicio);
                    $almacen->setRangoFin($rangoFin);
                    $almacen->setLote($lote);
                    $almacen->setEstado($estado);
                    $almacen->setServicio($servicio);
                    $almacen->setOrganismoTransito($organismoTransito);
                    $almacen->setConsumible($consumible);
                    $almacen->setClase($clase);

                    $em->persist($almacen);
                    $em->flush();

                    $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Almacen editado con exito", 
                    );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El Almacen no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Almacen entity.
     *
     * @Route("/{id}/delete", name="almacen_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $almacen = $em->getRepository('AppBundle:Almacen')->find($id);

            if ($almacen!=null) {

                $almacen->setEstado(0);
                $em->persist($almacen);
                $em->flush();

                $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Almacen eliminado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El Almacen no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a Almacen entity.
     *
     * @param Almacen $almacen The Almacen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Almacen $almacen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('almacen_delete', array('id' => $almacen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
