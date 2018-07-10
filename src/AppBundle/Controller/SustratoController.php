<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sustrato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * Sustrato controller.
 *
 * @Route("sustrato")
 */
class SustratoController extends Controller
{
    /**
     * Lists all sustrato entities.
     *
     * @Route("/", name="sustrato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sustratos = $em->getRepository('AppBundle:Sustrato')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de sustratos",
            'data' => $sustratos, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new sustrato entity.
     *
     * @Route("/new", name="sustrato_new")
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
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{*/
                $estado = $params->estado;
                $desde = $params->desde;
                $hasta = $params->hasta;
                //Captura llaves foraneas
                $sedeOperativaId = $params->sedeOperativaId;
                $moduloId = $params->moduloId;
                $claseId = (isset($params->claseId)) ? $params->claseId : null;

                $em = $this->getDoctrine()->getManager();
                $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($sedeOperativaId);
                $modulo = $em->getRepository('AppBundle:Modulo')->find($moduloId);

                while ($desde <= $hasta) {
                    $sustrato = new Sustrato();
                    $sustrato->setEstado($estado);
                    $sustrato->setConsecutivo($modulo->getSiglaSustrato().$desde);
                    //Inserta llaves foraneas
                    $sustrato->setSedeOperativa($sedeOperativa);
                    $sustrato->setModulo($modulo);
                    if ($claseId) {
                        $clase = $em->getRepository('AppBundle:Clase')->find($claseId);
                        $sustrato->setClase($clase);
                    }

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sustrato);
                    $em->flush();
                    $desde++;
                }


                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
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
     * Finds and displays a sustrato entity.
     *
     * @Route("/{id}/show", name="sustrato_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $sustrato = $em->getRepository('AppBundle:Sustrato')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "ustrato con numero"." ".$sustrato->getNumero(), 
                    'data'=> $sustrato,
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
     * Finds and displays a sustrato entity.
     *
     * @Route("/show/consecutivo/{consecutivo}", name="sustrato_show_consecutivo")
     * @Method({"GET", "POST"})
     */
    public function showNumeroAction(Request $request,$consecutivo)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $sustrato = $em->getRepository('AppBundle:Sustrato')->findOneBy(
                array('consecutivo' => $consecutivo,'estado'=>'Disponible')
            );

           

            if ($sustrato) {
                $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'data'=> $sustrato,
                );
            }else{
                $response = array(
                        'status' => 'error',
                        'code' => 300,
                        'msj'=> 'sustrato no encontrado',
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
     * Displays a form to edit an existing sustrato entity.
     *
     * @Route("/edit", name="sustrato_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            // var_dump($params);
            $estado = (isset($params->estado)) ? $params->estado : null;
            $sustratoId = (isset($params->id)) ? $params->id : null;
            $descripcion = (isset($params->descripcion)) ? $params->descripcion : null;
            $impresion = (isset($params->impresion)) ? $params->impresion : null;
            $entregado = (isset($params->entregado)) ? $params->entregado : null;
            $ciudadanoId = (isset($params->ciudadanoId)) ? $params->ciudadanoId : null;

            $em = $this->getDoctrine()->getManager();
            $sustrato = $em->getRepository("AppBundle:Sustrato")->find($sustratoId);

            $em = $this->getDoctrine()->getManager();
            if ($ciudadanoId) {
                # code...
                $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByIdentificacion($ciudadanoId);
                $sustrato->setCiudadano($usuario->getCiudadano());
            }
            if ($sustrato!=null) {
                $sustrato->setDescripcion($descripcion);
                $sustrato->setImpresion($impresion);
                $sustrato->setEntregado($entregado);
                $sustrato->setEstado($estado);
                $em->persist($sustrato);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $sustrato,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a sustrato entity.
     *
     * @Route("/{id}", name="sustrato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sustrato $sustrato)
    {
        $form = $this->createDeleteForm($sustrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sustrato);
            $em->flush();
        }

        return $this->redirectToRoute('sustrato_index');
    }

    /**
     * Creates a form to delete a sustrato entity.
     *
     * @param Sustrato $sustrato The sustrato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sustrato $sustrato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sustrato_delete', array('id' => $sustrato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="sustrato_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $sustratos = $em->getRepository('AppBundle:Sustrato')->findBy(
        array('estado' => 'Disponible')
    );
      foreach ($sustratos as $key => $sustrato) {
        $response[$key] = array(
            'value' => $sustrato->getId(),
            'label' => $sustrato->getModulo()->getNombre()."_".$sustrato->getConsecutivo(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing sustrato entity.
     *
     * @Route("/edit/estado", name="sustrato_edit_estado")
     * @Method({"GET", "POST"})
     */
    public function editEstadoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $sustrato = $em->getRepository("AppBundle:Sustrato")->find($params->id);

            if ($sustrato) {
                $sustrato->setEstado('Utilizado');
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $sustrato,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }
}
