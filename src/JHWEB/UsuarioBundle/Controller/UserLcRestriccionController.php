<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcRestriccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userlcrestriccion controller.
 *
 * @Route("userlcrestriccion")
 */
class UserLcRestriccionController extends Controller
{ 
    /**
     * Lists all userLcRestriccion entities.
     *
     * @Route("/", name="userlcrestriccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLcRestriccions = $em->getRepository('JHWEBUsuarioBundle:UserLcRestriccion')->findAll();

        return $this->render('userlcrestriccion/index.html.twig', array(
            'userLcRestriccions' => $userLcRestriccions,
        ));
    }

    /**
     * Creates a new userLcRestriccion entity.
     *
     * @Route("/new", name="userlcrestriccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);
        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);
            $userLcRestriccion = new UserLcRestriccion();

            $userLicenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->find($params->idLicenciaConduccion);
            $userLcRestriccion->setUserLicenciaConduccion($userLicenciaConduccion);
            $userLcRestriccion->setFechaResolucion(new \Datetime($params->fechaResolucion));
            $userLcRestriccion->setFechaResolucion(new \Datetime($params->fechaResolucion));
            $userLcRestriccion->setTipoActo($params->tipoActo);
            $userLcRestriccion->setNumResolucion($params->numResolucion);
            $userLcRestriccion->setEstado('ACTIVO');
            if($params->tipo == 'CANCELACION'){
                $userLcRestriccion->setFechaCancelacion(new \Datetime($params->fechaCancelacion));
                $userLcRestriccion->setTipo('CANCELACION');
                $userLicenciaConduccion->setEstado('CANCELADA');

            }else{
                $userLcRestriccion->setFechaInicio(new \Datetime($params->fechaFin));
                $userLcRestriccion->setFechaFin(new \Datetime($params->fechaFin));
                $userLcRestriccion->setTipo('SUSPENSION');
                $userLicenciaConduccion->setEstado('SUSPENDIDA');
            }
            $userLicenciaConduccion->setActivo(false);

            $em->persist($userLcRestriccion);
            $em->persist($userLicenciaConduccion);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con éxito.", 
            );
        } else {
          $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new Cuenta entity.
     *
     * @Route("/pdf/genera/auto", name="auto_genera_pdf_acta")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager(); 
        $json = $request->get("data",null);
        $params = json_decode($json);

        $userLicenciaConduccion = $em->getRepository('JHWEBUsuarioBundle:UserLicenciaConduccion')->find($params->idLicenciaConduccion);
        $userLcRestriccion = $em->getRepository('JHWEBUsuarioBundle:UserLcRestriccion')->findOneBy(
            array(
                'userLicenciaConduccion' => $params->idLicenciaConduccion,
                'estado' =>'ACTIVA',
            )
        );

        $userLcRestriccion->setHorasComunitarias($params->horasComunitarias);
        $userLcRestriccion->setEstado('DEVUELTA');

        $userLicenciaConduccion->setEstado('ACTIVA');
        $userLicenciaConduccion->setActivo(1);

        $em->persist($userLicenciaConduccion);
        $em->persist($userLcRestriccion);
        $em->flush();
       
        $html = $this->renderView('@JHWEBUsuario/Default/pdf.genera.auto.insumo.html.twig', array()); 

        /* ================= */
        return new Response(
            $this->get('app.pdf')->templatePreview($html, 'Acta '.'Num Acta.'),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="fichero.pdf"'
            )
        );

    }

    /**
     * Finds and displays a userLcRestriccion entity.
     *
     * @Route("/{id}", name="userlcrestriccion_show")
     * @Method("GET")
     */
    public function showAction(UserLcRestriccion $userLcRestriccion)
    {

        return $this->render('userlcrestriccion/show.html.twig', array(
            'userLcRestriccion' => $userLcRestriccion,
        ));
    }
}
