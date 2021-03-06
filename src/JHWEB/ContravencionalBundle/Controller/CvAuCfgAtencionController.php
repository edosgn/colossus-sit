<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAuCfgAtencion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvaucfgatencion controller.
 *
 * @Route("cvaucfgatencion")
 */
class CvAuCfgAtencionController extends Controller
{
    /**
     * Lists all cvAuCfgAtencion entities.
     *
     * @Route("/", name="cvaucfgatencion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $atenciones = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgAtencion')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($atenciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($atenciones)." registros encontrados", 
                'data'=> $atenciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvAuCfgAtencion entity.
     *
     * @Route("/new", name="cvaucfgatencion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            if ($params->dias) {
                foreach ($params->dias as $key => $dia) {
                    $atencion = new CvAuCfgAtencion();

                    $atencion->setDia($dia);
                    $atencion->setHoraManianaInicial(new \Datetime('08:00'));
                    $atencion->setHoraManianaFinal(new \Datetime('12:00'));
                    $atencion->setHoraTardeInicial(new \Datetime('14:00'));
                    $atencion->setHoraTardeFinal(new \Datetime('18:00'));
                    $atencion->setActivo(true);

                    $em->persist($atencion);
                    $em->flush();
                }
            }

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cvAuCfgAtencion entity.
     *
     * @Route("/{id}/show", name="cvaucfgatencion_show")
     * @Method("GET")
     */
    public function showAction(CvAuCfgAtencion $cvAuCfgAtencion)
    {
        $deleteForm = $this->createDeleteForm($cvAuCfgAtencion);

        return $this->render('cvaucfgatencion/show.html.twig', array(
            'cvAuCfgAtencion' => $cvAuCfgAtencion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvAuCfgAtencion entity.
     *
     * @Route("/edit", name="cvaucfgatencion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $atencion = $em->getRepository("JHWEBContravencionalBundle:CvAuCfgAtencion")->find(
                $params->id
            );

            if ($atencion) {
                $atencion->setDia($params->dia);

                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvAuCfgAtencion entity.
     *
     * @Route("/delete", name="cvaucfgatencion_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $atencion = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgAtencion')->find(
                $params->id
            );

            $atencion->setActivo(false);

            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }
}
