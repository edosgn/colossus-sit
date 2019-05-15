<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoCfgDescuento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdocfgdescuento controller.
 *
 * @Route("cvcdocfgdescuento")
 */
class CvCdoCfgDescuentoController extends Controller
{
    /**
     * Lists all cvCdoCfgDescuento entities.
     *
     * @Route("/", name="cvcdocfgdescuento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $descuentos = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgDescuento')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($descuentos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($descuentos)." registros encontrados", 
                'data'=> $descuentos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoCfgDescuento entity.
     *
     * @Route("/new", name="cvcdocfgdescuento_new")
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

            $descuento = new CvCdoCfgDescuento();

            $descuento->setPorcentaje($params->porcentaje);
            $descuento->setFechaInicial(
                new \Datetime($params->fechaInicial)
            );
            $descuento->setFechaFinal(
                new \Datetime($params->fechaFinal)
            );
            $descuento->setActivo(true);

            $em->persist($descuento);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.',
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a cvCdoCfgDescuento entity.
     *
     * @Route("/show", name="cvcdocfgdescuento_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $descuento = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgDescuento')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $descuento
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cvCdoCfgDescuento entity.
     *
     * @Route("/edit", name="cvcdocfgdescuento_edit")
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

            $descuento = $em->getRepository("JHWEBContravencionalBundle:CvCdoCfgDescuento")->find(
                $params->id
            );

            if ($descuento) {
                $descuento->setPorcentaje($params->porcentaje);
                $descuento->setFechaInicial(
                    new \Datetime($params->fechaInicial)
                );
                $descuento->setFechaFinal(
                    new \Datetime($params->fechaFinal)
                );

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $descuento,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvCdoCfgDescuento entity.
     *
     * @Route("/delete", name="cvcdocfgdescuento_delete")
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

            $descuento = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgDescuento')->find(
                $params->id
            );

            $descuento->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a cvCdoCfgDescuento entity.
     *
     * @param CvCdoCfgDescuento $cvCdoCfgDescuento The cvCdoCfgDescuento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoCfgDescuento $cvCdoCfgDescuento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdocfgdescuento_delete', array('id' => $cvCdoCfgDescuento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
