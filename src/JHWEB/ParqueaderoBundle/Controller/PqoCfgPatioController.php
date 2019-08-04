<?php

namespace JHWEB\ParqueaderoBundle\Controller;

use JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio;
use JHWEB\ParqueaderoBundle\Entity\PqoPatioCiudadano;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pqocfgpatio controller.
 *
 * @Route("pqocfgpatio")
 */
class PqoCfgPatioController extends Controller
{
    /**
     * Lists all pqoCfgPatio entities.
     *
     * @Route("/", name="pqocfgpatio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $patios = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($patios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($patios)." registros encontrados", 
                'data'=> $patios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pqoCfgPatio entity.
     *
     * @Route("/new", name="pqocfgpatio_new")
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
           
            $patio = new PqoCfgPatio();

            $patio->setNombre(mb_strtoupper($params->nombre,'utf-8'));
            $patio->setDireccion($params->direccion);
            $patio->setCorreo($params->correo);
            $patio->setTelefono($params->telefono);
            $patio->setNumeroResolucion($params->numeroResolucion);
            $patio->setFechaInicial(new \Datetime($params->fechaInicial));
            $patio->setFechaFinal(new \Datetime($params->fechaFinal));
            $patio->setInterno($params->interno);
            $patio->setActivo(true);

            if ($params->administrador) {
                $patio->setAdministrador(mb_strtoupper($params->administrador,'utf-8'));
            }

            if ($params->propietario) {
                $patio->setPropietario(mb_strtoupper($params->propietario,'utf-8'));
            }

            if ($params->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
                $patio->setOrganismoTransito($organismoTransito);
            }


            $file = $request->files->get('file');
               
            if ($file) {
                $extension = $file->guessExtension();

                if ($extension != 'pdf' && $extension != 'PDF') {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "EL documento debe ser formato .pdf", 
                    );
                }else{     
                    $filename = md5(rand().time()).".".$extension;
                    $dir=__DIR__.'/../../../../web/docs/patio';
    
                    $file->move($dir,$filename);
                    $patio->setArchivo($filename);

                    $em->persist($patio);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con exito.",
                    );
                }
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
     * Finds and displays a pqoCfgPatio entity.
     *
     * @Route("/{id}/show", name="pqocfgpatio_show")
     * @Method("GET")
     */
    public function showAction(PqoCfgPatio $pqoCfgPatio)
    {
        $deleteForm = $this->createDeleteForm($pqoCfgPatio);

        return $this->render('pqocfgpatio/show.html.twig', array(
            'pqoCfgPatio' => $pqoCfgPatio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pqoCfgPatio entity.
     *
     * @Route("/edit", name="pqocfgpatio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                $params->id
            );

            if ($patio) {
                $patio->setNombre(mb_strtoupper($params->nombre,'utf-8'));
                $patio->setDireccion(mb_strtoupper($params->direccion,'utf-8'));

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $patio,
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
     * Deletes a pqoCfgPatio entity.
     *
     * @Route("/delete", name="pqocfgpatio_delete")
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
            
            $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                $params->id
            );

            if ($patio) {
                $patio->setActivo(false);

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
     * Creates a form to delete a pqoCfgPatio entity.
     *
     * @param PqoCfgPatio $pqoCfgPatio The pqoCfgPatio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PqoCfgPatio $pqoCfgPatio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pqocfgpatio_delete', array('id' => $pqoCfgPatio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="pqocfgpatio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        
        $em = $this->getDoctrine()->getManager();

        $patios = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($patios as $key => $patio) {
            $response[$key] = array(
                'value' => $patio->getId(),
                'label' => $patio->getNombre().' - '.$patio->getDireccion(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * Asigna un patio a un ciudadano.
     *
     * @Route("/assign", name="pqocfgpatio_assign")
     * @Method({"GET", "POST"})
     */
    public function assignAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                $params->idPatio
            );

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->identificacion
                )
            );

            if ($ciudadano) {
                $patioCiudadanoOld = $em->getRepository('JHWEBParqueaderoBundle:PqoPatioCiudadano')->findBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true
                    )
                );
    
                if ($patioCiudadanoOld) {
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El ciudadano seleccionado ya tiene una asignación en el patio '.$patio->getNombre(), 
                    );
                }else{
                    $patioCiudadano = new PqoPatioCiudadano();
        
                    $patioCiudadano->setCiudadano($ciudadano);
                    $patioCiudadano->setPatio($patio);
                    $patioCiudadano->setActivo(true);
    
                    $em->persist($patioCiudadano);
                    $em->flush();
                   
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro creado con exito.',
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano con la identificación digitada no existe.', 
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
     * Busca si un ciudadano esta asignado a un patio.
     *
     * @Route("/search/ciudadano", name="pqocfgpatio_search_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'tipoIdentificacion' => 1,
                    'identificacion' => $params->identificacion
                )
            );

            if ($ciudadano) {
                $patioCiudadano = $em->getRepository('JHWEBParqueaderoBundle:PqoPatioCiudadano')->findOneBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true
                    )
                );

                if ($patioCiudadano) {
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro encontrado con exito.',
                        'data' => $patioCiudadano
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El ciudadano no tiene activa una vinculacion a un patio actualmente.', 
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El ciudadano con la identificación digitada no existe.', 
                );
            }
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
     * Busca todos los ciudadanos activos que se encuentran vinculados a un patio.
     *
     * @Route("/search/ciudadanos", name="pqocfgpatio_search_ciudadanos")
     * @Method({"GET", "POST"})
     */
    public function searchByCiudadanosAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                $params->id
            );

            $patioCiudadanos = $em->getRepository('JHWEBParqueaderoBundle:PqoPatioCiudadano')->findBy(
                array(
                    'patio' => $patio->getId(),
                    'activo' => true
                )
            );

            if ($patioCiudadanos) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($patioCiudadanos).' registros encontrados con exito.',
                    'data' => $patioCiudadanos
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Ningún ciudadano vinculado actualmente.', 
                );
            }
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
     * Asigna un patio a un ciudadano.
     *
     * @Route("/delete/ciudadano", name="pqocfgpatio_delete_ciudadano")
     * @Method({"GET", "POST"})
     */
    public function deleteCiudadanoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $patioCiudadano = $em->getRepository('JHWEBParqueaderoBundle:PqoPatioCiudadano')->find(
                $params->idPatioCiudadano
            );

            if ($patioCiudadano) {
                $patioCiudadano->setActivo(false);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Ciudadano eliminado con exito.', 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'El registro no se encuentra en la base de datos.', 
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
}
