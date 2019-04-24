<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgGrupoEtnico;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfggrupoetnico controller.
 *
 * @Route("usercfggrupoetnico")
 */
class UserCfgGrupoEtnicoController extends Controller
{
    /**
     * Lists all userCfgGrupoEtnico entities.
     *
     * @Route("/", name="usercfggrupoetnico_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $grupos = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($grupos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($grupos) . " registros encontrados",
                'data' => $grupos,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a new UserCfgGrupoEtnico entity.
     *
     * @Route("/new", name="usercfggrupoetnico_new")
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

            $grupo = new UserCfgGrupoEtnico();

            $grupo->setNombre(strtoupper($params->nombre));
            $grupo->setActivo(true);
            $em->persist($grupo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
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
     * Finds and displays a UserCfgGrupoEtnico entity.
     *
     * @Route("/show", name="usercfggrupoetnico_show")
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

            $grupo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->find(
                $params->id
            );

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro encontrado con exito.',
                'data' => $grupo
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
     * Displays a form to edit an existing UserCfgGrupoEtnico entity.
     *
     * @Route("/edit", name="usercfggrupoetnico_edit")
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
            $grupo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->find($params->id);

            if ($grupo!=null) {
                $grupo->setNombre($params->nombre);

                $em->persist($grupo);
                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito.", 
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
                    'msj' => "Autorizacion no valida para editar.", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a UserCfgGrupoEtnico entity.
     *
     * @Route("/delete", name="usercfggrupoetnico_delete")
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

            $grupo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->find($params->id);

            $grupo->setActivo(false);

            $em->persist($grupo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito", 
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
     * datos para select 2
     *
     * @Route("/select", name="usercfggrupoetnico_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $grupos = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoEtnico')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($grupos as $key => $grupo) {
            $response[$key] = array(
                'value' => $grupo->getId(),
                'label' => $grupo->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
