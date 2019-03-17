<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgEmpresaTipoSociedad;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfgempresatiposociedad controller.
 *
 * @Route("usercfgempresatiposociedad")
 */
class UserCfgEmpresaTipoSociedadController extends Controller
{
    /**
     * Lists all userCfgEmpresaTipoSociedad entities.
     *
     * @Route("/", name="usercfgempresatiposociedad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tipoSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->findBy(
            array('activo' => true)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "Lista de tipoSociedad",
            'data' => $tipoSociedad,
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new tipoSociedad entity.
     *
     * @Route("/new", name="usercfgempresatiposociedad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $tipoSociedad = new UserCfgEmpresaTipoSociedad();

            $tipoSociedad->setNombre($params->nombre);
            $tipoSociedad->setActivo(true);

            $em->persist($tipoSociedad);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a userCfgEmpresaTipoSociedad entity.
     *
     * @Route("/show", name="usercfgempresatiposociedad_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $tipoSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->find($params->id);

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado", 
                'data'=> $tiposociedad,
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
     * Displays a form to edit an existing userCfgEmpresaTipoSociedad entity.
     *
     * @Route("/edit", name="usercfgempresatiposociedad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $tipoSociedad = $em->getRepository("JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad")->find($params->id);

            if ($tipoSociedad!=null) {
                $tipoSociedad->setNombre($params->nombre);

                $em->persist($tipoSociedad);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $tipoSociedad,
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
                'message' => "Autorizacion no validar", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Deletes a tipoSociedad entity.
     *
     * @Route("/delete", name="usercfgempresatiposociedad_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $tipoSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->find($params->id);
            $tipoSociedad->setActivo(false);
            $em->persist($tipoSociedad);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito", 
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
     * Creates a form to delete a tipoSociedad entity.
     *
     * @param TipoSociedad $tipoSociedad The tipoSociedad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoSociedad $tipoSociedad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiposociedad_delete', array('id' => $tipoSociedad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="usercfgempresatiposociedad_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposSociedad = $em->getRepository('JHWEBUsuarioBundle:UserCfgEmpresaTipoSociedad')->findBy(
            array('activo' => true)
        );
        foreach ($tiposSociedad as $key => $tipoSociedad) {
            $response[$key] = array(
                'value' => $tipoSociedad->getId(),
                'label' => $tipoSociedad->getNombre(),
            );
        }
       return $helpers->json($response);
    }
}
