<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AgenteTransito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Agentetransito controller.
 *
 * @Route("agentetransito")
 */
class AgenteTransitoController extends Controller
{
    /**
     * Lists all agenteTransito entities.
     *
     * @Route("/", name="agentetransito_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $agentes = $em->getRepository('AppBundle:AgenteTransito')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de agentes",
            'data' => $agentes, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new agenteTransito entity.
     *
     * @Route("/new", name="agentetransito_new")
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
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{
                $placa = $params->placa;
                $ciudadanoId = $params->ciudadanoId;
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);

                $agenteTransito = new Agentetransito();

                $agenteTransito->setPlaca($placa);
                $agenteTransito->setCiudadano($ciudadano);
                $agenteTransito->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($agenteTransito);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
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
     * Finds and displays a agenteTransito entity.
     *
     * @Route("/{id}/show", name="agentetransito_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, AgenteTransito $agenteTransito)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $agenteTransito,
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
     * Displays a form to edit an existing agenteTransito entity.
     *
     * @Route("/{id}/edit", name="agentetransito_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AgenteTransito $agenteTransito)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $id = $params->id;
            $placa = $params->placa;

            $ciudadanoId = $params->ciudadanoId;
            $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
            if ($agenteTransito!=null) {
                $agenteTransito->setPlaca($placa);
                $agenteTransito->setCiudadano($ciudadano);
                $em = $this->getDoctrine()->getManager();
                $em->persist($agenteTransito);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $agenteTransito,
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
                    'msj' => "Autorizacion no valida para editar agente de transito", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a agenteTransito entity.
     *
     * @Route("/{id}/delete", name="agentetransito_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, AgenteTransito $agenteTransito)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $agenteTransito->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($agenteTransito);
                $em->flush();
                $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro eliminado con exito", 
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
     * Creates a form to delete a agenteTransito entity.
     *
     * @param AgenteTransito $agenteTransito The agenteTransito entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AgenteTransito $agenteTransito)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agentetransito_delete', array('id' => $agenteTransito->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * datos para select 2
     *
     * @Route("/select", name="agenteTransito_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $agenteTransitos = $em->getRepository('AppBundle:AgenteTransito')->findBy(
        array('estado' => 1)
    );
      foreach ($agenteTransitos as $key => $agenteTransito) {
        $response[$key] = array(
            'value' => $agenteTransito->getId(),
            'label' => $agenteTransito->getPlaca()."_".$agenteTransito->getCiudadano()->getNumeroIdentificacion()."_".$agenteTransito->getCiudadano()->getPrimerNombre()."_".$agenteTransito->getCiudadano()->getPrimerApellido(),
            'agenteNombres' => $agenteTransito->getCiudadano()->getNumeroIdentificacion()."_".$agenteTransito->getCiudadano()->getPrimerNombre()."_".$agenteTransito->getCiudadano()->getPrimerApellido(),
            );
      }
       return $helpers->json($response);
    }
}
