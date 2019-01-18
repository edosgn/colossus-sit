<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoCfgInteres;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdocfgintere controller.
 *
 * @Route("cvcdocfginteres")
 */
class CvCdoCfgInteresController extends Controller
{
    /**
     * Lists all cvCdoCfgIntere entities.
     *
     * @Route("/", name="cvcdocfginteres_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $intereses = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgInteres')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($intereses) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($intereses)." registros encontrados", 
                'data'=> $intereses,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoCfgIntere entity.
     *
     * @Route("/new", name="cvcdocfginteres_new")
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

            $interes = new CvCdoCfgInteres();

            $interes->setPorcentaje($params->porcentaje);
            $interes->setDias($params->dias);
            $interes->setActivo(true);

            if ($params->idComparendoEstado) {
                $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                    $params->idComparendoEstado
                );
                $interes->setEstado($estado);
            }
            
            $em->persist($interes);
            
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a cvCdoCfgIntere entity.
     *
     * @Route("/show", name="cvcdocfginteres_show")
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

            $interes = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgInteres')->find(
                $params->id
            );

            $em->persist($interes);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $interes
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
     * Displays a form to edit an existing cvCdoCfgIntere entity.
     *
     * @Route("/edit", name="cvcdocfginteres_edit")
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

            $interes = $em->getRepository("JHWEBContravencionalBundle:CvCdoCfgInteres")->find($params->id);

            if ($interes) {
                $interes->setPorcentaje($params->porcentaje);
                $interes->setDias($params->dias);

                if ($params->idComparendoEstado) {
                    $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                        $params->idComparendoEstado
                    );
                    $interes->setEstado($estado);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $interes,
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
     * Deletes a cvCdoCfgIntere entity.
     *
     * @Route("/delete", name="cvcdocfginteres_delete")
     * @Method({"GET", "POST"})
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

            $interes = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgInteres')->find(
                $params->id
            );

            $interes->setActivo(false);

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
     * Creates a form to delete a cvCdoCfgIntere entity.
     *
     * @param CvCdoCfgInteres $cvCdoCfgIntere The cvCdoCfgIntere entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoCfgInteres $cvCdoCfgIntere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdocfginteres_delete', array('id' => $cvCdoCfgIntere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
