<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tramite;
use AppBundle\Form\TramiteType;

/**
 * Tramite controller.
 *
 * @Route("/tramite")
 */
class TramiteController extends Controller
{
    /**
     * Lists all Tramite entities.
     *
     * @Route("/", name="tramite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramites = $em->getRepository('AppBundle:Tramite')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tramites", 
                    'data'=> $tramites,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Tramite entity.
     *
     * @Route("/new", name="tramite_new")
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
                        $nombre = $params->nombre;
                        $valor = $params->valor;
                        $redondeo = $params->redondeo;
                        $unidad = $params->unidad;
                        $afectacion = $params->afectacion;
                        $moduloId = $params->moduloId;
                        $em = $this->getDoctrine()->getManager();
                        $modulo = $em->getRepository('AppBundle:Modulo')->find($moduloId);
                        $tramite = new Tramite();
                        $tramite->setNombre($nombre);
                        $tramite->setValor($valor);
                        $tramite->setRedondeo($redondeo);
                        $tramite->setUnidad($unidad);
                        $tramite->setAfectacion($afectacion);
                        $tramite->setModulo($modulo);
                        $tramite->setEstado(true);
                        $em->persist($tramite);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "tramite creado con exito", 
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
     * Finds and displays a Tramite entity.
     *
     * @Route("/show/{id}", name="tramite_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramite con nombre"." ".$tramite->getNombre(), 
                    'data'=> $tramite,
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
     * Displays a form to edit an existing Tramite entity.
     *
     * @Route("/edit", name="tramite_edit")
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
            $redondeo = $params->redondeo;
            $unidad = $params->unidad;
            $afectacion = $params->afectacion;
            $moduloId = $params->moduloId;
            $em = $this->getDoctrine()->getManager();
            $modulo = $em->getRepository('AppBundle:Modulo')->find($moduloId);
            $tramite = $em->getRepository("AppBundle:Tramite")->find($params->id);

            if ($tramite!=null) {
                $tramite->setNombre($nombre);
                $tramite->setValor($valor);
                $tramite->setRedondeo($redondeo);
                $tramite->setUnidad($unidad);
                $tramite->setAfectacion($afectacion);
                $tramite->setModulo($modulo);
                $tramite->setEstado(true);
                $em->persist($tramite);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramite editado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El tramite no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Tramite entity.
     *
     * @Route("/{id}/delete", name="tramite_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tramite = $em->getRepository('AppBundle:Tramite')->find($id);

            $tramite->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tramite);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tramite eliminado con exito", 
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
     * Creates a form to delete a Tramite entity.
     *
     * @param Tramite $tramite The Tramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tramite $tramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramite_delete', array('id' => $tramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
