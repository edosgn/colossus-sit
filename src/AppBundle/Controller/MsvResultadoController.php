<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvResultado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Msvresultado controller.
 *
 * @Route("msvresultado")
 */
class MsvResultadoController extends Controller
{
    /**
     * Lists all msvResultado entities.
     *
     * @Route("/", name="msvresultado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $resultados = $em->getRepository('AppBundle:MsvResultado')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($resultados) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($resultados) . " registros encontrados",
                'data' => $resultados,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new msvResultado entity.
     *
     * @Route("/new", name="msvresultado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $msvResultado = new MsvResultado();
            $em = $this->getDoctrine()->getManager();

            $msvResultado->setPilarFortalecimiento($params->nombreFortalecimiento);
            $msvResultado->setValorObtenidoFortalecimiento($params->valorObtenidoFortalecimiento);
            $msvResultado->setValorPonderadoFortalecimiento(0.3);
            $valorResultadoFortalecimiento = $params->valorObtenidoFotalecimiento * 0.3;
            $msvResultado->setValorResultadoFortalecimiento($valorResultadoFortalecimiento);

            $msvResultado->setPilarComportamiento($params->nombreComportamiento);
            $msvResultado->setValorObtenidoComportamiento($params->valorObtenidoComportamiento);
            $msvResultado->setValorPonderadoComportamiento(0.2);
            $valorResultadoComportamiento = $params->valorObtenidoComportamiento * 0.3;
            $msvResultado->setValorResultadoComportamiento($valorResultadoComportamiento);

            $msvResultado->setPilarVehiculoSeguro($params->nombreVehiculoSeguro);
            $msvResultado->setValorObtenidoVehiculoSeguro($params->valorObtenidoVehiculoSeguro);
            $msvResultado->setValorPonderadoVehiculoSeguro(0.2);
            $valorResultadoVehiculoSeguro = $params->valorObtenidoVehiculoSeguro * 0.2;
            $msvResultado->setValorResultadoVehiculoSeguro($valorResultadoVehiculoSeguro);

            $msvResultado->setPilarInfraestructuraSegura($params->nombreInfraestructuraSegura);
            $msvResultado->setValorObtenidoInfraestructuraSegura($params->valorObtenidoInfraestructuraSegura);
            $msvResultado->setValorPonderadoInfraestructuraSegura(0.1);
            $valorResultadoInfraestructuraSegura = $params->valorObtenidoInfraestructuraSegura * 0.1;
            $msvResultado->setValorResultadoInfraestructuraSegura($valorResultadoInfraestructuraSegura);

            $msvResultado->setPilarAtencionVictima($params->nombreAtencionVictima);
            $msvResultado->setValorObtenidoAtencionVictima($params->valorObtenidoAtencionVictima);
            $msvResultado->setValorPonderadoAtencionVictima($params->valorPonderadoAtencionVictima);
            $valorResultadoAtencionVictima = $params->valorObtenidoAtencionVictima * 0.1;
            $msvResultado->setValorResultadoAtencionVictima($valorResultadoAtencionVictima);

            $msvResultado->setPilarValorAgregado($params->nombreValorAgregado);
            $msvResultado->setValorObtenidoValorAgregado($params->valorObtenidoValorAgregado);
            $msvResultado->setValorPonderadoValorAgregado(0.05);
            $valorResultadoValorAgregado = $params->valorObtenidoValorAgregado * 0.05;
            $msvResultado->setValorResultadoValorAgregado($valorResultadoValorAgregado);

            $msvResultado->setResultadoFinal($valorResultadoFortalecimiento + $valorResultadoComportamiento + $valorResultadoVehiculoSeguro + $valorResultadoInfraestructuraSegura + $valorResultadoAtencionVictima + $valorResultadoValorAgregado);

            $msvResultado->setActivo(true);
            $em->persist($msvResultado);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvResultado entity.
     *
     * @Route("/{id}", name="msvresultado_show")
     * @Method("GET")
     */
    public function showAction(MsvResultado $msvResultado)
    {

        return $this->render('msvresultado/show.html.twig', array(
            'msvResultado' => $msvResultado,
        ));
    }
}
