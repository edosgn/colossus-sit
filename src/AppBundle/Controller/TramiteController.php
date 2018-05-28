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
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lista de tramites", 
                    'data'=> $tramites,
            );
         
        return $helpers->json($response);
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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $nombre = $params->nombre;
                $valor = $params->valor;
                $unidad = $params->unidad;
                $redondeo = (isset($params->redondeo)) ? $params->redondeo : false;
                $afectacion = (isset($params->afectacion)) ? $params->afectacion : false;
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

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramite creado con exito", 
                );
               
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
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramite con nombre"." ".$tramite->getNombre(), 
                    'data'=> $tramite,
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
            $unidad = $params->unidad;
            $redondeo = (isset($params->redondeo)) ? $params->redondeo : false;
            $afectacion = (isset($params->afectacion)) ? $params->afectacion : false;
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

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramite editado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El tramite no se encuentra en la base de datos", 
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
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tramite eliminado con exito", 
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

    /**
     * Deletes a Tramite entity.
     *
     * @Route("/TramitesModulo/{id}", name="tramite_modulo")
     * @Method("POST")
     */
    public function TramitesModulo(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $tramites = $em->getRepository('AppBundle:Tramite')->findBy(
            array('modulo' => $id)
            );

            if ($tramites != null) {
               $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Tramites encontrados", 
                        'data' => $tramites, 
                );
            }else{
                $response = array( 
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Aun no hay tramites", 
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
     * datos para select 2
     *
     * @Route("/select", name="tramite_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramites = $em->getRepository('AppBundle:Tramite')->findBy(
            array('estado' => true)
        );
        foreach ($tramites as $key => $tramite) {
            $response[$key] = array(
                'value' => $tramite->getId(),
                'label' => $tramite->getNombre(),
            );
        }
       return $helpers->json($response);
    }

    /**
     * datos para select 2 por modulo
     *
     * @Route("/{id}/select/tramites/por/modulo", name="modulo_select_por_modulo")
     * @Method({"GET", "POST"})
     */
    public function selectDepartamentoPorPaisAction($id)
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    
    $tramites = $em->getRepository('AppBundle:Tramite')->findBy(
        array(
            'modulo' => $id,
            'estado' => 1
        )
    );
      foreach ($tramites as $key => $tramite) {
        $response[$key] = array(
            'value' => $tramite->getId(),
            'label' => $tramite->getNombre(),
            );
      }
       return $helpers->json($response);
    }
}
