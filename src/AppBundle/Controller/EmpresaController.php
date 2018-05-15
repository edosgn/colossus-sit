<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\TipoSociedad;
use AppBundle\Form\EmpresaType;

/**
 * Empresa controller.
 *
 * @Route("/empresa")
 */
class EmpresaController extends Controller
{
    /**
     * Lists all Empresa entities.
     *
     * @Route("/", name="empresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('AppBundle:Empresa')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado empresas", 
                    'data'=> $empresas,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new Empresa entity.
     *
     * @Route("/new", name="empresa_new")
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
            // if (count($params)==0) {
            //     $responce = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "los campos no pueden estar vacios", 
            //     );
            // }else{
                        
                        $nombre = $params->nombre;
                        $sigla = $params->sigla;
                        $nit = $params->nit;
                        $dv = $params->dv;
                        $capitalPagado = $params->capitalPagado;
                        $patrimonioLiquido = $params->patrimonioLiquido;
                        $empresaPrestadora = $params->empresaPrestadora;
                        $certificadoExistencial = $params->certificadoExistencial;
                        $tipoSociedadId = $params->tipoSociedadId;
                        $tipoEntidad = $params->tipoEntidad;
                        $municipioId = $params->municipioId;
                        $nroRegistro = $params->nroRegistro;
                        $fechaDeVencimiento = $params->fechaDeVencimiento;
                        $direccion = $params->direccion;
                        $telefono = $params->telefono;
                        $celular = $params->celular;
                        $correo = $params->correo;
                        $fax = $params->fax;
                        $ciudadanoId = $params->ciudadanoId;

                        $fechaDeVencimiento=new \DateTime($fechaDeVencimiento);

                        
                //    var_dump($ciudadanoId);
                //             die();
                        $em = $this->getDoctrine()->getManager();                                                 
                        $tipoSociedad = $em->getRepository('AppBundle:TipoSociedad')->find($tipoSociedadId);
                        $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
                        $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);
                

                        $em = $this->getDoctrine()->getManager();                       
                           
                            $empresa = new Empresa();

                            $empresa->setNombre($nombre);
                            $empresa->setSigla($sigla);
                            $empresa->setNit($nit);
                            $empresa->setDv($dv);
                            $empresa->setCapitalPagado($capitalPagado);
                            $empresa->setCapitalLiquido($patrimonioLiquido);
                            $empresa->setEmpresaPrestadora($empresaPrestadora);
                            $empresa->setCertificadoExistencia($certificadoExistencial);
                            $empresa->setTipoSocidad($tipoSociedad);
                            $empresa->setTipoEntidad($tipoEntidad);
                            $empresa->setMunicipio($municipio);
                            $empresa->setNroRegistroMercantil($nroRegistro);
                            $empresa->setFechaVencimientoRegistroMercantil($fechaDeVencimiento);
                            $empresa->setTelefono($telefono);
                            $empresa->setDireccion($direccion);
                            $empresa->setCorreo($correo);
                            $empresa->setTelefono($telefono);
                            $empresa->setCelular($celular);
                            $empresa->setCorreo($correo);
                            $empresa->setFax($fax);
                            $empresa->setCiudadano($ciudadano); 
                            $empresa->setEstado(true);
                            $em = $this->getDoctrine()->getManager();
                            
                            $em->persist($empresa);
                            $em->flush();

                            $responce = array(
                                'status' => 'success',
                                'code' => 200,
                                'msj' => "Empresa creado con exito", 
                            );
                     

                        
                       
                    // }
        }else{
            $responce = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($responce);
    }

    /**
     * Finds and displays a Empresa entity.
     *
     * @Route("/show/{id}/empresa", name="empresa_show_original")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('AppBundle:Empresa')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "empresa con nombre"." ".$empresa->getNombre(), 
                    'data'=> $empresa,
            );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Displays a form to edit an existing Empresa entity.
     *
     * @Route("/edit", name="empresa_edit")
     * @Method({"POST", "POST"})
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

            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository("AppBundle:Empresa")->find($params->id);

            if ($empresa!=null) {
                $nit = $params->nit;
                $dv = $params->dv;
                $nombre = $params->nombre;
                $telefono = $params->telefono;
                $direccion = $params->direccion;
                $correo = $params->correo;
                $municipioId = $params->municipioId;
                $tipoSociedadId = $params->tipoSociedadId;
                $ciudadanoId = $params->ciudadanoId;
                $em = $this->getDoctrine()->getManager();
                $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
                $tipoSociedad = $em->getRepository('AppBundle:TipoSociedad')->find($tipoSociedadId);
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);

                $empresa->setNit($nit);
                $empresa->setDv($dv);
                $empresa->setNombre($nombre);
                $empresa->setTelefono($telefono);
                $empresa->setDireccion($direccion);
                $empresa->setCorreo($correo);
                $empresa->setMunicipio($municipio);
                $empresa->setTipoSociedad($tipoSociedad);
                $empresa->setCiudadano($ciudadano);


                $empresa->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($empresa);
                $em->flush();

                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Empresa editada con exito", 
                );

            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La empresa no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a Empresa entity.
     *
     * @Route("/{id}/delete", name="empresa_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('AppBundle:Empresa')->find($id);

            $empresa->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($empresa);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "empresa eliminado con exito", 
                );
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a Empresa entity.
     *
     * @param Empresa $empresa The Empresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Empresa $empresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('empresa_delete', array('id' => $empresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * busca empresas por nit.
     *
     * @Route("/show/nit", name="empresa_show")
     * @Method("POST")
     */
    public function showNitAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("json",null);
        $params = json_decode($json);
        $nit = $params->nit;
       
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('AppBundle:Empresa')->findOneBy(
            array('nit' => $nit,
            'estado' => 1)
            );
            if ($empresa!=null) {
               $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "empresa encontrada", 
                    'data'=> $empresa,
            );
            }else{
                 $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Empresa no Encontrada", 
                );
            }
            
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($responce);
    }


     /**
     * datos para select 2
     *
     * @Route("/select", name="empresa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $empresas = $em->getRepository('AppBundle:Empresa')->findBy(
        array('estado' => 1)
    );
    if ($empresas == null) {
       $responce = null;
    }
      foreach ($empresas as $key => $empresa) {
        $responce[$key] = array(
            'value' => $empresa->getId(),
            'label' => $empresa->getNit()."_".$empresa->getNombre(),
            );
      }
       return $helpers->json($responce);
    }
}
