<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteCfgConcepto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtecfgconcepto controller.
 *
 * @Route("frotrtecfgconcepto")
 */
class FroTrteCfgConceptoController extends Controller
{
    /**
     * Lists all froTrteCfgConcepto entities.
     *
     * @Route("/", name="frotrtecfgconcepto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramitesConceptos = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tramitesConceptos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesConceptos) . " registros encontrados",
                'data' => $tramitesConceptos,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new Tramite Concepto entity.
     *
     * @Route("/new", name="tramite_concepto_new")
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
            
            $tramiteConcepto = new FroTrteCfgConcepto();

            $tramiteConcepto->setNombre(strtoupper($params->nombre));
            $tramiteConcepto->setValor($params->valor);
            $tramiteConcepto->setCuenta($params->cuenta);
            $tramiteConcepto->setActivo(true);

            $em->persist($tramiteConcepto);
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
     * Finds and displays a froTrteCfgConcepto entity.
     *
     * @Route("/{id}", name="frotrtecfgconcepto_show")
     * @Method("GET")
     */
    public function showAction(FroTrteCfgConcepto $froTrteCfgConcepto)
    {

        return $this->render('frotrtecfgconcepto/show.html.twig', array(
            'froTrteCfgConcepto' => $froTrteCfgConcepto,
        ));
    }
}
