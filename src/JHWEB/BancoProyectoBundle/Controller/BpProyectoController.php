<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpProyecto;
use JHWEB\BancoProyectoBundle\Entity\BpActividad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/", name="bpProyecto_index")
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
     * @Route("/new", name="bpProyecto_new")
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
            $proyecto->setNombre(strtoupper($params->nombre));
            $proyecto->setFecha(new \Datetime(date('Y-m-d')));
            $proyecto->setCuentaNumero($params->cuentaNumero);
            $proyecto->setCuentaNombre($params->cuentaNombre);
            $proyecto->setCostoTotal(0);
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
     * @Route("/show/{id}", name="bpProyecto_show")
     * @Method("POST")
     */
    public function showAction(Request  $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "bpProyecto encontrado", 
                    'data'=> $proyecto,
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
     * Displays a form to edit an existing BpProyecto entity.
     *
     * @Route("/edit", name="bpProyecto_edit")
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
     * @Route("/delete", name="bpProyecto_delete")
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
            ->setAction($this->generateUrl('bpProyecto_delete', array('id' => $proyecto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =========================================== */

    /**
     * Busca las cuentas asociadas a un proyecto.
     *
     * @Route("/search/cuentas", name="bpProyecto_search_cuentas")
     * @Method({"GET", "POST"})
     */
    public function searchCuentasAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $cuentas = $em->getRepository('JHWEBBancoProyectoBundle:BpCuenta')->findBy(
                array(
                    'proyecto' => $params->idProyecto,
                    'activo' => true
                )
            );

            if ($cuentas) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($cuentas)." registros encontrados.",
                    'data'=> $cuentas,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ninguna actividad registrada aún.",
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
     * Deletes a BpProyecto entity.
     *
     * @Route("/search/numero", name="bpProyecto_search_numero")
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
            
            $proyecto = $em->getRepository('JHWEBBancoProyectoBundle:BpProyecto')->findOneByNumero(
                $params->numero
            );

            if ($proyecto) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito.",
                    'data' => $proyecto
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
}
