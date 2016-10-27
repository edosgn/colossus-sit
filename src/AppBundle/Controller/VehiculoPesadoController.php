<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VehiculoPesado;
use AppBundle\Form\VehiculoPesadoType;

/**
 * VehiculoPesado controller.
 *
 * @Route("/vehiculopesado")
 */
class VehiculoPesadoController extends Controller
{
    /**
     * Lists all VehiculoPesado entities.
     *
     * @Route("/", name="vehiculopesado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculoPesado = $em->getRepository('AppBundle:VehiculoPesado')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado vehiculoPesado", 
                    'data'=> $vehiculoPesado,
            );
        return $helpers->json($responce);
    }

    /**
     * Creates a new VehiculoPesado entity.
     *
     * @Route("/new", name="vehiculopesado_new")
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
                        $tonelaje = $params->tonelaje;
                        $numeroEjes = $params->numeroEjes;
                        $numeroMt = $params->numeroMt;
                        $fichaTecnicaHomologacionCarroceria = $params->fichaTecnicaHomologacionCarroceria;
                        $fichaTecnicaHomologacionChasis = $params->fichaTecnicaHomologacionChasis;
                        $vehiculoId = $params->vehiculoId;
                        $modalidadId = $params->modalidadId;
                        $empresaId = $params->empresaId;
                        $em = $this->getDoctrine()->getManager();
                        $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
                        $modalidad = $em->getRepository('AppBundle:Modalidad')->find($modalidadId);
                        $empresa = $em->getRepository('AppBundle:Empresa')->find($empresaId);

                        $vehiculoPesado = new VehiculoPesado();

                        $vehiculoPesado->setTonelaje($tonelaje);
                        $vehiculoPesado->setNumeroEjes($numeroEjes);
                        $vehiculoPesado->setNumeroMt($numeroMt);
                        $vehiculoPesado->setFichaTecnicaHomologacionCarroceria($fichaTecnicaHomologacionCarroceria);
                        $vehiculoPesado->setFichaTecnicaHomologacionChasis($fichaTecnicaHomologacionChasis);
                        $vehiculoPesado->setVehiculo($vehiculo);
                        $vehiculoPesado->setModalidad($modalidad);
                        $vehiculoPesado->setEmpresa($empresa);
                        $vehiculoPesado->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($vehiculoPesado);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "vehiculoPesado creado con exito", 
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
     * Finds and displays a VehiculoPesado entity.
     *
     * @Route("/show/{id}", name="vehiculopesado_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculoPesado = $em->getRepository('AppBundle:VehiculoPesado')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculoPesado", 
                    'data'=> $vehiculoPesado,
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
     * Displays a form to edit an existing VehiculoPesado entity.
     *
     * @Route("/edit", name="vehiculopesado_edit")
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

            $tonelaje = $params->tonelaje;
            $numeroEjes = $params->numeroEjes;
            $numeroMt = $params->numeroMt;
            $fichaTecnicaHomologacionCarroceria = $params->fichaTecnicaHomologacionCarroceria;
            $fichaTecnicaHomologacionChasis = $params->fichaTecnicaHomologacionChasis;
            $vehiculoId = $params->vehiculoId;
            $modalidadId = $params->modalidadId;
            $empresaId = $params->empresaId;
            $em = $this->getDoctrine()->getManager();
            $vehiculo = $em->getRepository('AppBundle:Vehiculo')->find($vehiculoId);
            $modalidad = $em->getRepository('AppBundle:Modalidad')->find($modalidadId);
            $empresa = $em->getRepository('AppBundle:Empresa')->find($empresaId);

            $em = $this->getDoctrine()->getManager();
            $vehiculoPesado = $em->getRepository("AppBundle:VehiculoPesado")->find($params->id);

            if ($vehiculoPesado!=null) {
                $vehiculoPesado->setTonelaje($tonelaje);
                $vehiculoPesado->setNumeroEjes($numeroEjes);
                $vehiculoPesado->setNumeroMt($numeroMt);
                $vehiculoPesado->setFichaTecnicaHomologacionCarroceria($fichaTecnicaHomologacionCarroceria);
                $vehiculoPesado->setFichaTecnicaHomologacionChasis($fichaTecnicaHomologacionChasis);
                $vehiculoPesado->setVehiculo($vehiculo);
                $vehiculoPesado->setModalidad($modalidad);
                $vehiculoPesado->setEmpresa($empresa);
                $vehiculoPesado->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculoPesado);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculoPesado editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El vehiculoPesado no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar vehiculoPesado", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a VehiculoPesado entity.
     *
     * @Route("/{id}/delete", name="vehiculopesado_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculoPesado = $em->getRepository('AppBundle:VehiculoPesado')->find($id);

            $vehiculoPesado->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($vehiculoPesado);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "VehiculoPesado eliminado con exito", 
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
     * Creates a form to delete a VehiculoPesado entity.
     *
     * @param VehiculoPesado $vehiculoPesado The VehiculoPesado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoPesado $vehiculoPesado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculopesado_delete', array('id' => $vehiculoPesado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * busca los vehiculos pesados por id vehiculo.
     *
     * @Route("/vehiculo/{id}", name="vehiculopesado_show_vehiculo")
     * @Method("POST")
     */
    public function showPesadoVehiculoAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $vehiculoPesado = $em->getRepository('AppBundle:VehiculoPesado')->findOneBy(array('estado' =>1,'vehiculo'=>$id));
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "vehiculoPesado", 
                    'data'=> $vehiculoPesado,
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
}
