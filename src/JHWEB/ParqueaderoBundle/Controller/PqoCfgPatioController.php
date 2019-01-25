<?php

namespace JHWEB\ParqueaderoBundle\Controller;

use JHWEB\ParqueaderoBundle\Entity\PqoCfgPatio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
           
            $patio = new PqoCfgPatio();

            $patio->setNombre(mb_strtoupper($params->nombre,'utf-8'));
            $patio->setDireccion(mb_strtoupper($params->direccion,'utf-8'));
            $patio->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($patio);
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
}