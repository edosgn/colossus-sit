<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloDevolucionRadicado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Vhlodevolucionradicado controller.
 *
 * @Route("vhlodevolucionradicado")
 */
class VhloDevolucionRadicadoController extends Controller
{
    /**
     * Lists all vhloDevolucionRadicado entities.
     *
     * @Route("/", name="vhlodevolucionradicado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vhloDevolucionRadicados = $em->getRepository('JHWEBVehiculoBundle:VhloDevolucionRadicado')->findAll();

        return $this->render('vhlodevolucionradicado/index.html.twig', array(
            'vhloDevolucionRadicados' => $vhloDevolucionRadicados,
        ));
    }

    /**
     * Creates a new vhloDevolucionRadicado entity.
     *
     * @Route("/new", name="vhlodevolucionradicado_new")
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
            
            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
            
            
            $vehiculoDevolucion = $em->getRepository('JHWEBVehiculoBundle:VhloDevolucionRadicado')->findOneBy(
                array(
                    'vehiculo' => $vehiculo->getId(),
                    'activo' => true
                )
            );

            if(!$vehiculoDevolucion) {
                $devolucionRadicado = new VhloDevolucionRadicado();
    
                $devolucionRadicado->setVehiculo($vehiculo);
                $devolucionRadicado->setNumeroLicenciaTransito($params->numeroLicenciaTransito);
                $devolucionRadicado->setFechaIngreso(new \DateTime($params->fechaIngreso));
                $devolucionRadicado->setNumeroGuiaLlegada($params->numeroGuiaLlegada);
                $devolucionRadicado->setEmpresaEnvio($params->empresaEnvio);
                $devolucionRadicado->setActivo(true);
    
                //edicion de vehiculo
                $vehiculo->setTipoMatricula('DEVOLUCION');
                
                $em->persist($devolucionRadicado);
                $em->persist($vehiculo);
    
                $em->flush();
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito", 
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El vehiculo ya fue devolucionado.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloDevolucionRadicado entity.
     *
     * @Route("/{id}", name="vhlodevolucionradicado_show")
     * @Method("GET")
     */
    public function showAction(VhloDevolucionRadicado $vhloDevolucionRadicado)
    {

        return $this->render('vhlodevolucionradicado/show.html.twig', array(
            'vhloDevolucionRadicado' => $vhloDevolucionRadicado,
        ));
    }

    /**
     * Finds and displays a vhloDevolucionRadicado entity by vehiculo.
     *
     * @Route("/search/devolucion/vehiculo", name="vhlodevolucionradicado_search_by_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function searchByVehiculoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloVehiculo')->find($params->idVehiculo);
            
            
            $vehiculoDevolucion = $em->getRepository('JHWEBVehiculoBundle:VhloDevolucionRadicado')->findOneBy(
                array(
                    'vehiculo' => $vehiculo->getId(),
                )
            );

            if($vehiculoDevolucion) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data' => $vehiculoDevolucion
                );
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Registro noencontrado", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida"
            );
        }

        return $helpers->json($response);
    }
}
