<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrteCarpeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frotrtecarpetum controller.
 *
 * @Route("frotrtecarpeta")
 */
class FroTrteCarpetaController extends Controller
{
    /**
     * Lists all froTrteCarpetum entities.
     *
     * @Route("/", name="frotrtecarpeta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tramitesCarpeta = $em->getRepository('JHWEBFinancieroBundle:FroTrteCarpeta')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => count($tramitesCarpeta) . " registros encontrados",
            'data' => $tramitesCarpeta,
        );

        return $helpers->json($response);
    }

      /**
     * Creates a new froTrteCarpeta entity.
     *
     * @Route("/new", name="frotrtecarpeta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $trteCarpeta = new FroTrteCarpeta();

            if ($params->identificacionCiudadano) {
                $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                    array(
                        'identificacion' => $params->identificacionCiudadano
                    )
                );
                $trteCarpeta->setCiudadano($ciudadano);
            }

            if($params->idSolicitante) {
                $solicitante = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->idSolicitante);
                $trteCarpeta->setSolicitante($solicitante);
            }

            if($params->idTramitePrecio) {
                $tramitePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find($params->idTramitePrecio);
                $trteCarpeta->setTramite($tramitePrecio->getTramite());
            }

            if($params->idVehiculo) {
                $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
                $trteCarpeta->setVehiculo($vehiculo);
            }

            if($params->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($params->idOrganismoTransito);
                $trteCarpeta->setOrganismoTransito($organismoTransito);
            }

            $trteCarpeta->setValor($params->valorTramite);
            $trteCarpeta->setFechaRealizacion(new \Datetime($params->fechaRealizacion));
            $trteCarpeta->setCreatedAt(new \Datetime());

            $trteCarpeta->setActivo(true);
            $em->persist($trteCarpeta);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!!!',
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'title' => 'Ettor!!!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTrteCarpetum entity.
     *
     * @Route("/{id}", name="frotrtecarpeta_show")
     * @Method("GET")
     */
    public function showAction(FroTrteCarpeta $froTrteCarpetum)
    {

        return $this->render('frotrtecarpeta/show.html.twig', array(
            'froTrteCarpetum' => $froTrteCarpetum,
        ));
    }
}
