<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgUnidadReceptora;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgunidadreceptora controller.
 *
 * @Route("svcfgunidadreceptora")
 */
class SvCfgUnidadReceptoraController extends Controller
{
    /**
     * Lists all svCfgUnidadReceptora entities.
     *
     * @Route("/", name="svcfgunidadreceptora_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $unidadesReceptoras = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->findBy(
            array(
                'activo' => true,
            )
        );

        $response['data'] = array();

        if ($unidadesReceptoras) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($unidadesReceptoras) . " registros encontrados",
                'data' => $unidadesReceptoras,
            );
        }

        return $helpers->json($response);

    }

    /**
     * Creates a new svCfgUnidadReceptora entity.
     *
     * @Route("/new", name="svcfgunidadreceptora_new")
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
           
            $unidadReceptora = new SvCfgUnidadReceptora();
            
            $em = $this->getDoctrine()->getManager();

            if ($params->entidadAccidente) {
                $entidadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find(
                    $params->entidadAccidente
                );
                $unidadReceptora->setEntidadAccidente($entidadAccidente);
            }

            if ($params->municipio) {
                $municipio = $em->getRepository('AppBundle:Municipio')->find(
                    $params->municipio
                );
                $unidadReceptora->setMunicipio($municipio);
            }

            $unidadReceptora->setNombre($params->nombre);
            $unidadReceptora->setActivo(true);

            $em->persist($unidadReceptora);
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
     * Finds and displays a svCfgUnidadReceptora entity.
     *
     * @Route("/show", name="svcfgunidadreceptora_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $unidadReceptora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->find(
                $params->id
            );

            $em->persist($unidadReceptora);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $unidadReceptora,
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
     * Displays a form to edit an existing svCfgUnidadReceptora entity.
     *
     * @Route("/edit", name="svcfgunidadreceptora_edit")
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
            $em = $this->getDoctrine()->getManager();
            $unidadReceptora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->find($params->id);
            $entidadAccidente = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgEntidadAccidente')->find($params->entidadAccidente);
            $municipio = $em->getRepository('AppBundle:Municipio')->find($params->municipio);

            if ($unidadReceptora != null) {
                $unidadReceptora->setNombre($params->nombre);
                $unidadReceptora->setEntidadAccidente($entidadAccidente);
                $unidadReceptora->setMunicipio($municipio);

                $em->persist($unidadReceptora);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $unidadReceptora,
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
     * Deletes a svCfgUnidadReceptora entity.
     *
     * @Route("/delete", name="svCfgUnidadReceptora")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $unidadReceptora = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->find($params->id);

            $unidadReceptora->setActivo(false);

            $em->persist($unidadReceptora);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);

    }

    /**
     * Creates a form to delete a svCfgUnidadReceptora entity.
     *
     * @param SvCfgUnidadReceptoras $svCfgUnidadReceptora The svCfgUnidadReceptora entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgUnidadReceptora $svCfgUnidadReceptora)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgunidadreceptora_delete', array('id' => $svCfgUnidadReceptora->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgunidadreceptora_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $unidadesReceptoras = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgUnidadReceptora')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($unidadesReceptoras as $key => $unidadReceptora) {
            $response[$key] = array(
                'value' => $unidadReceptora->getId(),
                'label' => $unidadReceptora->getValor().' %'
            );
        }
        return $helpers->json($response);
    }
}
