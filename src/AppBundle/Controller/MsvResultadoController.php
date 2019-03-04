<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvResultado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


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

            $msvResultado->setFecha(new \Datetime(date('Y-m-d h:i:s')));

            $idEmpresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            $msvResultado->setEmpresa($idEmpresa);

            $msvResultado->setPilarFortalecimiento("FORTALECIMIENTO EN LA GESTIÓN INSTITUCIONAL");
            $msvResultado->setValorObtenidoFortalecimiento($params->valorObtenidoFortalecimiento);
            $msvResultado->setValorPonderadoFortalecimiento(0.3);
            $valorResultadoFortalecimiento = $params->valorObtenidoFortalecimiento * 0.3;
            $msvResultado->setResultadoFortalecimiento($valorResultadoFortalecimiento);

            $msvResultado->setPilarComportamiento("COMPORTAMIENTO HUMANO");
            $msvResultado->setValorObtenidoComportamiento($params->valorObtenidoComportamiento);
            $msvResultado->setValorPonderadoComportamiento(0.3);
            $valorResultadoComportamiento = $params->valorObtenidoComportamiento * 0.3;
            $msvResultado->setResultadoComportamiento($valorResultadoComportamiento);

            $msvResultado->setPilarVehiculoSeguro("VEHÍCULOS SEGUROS");
            $msvResultado->setValorObtenidoVehiculoSeguro($params->valorObtenidoVehiculoSeguro);
            $msvResultado->setValorPonderadoVehiculoSeguro(0.2);
            $valorResultadoVehiculoSeguro = $params->valorObtenidoVehiculoSeguro * 0.2;
            $msvResultado->setResultadoVehiculoSeguro($valorResultadoVehiculoSeguro);

            $msvResultado->setPilarInfraestructuraSegura("INFRAESTRUCTURA SEGURA ");
            $msvResultado->setValorObtenidoInfraestructuraSegura($params->valorObtenidoInfraestructuraSegura);
            $msvResultado->setValorPonderadoInfraestructuraSegura(0.1);
            $valorResultadoInfraestructuraSegura = $params->valorObtenidoInfraestructuraSegura * 0.1;
            $msvResultado->setResultadoInfraestructuraSegura($valorResultadoInfraestructuraSegura);

            $msvResultado->setPilarAtencionVictima("ATENCIÓN A VÍCTIMAS");
            $msvResultado->setValorObtenidoAtencionVictima($params->valorObtenidoAtencionVictima);
            $msvResultado->setValorPonderadoAtencionVictima(0.1);
            $valorResultadoAtencionVictima = $params->valorObtenidoAtencionVictima * 0.1;
            $msvResultado->setResultadoAtencionVictima($valorResultadoAtencionVictima);

            $msvResultado->setPilarValorAgregado("VALORES AGREGADOS O INNOVACIONES");
            $msvResultado->setValorObtenidoValorAgregado($params->valorObtenidoValorAgregado);
            $msvResultado->setValorPonderadoValorAgregado(0.05);
            $valorResultadoValorAgregado = $params->valorObtenidoValorAgregado * 0.05;
            $msvResultado->setResultadoValorAgregado($valorResultadoValorAgregado);

            $resultadoFinal = $valorResultadoFortalecimiento + $valorResultadoComportamiento + $valorResultadoVehiculoSeguro + $valorResultadoInfraestructuraSegura + $valorResultadoAtencionVictima + $valorResultadoValorAgregado;
            
            $msvResultado->setResultadoFinal($resultadoFinal);
            
            $minimoAval = 95*0.75;
            if($resultadoFinal >= $minimoAval){
                $msvResultado->setAval(true);
            }else{
                $msvResultado->setAval(false);
            }
            $msvResultado->setActivo(true);
            $em->persist($msvResultado);
            $em->flush();

            if($resultadoFinal >= $minimoAval){
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Los datos han sido registrados exitosamente.", 
                    'message2' => "El resultado final es: " . $resultadoFinal . ", cumple con el aval.",
                );
            } else {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Los datos han sido registrados exitosamente.", 
                        'message2' => "El resultado final es: " . $resultadoFinal . ", no cumple con el aval.",
                    );

            }
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
