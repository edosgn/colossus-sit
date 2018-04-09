<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Inmovilizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inmovilizacion controller.
 *
 * @Route("inmovilizacion")
 */
class InmovilizacionController extends Controller
{
    /**
     * Lists all inmovilizacion entities.
     *
     * @Route("/", name="inmovilizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $inmovilizaciones = $em->getRepository('AppBundle:Inmovilizacion')->findAll();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "lista de inmovilizaciones",
            'data' => $inmovilizaciones, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new inmovilizacion entity.
     *
     * @Route("/new", name="inmovilizacion_new")
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
            // if (count($params)==0) {
            //     $response = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "Los campos no pueden estar vacios", 
            //     );
            // }else{
                $numeroPatio = $params->numeroPatio;
                $numeroGrua = $params->numeroGrua;
                $numeroConsecutivo = $params->numeroConsecutivo;
                $direccionPatio = $params->direccionPatio;
                $placaGrua = $params->placaGrua;
                $comparendo = $params->comparendo;

                $inmovilizacion = new Inmovilizacion();

                $inmovilizacion->setNumeroPatio($numeroPatio);
                $inmovilizacion->setNumeroGrua($numeroGrua);
                $inmovilizacion->setNumeroConsecutivo($numeroConsecutivo);
                $inmovilizacion->setDireccionPatio($direccionPatio);
                $inmovilizacion->setPlacaGrua($placaGrua);
                $inmovilizacion->setComparendo($comparendo);

                $em = $this->getDoctrine()->getManager();
                $em->persist($inmovilizacion);
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
     * Finds and displays a inmovilizacion entity.
     *
     * @Route("/{id}/show", name="inmovilizacion_show")
     * @Method("GET")
     */
    public function showAction(Inmovilizacion $inmovilizacion)
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
                    'data'=> $inmovilizacion,
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
     * Displays a form to edit an existing inmovilizacion entity.
     *
     * @Route("/{id}/edit", name="inmovilizacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Inmovilizacion $inmovilizacion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $numeroPatio = $params->numeroPatio;
            $numeroGrua = $params->numeroGrua;
            $numeroConsecutivo = $params->numeroConsecutivo;
            $direccionPatio = $params->direccionPatio;
            $placaGrua = $params->placaGrua;
            $comparendo = $params->comparendo;

            $em = $this->getDoctrine()->getManager();

            if ($inmovilizacion!=null) {
                $inmovilizacion->setNumeroPatio($numeroPatio);
                $inmovilizacion->setNumeroGrua($numeroGrua);
                $inmovilizacion->setNumeroConsecutivo($numeroConsecutivo);
                $inmovilizacion->setDireccionPatio($direccionPatio);
                $inmovilizacion->setPlacaGrua($placaGrua);
                $inmovilizacion->setComparendo($comparendo);

                $em = $this->getDoctrine()->getManager();
                $em->persist($inmovilizacion);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $inmovilizacion,
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
     * Deletes a inmovilizacion entity.
     *
     * @Route("/{id}/delete", name="inmovilizacion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, Inmovilizacion $inmovilizacion)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $inmovilizacion->setEstado(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($inmovilizacion);
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
     * Creates a form to delete a inmovilizacion entity.
     *
     * @param Inmovilizacion $inmovilizacion The inmovilizacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inmovilizacion $inmovilizacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inmovilizacion_delete', array('id' => $inmovilizacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
