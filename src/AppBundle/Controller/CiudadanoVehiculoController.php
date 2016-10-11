<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CiudadanoVehiculo;
use AppBundle\Form\CiudadanoVehiculoType;

/**
 * CiudadanoVehiculo controller.
 *
 * @Route("/ciudadanovehiculo")
 */
class CiudadanoVehiculoController extends Controller
{
    /**
     * Lists all CiudadanoVehiculo entities.
     *
     * @Route("/", name="ciudadanovehiculo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $ciudadanoVehiculos = $em->getRepository('AppBundle:CiudadanoVehiculo')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado ciudadanoVehiculos", 
                    'data'=> $ciudadanoVehiculos,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new CiudadanoVehiculo entity.
     *
     * @Route("/new", name="ciudadanovehiculo_new")
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
            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                        $licenciaTransito = $params->licenciaTransito;
                        $fechaPropiedadInicial = $params->fechaPropiedadInicial;
                        $fechaPropiedadFinal = $params->fechaPropiedadFinal;
                        $estadoPropiedad = $params->estadoPropiedad;
                        $ciudadanoId = $params->ciudadanoId;
                        $vehiculoId = $params->vehiculoId;
                        $em = $this->getDoctrine()->getManager();
                        $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
                        $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(
                            array('placa' => $vehiculoId)
                        );
                       

                        $ciudadanoVehiculo = new CiudadanoVehiculo();

                        $ciudadanoVehiculo->setLicenciaTransito($licenciaTransito);
                        $ciudadanoVehiculo->setFechaPropiedadInicial($fechaPropiedadInicial);
                        $ciudadanoVehiculo->setFechaPropiedadFinal($fechaPropiedadFinal);
                        $ciudadanoVehiculo->setEstadoPropiedad($estadoPropiedad);
                        $ciudadanoVehiculo->setCiudadano($ciudadano);
                        $ciudadanoVehiculo->setVehiculo($vehiculo);

                        $ciudadanoVehiculo->setEstado(true);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($ciudadanoVehiculo);
                        $em->flush();
                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "CiudadanoVehiculo creado con exito", 
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
     * Finds and displays a CiudadanoVehiculo entity.
     *
     * @Route("/show/{id}", name="ciudadanovehiculo_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $ciudadanoVehiculo = $em->getRepository('AppBundle:CiudadanoVehiculo')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "ciudadanoVehiculo con nombre"." ".$ciudadanoVehiculo->getLicenciaTransito(), 
                    'data'=> $ciudadanoVehiculo,
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
     * Displays a form to edit an existing CiudadanoVehiculo entity.
     *
     * @Route("/edit", name="ciudadanovehiculo_edit")
     * @Method({"POST", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $licenciaTransito = $params->licenciaTransito;
            $fechaPropiedadInicial = $params->fechaPropiedadInicial;
            $fechaPropiedadFinal = $params->fechaPropiedadFinal;
            $estadoPropiedad = $params->estadoPropiedad;
            $ciudadanoId = $params->ciudadanoId;
            $vehiculoId = $params->vehiculoId;
            $em = $this->getDoctrine()->getManager();
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
             $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneBy(
                            array('placa' => $vehiculoId)
                        );

            $em = $this->getDoctrine()->getManager();
            $ciudadanoVehiculo = $em->getRepository("AppBundle:CiudadanoVehiculo")->find($params->id);

            if ($ciudadanoVehiculo!=null) {
                $ciudadanoVehiculo->setLicenciaTransito($licenciaTransito);
                $ciudadanoVehiculo->setFechaPropiedadInicial($fechaPropiedadInicial);
                $ciudadanoVehiculo->setFechaPropiedadFinal($fechaPropiedadFinal);
                $ciudadanoVehiculo->setEstadoPropiedad($estadoPropiedad);
                $ciudadanoVehiculo->setCiudadano($ciudadano);
                $ciudadanoVehiculo->setVehiculo($vehiculo);

                $ciudadanoVehiculo->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($ciudadanoVehiculo);
                $em->flush();
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "CiudadanoVehiculo actualizado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El ciudadanoVehiculo no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar ciudadanoVehiculo", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a CiudadanoVehiculo entity.
     *
     * @Route("/{id}/delete", name="ciudadanovehiculo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $ciudadanoVehiculo = $em->getRepository('AppBundle:CiudadanoVehiculo')->find($id);

            $ciudadanoVehiculo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($ciudadanoVehiculo);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "ciudadanoVehiculo eliminado con exito", 
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
     * Creates a form to delete a CiudadanoVehiculo entity.
     *
     * @param CiudadanoVehiculo $ciudadanoVehiculo The CiudadanoVehiculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CiudadanoVehiculo $ciudadanoVehiculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ciudadanovehiculo_delete', array('id' => $ciudadanoVehiculo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
