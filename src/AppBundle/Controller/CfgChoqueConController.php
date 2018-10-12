<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CfgChoqueCon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgchoquecon controller.
 *
 * @Route("cfgchoquecon")
 */
class CfgChoqueConController extends Controller
{
    /**
     * Lists all cfgChoqueCon entities.
     *
     * @Route("/", name="cfgchoquecon_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $cfgChoquesCon = $em->getRepository('AppBundle:CfgChoqueCon')->findBy(
            array('estado' => 1)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "listado choquesCon",
            'data' => $cfgChoquesCon,
        );

        return $helpers->json($response);

    }

    /**
     * Creates a new cfgChoqueCon entity.
     *
     * @Route("/new", name="cfgchoquecon_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $nombre = $params->nombre;

            $em = $this->getDoctrine()->getManager();
            $cfgChoqueCon = $em->getRepository('AppBundle:CfgChoqueCon')->findOneByNombre($params->nombre);

            if ($cfgChoqueCon == null) {
                $cfgChoqueCon = new CfgChoqueCon();

                $cfgChoqueCon->setNombre(strtoupper($nombre));
                $cfgChoqueCon->setEstado(true);

                $em->persist($cfgChoqueCon);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Choque con creado con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El nombre del choque con ya se encuentra registrado",
                );
            }

        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Finds and displays a cfgChoqueCon entity.
     *
     * @Route("/show", name="cfgchoquecon_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgChoqueCon = $em->getRepository('AppBundle:CfgChoqueCon')->find($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "choque con encontrado",
                'data' => $cfgChoqueCon,
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Displays a form to edit an existing cfgChoqueCon entity.
     *
     * @Route("/edit", name="cfgchoquecon_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $nombre = $params->nombre;
            $em = $this->getDoctrine()->getManager();
            $cfgChoqueCon = $em->getRepository('AppBundle:CfgChoqueCon')->find($params->id);
            if ($cfgChoqueCon != null) {

                $cfgChoqueCon->setNombre($nombre);
                $cfgChoqueCon->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cfgChoqueCon);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "choque con editada con exito",
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "EL choque con no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco",
            );
        }

        return $helpers->json($response);

    }

    /**
     * Deletes a cfgChoqueCon entity.
     *
     * @Route("/{id}/delete", name="cfgchoquecon_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgChoqueCon = $em->getRepository('AppBundle:CfgChoqueCon')->find($id);

            $cfgChoqueCon->setEstado(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cfgChoqueCon);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "choque con eliminado con exito",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a form to delete a cfgChoqueCon entity.
     *
     * @param CfgChoqueCon $cfgChoqueCon The cfgChoqueCon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgChoqueCon $cfgChoqueCon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgchoquecon_delete', array('id' => $cfgChoqueCon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgchoquecon_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        $cfgChoquesCon = $em->getRepository('AppBundle:CfgChoqueCon')->findBy(
            array('estado' => 1)
        );

        $response = null;

        foreach ($cfgChoquesCon as $key => $cfgChoqueCon) {
            $response[$key] = array(
                'value' => $cfgChoqueCon->getId(),
                'label' => $cfgChoqueCon->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
