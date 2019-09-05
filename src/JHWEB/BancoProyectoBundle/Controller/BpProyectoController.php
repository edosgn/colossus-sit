<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpProyecto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use \DOMDocument;
use \DOMXPath;

/**
 * Bpproyecto controller.
 *
 * @Route("bpproyecto")
 */
class BpProyectoController extends Controller
{
    /**
     * Lists all BpProyecto entities.
     *
     * @Route("/", name="bpproyecto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $proyectos = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($proyectos) {
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($proyectos)." registros encontrados",
                    'data'=> $proyectos,
            );
        }
         
        return $helpers->json($response);
    }

    /**
     * Creates a new BpProyecto entity.
     *
     * @Route("/new", name="bpproyecto_new")
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

            $proyecto = new BpProyecto();

            $proyecto->setNumero($params->numero);
            $proyecto->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $proyecto->setFecha(new \Datetime(date('Y-m-d')));
            $proyecto->setCostoTotal(0);
            $proyecto->setSaldoTotal(0);
            $proyecto->setActivo(true);

            $em->persist($proyecto);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "BpProyecto creado con exito", 
                'data' => $proyecto
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
     * Finds and displays a BpProyecto entity.
     *
     * @Route("/show", name="bpproyecto_show")
     * @Method("POST")
     */
    public function showAction(Request  $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($params->id);

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Registro encontrado', 
                    'data'=> $proyecto,
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing BpProyecto entity.
     *
     * @Route("/edit", name="bpproyecto_edit")
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

            $proyecto = $em->getRepository("JHWEBBancoProyectoBundle:BpProyecto")->find(
                $params->id
            );

            if ($proyecto) {
                $proyecto->setNumero($params->numero);
                $proyecto->setNombre(strtoupper($params->nombre));
                $proyecto->setFecha(new \Datetime(date('Y-m-d')));
                $proyecto->setCuentaNumero($params->cuentaNumero);
                $proyecto->setCuentaNombre($params->cuentaNombre);
                $proyecto->setCostoTotal($params->costoTotal);
                $proyecto->setSaldoTotal($params->costoTotal - $poyecto->getSaldoTotal());

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data'  => $proyecto
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
     * Deletes a BpProyecto entity.
     *
     * @Route("/delete", name="bpproyecto_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find(
                $params->id
            );

            if ($proyecto) {
                $proyecto->setActivo(false);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito"
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
                'message' => "Autorización no válida",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a BpProyecto entity.
     *
     * @param BpProyecto $proyecto The BpProyecto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpProyecto $proyecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpproyecto_delete', array('id' => $proyecto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =========================================== */

    /**
     * Buscar un único proyecto por numero
     *
     * @Route("/search/numero", name="bpproyecto_search_numero")
     * @Method({"GET", "POST"})
     */
    public function searchByNumeroAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findOneBy(
                array(
                    'numero' => $params->numero
                )
            );

            if ($proyecto) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito.",
                    'data' => $proyecto
                );
            } else {
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
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
     * Buscar un proyecto por filtro (1-Numero, 2-Fecha)
     *
     * @Route("/search/filter", name="bpproyecto_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $proyectos = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->getByFilter(
                $params
            );

            if ($proyectos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito.",
                    'data' => $proyectos
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
                'message' => "Autorización no válida",
            );
        }

        return $helpers->json($response);
    }

    

    /**
     * Crea PDF con resumen de comparendo .
     *
     * @Route("/graph", name="bpproyecto_graph")
     * @Method({"GET"})
     */
    public function graphAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('@JHWEBBancoProyecto/Default/pdf.proyecto.graph.html.twig');
    }

    /**
     * Crea PDF con resumen de comparendo .
     *
     * @Route("/{id}/pdf", name="bpproyecto_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request, $id)
    {
        //$url = __DIR__.$this->generateUrl('bpproyecto_graph');
        /*$url = 'http://localhost/GitHub/colossus-sit/web/app_dev.php/bancoproyecto/bpproyecto/graph';
        $html = file_get_contents($url);

        //preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*).(jpg|png|gif)/i', $html, $matches );
        //$imagen = $matches[1];
        //var_dump($matches);

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        var_dump( $xpath->evaluate('string(//div[@id="chart_div"])') );

        //var_dump($imagen);
        die();*/

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find(
            $id
        );

        $ordenesPago = $em->getRepository('JHWEBBancoProyectoBundle:BpOrdenPago')->getOrdenesPagoByProyecto(
            $proyecto->getId()
        );

        /*$html = $this->renderView('@JHWEBBancoProyecto/Default/pdf.proyecto.graph.html.twig');

        $doc=new DOMDocument();
        $doc->loadHTML("<html><body>Test<br><img src=\"myimage.jpg\" title=\"title\" alt=\"alt\"></body></html>");
        $xml=simplexml_import_dom($doc); // just to make xpath more simple
        $images=$xml->xpath('//img');
        foreach ($images as $img) {
            echo $img['src'] . ' ' . $img['alt'] . ' ' . $img['title'];
        }
        die();*/
                
        $html = $this->renderView('@JHWEBBancoProyecto/Default/pdf.proyecto.report.html.twig', array(
            'fechaActual' => $fechaActual,
            'proyecto'=> $proyecto,
            'ordenesPago'=> $ordenesPago,
        ));

        $this->get('app.pdf')->templateProyecto($html, $proyecto);
    }
}
