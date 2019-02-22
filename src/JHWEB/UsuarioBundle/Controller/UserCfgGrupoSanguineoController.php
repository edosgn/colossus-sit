<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserCfgGrupoSanguineo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usercfggruposanguineo controller.
 *
 * @Route("usercfggruposanguineo")
 */
class UserCfgGrupoSanguineoController extends Controller
{
    /**
     * Lists all userCfgGrupoSanguineo entities.
     *
     * @Route("/", name="usercfggruposanguineo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $gruposSanguineos = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($gruposSanguineos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($gruposSanguineos)." registros encontrados", 
                'data'=> $gruposSanguineos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new userCfgGrupoSanguineo entity.
     *
     * @Route("/new", name="usercfggruposanguineo_new")
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

            $grupoSanguineo = new UserCfgGrupoSanguineo();

            $grupoSanguineo->setNombre(
                mb_strtoupper($params->nombre,'utf-8')
            );
            $grupoSanguineo->setSigla(
                mb_strtoupper($params->sigla,'utf-8')
            );
            $grupoSanguineo->setActivo(true);

            $em->persist($grupoSanguineo);
            $em->flush();
           
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
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
     * Finds and displays a userCfgGrupoSanguineo entity.
     *
     * @Route("/show", name="usercfggruposanguineo_show")
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

            $grupoSanguineo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->find(
                $params->id
            );

            $em->persist($grupoSanguineo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $grupoSanguineo
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
     * Displays a form to edit an existing userCfgGrupoSanguineo entity.
     *
     * @Route("/edit", name="usercfggruposanguineo_edit")
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

            $grupoSanguineo = $em->getRepository("JHWEBUsuarioBundle:UserCfgGrupoSanguineo")->find(
                $params->id
            );

            if ($grupoSanguineo) {
                $grupoSanguineo->setNombre(
                    mb_strtoupper($params->nombre,'utf-8')
                );
                $grupoSanguineo->setSigla(
                    mb_strtoupper($params->sigla,'utf-8')
                );
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $grupoSanguineo,
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
     * Deletes a userCfgGrupoSanguineo entity.
     *
     * @Route("/delete", name="usercfggruposanguineo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $grupoSanguineo = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->find(
                $params->id
            );

            $grupoSanguineo->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
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
     * Creates a form to delete a userCfgGrupoSanguineo entity.
     *
     * @param UserCfgGrupoSanguineo $userCfgGrupoSanguineo The userCfgGrupoSanguineo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCfgGrupoSanguineo $userCfgGrupoSanguineo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercfggruposanguineo_delete', array('id' => $userCfgGrupoSanguineo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de grupos sanguineos para seleccion con busqueda
     *
     * @Route("/select", name="usercfggruposanguineo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $gruposSanguineos = $em->getRepository('JHWEBUsuarioBundle:UserCfgGrupoSanguineo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($gruposSanguineos as $key => $grupoSanguineo) {
            $response[$key] = array(
                'value' => $grupoSanguineo->getId(),
                'label' => $grupoSanguineo->getSigla(),
            );
        }

        return $helpers->json($response);
    }
}
