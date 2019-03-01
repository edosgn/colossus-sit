<?php

namespace JHWEB\FinancieroBundle\Controller;

use JHWEB\FinancieroBundle\Entity\FroTrtePrecio;
use JHWEB\FinancieroBundle\Entity\FroTrteConcepto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Frotrteprecio controller.
 *
 * @Route("frotrteprecio")
 */
class FroTrtePrecioController extends Controller
{
    /**
     * Lists all froTrtePrecio entities.
     *
     * @Route("/", name="frotrteprecio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $tramitesPrecios = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tramitesPrecios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tramitesPrecios) . " registros encontrados",
                'data' => $tramitesPrecios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new froTrtePrecio Concepto entity.
     *
     * @Route("/new", name="frotrteprecio_new")
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

            $tramitePrecio = new FroTrtePrecio();

            $tramitePrecio->setFechaInicio(new \Datetime($params->fechaInicio));
            $tramitePrecio->setValor($params->valor);
            $tramitePrecio->setValorTotal(0);
            $tramitePrecio->setActivo(true);

            if ($params->idTramite) {
                $tramite = $em->getRepository("JHWEBFinancieroBundle:FroTramite")->find(
                    $params->idTramite
                );
                $tramitePrecio->setTramite($tramite);
            }

            $tramitePrecio->setNombre(mb_strtoupper($params->nombre, 'utf-8'));

            if ($params->idClase) {
                $clase = $em->getRepository("JHWEBVehiculoBundle:VhloCfgClase")->find(
                    $params->idClase
                );
                $tramitePrecio->setClase($clase);
            }

            if ($params->idModulo) {
                $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find(
                    $params->idModulo
                );
                $tramitePrecio->setModulo($modulo);
            }

            $tramitePrecio->setActivo(true);

            $em->persist($tramitePrecio);
            $em->flush();

            if ($params->conceptos) {
                $totalConceptos = 0;
                foreach ($params->conceptos as $key => $idConcepto) {
                    $tramiteConcepto = new FroTrteConcepto();

                    $concepto = $em->getRepository('JHWEBFinancieroBundle:FroTrteCfgConcepto')->find(
                        $idConcepto
                    );
                    $tramiteConcepto->setConcepto($concepto);

                    $tramiteConcepto->setPrecio($tramitePrecio);

                    $tramiteConcepto->setActivo(true);

                    $em->persist($tramiteConcepto);
                    $em->flush();

                    $totalConceptos += $concepto->getValor();
                }
            }

            $tramitePrecio->setValorConcepto($totalConceptos);
            $tramitePrecio->setValorTotal(
                $totalConceptos + $tramitePrecio->getValor()
            );

            $em->flush();
            
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con éxito',
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorización no válida', 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a froTrtePrecio entity.
     *
     * @Route("/{id}/show", name="frotrteprecio_show")
     * @Method("GET")
     */
    public function showAction(FroTrtePrecio $froTrtePrecio)
    {
        $deleteForm = $this->createDeleteForm($froTrtePrecio);
        return $this->render('froTrtePrecio/show.html.twig', array(
            'froTrtePrecio' => $froTrtePrecio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing froTrtePrecio entity.
     *
     * @Route("/edit", name="frotrteprecio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $froTrtePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find($params->id);

            if ($froTrtePrecio != null) {

                $froTrtePrecio->setNombre(strtoupper($params->nombre));
                $froTrtePrecio->setValor($params->valor);
                $froTrtePrecio->setFechaInicio(new \Datetime($params->fechaInicio));
                $froTrtePrecio->setValorConcepto($params->valorConcepto);
                $froTrtePrecio->setValorTotal($params->valorTotal);

                $tramite = $em->getRepository("JHWEBFinancieroBundle:FroTramite")->find($params->idTramite);
                $froTrtePrecio->setTramite($tramite);

                $clase = $em->getRepository("JHWEBVehiculoBundle:VhloCfgClase")->find($params->idClase);
                $froTrtePrecio->setClase($clase);

                $modulo = $em->getRepository('JHWEBConfigBundle:CfgModulo')->find($idModulo);
                $froTrtePrecio->setModulo($modulo);

                $froTrtePrecio->setEstado(true);

                $em->persist($froTrtePrecio);

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $froTrtePrecio,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a froTrtePrecio entity.
     *
     * @Route("/delete", name="frotrteprecio_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $froTrtePrecio = $em->getRepository('JHWEBFinancieroBundle:FroTrtePrecio')->find($params->id);

            $froTrtePrecio->setActivo(false);

            $em->persist($froTrtePrecio);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a form to delete a froTrtePrecio entity.
     *
     * @param FroTrtePrecio $froTrtePrecio The froTramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FroTrtePrecio $froTrtePrecio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frotrteprecio_delete', array('id' => $froTrtePrecio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ======================================================= */

    /**
     * Listado de tramites y valores para selección con búsqueda
     *
     * @Route("/select", name="frotrteprecio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tramitesPrecio = $em->getRepository('JHWEBFinancieroBundle:FroTramite')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tramitesPrecios as $key => $tramitePrecio) {
            $response[$key] = array(
                'value' => $tramitePrecio->getId(),
                'label' => $tramitePrecio->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
