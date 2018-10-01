<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MgdRemitente;
use AppBundle\Entity\MgdDocumento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mgdremitente controller.
 *
 * @Route("mgdremitente")
 */
class MgdRemitenteController extends Controller
{
    /**
     * Lists all mgdRemitente entities.
     *
     * @Route("/", name="mgdpeticionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $remitentes = $em->getRepository('AppBundle:MgdRemitente')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de remitentes",
            'data' => $remitentes, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new mgdRemitente entity.
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


            $mgdRemitente = $em->getRepository('AppBundle:MgdRemitente')->findOneByIdentificacion(
                $params->remitente[0]->identificacion
            );

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneBy(
                array(
                        'estado' => 'Activo',
                        'identificacion' => $params->peticionario[0]->identificacion
                    )
                );

            if (!$mgdRemitente) {
                $mgdRemitente = new MgdRemitente();

                $mgdRemitente->setPrimerNombre($params->remitente[0]->primerNombre);
                $mgdRemitente->setSegundoNombre($params->remitente[0]->segundoNombre);
                $mgdRemitente->setPrimerApellido($params->remitente[0]->primerApellido);
                $mgdRemitente->setSegundoApellido($params->remitente[0]->segundoApellido);
                $mgdRemitente->setIdentificacion($params->remitente[0]->identificacion);
                
                if ($params->remitente[0]->tipoIdentificacionId) {
                    $tipoIdentificacion = $em->getRepository('AppBundle:TipoIdentificacion')->find(
                        $params->remitente[0]->tipoIdentificacionId
                    );
                    $mgdRemitente->setTipoIdentificacion($tipoIdentificacion);
                }


                $mgdRemitente->setDireccion($params->remitente[0]->direccion);
                $mgdRemitente->setTelefono($params->remitente[0]->telefono);
                $mgdRemitente->setCorreoElectronico($params->remitente[0]->correoElectronico);
                $mgdRemitente->setActivo(true);

                $em->persist($mgdRemitente);
                $em->flush();
            }


            $mgdDocumento = new MgdDocumento();

            $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));

            $consecutivo = $em->getRepository('AppBundle:MgdDocumento')->findMaximo(
                $fechaRegistro->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $mgdDocumento->setConsecutivo($consecutivo);

            if ($params->documento[0]->entidadNombre) {
                $mgdDocumento->setEntidadNombre($params->documento[0]->entidadNombre);
            }

            if ($params->documento[0]->entidadCargo) {
                $mgdDocumento->setEntidadCargo($params->documento[0]->entidadCargo);
            }

            $mgdDocumento->setNumeroRadicado(str_pad($consecutivo, 3, '0', STR_PAD_LEFT).$fechaRegistro->format('Y'));
           
            $mgdDocumento->setNumeroOficio($params->documento[0]->numeroOficio);
            $mgdDocumento->setFolios($params->documento[0]->folios);
            $mgdDocumento->setFechaRegistro($fechaRegistro);
            $mgdDocumento->setDescripcion($params->documento[0]->descripcion);

            if ($params->documento[0]->correoCertificadoLlegada == 'true') {
                $mgdDocumento->setCorreoCertificadoLlegada(true);
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

            $mgdDocumento->setRemitente($mgdRemitente);
            $mgdDocumento->setPeticionario($usuario->getCiudadano());

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
     * Finds and displays a mgdRemitente entity.
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
            $peticionario = $em->getRepository('AppBundle:MgdRemitente')->find($id);
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
     * Displays a form to edit an existing mgdRemitente entity.
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
            $mgdRemitente = $em->getRepository("AppBundle:MgdRemitente")->find($params->id);

            if ($mgdRemitente!=null) {
                $mgdRemitente->setPrimerNombre($params->primerNombre);
                $mgdRemitente->setSegundoNombre($params->segundoNombre);
                $mgdRemitente->setPrimerApellido($params->primerApellido);
                $mgdRemitente->setSegundoApellido($params->segundoApellido);
                $mgdRemitente->setIdentificacion($params->identificacion);

                if ($params->entidadNombre) {
                    $mgdRemitente->setEntidadNombre($params->entidadNombre);
                }

                if ($params->entidadCargo) {
                    $mgdRemitente->setEntidadCargo($params->entidadCargo);
                }

                $mgdRemitente->setDireccion($params->direccion);
                $mgdRemitente->setTelefono($params->telefono);
                $mgdRemitente->setCorreoElectronico($params->correoElectronico);
                $mgdRemitente->setNumeroOficio($params->numeroOficio);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($mgdRemitente);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $mgdRemitente,
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
     * Deletes a mgdRemitente entity.
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
            $mgdRemitente = $em->getRepository('AppBundle:MgdRemitente')->find($id);

            if ($mgdRemitente) {
                $mgdRemitente->setEstado(false);
                $em = $this->getDoctrine()->getManager();
                $em->persist($mgdRemitente);
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
     * Creates a form to delete a mgdRemitente entity.
     *
     * @param MgdRemitente $mgdRemitente The mgdRemitente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MgdRemitente $mgdRemitente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgdpeticionario_delete', array('id' => $mgdRemitente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca remitente por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/search", name="mgdremitente_search")
     * @Method({"GET", "POST"})
     */
    public function buscarRemitenteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $remitente = null;
 
        if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $remitente = $em->getRepository('AppBundle:MgdRemitente')->findOneBy(
                array(
                    'activo' => true,
                    'identificacion' => $params->identificacion
                )
            );

            if ($remitente) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $remitente,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "¡No existe el ciudadano registrado con ese número de identificación, por favor registrelo1!", 
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

            $peticionario = $em->getRepository('AppBundle:MgdRemitente')->findOneBy(
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
