<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MgdPeticionario;
use AppBundle\Entity\MgdDocumento;
use AppBundle\Entity\MgdMedidaCautelar;
use AppBundle\Entity\MgdMedidaCautelarVehiculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mgdpeticionario controller.
 *
 * @Route("mgdpeticionario")
 */
class MgdPeticionarioController extends Controller
{
    /**
     * Lists all mgdPeticionario entities.
     *
     * @Route("/", name="mgdpeticionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $peticionarios = $em->getRepository('AppBundle:MgdPeticionario')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de peticionarios",
            'data' => $peticionarios, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new mgdPeticionario entity.
     *
     * @Route("/new", name="mgdpeticionario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get('data',null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $mgdPeticionario = $em->getRepository('AppBundle:MgdPeticionario')->findOneByIdentificacion(
                $params->peticionario[0]->identificacion
            );

            if (!$mgdPeticionario) {
                $mgdPeticionario = new MgdPeticionario();

                $mgdPeticionario->setPrimerNombre($params->peticionario[0]->primerNombre);
                $mgdPeticionario->setSegundoNombre($params->peticionario[0]->segundoNombre);
                $mgdPeticionario->setPrimerApellido($params->peticionario[0]->primerApellido);
                $mgdPeticionario->setSegundoApellido($params->peticionario[0]->segundoApellido);
                $mgdPeticionario->setIdentificacion($params->peticionario[0]->identificacion);
                
                if ($params->peticionario[0]->tipoIdentificacionId) {
                    $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
                        $params->peticionario[0]->tipoIdentificacionId
                    );
                    $mgdPeticionario->setTipoIdentificacion($tipoIdentificacion);
                }

                if ($params->peticionario[0]->entidadNombre) {
                    $mgdPeticionario->setEntidadNombre($params->peticionario[0]->entidadNombre);
                }

                if ($params->peticionario[0]->entidadCargo) {
                    $mgdPeticionario->setEntidadCargo($params->peticionario[0]->entidadCargo);
                }

                $mgdPeticionario->setDireccion($params->peticionario[0]->direccion);
                $mgdPeticionario->setTelefono($params->peticionario[0]->telefono);
                $mgdPeticionario->setCorreoElectronico($params->peticionario[0]->correoElectronico);
                $mgdPeticionario->setActivo(true);

                $em->persist($mgdPeticionario);
                $em->flush();
            }


            $mgdDocumento = new MgdDocumento();

            $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));

            $consecutivo = $em->getRepository('AppBundle:MgdDocumento')->findMaximo($fechaRegistro->format('Y'));
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $mgdDocumento->setConsecutivo($consecutivo);
            $mgdDocumento->setNumeroRadicado($fechaRegistro->format('Y').$fechaRegistro->format('m').str_pad($consecutivo, 3, '0', STR_PAD_LEFT));

            $mgdDocumento->setNumeroOficio($params->documento[0]->numeroOficio);
            $mgdDocumento->setFolios($params->documento[0]->folios);
            $mgdDocumento->setFechaRegistro($fechaRegistro);
            $mgdDocumento->setDescripcion($params->documento[0]->descripcion);

            if ($params->documento[0]->correoCertificadoLlegada) {
                $mgdDocumento->setCorreoCertificadoLlegada($params->documento[0]->correoCertificadoLlegada);
            }

            if ($params->documento[0]->nombreTransportadoraLlegada) {
                $mgdDocumento->setNombreTransportadoraLlegada($params->documento[0]->nombreTransportadoraLlegada);
            }

            if ($params->documento[0]->fechaLlegada) {
                $mgdDocumento->setFechaLlegada($params->documento[0]->fechaLlegada);
            }

            if ($params->documento[0]->numeroGuiaLlegada) {
                $mgdDocumento->setNumeroGuiaLlegada($params->documento[0]->numeroGuiaLlegada);
            }

            if ($params->documento[0]->tipoCorrespondenciaId) {
                $tipoCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->find(
                    $params->documento[0]->tipoCorrespondenciaId
                );
                $mgdDocumento->setTipoCorrespondencia($tipoCorrespondencia);
            }

            $fechaActual = new \Datetime(date('Y-m-d'));
            if ($params->documento[0]->vigencia) {
                $vigencia = $params->documento[0]->vigencia;
            }else{
                $vigencia = $tipoCorrespondencia->getDiasVigencia();
            }
            $fechaVencimiento = $this->get('app.gestion.documental')->getFechaVencimiento(
                $fechaActual,
                $vigencia
            );
            $mgdDocumento->setFechaVencimiento($fechaVencimiento);
            $mgdDocumento->setDiasVigencia($vigencia);

            $mgdDocumento->setPeticionario($mgdPeticionario);

            $file = $request->files->get('file');
           
            if ($file) {
                $extension = $file->guessExtension();
                $filename = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../web/docs';

                $file->move($dir,$filename);
                $mgdDocumento->setUrl($filename);
            }
            $mgdDocumento->setEstado('Pendiente');

            $em->persist($mgdDocumento);
            $em->flush();

            if (count($params->medidaCautelar) > 0) {
                $mgdMedidaCautelar = new MgdMedidaCautelar();

                $mgdMedidaCautelar->setNumeroOficio($params->medidaCautelar[0]->numeroOficio);
                $mgdMedidaCautelar->setQuienOrdena($params->medidaCautelar[0]->quienOrdena);
                $mgdMedidaCautelar->setFechaInicio(new \Datetime($params->medidaCautelar[0]->fechaInicio));
                $mgdMedidaCautelar->setFechaFin(new \Datetime($params->medidaCautelar[0]->fechaFin));
                $mgdMedidaCautelar->setImplicadoidentificacion($params->medidaCautelar[0]->identificacionImplicado);
                $mgdMedidaCautelar->setDelito($params->medidaCautelar[0]->delito);
                $mgdMedidaCautelar->setDocumento($mgdDocumento);

                $em->persist($mgdMedidaCautelar);
                $em->flush();

                if (count($params->vehiculo) > 0) {
                    foreach ($params->vehiculo as $key => $vehiculo) {
                        $mgdMedidaCautelarVehiculo = new MgdMedidaCautelarVehiculo();

                        $mgdMedidaCautelarVehiculo->setLugar($params->vehiculo[0]->lugar);
                        $mgdMedidaCautelarVehiculo->setPlaca($params->vehiculo[0]->placa);

                        if ($params->vehiculo[0]->claseId) {
                            $clase = $em->getRepository('AppBundle:Clase')->find(
                                $params->vehiculo[0]->claseId
                            );
                            $mgdMedidaCautelarVehiculo->setClase($clase);
                        }
                        $mgdMedidaCautelarVehiculo->setMedidaCautelar($mgdMedidaCautelar);

                        $em->persist($mgdMedidaCautelarVehiculo);
                        $em->flush();
                    }
                }
            }

            //$em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito",
                'data' => $mgdDocumento
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a mgdPeticionario entity.
     *
     * @Route("/{id}/show", name="mgdpeticionario_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $peticionario = $em->getRepository('AppBundle:MgdPeticionario')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $peticionario,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing mgdPeticionario entity.
     *
     * @Route("/edit", name="mgdpeticionario_edit")
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

            $em = $this->getDoctrine()->getManager();
            $mgdPeticionario = $em->getRepository("AppBundle:MgdPeticionario")->find($params->id);

            if ($mgdPeticionario!=null) {
                $mgdPeticionario->setPrimerNombre($params->primerNombre);
                $mgdPeticionario->setSegundoNombre($params->segundoNombre);
                $mgdPeticionario->setPrimerApellido($params->primerApellido);
                $mgdPeticionario->setSegundoApellido($params->segundoApellido);
                $mgdPeticionario->setIdentificacion($params->identificacion);

                if ($params->entidadNombre) {
                    $mgdPeticionario->setEntidadNombre($params->entidadNombre);
                }

                if ($params->entidadCargo) {
                    $mgdPeticionario->setEntidadCargo($params->entidadCargo);
                }

                $mgdPeticionario->setDireccion($params->direccion);
                $mgdPeticionario->setTelefono($params->telefono);
                $mgdPeticionario->setCorreoElectronico($params->correoElectronico);
                $mgdPeticionario->setNumeroOficio($params->numeroOficio);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($mgdPeticionario);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $mgdPeticionario,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a mgdPeticionario entity.
     *
     * @Route("/{id}/delete", name="mgdpeticionario_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $mgdPeticionario = $em->getRepository('AppBundle:MgdPeticionario')->find($id);

            if ($mgdPeticionario) {
                $mgdPeticionario->setEstado(false);
                $em = $this->getDoctrine()->getManager();
                $em->persist($mgdPeticionario);
                $em->flush();
                $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro eliminado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }

        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a mgdPeticionario entity.
     *
     * @param MgdPeticionario $mgdPeticionario The mgdPeticionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgdPeticionario $mgdPeticionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgdpeticionario_delete', array('id' => $mgdPeticionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/search", name="mgdpeticionario_search")
     * @Method({"GET", "POST"})
     */
    public function buscarPeticionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $peticionario = null;

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $peticionario = $em->getRepository('AppBundle:MgdPeticionario')->findOneBy(
                array(
                    'activo' => true,
                    'identificacion' => $params->identificacion
                )
            );

            if ($peticionario == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $peticionario,
                );
            }

            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/upload", name="mgdpeticionario_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $files = $request->files->get('file');     

        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            foreach($files as $file)
            {
              $extension = $file->guessExtension();
              $filename = md5(rand().time()).".".$extension;
              $dir=__DIR__.'/../../../../web/img/docs';

              $file->move($dir,$filename);
            }

            $peticionario = $em->getRepository('AppBundle:MgdPeticionario')->findOneBy(
                array(
                    'activo' => true,
                    'identificacion' => $params->identificacion
                )
            );

            if ($peticionario == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Registro no encontrado", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $peticionario,
                );
            }

            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }
}
