<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserEmpresa;
use JHWEB\UsuarioBundle\Entity\UserEmpresaRepresentante;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userempresa controller.
 *
 * @Route("userempresa")
 */
class UserEmpresaController extends Controller
{
    /**
     * Lists all userEmpresa entities.
     *
     * @Route("/", name="userempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($empresas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($empresas) . " registros encontrados",
                'data' => $empresas,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new userEmpresa entity.
     *
     * @Route("/new", name="userempresa_new")
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
            var_dump($params);
            die();
            $fechaDeVencimiento = new \DateTime($params->empresa->fechaVencimientoRegistroMercantil);
            $fechaInicial = new \DateTime($params->empresa->fechaInicial);

            $tipoSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->find($params->empresa->idTipoSociedad);
            $tipoIdentificacion = $em->getRepository('JHWEBUsuarioBundle:UserCfgTipoIdentificacion')->find($params->empresa->idTipoIdentificacion);
            $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find($params->empresa->idMunicipio);

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find($params->empresa->idCiudadano);
            $empresaRepresentante = $em->getRepository('JHWEBUsuarioBundle:UserEmpresaRepresentante')->findOneBy(array(
                'ciudadano' => $ciudadano
            ));

            $empresaServicio = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaServicio')->find($params->empresa->idEmpresaServicio);

            $empresa = new UserEmpresa();

            $empresa->setNombre($params->empresa->nombre);
            $empresa->setSigla($params->empresa->sigla);
            $empresa->setNit($params->empresa->nit);
            $empresa->setDv($params->empresa->dv);
            $empresa->setCapitalPagado($params->empresa->capitalPagado);
            $empresa->setCapitalLiquido($params->empresa->capitalPagado);
            $empresa->setEmpresaPrestadora($params->empresa->empresaPrestadora);
            $empresa->setCertificadoExistencial($params->empresa->certificadoExistencial);
            $empresa->setTipoSociedad($tipoSociedad);
            $empresa->setTipoIdentificacion($tipoIdentificacion);
            $empresa->setTipoEntidad($params->empresa->tipoEntidad);
            $empresa->setMunicipio($municipio);
            $empresa->setNroRegistroMercantil($params->empresa->nroRegistroMercantil);
            $empresa->setFechaVencimientoRegistroMercantil($fechaDeVencimiento);
            $empresa->setTelefono($params->empresa->telefono);
            $empresa->setDireccion($params->empresa->direccion);
            $empresa->setCelular($params->empresa->celular);
            $empresa->setCorreo($params->empresa->correo);
            $empresa->setFax($params->empresa->fax);
            $empresa->setCiudadano($ciudadano);
            $empresa->setEmpresaRepresentante($empresaRepresentante);
            $empresa->setEmpresaServicio($empresaServicio);
            $empresa->setActivo(true);

            $em->persist($empresa);

            $empresaRepresentante = new UserEmpresaRepresentante();

            $empresaRepresentante->setEmpresa($empresa);
            $empresaRepresentante->setCiudadano($ciudadano);
            $empresaRepresentante->setFechaInicial($fechaInicial);
            $empresaRepresentante->setActivo(true);

            $em->persist($empresaRepresentante);
            $em->flush();


            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Empresa creado con éxito",
            );
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
     * Finds and displays a userEmpresa entity.
     *
     * @Route("/show", name="userempresa_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                $params->id
            );

            $em->persist($empresa);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $empresa,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing userEmpresa entity.
     *
     * @Route("/{id}/edit", name="userempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserEmpresa $userEmpresa)
    {
        $deleteForm = $this->createDeleteForm($userEmpresa);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserEmpresaType', $userEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userempresa_edit', array('id' => $userEmpresa->getId()));
        }

        return $this->render('userempresa/edit.html.twig', array(
            'userEmpresa' => $userEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userEmpresa entity.
     *
     * @Route("/{id}/delete", name="userempresa_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, UserEmpresa $userEmpresa)
    {
        $form = $this->createDeleteForm($userEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userEmpresa);
            $em->flush();
        }

        return $this->redirectToRoute('userempresa_index');
    }

    /**
     * Creates a form to delete a userEmpresa entity.
     *
     * @param UserEmpresa $userEmpresa The userEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserEmpresa $userEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userempresa_delete', array('id' => $userEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================================*/
    /**
     * Busca empresas por NIT o Nombre.
     *
     * @Route("/show/nit/nombre", name="userempresa_show_nit_nombre")
     * @Method({"GET", "POST"})
     */
    public function showNitOrNombreAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("json", null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();
        if ($authCheck == true) {
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->getByNitOrNombre($params);

            if ($empresa) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Empresa encontrada",
                    'data' => $empresa,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Empresa no Encontrada",
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
     * Listado de empresas
     *
     * @Route("/select", name="userempresa_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($empresas as $key => $empresa) {
            $response[$key] = array(
                'value' => $empresa->getId(),
                'label' => $empresa->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
