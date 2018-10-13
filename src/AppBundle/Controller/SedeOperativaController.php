<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SedeOperativa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sedeoperativa controller.
 *
 * @Route("sedeoperativa")
 */
class SedeOperativaController extends Controller
{
    /**
     * Lists all sedeOperativa entities.
     *
     * @Route("/", name="sedeoperativa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sedesOperativas = $em->getRepository('AppBundle:SedeOperativa')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de sedesOperativas",
            'data' => $sedesOperativas, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new sedeOperativa entity.
     *
     * @Route("/new", name="sedeoperativa_new")
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
            // var_dump($params);
            // die();
            $municipioId = $params->municipioId;
            $nombre = $params->nombre;
            $codigoDivipo = $params->codigoDivipo;
            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);

            $sedeOperativa = new Sedeoperativa();

            $sedeOperativa->setNombre($nombre);
            $sedeOperativa->setCodigoDivipo($codigoDivipo);
            $sedeOperativa->setMunicipio($municipio);
            $sedeOperativa->setAsignacionRango($params->asignacionRango);
            $sedeOperativa->setEstado(true);

            $em->persist($sedeOperativa);
            $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
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
     * Finds and displays a agenteTransito entity.
     *
     * @Route("/{id}/show", name="sedeoperativa_show")
     * @Method({"GET", "POST"})
     */
     public function showAction(Request $request, SedeOperativa $sedeOperativa)
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
                    'data'=> $sedeOperativa,
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
     * Displays a form to edit an existing sedeOperativa entity.
     *
     * @Route("/edit", name="sedeoperativa_edit")
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
            $codigoDivipo = $params->codigoDivipo;
            $municipioId = $params->municipioId;
            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            
            $sedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->id);

            if ($sedeOperativa!=null) {
                $sedeOperativa->setNombre($nombre);
                $sedeOperativa->setCodigoDivipo($codigoDivipo);
                $sedeOperativa->setMunicipio($municipio);
                $sedeOperativa->setAsignacionRango($params->asignacionRango);
                $em = $this->getDoctrine()->getManager();
                $em->persist($sedeOperativa);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $sedeOperativa,
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
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a sedeOperativa entity.
     *
     * @Route("/{id}/delete", name="sedeoperativa_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, SedeOperativa $sedeOperativa)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $sedeOperativa->setEstado(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($sedeOperativa);
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
     * Creates a form to delete a sedeOperativa entity.
     *
     * @param SedeOperativa $sedeOperativa The sedeOperativa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SedeOperativa $sedeOperativa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sedeoperativa_delete', array('id' => $sedeOperativa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Datos para select 2
     *
     * @Route("/select", name="sedeoperativa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {

    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $sedesOperativas = $em->getRepository('AppBundle:SedeOperativa')->findBy(
        array('estado' => 1)
    );
        foreach ($sedesOperativas as $key => $sedeOperativa) {
            $consecutive = substr($sedeOperativa->getCodigoDivipo(), 0, 12);
            $response[$key] = array(
                'value' => $sedeOperativa->getId(),
                'label' => $sedeOperativa->getCodigoDivipo()."_".$sedeOperativa->getNombre()."  -  ".$sedeOperativa->getMunicipio(),
                'consecutive' => $consecutive
            );
        }
        return $helpers->json($response);
    }
}
