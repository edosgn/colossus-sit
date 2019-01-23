<?php

namespace JHWEB\ParqueaderoBundle\Controller;

use JHWEB\ParqueaderoBundle\Entity\PqoCfgGrua;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pqocfggrua controller.
 *
 * @Route("pqocfggrua")
 */
class PqoCfgGruaController extends Controller
{
    /**
     * Lists all pqoCfgGrua entities.
     *
     * @Route("/", name="pqocfggrua_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $gruas = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgGrua')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($gruas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($gruas)." registros encontrados", 
                'data'=> $gruas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pqoCfgGrua entity.
     *
     * @Route("/new", name="pqocfggrua_new")
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
           
            $grua = new PqoCfgGrua();

            $grua->setPlaca(strtoupper($params->placa));
            $grua->setCodigo(strtoupper($params->codigo));
            $grua->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($grua);
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
     * Finds and displays a pqoCfgGrua entity.
     *
     * @Route("/{id}/show", name="pqocfggrua_show")
     * @Method("GET")
     */
    public function showAction(PqoCfgGrua $pqoCfgGrua)
    {
        $deleteForm = $this->createDeleteForm($pqoCfgGrua);

        return $this->render('pqocfggrua/show.html.twig', array(
            'pqoCfgGrua' => $pqoCfgGrua,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pqoCfgGrua entity.
     *
     * @Route("/edit", name="pqocfggrua_edit")
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
            
            $grua = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgGrua')->find(
                $params->id
            );

            if ($grua) {
                $grua->setPlaca(strtoupper($params->placa));
                $grua->setCodigo(strtoupper($params->codigo));

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $grua,
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
     * Deletes a pqoCfgGrua entity.
     *
     * @Route("/delete", name="pqocfggrua_delete")
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
            
            $grua = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgGrua')->find(
                $params->id
            );

            if ($grua) {
                $grua->setActivo(false);

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
     * Creates a form to delete a pqoCfgGrua entity.
     *
     * @param PqoCfgGrua $pqoCfgGrua The pqoCfgGrua entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PqoCfgGrua $pqoCfgGrua)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pqocfggrua_delete', array('id' => $pqoCfgGrua->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="pqocfggrua_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $gruas = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgGrua')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($gruas as $key => $grua) {
            $response[$key] = array(
                'value' => $grua->getId(),
                'label' => $grua->getCodigo().' - '.$grua->getPlaca(),
            );
        }

        return $helpers->json($response);
    }
}
