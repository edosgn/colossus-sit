<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCalificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcalificacion controller.
 *
 * @Route("svcalificacion")
 */
class SvCalificacionController extends Controller
{
    /**
     * Lists all svCalificacion entities.
     *
     * @Route("/", name="svcalificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $svCalificacions = $em->getRepository('JHWEBSeguridadVialBundle:SvCalificacion')->findAll();

        return $this->render('svcalificacion/index.html.twig', array(
            'svCalificacions' => $svCalificacions,
        ));
    }

    /**
     * Creates a new svCalificacion entity.
     *
     * @Route("/new", name="svcalificacion_new")
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

            foreach ($params->parametros[0] as $keyParametro => $parametro) {
                foreach ($parametro->variables as $keyVariable => $variable) {
                    foreach ($variable->criterios as $keyCriterio => $criterio) {
                        $criterioA = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCriterio')->find($criterio->id);
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresa);
                        $revision = $em->getRepository('JHWEBSeguridadVialBundle:SvRevision')->find($params->revision);
        
                        $msvCalificacion = new SvCalificacion();
                        $msvCalificacion->setCriterio($criterioA);
                        $msvCalificacion->setEmpresa($empresa);
                        $msvCalificacion->setRevision($revision);
                        $msvCalificacion->setAplica($criterio->aplica);
                        $msvCalificacion->setEvidencia($criterio->evidencia);
                        $msvCalificacion->setResponde($criterio->responde);
                        $msvCalificacion->setObservacion($criterio->observacion);
                        if ($criterio->responde == true) {
                            $msvCalificacion->setValorObtenido($parametro->valor / $parametro->numeroCriterios);
                        } else {
                            $msvCalificacion->setValorObtenido(0);
                        }
                        $msvCalificacion->setActivo(true);
                        $em->persist($msvCalificacion);
                        $em->flush();
                    }
                }
            }
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registros creados con éxito",
            );
        } else {
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
     * Finds and displays a svCalificacion entity.
     *
     * @Route("/{id}", name="svcalificacion_show")
     * @Method("GET")
     */
    public function showAction(SvCalificacion $svCalificacion)
    {

        return $this->render('svcalificacion/show.html.twig', array(
            'svCalificacion' => $svCalificacion,
        ));
    }
}
