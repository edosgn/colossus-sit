<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Vhlocfgservicio controller.
 *
 * @Route("vhlocfgservicio")
 */
class VhloCfgServicioController extends Controller
{
    /**
     * Lists all vhloCfgServicio entities.
     *
     * @Route("/", name="vhlocfgservicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $servicios = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->findBy(
            array('activo' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "listado servicios", 
                    'data'=> $servicios,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new Servicio entity.
     *
     * @Route("/new", name="vhlocfgservicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $nombre = $params->nombre;
            $codigo = $params->codigo;

            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->findBy(
                array('codigo' => $codigo)
            );

            if ($servicio==null) {
                $servicio = new VhloCfgServicio();

                $servicio->setNombre(strtoupper($nombre));
                $servicio->setCodigo($codigo);
                $servicio->setActivo(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($servicio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con éxito", 
                ); 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El código no puede repetirse.", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloCfgServicio entity.
     *
     * @Route("/show", name="vhlocfgservicio_show")
     * @Method("POST")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $servicio
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing Servicio entity.
     *
     * @Route("/edit", name="vhlocfgservicio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

           
            $nombre = $params->nombre;
            $codigo = $params->codigo;

            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository("JHWEBVehiculoBundle:VhloCfgServicio")->find($params->id);

            if ($servicio!=null) {
                $servicio->setNombre(strtoupper($nombre));
                $servicio->setCodigo($codigo);
                $servicio->setActivo(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($servicio);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Servicio editado con éxito", 
                ); 
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El servicio no se encuentra en la base de datos.", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida.", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a Servicio entity.
     *
     * @Route("/{id}/delete", name="vhlocfgservicio_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $servicio = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->find($id);

            $servicio->setActivo(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con éxito.", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a VhloCfgServicio entity.
     *
     * @param VhloCfgServicio $vhloCfgServicio The VhloCfgServicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgServicio $vhloCfgServicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgservicio_delete', array('id' => $vhloCfgServicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ================================================ */

    /**
     * Lista de servicios para selección con búsqueda
     *
     * @Route("/select", name="vhlocfgservicio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $servicios = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->findBy(
        array('activo' => 1)
    );

    $response = null;
    
      foreach ($servicios as $key => $servicio) {
        $response[$key] = array(
            'value' => $servicio->getId(),
            'label' => $servicio->getCodigo()."_".$servicio->getNombre(),
            );
      }
       return $helpers->json($response);
    }

    /**
     * Listado de todas las categorias según el tipo de vehiculo para selección con búsqueda
     *
     * @Route("/select/servicio/tipovehiculo", name="userlccfgcategoria_select_servicio_tipovehiculo")
     * @Method({"GET", "POST"})
     */
    public function selectByCategoriaAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $servicios = $em->getRepository('JHWEBVehiculoBundle:VhloCfgServicio')->findBy(
                array('activo' => true)
            );

            $categoria = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->find(
                $params->idCategoria
            );
            
            $response = null;

            if ($servicios) {
                foreach ($categorias as $key => $categoria) {
                    if ($tipoVehiculo->getId() == 1 && $servicio->getId() == 1) {
                        # code...
                    }

                    $response[$key] = array(
                        'value' => $categoria->getId(),
                        'label' => $categoria->getNombre(),
                    );
                }

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Categorias encontradas.',
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'No existen categorias activas en el sistema.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }
}
