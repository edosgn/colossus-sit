<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoCfgTipoInfractor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdocfgtipoinfractor controller.
 *
 * @Route("cvcdocfgtipoinfractor")
 */
class CvCdoCfgTipoInfractorController extends Controller
{
    /**
     * Lists all cvCdoCfgTipoInfractor entities.
     *
     * @Route("/", name="cvcdocfgtipoinfractor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tiposInfractor = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgTipoInfractor')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tiposInfractor) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tiposInfractor)." registros encontrados", 
                'data'=> $tiposInfractor,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoCfgTipoInfractor entity.
     *
     * @Route("/new", name="cvcdocfgtipoinfractor_new")
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

            $tipoInfractor = new CvCdoCfgTipoInfractor();

            $tipoInfractor->setNombre(
                mb_strtoupper($params->nombre,'utf-8')
            );
            $tipoInfractor->setActivo(true);

            $em->persist($tipoInfractor);
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
     * Finds and displays a cvCdoCfgTipoInfractor entity.
     *
     * @Route("/show", name="cvcdocfgtipoinfractor_show")
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

            $tipoInfractor = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgTipoInfractor')->find(
                $params->id
            );

            if ($tipoInfractor) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con exito",
                    'data' => $tipoInfractor
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
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cvCdoCfgTipoInfractor entity.
     *
     * @Route("/edit", name="cvcdocfgtipoinfractor_edit")
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

            $tipoInfractor = $em->getRepository("JHWEBContravencionalBundle:CvCdoCfgTipoInfractor")->find(
                $params->id
            );

            if ($tipoInfractor) {
                $tipoInfractor->setNombre(
                    mb_strtoupper($params->nombre,'utf-8')
                );
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoInfractor,
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
     * Deletes a cvCdoCfgTipoInfractor entity.
     *
     * @Route("/delete", name="cvcdocfgtipoinfractor_delete")
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

            $interes = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgTipoInfractor')->find(
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
     * Creates a form to delete a cvCdoCfgTipoInfractor entity.
     *
     * @param CvCdoCfgTipoInfractor $cvCdoCfgTipoInfractor The cvCdoCfgTipoInfractor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoCfgTipoInfractor $cvCdoCfgTipoInfractor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdocfgtipoinfractor_delete', array('id' => $cvCdoCfgTipoInfractor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de tipos de infractor para seleccion con busqueda
     *
     * @Route("/select", name="cvcdocfgtipoinfractor_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tiposInfractor = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgTipoInfractor')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tiposInfractor as $key => $tipoInfractor) {
            $response[$key] = array(
                'value' => $tipoInfractor->getId(),
                'label' => $tipoInfractor->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
